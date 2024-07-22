<?php

namespace App\Http\Controllers\admin\master;

use App\helper\helper;
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

class categoryController extends Controller
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
        $this->ActiveMenuName = "Category";
        $this->PageTitle = "Category";
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
            return view('admin.master.category.view', $FormData);
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
            return view('admin.master.category.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/category');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/category/create');
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
            return view('admin.master.category.create', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/category');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $CID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['CID'] = $CID;
            $FormData['EditData'] = DB::Table('tbl_category')->where('CID', $CID)->where('DFlag', 0)->get();
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.category.create', $FormData);
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
            $CID = "";
            $rules = array(
                'CategoryName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_category", "WHERE" => " CName='" . $req->CategoryName . "'"), "This Category Name is already exists.")],
            );
            $message = array();

            if ($req->CategoryImage != "") {$rules['CategoryImage'] = 'mimes:jpeg,jpg,png,gif,bmp';}
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Category Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $CategoryImage = "";
            try {

                $CID = $this->DocNum->getDocNum("CATEGORY");

                if ($req->hasFile('CategoryImage')) {
                    $dir = "uploads/admin/master/category/";
                    if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                    $file = $req->file('CategoryImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $originalFilePath = $dir . $fileName1;
                    $webImage = helper::compressImageToWebp($originalFilePath);
                    if($webImage['status']){
                        $CategoryImage = $webImage['path'];
                    }else{
                        return $webImage;
                    }
                }

                $data = array(
                    "CID" => $CID,
                    "CName" => $req->CategoryName,
                    "CImage" => $CategoryImage,
                    "ActiveStatus" => $req->ActiveStatus,
                    "createdOn" => date("Y-m-d H:i:s"),
                    "createdBy" => $this->UserID,
                );
                $status = DB::Table('tbl_category')->insert($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("CATEGORY");
                $NewData = DB::Table('tbl_category')->where('CID', $CID)->get();
                $logData = array("Description" => "New Category Created ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD, "ReferID" => $CID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Category Create Successfully");
            } else {
                if ($CategoryImage != "") {
                    if (file_exists($CategoryImage)) {
                        unlink($CategoryImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Category Create Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Update(Request $req, $CID)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $OldData = $NewData = array();
            $OldData = DB::table('tbl_category')->where('CID', $CID)->get();

            $rules = array(
                'CategoryName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_category", "WHERE" => " CName='" . $req->CategoryName . "' and CID<>'" . $CID . "'"), "This Category Name is already exists.")],
            );
            $message = array();
            if ($req->CategoryImage != "") {$rules['CategoryImage'] = 'mimes:jpeg,jpg,png,gif,bmp';}
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Category Update Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $CategoryImage = "";
            try {
                $CImage = "";
                if ($req->hasFile('CategoryImage')) {
                    $dir = "uploads/admin/master/category/";
                    if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                    $file = $req->file('CategoryImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $originalFilePath = $dir . $fileName1;
                    $webImage = Helper::compressImageToWebp($originalFilePath);
                    if($webImage['status']){
                        $CategoryImage = $webImage['path'];
                    }else{
                        return $webImage;
                    }
                    $CImage = $OldData[0]->CImage;
                }

                $data = array(
                    "CName" => $req->CategoryName,
                    "ActiveStatus" => $req->ActiveStatus,
                    "updatedOn" => date("Y-m-d H:i:s"),
                    "UpdatedBy" => $this->UserID,
                );
                if ($CategoryImage != "") {
                    $data["CImage"] = $CategoryImage;
                }
                $status = DB::Table('tbl_category')->where('CID', $CID)->update($data);
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
                $NewData = DB::Table('tbl_category')->where('CID', $CID)->get();
                $logData = array("Description" => "Category Updated ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::UPDATE, "ReferID" => $CID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Category Update Successfully");
            } else {
                if ($CategoryImage != "") {
                    if (file_exists($CategoryImage)) {
                        unlink($CategoryImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Category Update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Delete(Request $req, $CID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_category')->where('CID', $CID)->get();
                $status = DB::table('tbl_category')->where('CID', $CID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Category has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $CID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Category Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Category Delete Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $CID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_category')->where('CID', $CID)->get();
                $status = DB::table('tbl_category')->where('CID', $CID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_category')->where('CID', $CID)->get();
                $logData = array("Description" => "Category has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $CID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Category Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Category Restore Failed");
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
                array('db' => 'CID', 'dt' => '0'),
                array('db' => 'CName', 'dt' => '1'),
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
                    'db' => 'CID',
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
            $data['TABLE'] = 'tbl_category';
            $data['PRIMARYKEY'] = 'CID';
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
                array('db' => 'CID', 'dt' => '0'),
                array('db' => 'CName', 'dt' => '1'),
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
                    'db' => 'CID',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_category';
            $data['PRIMARYKEY'] = 'CID';
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
