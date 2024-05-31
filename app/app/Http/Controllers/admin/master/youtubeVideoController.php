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

class youtubeVideoController extends Controller
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
        $this->ActiveMenuName = "Youtube-Video";
        $this->PageTitle = "Youtube Video";
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
            return view('admin.master.youtubevideo.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/youtubevideo/create');
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
            return view('admin.master.youtubevideo.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/youtubevideo');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/youtubevideo/create');
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
            return view('admin.master.youtubevideo.create', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/youtubevideo');
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
            $FormData['EditData'] = DB::Table('tbl_youtubevideo')->where('ID', $ID)->where('DFlag', 0)->get();
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.youtubevideo.create', $FormData);
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

            $ID = "";
            $rules = array(
                'LINK' => ['required', 'min:3', new ValidUnique(array("TABLE" => "tbl_youtubevideo", "WHERE" => " LINK='" . $req->LINK . "'"), "This LINK Name is already exists.")],
            );
            $message = array();

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "LINK Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            try {
                $ID = $this->DocNum->getDocNum("Youtube-Video");
                $embeddedLink = $this->convertToEmbeddedLink($req->LINK);
                $data = array(
                    "ID" => $ID,
                    "LINK" => $embeddedLink,
                    "ActiveStatus" => $req->ActiveStatus,
                    "createdOn" => date("Y-m-d H:i:s"),
                    "createdBy" => $this->UserID,
                );
                $status = DB::Table('tbl_youtubevideo')->insert($data);
            } catch (Exception $e) {
                $status = false;
                logger($e);
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Youtube-Video");
                $NewData = DB::Table('tbl_youtubevideo')->where('ID', $ID)->get();
                $logData = array("Description" => "New Youtube Video Created ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Youtube Video Create Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Youtube Video Create Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Update(Request $req, $ID)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $OldData = $NewData = array();
            $OldData = DB::table('tbl_youtubevideo')->where('ID', $ID)->get();

            $rules = array(
                'LINK' => ['required', 'min:3', 'max:100', new ValidUnique(array("TABLE" => "tbl_youtubevideo", "WHERE" => " LINK='" . $req->LINK . "' and ID<>'" . $ID . "'"), "This LINK Name is already exists.")],
            );
            $message = array();
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "LINK Update Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            try {
                // Convert the received LINK to embedded link
                $embeddedLink = $this->convertToEmbeddedLink($req->LINK);

                $data = array(
                    "LINK" => $embeddedLink,
                    "ActiveStatus" => $req->ActiveStatus,
                    "updatedOn" => date("Y-m-d H:i:s"),
                    "UpdatedBy" => $this->UserID,
                );
                $status = DB::table('tbl_youtubevideo')->where('ID', $ID)->update($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_youtubevideo')->where('ID', $ID)->get();
                $logData = array("Description" => "Youtube Video Updated ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::UPDATE, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Youtube Video Update Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Youtube Video Update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    private function convertToEmbeddedLink($link)
    {
        // Regular expression to extract video ID from YouTube link
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        preg_match($pattern, $link, $matches);

        if (count($matches) > 1) {
            // Construct embedded link
            return "https://www.youtube.com/embed/" . $matches[1];
        }

        return $link; // Return the original link if not a valid YouTube link
    }

    public function Delete(Request $req, $ID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_youtubevideo')->where('ID', $ID)->get();
                $status = DB::table('tbl_youtubevideo')->where('ID', $ID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Youtube Video has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Youtube Video Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Youtube Video Delete Failed");
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
                $OldData = DB::table('tbl_youtubevideo')->where('ID', $ID)->get();
                $status = DB::table('tbl_youtubevideo')->where('ID', $ID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_youtubevideo')->where('ID', $ID)->get();
                $logData = array("Description" => "Youtube Video has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $ID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Youtube Video Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Youtube Video Restore Failed");
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
                array('db' => 'ID', 'dt' => '0'),
                array('db' => 'LINK', 'dt' => '1'),
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
                    'db' => 'ID',
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
            $data['TABLE'] = 'tbl_youtubevideo';
            $data['PRIMARYKEY'] = 'ID';
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
                array('db' => 'ID', 'dt' => '0'),
                array('db' => 'LINK', 'dt' => '1'),
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
                    'db' => 'ID',
                    'dt' => '3',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_youtubevideo';
            $data['PRIMARYKEY'] = 'ID';
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
