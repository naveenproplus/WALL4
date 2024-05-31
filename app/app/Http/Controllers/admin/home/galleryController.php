<?php

namespace App\Http\Controllers\admin\home;

use DB;
use Auth;
use cruds;
use Exception;
use App\Models\DocNum;
use App\Models\general;
use App\Models\support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\admin\logController;

class galleryController extends Controller
{
    private $general;
    private $support;
    private $DocNum;
    private $UserID;
    private $ActiveMenuName;
    private $PageTitle;
    private $CRUD;
    private $logs;
    private $Settings;
    private $Menus;
    public function __construct()
    {
        $this->ActiveMenuName = "Gallery";
        $this->PageTitle = "Home Gallery";
        $this->middleware('auth');
        $this->DocNum = new DocNum();
        $this->support = new support();

        $this->middleware(function ($request, $next) {
            $this->UserID = auth()->user()->UserID;
            $this->general = new general($this->UserID, $this->ActiveMenuName);
            $this->Menus = $this->general->loadMenu();
            $this->CRUD = $this->general->getCrudOperations($this->ActiveMenuName);
            $this->logs = new logController();
            $this->Settings = $this->general->getSettings();
            return $next($request);
        });
    }
    public function index(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['galleryImages'] = DB::Table('tbl_gallery_images')->where('DFlag', 0)->get();
            return view('admin.home.gallery.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/home/gallery/create');
        } else {
            return view('errors.403');
        }
    }
    public function Create(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['isEdit'] = false;
            return view('admin.home.gallery.upload', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/home/gallery');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $ID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ID'] = $ID;
            $FormData['EditData'] = DB::Table('tbl_gallery_images')->where('ID', $ID)->where('DFlag', 0)->get();
            if (count($FormData['EditData']) > 0) {
                return view('admin.home.gallery.upload', $FormData);
            } else {
                return view('errors.400');
            }
        } else {
            return view('errors.403');
        }
    }

    private function getImageData($base64)
    {
        $base64_str = substr($base64, strpos($base64, ",") + 1);
        $image = base64_decode($base64_str);
        return $image;
    }
    public function Save(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "add") == true) {
            $OldData = $NewData = array();
            $ID = "";
            DB::beginTransaction();
            $status = false;
            $galleryImage = "";
            try {

                $ID = $this->DocNum->getDocNum("Gallery-Images");
                $dir = "uploads/home/gallery/images/" . $ID . "/";

                if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                if ($req->hasFile('galleryImage')) {
                    $file = $req->file('galleryImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $galleryImage = $dir . $fileName1;
                } else if ($req->galleryImage != "") {
                    $rnd = $this->support->RandomString(10) . "_" . date("YmdHis");
                    $fileName = $rnd . ".png";
                    $imgData = $this->getImageData($req->galleryImage);
                    file_put_contents($dir . $fileName, $imgData);
                    $galleryImage = $dir . $fileName;
                }
                $data = array(
                    "ID" => $ID,
                    "GalleryImage" => $galleryImage,
                    "GalleryID" => $req->GalleryID,
                    "createdOn" => date("Y-m-d H:i:s"),
                    "createdBy" => $this->UserID,
                );
                $status = DB::Table('tbl_gallery_images')->insert($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Gallery-Images");
                $NewData = DB::Table('tbl_gallery_images')->where('ID', $ID)->get();
                $logData = array("Description" => "New Gallery added ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Gallery image added successfully");
            } else {
                if ($galleryImage != "") {
                    if (file_exists($galleryImage)) {
                        unlink($galleryImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Gallery image add failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

   public function Update(Request $req, $ID)
{
    if ($this->general->isCrudAllow($this->CRUD, "edit")) {
        $OldData = DB::table('tbl_gallery_images')->where('ID', $ID)->get();
        $NewData = [];
        DB::beginTransaction();
        try {
            $dir = "uploads/home/gallery/images/" . $ID . "/";
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $galleryImage = "";
            if ($req->hasFile('galleryImage')) {
                $file = $req->file('galleryImage');
                $fileName = md5($file->getClientOriginalName() . time());
                $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                $file->move($dir, $fileName1);
                $galleryImage = $dir . $fileName1;
            } elseif ($req->galleryImage != "") {
                $rnd = $this->support->RandomString(10) . "_" . date("YmdHis");
                $fileName = $rnd . ".png";
                $imgData = $this->getImageData($req->galleryImage);
                file_put_contents($dir . $fileName, $imgData);
                $galleryImage = $dir . $fileName;
            }

            // Prepare update data
            $data = [
                "updatedOn" => date("Y-m-d H:i:s"),
                "updatedBy" => $this->UserID,
            ];

            // If GalleryID or GalleryImage is provided, update them
            if ($req->has('GalleryID')) {
                $data['GalleryID'] = $req->GalleryID;
            }
            if ($galleryImage != "") {
                $data['GalleryImage'] = $galleryImage;
            }

            // Perform the update operation
            $status = DB::table('tbl_gallery_images')->where('ID', $ID)->update($data);
        } catch (Exception $e) {
            logger($e);
            $status = false;
        }

        if ($status) {
            DB::commit();
            $NewData = DB::table('tbl_gallery_images')->where('ID', $ID)->get();
            $logData = [
                "Description" => "Gallery updated",
                "ModuleName" => $this->ActiveMenuName,
                "Action" => cruds::UPDATE,
                "ReferID" => $ID,
                "OldData" => $OldData,
                "NewData" => $NewData,
                "UserID" => $this->UserID,
                "IP" => $req->ip(),
            ];
            $this->logs->Store($logData);
            return ['status' => true, 'message' => "Gallery updated successfully"];
        } else {
            // If galleryImage is not empty and the update failed, remove the uploaded image
            if ($galleryImage != "") {
                if (file_exists($galleryImage)) {
                    unlink($galleryImage);
                }
            }
            DB::rollback();
            return ['status' => false, 'message' => "Gallery update failed"];
        }
    } else {
        return response(['status' => false, 'message' => "Access Denied"], 403);
    }
}


    public function Delete(Request $req, $ID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_gallery_images')->where('ID', $ID)->get();
                $status = DB::table('tbl_gallery_images')->where('ID', $ID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Gallery image has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Gallery image deleted successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Gallery image delete failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $ID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_gallery_images')->where('ID', $ID)->get();
                $status = DB::table('tbl_gallery_images')->where('ID', $ID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_gallery_images')->where('ID', $ID)->get();
                $logData = array("Description" => "Gallery image has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Gallery image restored successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Gallery image restore failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function getGalleryName()
    {
        $data = DB::table('tbl_gallery_master')->where('DFlag', 0)->where('ActiveStatus', 1)->get();
        return $data;
    }

	 public function deleted(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['galleryImages'] = DB::Table('tbl_gallery_images')->where('DFlag', 1)->get();
            return view('admin.home.gallery.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/home/gallery/deleted');
        } else {
            return view('errors.403');
        }
    }
}
