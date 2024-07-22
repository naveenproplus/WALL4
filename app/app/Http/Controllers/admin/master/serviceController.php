<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\admin\logController;
use App\Http\Controllers\Controller;
use App\Models\addWaterMark;
use App\Models\DocNum;
use App\Models\general;
use App\Models\ServerSideProcess;
use App\Models\support;
use App\Rules\ValidDB;
use App\Rules\ValidUnique;
use Auth;
use cruds;
use DB;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class serviceController extends Controller
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
    private $addWaterMark;
    public function __construct()
    {
        $this->ActiveMenuName = "Services";
        $this->PageTitle = "Services";
        $this->middleware('auth');
        $this->DocNum = new DocNum();
        $this->support = new support();
        $this->addWaterMark = new addWaterMark();

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
            return view('admin.master.services.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/services/create');
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
            return view('admin.master.services.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/services');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/services/create');
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
            $FormData['ServiceIcons'] = $this->getServiceIcons();
            return view('admin.master.services.service', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/services');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $ServiceID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ServiceID'] = $ServiceID;
            $FormData['Settings'] = $this->Settings;
            $FormData['ServiceIcons'] = $this->getServiceIcons();
            $FormData['EditData'] = $this->getServices(array("ServiceID" => $ServiceID));
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.services.service', $FormData);
            } else {
                return view('errors.400');
            }
        } else {
            return view('errors.403');
        }
    }

    public function getCategory(Request $req)
    {
        return DB::Table('tbl_category')->where('DFlag', 0)->where('ActiveStatus', 1)->orderBy('CName', 'asc')->get();
    }

    public function getTax(Request $req)
    {
        return DB::Table('tbl_tax')->where('DFlag', 0)->where('ActiveStatus', 1)->get();
    }
    public function getUOM(Request $req)
    {
        return DB::Table('tbl_uom')->where('DFlag', 0)->where('ActiveStatus', 1)->orderBy('UName', 'asc')->get();
    }
    public function checkServiceName(Request $req)
    {
        $sql = "Select * from tbl_services Where ServiceName='" . $req->ServiceName . "'";
        if ($req->serviceID != "") {
            $sql .= " and ServiceID<>'" . $req->serviceID . "'";
        }
        $result = DB::SELECT($sql);
        if (count($result) > 0) {
            return array('status' => true, "message" => "Service Name is not available. Already taken");
        } else {
            return array('status' => false, "message" => "Service Name is available");
        }
    }
    public function checkSlug(Request $req)
    {
        $sql = "Select * from tbl_services Where Slug='" . $req->Slug . "'";
        if ($req->serviceID != "") {
            $sql .= " and ServiceID<>'" . $req->serviceID . "'";
        }
        $result = DB::SELECT($sql);
        if (count($result) > 0) {
            return array('status' => true, "message" => "Slug is not available. Already taken");
        } else {
            return array('status' => false, "message" => "Slug is available");
        }
    }
    private function getServices($data = array())
    {
        $sql = "SELECT P.ServiceID, P.ServiceName, P.Slug, P.ServiceImage,P.ServiceIcon, P.CID, C.CName, P.Price, P.UOM as UID, U.UCode, U.UName, P.Decimals, P.TaxID, P.TaxType, P.HSNSAC, P.Title, P.Description1, P.Description2, P.Description3, P.ActiveStatus FROM tbl_services as P LEFT JOIN tbl_category as C ON C.CID=P.CID LEFT JOIN tbl_uom as U ON U.UID=P.UOM LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID Where P.DFlag=0 ";
        if (is_array($data)) {
            if (array_key_exists("ServiceID", $data)) {$sql .= " and P.ServiceID='" . $data['ServiceID'] . "'";}
            if (array_key_exists("Slug", $data)) {$sql .= " and P.Slug='" . $data['Slug'] . "'";}
            if (array_key_exists("CID", $data)) {$sql .= " and P.CID='" . $data['CID'] . "'";}

        }
        $result = DB::Select($sql);
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->GalleryImages = DB::Table('tbl_services_gallery')->where('ServiceID', $result[$i]->ServiceID)->get();
        }
        return $result;
    }

    public function Save(Request $req){
        if ($this->general->isCrudAllow($this->CRUD, "add") == true) {
            $img = json_decode($req->Images, true);
            $OldData = $NewData = array();
            $ServiceID = "";

            $ValidDB = array();
            //Tax
            $ValidDB['Tax']['TABLE'] = "tbl_tax";
            $ValidDB['Tax']['ErrMsg'] = "Tax does not exist";
            $ValidDB['Tax']['WHERE'][] = array("COLUMN" => "TaxID", "CONDITION" => "=", "VALUE" => $req->Tax);
            $ValidDB['Tax']['WHERE'][] = array("COLUMN" => "DFlag", "CONDITION" => "=", "VALUE" => 0);
            $ValidDB['Tax']['WHERE'][] = array("COLUMN" => "ActiveStatus", "CONDITION" => "=", "VALUE" => 1);

            //Category
            $ValidDB['Category']['TABLE'] = "tbl_category";
            $ValidDB['Category']['ErrMsg'] = "Category does not exist";
            $ValidDB['Category']['WHERE'][] = array("COLUMN" => "CID", "CONDITION" => "=", "VALUE" => $req->Category);
            $ValidDB['Category']['WHERE'][] = array("COLUMN" => "DFlag", "CONDITION" => "=", "VALUE" => 0);
            $ValidDB['Category']['WHERE'][] = array("COLUMN" => "ActiveStatus", "CONDITION" => "=", "VALUE" => 1);

            $rules = array(
                'ServiceName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_services", "WHERE" => " ServiceName='" . $req->ServiceName . "'"), "This Service Name is already exists.")],
                'Slug' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_services", "WHERE" => " Slug='" . $req->Slug . "'"), "Slug is already exists.")],
                'HSNSAC' => 'required',
                'Price' => 'required|numeric',
                'Category' => ['required', new ValidDB($ValidDB['Category'])],
                'Tax' => ['required', new ValidDB($ValidDB['Tax'])],
            );
            $message = array();

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                if (array_key_exists("coverImg", $img) && file_exists($img['coverImg']['uploadPath'])) {
                    unlink($img['coverImg']['uploadPath']);
                }
                if (array_key_exists("gallery", $img)) {
                    foreach ($img['gallery'] as $gallery) {
                        if (file_exists($gallery['uploadPath'])) {
                            unlink($gallery['uploadPath']);
                        }
                    }
                }
                return array('status' => false, 'message' => "Service Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $ServiceImage = "";
            $galleryUrls = [];
            try {
                $ServiceID = $this->DocNum->getDocNum("Services");
                $dir = "uploads/admin/master/services/" . $ServiceID . "/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                if (array_key_exists("coverImg", $img)) {
                    if (file_exists($img['coverImg']['uploadPath'])) {
                        $UploadedImage = $img['coverImg']['uploadPath'];
                        $originalFileName = pathinfo($img['coverImg']['fileName'], PATHINFO_FILENAME);
                        $originalExtension = strtolower(pathinfo($img['coverImg']['fileName'], PATHINFO_EXTENSION));
                        $defaultImage = $dir . $originalFileName . '.' . $originalExtension;
                    
                        copy($UploadedImage, $defaultImage);
                        $webImage = Helper::compressImageToWebp($defaultImage);
                        if($webImage['status']){
                            $ServiceImage = $webImage['path'];
                        }else{
                            return $webImage;
                        }
                        unlink($UploadedImage);
                    }
                }
                if (array_key_exists("gallery", $img)) {
                    foreach ($img['gallery'] as $pg) {
                        if (file_exists($pg['uploadPath'])) {
                            $UploadedImage = $pg['uploadPath'];
                            $originalFileName = pathinfo($pg['fileName'], PATHINFO_FILENAME);
                            $originalExtension = strtolower(pathinfo($pg['fileName'], PATHINFO_EXTENSION));
                            $defaultImage = $dir . $originalFileName . '.' . $originalExtension;
                        
                            copy($UploadedImage, $defaultImage);
                            $webImage = Helper::compressImageToWebp($defaultImage);
                            if($webImage['status']){
                                $tmp = $webImage['path'];
                            }else{
                                return $webImage;
                            }
                            unlink($UploadedImage);
                            $galleryUrls[] = $tmp;
                        }
                    }
                }
                $data = array(
                    "ServiceID" => $ServiceID,
                    "ServiceName" => $req->ServiceName,
                    "HSNSAC" => $req->HSNSAC,
                    "Slug" => $req->Slug,
                    "CID" => $req->Category,
                    "Price" => $req->Price,
                    "UOM" => $req->UOM,
                    "TaxType" => $req->TaxType,
                    "TaxID" => $req->Tax,
                    "ActiveStatus" => $req->ActiveStatus,
                    "Title" => $req->Title,
                    "Description1" => $req->Description1,
                    "Description2" => $req->Description2,
                    "Description3" => $req->Description3,
                    "ServiceImage" => $ServiceImage,
                    "ServiceIcon" => $req->ServiceIcon,
                    "CreatedOn" => date("Y-m-d H:i:s"),
                    "CreatedBy" => $this->UserID,
                );
                $status = DB::Table('tbl_services')->insert($data);

                if ($status && !empty($galleryUrls)) {
                    foreach ($galleryUrls as $url) {
                        $SLNO = $this->DocNum->getDocNum("Service-Gallery");
                        $inserted = DB::table('tbl_services_gallery')->insert([
                            'SLNO' => $SLNO,
                            'ServiceID' => $ServiceID,
                            'ImageUrl' => $url,
                            'CreatedOn' => date("Y-m-d H:i:s")
                        ]);
                        if ($inserted) {
                            $this->DocNum->updateDocNum("Service-Gallery");
                        }
                    }
                }
            } catch (Exception $e) {
                $status = false;
            }

            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Services");
                $NewData = $this->getServices(array("ServiceID" => $ServiceID));
                $logData = array( "Description" => "New Service Created ","ModuleName" => $this->ActiveMenuName,"Action" => cruds::ADD,"ReferID" => $ServiceID,"OldData" => $OldData,"NewData" => $NewData,"UserID" => $this->UserID,"IP" => $req->ip(),);
                $this->logs->Store($logData);

                return ['status' => true,'message' => "Service Create Successfully"];
            } else {
                if ($ServiceImage && file_exists($ServiceImage)) {
                    unlink($ServiceImage);
                }
                foreach ($galleryUrls as $url) {
                    if (file_exists($url)) {
                        unlink($url);
                    }
                }
                DB::rollback();
                return [ 'status' => false, 'message' => "Service Create Failed"];
            }
        } else {
            return response()->json(['status' => false, 'message' => "Access Denied"], 403);
        }
    }

    public function Update(Request $req, $ServiceID){
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $img = json_decode($req->Images, true);
            $OldData = $NewData = array();

            $ValidDB = array();
            // Tax
            $ValidDB['Tax']['TABLE'] = "tbl_tax";
            $ValidDB['Tax']['ErrMsg'] = "Tax does not exist";
            $ValidDB['Tax']['WHERE'][] = array("COLUMN" => "TaxID", "CONDITION" => "=", "VALUE" => $req->Tax);
            $ValidDB['Tax']['WHERE'][] = array("COLUMN" => "DFlag", "CONDITION" => "=", "VALUE" => 0);
            $ValidDB['Tax']['WHERE'][] = array("COLUMN" => "ActiveStatus", "CONDITION" => "=", "VALUE" => 1);

            // Category
            $ValidDB['Category']['TABLE'] = "tbl_category";
            $ValidDB['Category']['ErrMsg'] = "Category does not exist";
            $ValidDB['Category']['WHERE'][] = array("COLUMN" => "CID", "CONDITION" => "=", "VALUE" => $req->Category);
            $ValidDB['Category']['WHERE'][] = array("COLUMN" => "DFlag", "CONDITION" => "=", "VALUE" => 0);
            $ValidDB['Category']['WHERE'][] = array("COLUMN" => "ActiveStatus", "CONDITION" => "=", "VALUE" => 1);

            $rules = array(
                'ServiceName' => [
                    'required',
                    'min:3',
                    'max:100',
                    new ValidUnique(array("TABLE" => "tbl_services", "WHERE" => " ServiceName='" . $req->ServiceName . "' AND ServiceID != '" . $ServiceID . "'"), "This Service Name is already exists."),
                ],
                'Slug' => [
                    'required',
                    'min:3',
                    'max:100',
                    new ValidUnique(array("TABLE" => "tbl_services", "WHERE" => " Slug='" . $req->Slug . "' AND ServiceID != '" . $ServiceID . "'"), "Slug is already exists."),
                ],

                'Price' => 'required|numeric',
                'Tax' => ['required', new ValidDB($ValidDB['Tax'])],
            );

            $message = array();

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                if (array_key_exists("coverImg", $img) && file_exists($img['coverImg']['uploadPath'])) {
                    unlink($img['coverImg']['uploadPath']);
                }
                if (array_key_exists("gallery", $img)) {
                    foreach ($img['gallery'] as $gallery) {
                        if (file_exists($gallery['uploadPath'])) {
                            unlink($gallery['uploadPath']);
                        }
                    }
                }
                return array('status' => false, 'message' => "Service Update Failed", 'errors' => $validator->errors());
            }

            DB::beginTransaction();
            $status = false;
            $ServiceImage = "";
            $SImage = "";
            $galleryUrls = [];
            try {
                $OldData = $this->getServices(array("ServiceID" => $ServiceID));
                $dir = "uploads/admin/master/services/" . $ServiceID . "/";
                if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                
                if (array_key_exists("coverImg", $img)) {
                    if (file_exists($img['coverImg']['uploadPath'])) {
                        $UploadedImage = $img['coverImg']['uploadPath'];
                        $originalFileName = pathinfo($img['coverImg']['fileName'], PATHINFO_FILENAME);
                        $originalExtension = strtolower(pathinfo($img['coverImg']['fileName'], PATHINFO_EXTENSION));
                        $defaultImage = $dir . $originalFileName . '.' . $originalExtension;
                    
                        copy($UploadedImage, $defaultImage);
                        $webImage = Helper::compressImageToWebp($defaultImage);
                        if($webImage['status']){
                            $ServiceImage = $webImage['path'];
                        }else{
                            return $webImage;
                        }
                        unlink($UploadedImage);
                        $SImage = $OldData[0]->ServiceImage;
                    }
                }
                if (array_key_exists("gallery", $img)) {
                    foreach ($img['gallery'] as $pg) {
                        if (file_exists($pg['uploadPath'])) {
                            $UploadedImage = $pg['uploadPath'];
                            $originalFileName = pathinfo($pg['fileName'], PATHINFO_FILENAME);
                            $originalExtension = strtolower(pathinfo($pg['fileName'], PATHINFO_EXTENSION));
                            $defaultImage = $dir . $originalFileName . '.' . $originalExtension;
                        
                            copy($UploadedImage, $defaultImage);
                            $webImage = Helper::compressImageToWebp($defaultImage);
                            if($webImage['status']){
                                $tmp = $webImage['path'];
                            }else{
                                return $webImage;
                            }
                            unlink($UploadedImage);
                            $galleryUrls[] = array("slno" => $pg['slno'], "ServiceID" => $ServiceID, "ImageUrl" => $tmp);
                        }
                    }
                }

                // Initialize $data with common fields
                $data = array(
                    "ServiceName" => $req->ServiceName,
                    "HSNSAC" => $req->HSNSAC,
                    "Slug" => $req->Slug,
                    "CID" => $req->Category,
                    "Price" => $req->Price,
                    "UOM" => $req->UOM,
                    "TaxType" => $req->TaxType,
                    "TaxID" => $req->Tax,
                    "ActiveStatus" => $req->ActiveStatus,
                    "Title" => $req->Title,
                    "Description1" => $req->Description1,
                    "Description2" => $req->Description2,
                    "Description3" => $req->Description3,
                    "ServiceIcon" => $req->ServiceIcon,
                    "UpdatedOn" => date("Y-m-d H:i:s"),
                    "UpdatedBy" => $this->UserID,
                );

                // Check if both ServiceImage and ServiceIcon paths are not empty
                if ($ServiceImage != "") {
                    $data["ServiceImage"] = $ServiceImage;
                }

                $status = DB::table('tbl_services')->where('ServiceID', $ServiceID)->update($data);
                if ($status) {
                    foreach ($galleryUrls as $pg) {
                        if ($status) {
                            $tmp = DB::Table('tbl_services_gallery')->where('slno', $pg['slno'])->where('ServiceID', $ServiceID)->get();
                            if ($pg['slno'] != "" && count($tmp) > 0) {
                                $pg["UpdatedOn"] = date("Y-m-d H:i:s");
                                $status = DB::Table('tbl_services_gallery')->where('slno', $pg['slno'])->update($pg);
                            } else {
                                $SLNO = $this->DocNum->getDocNum("Service-Gallery");
                                $pg["slno"] = $SLNO;
                                $pg["CreatedOn"] = date("Y-m-d H:i:s");
                                $status = DB::Table('tbl_services_gallery')->insert($pg);
                                if ($status) {
                                    $this->DocNum->updateDocNum("Service-Gallery");
                                }
                            }
                        }
                    }
                }

                if ($status) {
                    $DeletedGalleryImg = json_decode($req->DeletedGalleryImg, true);
                    for ($i = 0; $i < count($DeletedGalleryImg); $i++) {
                        $t = DB::Table('tbl_services_gallery')->where('SLNO', $DeletedGalleryImg[$i])->get();
                        if (count($t) > 0) {
                            if (file_exists($t[0]->ImageUrl)) {
                                unlink($t[0]->ImageUrl);
                            }
                            $status = DB::Table('tbl_services_gallery')->where('SLNO', $DeletedGalleryImg[$i])->delete();
                        }
                    }
                }
            } catch (Exception $e) {
                $status = false;
            }

            if ($status == true) {
                DB::commit();
                if ($SImage != "") {
                    if (file_exists($SImage)) {
                        unlink($SImage);
                    }
                }
                $NewData = $this->getServices(array("ServiceID" => $ServiceID));
                $logData = array("Description" => "Service updated ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::UPDATE, "ReferID" => $ServiceID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Service updated Successfully");
            } else {
                if ($ServiceImage != "") {
                    if (file_exists($ServiceImage)) {
                        unlink($ServiceImage);
                    }
                }
                foreach ($gallery as $pg) {
                    if (file_exists($pg['ImageUrl'])) {
                        unlink($pg['ImageUrl']);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Service Update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Delete(Request $req, $ServiceID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = $this->getServices(array("ServiceID" => $ServiceID));
                $status = DB::table('tbl_services')->where('ServiceID', $ServiceID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Service has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ServiceID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Service Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Service Delete Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $ServiceID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = $this->getServices(array("ServiceID" => $ServiceID));
                $status = DB::table('tbl_services')->where('ServiceID', $ServiceID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = $this->getServices(array("ServiceID" => $ServiceID));
                $logData = array("Description" => "Service has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $ServiceID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Service Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Service Restore Failed");
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
                array('db' => 'P.ServiceName', 'dt' => '0'),
                array('db' => 'C.CName', 'dt' => '1'),
                array('db' => 'P.Price', 'dt' => '2'),
                array('db' => 'P.ActiveStatus', 'dt' => '3'),
                array('db' => 'P.ServiceID', 'dt' => '4'),
                array('db' => 'P.Slug', 'dt' => '5'),
            );

            $columns1 = array(
                array('db' => 'ServiceName', 'dt' => '0',
                    'formatter' => function ($d, $row) {
                        return '<a target="_blank" href="' . url('/') . '/services/' . $row['Slug'] . '">' . $d . '</a>';
                    }
                ),
                array('db' => 'CName', 'dt' => '1'),
                array('db' => 'Price', 'dt' => '2', 'formatter' => function ($d, $row) {return Helper::NumberFormat($d, $this->Settings['price-decimals']);}),
                array('db' => 'ActiveStatus', 'dt' => '3',
                    'formatter' => function ($d, $row) {
                        return $d == "1" ? "<span class='badge badge-success m-1'>Active</span>" : "<span class='badge badge-danger m-1'>Inactive</span>";
                    },
                ),
                array(
                    'db' => 'ServiceID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '';
                        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn btn-outline-success m-5 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
                        }
                        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn btn-outline-danger m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }
                        return $html;
                    },
                ),
                array('db' => 'Slug', 'dt' => '5'),
            );

            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_services as P LEFT JOIN tbl_category as C ON C.CID=P.CID LEFT JOIN tbl_uom as U ON U.UID=P.UOM LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID';
            $data['PRIMARYKEY'] = 'P.ServiceID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = " P.DFlag=0 ";
            return $ServerSideProcess->SSP($data);
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function RestoreTableView(Request $request){
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $ServerSideProcess = new ServerSideProcess();

            $columns = array(
                array('db' => 'P.ServiceName', 'dt' => '0'),
                array('db' => 'C.CName', 'dt' => '1'),
                array('db' => 'P.Price', 'dt' => '2'),
                array(
                    'db' => 'P.ActiveStatus',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'ServiceID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '';
                        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
                            $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        }
                        return $html;
                    },
                ),
                array('db' => 'P.Slug', 'dt' => '5'),
            );

            $columns1 = array(
                array('db' => 'ServiceName', 'dt' => '0', 'formatter' => function ($d, $row) {return '<a target="_blank" href="' . url('/') . '/services/' . $row['Slug'] . '">' . $d . '</a>';}),
                array('db' => 'CName', 'dt' => '1'),
                array('db' => 'Price', 'dt' => '2', 'formatter' => function ($d, $row) {return Helper::NumberFormat($d, $this->Settings['price-decimals']);}),
                array(
                    'db' => 'ActiveStatus',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'ServiceID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '';
                        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
                            $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        }
                        return $html;
                    },
                ),
                array('db' => 'Slug', 'dt' => '5'),
            );

            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_services as P LEFT JOIN tbl_category as C ON C.CID=P.CID LEFT JOIN tbl_uom as U ON U.UID=P.UOM LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID';
            $data['PRIMARYKEY'] = 'P.ServiceID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = " P.DFlag=1 ";
            return $ServerSideProcess->SSP($data);
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function getServiceIcons(){
        return ['blueprint-1','blueprint','crane','left-arrow','parquet','briefing','checked','close','coffee-cup','concept','email','execution','furniture','graphic-designer','happy','home','interior-design','login','loupe','maps-and-location','parquet','phone-call','pin','placeholder','play','plus','project-management','quotation','quote','right-arrow','support','telephone'];
    }


}
