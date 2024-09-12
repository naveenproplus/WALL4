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

class ProjectAreaController extends Controller
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
        $this->ActiveMenuName = "Project-Area";
        $this->PageTitle = "Project Area";
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
            return view('admin.master.project-area.view', $FormData);
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
            return view('admin.master.project-area.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/category');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/project-area/create');
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
            return view('admin.master.project-area.create', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/project-type');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $ProjectAreaID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ProjectAreaID'] = $ProjectAreaID;
            $FormData['EditData'] = DB::Table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->where('DFlag', 0)->get();
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.project-area.create', $FormData);
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
            $img = json_decode($req->Images, true);

            $OldData = $NewData = array();
            $rules = array(
                'ProjectAreaName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_project_area", "WHERE" => "ProjectAreaName='" . $req->ProjectAreaName . "' and ProjectType ='" . $req->ProjectType . "'"), "This Project Area Name is already exists.")],
            );
            $message = array();

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                if ($img && array_key_exists("coverImg", $img)) {
                    if (file_exists($img['coverImg']['uploadPath'])) {
                        unlink($img['coverImg']['uploadPath']);
                    }
                }
                return array('status' => false, 'message' => "Project Area Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            try {
                $ProjectAreaImage = "";
                $ProjectAreaID = $this->DocNum->getDocNum("Project-Area");
                $dir = "uploads/admin/master/project-area/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                if ($img && array_key_exists('coverImg', $img) && file_exists($img['coverImg']['uploadPath'])) {
                    $UploadedImage = $img['coverImg']['uploadPath'];
                    $originalFileName = pathinfo($img['coverImg']['fileName'], PATHINFO_FILENAME);
                    $originalExtension = strtolower(pathinfo($img['coverImg']['fileName'], PATHINFO_EXTENSION));
                    $defaultImage = $dir . $originalFileName . '.' . $originalExtension;

                    copy($UploadedImage, $defaultImage);
                    $webImage = helper::compressImageToWebp($defaultImage);
                    if ($webImage['status']) {
                        $ProjectAreaImage = $webImage['path'];
                    } else {
                        return $webImage;
                    }
                    unlink($UploadedImage);
                }

                $data = array(
                    "ProjectAreaID" => $ProjectAreaID,
                    "ProjectAreaName" => $req->ProjectAreaName,
                    "ProjectType" => $req->ProjectType,
                    "ProjectAreaImage" => $ProjectAreaImage,
                    "ActiveStatus" => $req->ActiveStatus,
                    "CreatedOn" => date("Y-m-d H:i:s"),
                    "CreatedBy" => $this->UserID,
                );
                $status = DB::Table('tbl_project_area')->insert($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Project-Area");
                $NewData = DB::Table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->get();
                $logData = array("Description" => "New Project Area Created ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD, "ReferID" => $ProjectAreaID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Project Area Create Successfully");
            } else {
                if ($ProjectAreaImage != "") {
                    if (file_exists($ProjectAreaImage)) {
                        unlink($ProjectAreaImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Project Area Create Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Update(Request $req, $ProjectAreaID)
    {
        logger($req);
        // return $req;

        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {

            $img = json_decode($req->Images, true);
            $OldData = $NewData = array();
            $OldData = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->get();

            $rules = array(
                'ProjectAreaName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_project_area", "WHERE" => " ProjectAreaName='" . $req->ProjectAreaName . "' and ProjectType ='" . $req->ProjectType . "' and  ProjectAreaID <>'" . $ProjectAreaID . "'"), "This Project Area Name already exists.")],
            );

            $message = array();

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                if ($img && array_key_exists("url", $img)) {
                    if (file_exists($img['url'])) {
                        unlink($img['url']);
                    }
                }
                return array('status' => false, 'message' => "Project Area Update Failed", 'errors' => $validator->errors());
            }

            DB::beginTransaction();
            $status = false;
            try {
                $OldImage = "";
                $ProjectAreaImage = "";
                $dir = "uploads/admin/master/project-area/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }


                if ($img && array_key_exists('url', $img) && file_exists($img['url'])) {
                    $UploadedImage = $img['url'];
                    $originalFileName = pathinfo($img['url'], PATHINFO_FILENAME);
                    $originalExtension = strtolower(pathinfo($img['url'], PATHINFO_EXTENSION));
                    $defaultImage = $dir . $originalFileName . '.' . $originalExtension;

                    copy($UploadedImage, $defaultImage);
                    $webImage = helper::compressImageToWebp($defaultImage);
                    if ($webImage['status']) {
                        $ProjectAreaImage = $webImage['path'];
                    } else {
                        return $webImage;
                    }
                    $OldImage = $OldData[0]->ProjectAreaImage;
                    unlink($UploadedImage);
                }

                $data = array(
                    "ProjectAreaName" => $req->ProjectAreaName,
                    "ProjectType" => $req->ProjectType,
                    "ActiveStatus" => $req->ActiveStatus,
                    "UpdatedOn" => date("Y-m-d H:i:s"),
                    "UpdatedBy" => $this->UserID,
                );

                if ($ProjectAreaImage) {
                    $data["ProjectAreaImage"] = $ProjectAreaImage;
                }

                $status = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->update($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();

                if ($OldImage != "") {
                    if (file_exists($OldImage)) {
                        unlink($OldImage);
                    }
                }

                $NewData = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->get();
                $logData = array(
                    "Description" => "Project Area Updated",
                    "ModuleName" => $this->ActiveMenuName,
                    "Action" => cruds::UPDATE,
                    "ReferID" => $ProjectAreaID,
                    "OldData" => $OldData,
                    "NewData" => $NewData,
                    "UserID" => $this->UserID,
                    "IP" => $req->ip(),
                );
                $this->logs->Store($logData);

                return array('status' => true, 'message' => "Project Area Update Successfully");
            } else {
                if ($ProjectAreaImage != "") {
                    if (file_exists($ProjectAreaImage)) {
                        unlink($ProjectAreaImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Project Area Update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Delete(Request $req, $ProjectAreaID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->get();
                $status = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Project Area has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ProjectAreaID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Project Area Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Project Area Delete Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $ProjectAreaID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->get();
                $status = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_project_area')->where('ProjectAreaID', $ProjectAreaID)->get();
                $logData = array("Description" => "Project Area has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $ProjectAreaID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Project Area Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Project Area Restore Failed");
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
                array('db' => 'ProjectAreaID', 'dt' => '0'),
                array('db' => 'ProjectAreaName', 'dt' => '1'),
                array('db' => 'ProjectType', 'dt' => '2'),
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
                    'db' => 'ProjectAreaID',
                    'dt' => '4',
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
            $data['TABLE'] = 'tbl_project_area';
            $data['PRIMARYKEY'] = 'ProjectAreaID';
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
                array('db' => 'ProjectAreaID', 'dt' => '0'),
                array('db' => 'ProjectAreaName', 'dt' => '1'),
                array('db' => 'ProjectType', 'dt' => '2'),
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
                    'db' => 'ProjectAreaID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_project_area';
            $data['PRIMARYKEY'] = 'ProjectAreaID';
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
