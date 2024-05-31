<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\admin\logController;
use App\Http\Controllers\Controller;
use App\Models\DocNum;
use App\Models\general;
use App\Models\ServerSideProcess;
use App\Models\support;
use App\Rules\ValidUnique;
use Auth;
use cruds;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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
        $this->ActiveMenuName = "Gallery-Type";
        $this->PageTitle = "Gallery Type";
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
            return view('admin.master.gallery.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/category/create');
        } else {
            return view('errors.403');
        }
    }

    public function restoreView(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            return view('admin.master.gallery.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/category');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/gallery/create');
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
            return view('admin.master.gallery.create', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/gallery');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $GalleryID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['GalleryID'] = $GalleryID;
            $FormData['EditData'] = DB::Table('tbl_gallery_master')->where('GalleryID', $GalleryID)->where('DFlag', 0)->get();
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.gallery.create', $FormData);
            } else {
                return view('errors.400');
            }
        } else {
            return view('errors.403');
        }
    }
    public function Save(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "add") == true) {
            $OldData = $NewData = array();
            $GalleryID = "";
            $rules = array(
                'GalleryName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_gallery_master", "WHERE" => " GalleryName='" . $req->GalleryName . "'"), "This Gallery Name is already exists.")],
            );
            $message = array();

            if ($req->CoverImage != "") {$rules['CoverImage'] = 'mimes:jpeg,jpg,png,gif,bmp';}
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Gallery Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $CoverImage = "";
            try {

                $GalleryID = $this->DocNum->getDocNum("Gallery");

                if ($req->hasFile('CoverImage')) {
                    $dir = "uploads/admin/master/Gallery/";
                    if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                    $file = $req->file('CoverImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $CoverImage = $dir . $fileName1;
                }

                $data = array(
                    "GalleryID" => $GalleryID,
                    "GalleryName" => $req->GalleryName,
                    "CoverImage" => $CoverImage,
                    "ActiveStatus" => $req->ActiveStatus,
                    "createdOn" => date("Y-m-d H:i:s"),
                    "createdBy" => $this->UserID,
                );
                $status = DB::Table('tbl_gallery_master')->insert($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Gallery");
                $NewData = DB::Table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();
                $logData = array("Description" => "New Gallery Created ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD, "ReferID" => $GalleryID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Gallery Create Successfully");
            } else {
                if ($CoverImage != "") {
                    if (file_exists($CoverImage)) {
                        unlink($CoverImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Gallery Create Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Update(Request $req, $GalleryID)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $OldData = $NewData = array();
            $OldData = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();

            $rules = array(
                'GalleryName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_gallery_master", "WHERE" => " GalleryName='" . $req->GalleryName . "' and GalleryID<>'" . $GalleryID . "'"), "This Gallery Name already exists.")],
            );

            $message = array();

            if ($req->hasFile('CoverImage')) {
                $rules['CoverImage'] = 'mimes:jpeg,jpg,png,gif,bmp';
            }

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Gallery Update Failed", 'errors' => $validator->errors());
            }

            DB::beginTransaction();
            $status = false;
            $CoverImage = "";

            try {
                $CImage = "";

                if ($req->hasFile('CoverImage')) {
                    $dir = "uploads/admin/master/gallery/";

                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }

                    $file = $req->file('CoverImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $CoverImage = $dir . $fileName1;

                    $result = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();

                    if (count($result) > 0) {
                        $CImage = $result[0]->CoverImage;
                    }
                }

                $data = array(
                    "GalleryName" => $req->GalleryName,
                    "ActiveStatus" => $req->ActiveStatus,
                    "updatedOn" => date("Y-m-d H:i:s"),
                    "UpdatedBy" => $this->UserID,
                );

                if ($CoverImage != "") {
                    $data["CoverImage"] = $CoverImage;
                }

                $status = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->update($data);
            } catch (Exception $e) {
                $status = false;
            }

            if ($status == true) {
                DB::commit();

                if ($CImage != "") {
                    if (file_exists($CImage)) {
                        unlink($CImage);
                    }
                }

                $NewData = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();
                $logData = array(
                    "Description" => "Gallery Updated",
                    "ModuleName" => $this->ActiveMenuName,
                    "Action" => cruds::UPDATE,
                    "ReferID" => $GalleryID,
                    "OldData" => $OldData,
                    "NewData" => $NewData,
                    "UserID" => $this->UserID,
                    "IP" => $req->ip(),
                );
                $this->logs->Store($logData);

                return array('status' => true, 'message' => "Gallery Update Successfully");
            } else {
                if ($CoverImage != "") {
                    if (file_exists($CoverImage)) {
                        unlink($CoverImage);
                    }
                }

                DB::rollback();

                return array('status' => false, 'message' => "Gallery Update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Delete(Request $req, $GalleryID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();
                $status = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Gallery has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $GalleryID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Gallery Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Gallery Delete Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $GalleryID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();
                $status = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_gallery_master')->where('GalleryID', $GalleryID)->get();
                $logData = array("Description" => "Gallery has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $GalleryID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Gallery Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Gallery Restore Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function TableView(Request $request)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $ServerSideProcess = new ServerSideProcess();
            $columns = array(
                array('db' => 'GalleryID', 'dt' => '0'),
                array('db' => 'GalleryName', 'dt' => '1'),
                array(
                    'db' => 'ActiveStatus',
                    'dt' => '2',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'GalleryID',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        $html = '';
                        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn  btn-outline-success m-5 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
                        }
                        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn  btn-outline-danger m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_gallery_master';
            $data['PRIMARYKEY'] = 'GalleryID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = " DFlag=0 ";
            return $ServerSideProcess->SSP($data);
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function RestoreTableView(Request $request)
    {
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            $ServerSideProcess = new ServerSideProcess();
            $columns = array(
                array('db' => 'GalleryID', 'dt' => '0'),
                array('db' => 'GalleryName', 'dt' => '1'),
                array(
                    'db' => 'ActiveStatus',
                    'dt' => '2',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'GalleryID',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_gallery_master';
            $data['PRIMARYKEY'] = 'GalleryID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = " DFlag=1 ";
            return $ServerSideProcess->SSP($data);
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
}
