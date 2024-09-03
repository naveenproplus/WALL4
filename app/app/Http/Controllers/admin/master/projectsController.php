<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\admin\logController;
use App\Http\Controllers\Controller;
use App\Models\addWaterMark;
use App\Models\DocNum;
use App\Models\general;
use App\Models\ServerSideProcess;
use App\Models\support;
use App\Rules\ValidUnique;
use Auth;
use cruds;
use Helper;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class projectsController extends Controller
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
        $this->ActiveMenuName = "Projects";
        $this->PageTitle = "Projects";
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
            return view('admin.master.projects.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/projects/create');
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
            return view('admin.master.projects.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/projects');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/projects/create');
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
            $FormData['Services'] = $this->getServices();
            return view('admin.master.projects.project', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/projects');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $ProjectID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ProjectID'] = $ProjectID;
            $FormData['Settings'] = $this->Settings;
            $FormData['Services'] = $this->getServices();
            $FormData['EditData'] = $this->getProjects(array("ProjectID" => $ProjectID));
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.projects.project', $FormData);
            } else {
                return view('errors.400');
            }
        } else {
            return view('errors.403');
        }
    }

    private function getProjects($data = array())
    {
        $sql = "SELECT P.ProjectID, P.ProjectName, P.Slug, P.SDesc, P.LDesc ,P.ProjectAddress ,P.ProjectImage , P.ActiveStatus, P.ProjectAddress,P.ClientID ,P.ServiceID ,P.ProjectAreaID, PA.ProjectType FROM tbl_projects as P left join tbl_project_area as PA on PA.ProjectAreaID = P.ProjectAreaID Where P.DFlag = 0 ";
        if (is_array($data)) {
            if (array_key_exists("ProjectID", $data)) {$sql .= " and P.ProjectID='" . $data['ProjectID'] . "'";}

        }
        $result = DB::Select($sql);
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->GalleryImages = DB::Table('tbl_projects_gallery')->where('ProjectID', $result[$i]->ProjectID)->get();
        }
        return $result;
    }

    public function Save(Request $req){
        if ($this->general->isCrudAllow($this->CRUD, "add") == true) {
            $img = json_decode($req->Images, true);
            $OldData = $NewData = array();
            $ProjectID = "";

            $ValidDB = array();

            $rules = array(
                'ProjectName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_projects", "WHERE" => " ProjectName='" . $req->ProjectName . "'"), "This Project Name is already exists.")],
                'Slug' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_projects", "WHERE" => " Slug='" . $req->Slug . "'"), "Slug is already exists.")],

                'ClientID' => ['required'],
                'ProjectAreaID' => ['required'],
            );

            $message = [
                'ClientID.required' => 'Client field is required.',
            ];

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                if (array_key_exists("coverImg", $img)) {
                    if (file_exists($img['coverImg']['uploadPath'])) {
                        unlink($img['coverImg']['uploadPath']);
                    }
                }
                if (array_key_exists("gallery", $img)) {
                    foreach ($img['gallery'] as $gallery) {
                        if (file_exists($gallery['uploadPath'])) {
                            unlink($gallery['uploadPath']);
                        }
                    }
                }
                return array('status' => false, 'message' => "Project Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $ProjectImage = "";
            $galleryUrls = [];
            try {
                $ProjectID = $this->DocNum->getDocNum("Projects");
                $dir = "uploads/admin/master/projects/" . $ProjectID . "/";
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
                            $ProjectImage = $webImage['path'];
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
                    "ProjectID" => $ProjectID,
                    "ProjectName" => $req->ProjectName,
                    "Slug" => $req->Slug,
                    "ProjectAreaID" => $req->ProjectAreaID,
                    "ProjectAddress" => $req->Address,
                    "SDesc" => $req->SDesc,
                    "LDesc" => $req->LDesc,
                    "ClientID" => $req->ClientID,
                    "ServiceID" => $req->ServiceID,
                    "CreatedOn" => date("Y-m-d H:i:s"),
                    "CreatedBy" => $this->UserID,
                );

                if ($ProjectImage) {
                    $data["ProjectImage"] = $ProjectImage;
                }

                $status = DB::Table('tbl_projects')->insert($data);
                // Store gallery images URLs in the database
                if ($status && !empty($galleryUrls)) {
                    foreach ($galleryUrls as $url) {
                        $SLNO = $this->DocNum->getDocNum("Project-Gallery");
                        $inserted = DB::table('tbl_projects_gallery')->insert([
                            'ProjectID' => $ProjectID,
                            'ImageUrl' => $url,
                            'SLNO' => $SLNO,
                            'CreatedOn' => date("Y-m-d H:i:s"),
                        ]);
                        if ($inserted) {
                            $this->DocNum->updateDocNum("Project-Gallery");
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error('Error inserting project: ' . $e->getMessage());
                $status = false;
            }

            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Projects");
                $NewData = $this->getProjects(array("ProjectID" => $ProjectID));
                $logData = array(
                    "Description" => "New Project Created ",
                    "ModuleName" => $this->ActiveMenuName,
                    "Action" => cruds::ADD,
                    "ReferID" => $ProjectID,
                    "OldData" => $OldData,
                    "NewData" => $NewData,
                    "UserID" => $this->UserID,
                    "IP" => $req->ip(),
                );
                $this->logs->Store($logData);

                return [
                    'status' => true,
                    'message' => "Project Created Successfully",
                ];
            } else {
                if ($ProjectImage != "") {
                    if (file_exists($ProjectImage)) {
                        unlink($ProjectImage);
                    }
                }
                foreach ($galleryUrls as $url) {
                    if (file_exists($url)) {
                        unlink($url);
                    }
                }
                DB::rollback();

                return [ 'status' => false, 'message' => "Project Create Failed"];
            }
        } else {
            return response()->json(['status' => false, 'message' => "Access Denied"], 403);
        }
    }

    public function Update(Request $req, $ProjectID)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $img = json_decode($req->Images, true);
            $OldData = $NewData = array();

            $rules = array(
                'ProjectName' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_projects", "WHERE" => " ProjectName='" . $req->ProjectName . "' AND ProjectID != '" . $ProjectID . "'"), "This Project Name is already exists.")],
                'ClientID' => ['required'],
                'Slug' => ['required','min:3','max:100',new ValidUnique(array("TABLE" => "tbl_projects", "WHERE" => " Slug='" . $req->Slug . "' AND ProjectID != '" . $ProjectID . "'"), "Slug is already exists.")],
            );

            $message = array();

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                if (array_key_exists("coverImg", $img)) {
                    if (file_exists($img['coverImg']['uploadPath'])) {
                        unlink($img['coverImg']['uploadPath']);
                    }
                }
                if (array_key_exists("gallery", $img)) {
                    foreach ($img['gallery'] as $gallery) {
                        if (file_exists($gallery['uploadPath'])) {
                            unlink($gallery['uploadPath']);
                        }
                    }
                }
                return array('status' => false, 'message' => "Project Update Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $ProjectImage = "";
            $gallery = [];
            try {
                $OldData = $this->getProjects(array("ProjectID" => $ProjectID));
                $dir = "uploads/admin/master/projects/" . $ProjectID . "/";
                if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                $newProjectImgPath = '';

                if (array_key_exists('coverImg', $img) && file_exists($img['coverImg']['uploadPath'])) {

                    if (file_exists($img['coverImg']['uploadPath'])) {
                        $UploadedImage = $img['coverImg']['uploadPath'];
                        $originalFileName = pathinfo($img['coverImg']['fileName'], PATHINFO_FILENAME);
                        $originalExtension = strtolower(pathinfo($img['coverImg']['fileName'], PATHINFO_EXTENSION));
                        $defaultImage = $dir . $originalFileName . '.' . $originalExtension;
                    
                        copy($UploadedImage, $defaultImage);
                        $webImage = Helper::compressImageToWebp($defaultImage);
                        if($webImage['status']){
                            $newProjectImgPath = $webImage['path'];
                        }else{
                            return $webImage;
                        }
                        unlink($UploadedImage);
                        $ProjectImage = $OldData[0]->ProjectImage;
                    }
                }

                // Store gallery images URLs in the database
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
                            $gallery[] = array("slno" => $pg['slno'], "ProjectID" => $ProjectID, "ImageUrl" => $tmp);
                        }
                    }
                }

                // Initialize $data with common fields
                $data = array(
                    "ProjectName" => $req->ProjectName,
                    "Slug" => $req->Slug,
                    "ProjectAddress" => $req->Address,
                    "ClientID" => $req->ClientID,
                    "ServiceID" => $req->ServiceID,
                    "ProjectAreaID" => $req->ProjectAreaID,
                    "SDesc" => $req->SDesc,
                    "LDesc" => $req->LDesc,
                    "CreatedOn" => date("Y-m-d H:i:s"),
                    "CreatedBy" => $this->UserID,
                );

                // Check if only ProjectImage path is not empty
                if ($newProjectImgPath != "") {
                    $data["ProjectImage"] = $newProjectImgPath;
                }

                $status = DB::table('tbl_projects')->where('ProjectID', $ProjectID)->update($data);
                if ($status) {
                    foreach ($gallery as $pg) {
                        if ($status) {
                            $tmp = DB::Table('tbl_projects_gallery')->where('slno', $pg['slno'])->where('ProjectID', $ProjectID)->get();
                            if ($pg['slno'] != "" && count($tmp) > 0) {
                                $pg["UpdatedOn"] = date("Y-m-d H:i:s");
                                $status = DB::Table('tbl_projects_gallery')->where('slno', $pg['slno'])->update($pg);
                            } else {
                                $SLNO = $this->DocNum->getDocNum("Project-Gallery");
                                $pg["slno"] = $SLNO;
                                $pg["CreatedOn"] = date("Y-m-d H:i:s");
                                $status = DB::Table('tbl_projects_gallery')->insert($pg);
                                if ($status) {
                                    $this->DocNum->updateDocNum("Project-Gallery");
                                }
                            }
                        }
                    }
                }

                if ($status) {
                    $DeletedGalleryImg = json_decode($req->DeletedGalleryImg, true);
                    for ($i = 0; $i < count($DeletedGalleryImg); $i++) {
                        $t = DB::Table('tbl_projects_gallery')->where('SLNO', $DeletedGalleryImg[$i])->get();
                        if (count($t) > 0) {
                            if (file_exists($t[0]->ImageUrl)) {
                                unlink($t[0]->ImageUrl);
                            }
                            $status = DB::Table('tbl_projects_gallery')->where('SLNO', $DeletedGalleryImg[$i])->delete();
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error('Error inserting project: ' . $e->getMessage()); // Log the exception message

                $status = false;
            }

            if ($status == true) {
                DB::commit();
                if ($ProjectImage) {
                    if (file_exists($ProjectImage)) {
                        unlink($ProjectImage);
                    }
                }
                $NewData = $this->getProjects(array("ProjectID" => $ProjectID));
                $logData = array("Description" => "Project updated ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::UPDATE, "ReferID" => $ProjectID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Project updated Successfully");
            } else {
                if ($ProjectImage) {
                    if (file_exists($ProjectImage)) {
                        unlink($ProjectImage);
                    }
                }
                foreach ($gallery as $pg) {
                    if (file_exists($pg['ImageUrl'])) {
                        unlink($pg['ImageUrl']);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Project update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Delete(Request $req, $ProjectID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = $this->getProjects(array("ProjectID" => $ProjectID));
                $status = DB::table('tbl_projects')->where('ProjectID', $ProjectID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Project has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ProjectID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Project Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Project Delete Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $ProjectID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = $this->getProjects(array("ProjectID" => $ProjectID));
                $status = DB::table('tbl_projects')->where('ProjectID', $ProjectID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = $this->getProjects(array("ProjectID" => $ProjectID));
                $logData = array("Description" => "Project has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $ProjectID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Project Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Project Restore Failed");
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
                array('db' => 'P.ProjectName', 'dt' => '0'),
                array('db' => 'C.Name', 'dt' => '1'),
                array('db' => 'C.MobileNumber', 'dt' => '2'),
                array('db' => 'P.ActiveStatus', 'dt' => '3'),
                array('db' => 'P.ProjectID', 'dt' => '4'),

            );

            $columns1 = array(
                array('db' => 'ProjectName', 'dt' => '0'),
                array('db' => 'Name', 'dt' => '1'),
                array('db' => 'MobileNumber', 'dt' => '2'),
                array('db' => 'ActiveStatus', 'dt' => '3',
                    'formatter' => function ($d, $row) {
                        return $d == "1" ? "<span class='badge badge-success m-1'>Active</span>" : "<span class='badge badge-danger m-1'>Inactive</span>";
                    },
                ),
                array(
                    'db' => 'ProjectID',
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
            $data['TABLE'] = 'tbl_projects AS P LEFT JOIN tbl_client AS C ON C.ClientID = P.ClientID';
            $data['PRIMARYKEY'] = 'P.ProjectID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = "P.DFlag = 0";

            return $ServerSideProcess->SSP($data);
            Log::info($data);
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function RestoreTableView(Request $request)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $ServerSideProcess = new ServerSideProcess();
            $columns = array(
                array('db' => 'P.ProjectName', 'dt' => '0'),
                array('db' => 'C.Name', 'dt' => '1'),
                array('db' => 'C.MobileNumber', 'dt' => '2'),
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
                    'db' => 'P.ProjectID',
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
            $columns1 = array(
                array('db' => 'ProjectName', 'dt' => '0'),
                array('db' => 'Name', 'dt' => '1'),
                array('db' => 'MobileNumber', 'dt' => '2'),

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
                    'db' => 'ProjectID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '';

                        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
                            $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        }
                        return $html;
                    },
                ),
            );

            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_projects AS P LEFT JOIN tbl_client AS C ON C.ClientID = P.ClientID';
            $data['PRIMARYKEY'] = 'P.ProjectID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = "P.DFlag = 1";

            return $ServerSideProcess->SSP($data);

        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public static function getClients()
    {
        try {
            $clients = DB::select('SELECT ClientID, Name FROM tbl_client');
            return response()->json($clients);
        } catch (\Exception $e) {
            Log::error('Error fetching clients: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching clients. Please check the logs for more information.'], 500);
        }
    }
    public static function getServices(){
        return DB::table('tbl_services')->where('DFlag',0)->where('ActiveStatus',1)->select('ServiceID','ServiceName')->get();
    }

    public function checkProjectName(Request $req)
    {
        $sql = "Select * from tbl_projects Where ProjectName='" . $req->ProjectName . "'";
        if ($req->ProjectID != "") {
            $sql .= " and ProjectID <>'" . $req->ProjectID . "'";
        }
        $result = DB::SELECT($sql);
        if (count($result) > 0) {
            return array('status' => true, "message" => "Project Name is not available. Already taken");
        } else {
            return array('status' => false, "message" => "Project Name is available");
        }
    }
    public function checkSlug(Request $req)
    {
        $sql = "Select * from tbl_projects Where Slug='" . $req->Slug . "'";
        if ($req->projectID != "") {
            $sql .= " and ProjectID<>'" . $req->projectID . "'";
        }
        $result = DB::SELECT($sql);
        if (count($result) > 0) {
            return array('status' => true, "message" => "Slug is not available. Already taken");
        } else {
            return array('status' => false, "message" => "Slug is available");
        }
    }

    public static function getProjectArea(Request $req)
    {
        try {
            $clients = DB::select('SELECT ProjectAreaID, ProjectAreaName FROM tbl_project_area where DFlag = 0 and ActiveStatus = 1 and ProjectType = "'.$req->ProjectType.'"');
            return response()->json($clients);
        } catch (\Exception $e) {
            Log::error('Error fetching project area: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching project area. Please check the logs for more information.'], 500);
        }
    }

}
