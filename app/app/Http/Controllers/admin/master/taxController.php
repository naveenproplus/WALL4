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
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class taxController extends Controller
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
        $this->ActiveMenuName = "Tax";
        $this->PageTitle = "Tax";
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
            return view('admin.master.tax.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/tax/create');
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
            return view('admin.master.tax.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/tax');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/tax/create');
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
            return view('admin.master.tax.create', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/tax');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $TaxID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['TaxID'] = $TaxID;
            $FormData['EditData'] = DB::Table('tbl_tax')->where('TaxID', $TaxID)->where('DFlag', 0)->get();
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.tax.create', $FormData);
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
                'TaxName' => ['required', 'max:50', new ValidUnique(array("TABLE" => "tbl_tax", "WHERE" => " TaxName='" . $req->TaxName . "'  "), "This Tax Name is already taken.")],
                'Percentage' => ['required', 'numeric', 'min:0', 'max:100', new ValidUnique(array("TABLE" => "tbl_tax", "WHERE" => " TaxPercentage='" . $req->Percentage . "'  "), "This Tax Percentage is already taken.")],
            );
            $message = array(
                'TaxName.required' => "Tax Name is required",
                'TaxName.max' => "Tax Name may not be greater than 100 characters",
                'Percentage.required' => "Tax Percentage is required",
                'Percentage.numeric' => "The Tax Percentage must be numeric value.",
                'Percentage.min' => "The Tax Percentage is must be equal or greater than 0",
                'Percentage.max' => "The Tax Percentage is not greater than 100",
            );
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Tax Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            try {

                $TaxID = $this->DocNum->getDocNum("TAX");
                $data = array(
                    "TaxID" => $TaxID,
                    "TaxName" => $req->TaxName,
                    "TaxPercentage" => $req->Percentage,
                    "ActiveStatus" => $req->ActiveStatus,
                    "CreatedBy" => $this->UserID,
                    "CreatedOn" => date("Y-m-d H:i:s"),
                );
                $status = DB::Table('tbl_tax')->insert($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Tax");
                $NewData = DB::Table('tbl_tax')->where('TaxID', $TaxID)->get();
                $logData = array("Description" => "New Tax Created ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::ADD, "ReferID" => $TaxID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Tax Create Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Tax Create Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Update(Request $req, $TaxID)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $OldData = $NewData = array();
            $OldData = DB::table('tbl_tax')->where('TaxID', $TaxID)->get();

            $rules = array(
                'TaxName' => ['required', 'max:50', new ValidUnique(array("TABLE" => "tbl_tax", "WHERE" => " TaxName='" . $req->TaxName . "'  and TaxID<>'" . $TaxID . "' "), "This Tax Name is already taken.")],
                'Percentage' => ['required', 'numeric', 'min:0', 'max:100', new ValidUnique(array("TABLE" => "tbl_tax", "WHERE" => " TaxPercentage='" . $req->Percentage . "' and TaxID<>'" . $TaxID . "' "), "This Tax Percentage is already taken.")],
            );
            $message = array(
                'TaxName.required' => "Tax Name is required",
                'TaxName.max' => "Tax Name may not be greater than 100 characters",
                'Percentage.required' => "Tax Percentage is required",
                'Percentage.numeric' => "The Tax Percentage must be numeric value.",
                'Percentage.min' => "The Tax Percentage is must be equal or greater than 0",
                'Percentage.max' => "The Tax Percentage is not greater than 100",
            );
            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Tax Update Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            try {

                $data = array(
                    "TaxID" => $TaxID,
                    "TaxName" => $req->TaxName,
                    "TaxPercentage" => $req->Percentage,
                    "ActiveStatus" => $req->ActiveStatus,
                    "UpdatedBy" => $this->UserID,
                    "UpdatedOn" => date("Y-m-d H:i:s"),
                );

                $status = DB::Table('tbl_tax')->where('TaxID', $TaxID)->update($data);
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();

                $NewData = DB::table('tbl_tax')->where('TaxID', $TaxID)->get();
                $logData = array("Description" => "Tax Updated ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::UPDATE, "ReferID" => $TaxID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Tax Update Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Tax Update Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Delete(Request $req, $TaxID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_tax')->where('TaxID', $TaxID)->get();
                $status = DB::table('tbl_tax')->where('TaxID', $TaxID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Tax has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $TaxID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Tax Deleted Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Tax Delete Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }
    public function Restore(Request $req, $TaxID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "restore") == true) {
            DB::beginTransaction();
            $status = false;
            try {
                $OldData = DB::table('tbl_tax')->where('TaxID', $TaxID)->get();
                $status = DB::table('tbl_tax')->where('TaxID', $TaxID)->update(array("DFlag" => 0, "UpdatedBy" => $this->UserID, "UpdatedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {

            }
            if ($status == true) {
                DB::commit();
                $NewData = DB::table('tbl_tax')->where('TaxID', $TaxID)->get();
                $logData = array("Description" => "Tax has been Restored ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::RESTORE, "ReferID" => $TaxID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
                $this->logs->Store($logData);
                return array('status' => true, 'message' => "Tax Restored Successfully");
            } else {
                DB::rollback();
                return array('status' => false, 'message' => "Tax Restore Failed");
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
                array('db' => 'TaxID', 'dt' => '0'),
                array('db' => 'TaxName', 'dt' => '1'),
                array('db' => 'TaxPercentage', 'dt' => '2', 'formatter' => function ($d, $row) {return Helper::NumberFormat($d, $this->Settings['percentage-decimals']);}),
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
                    'db' => 'TaxID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '';
                        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn  btn-outline-success btn-sm -success mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
                        }
                        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
                            $html .= '<button type="button" data-id="' . $d . '" class="btn  btn-outline-danger btn-sm -success btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                        }
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_tax';
            $data['PRIMARYKEY'] = 'TaxID';
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
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $ServerSideProcess = new ServerSideProcess();
            $columns = array(
                array('db' => 'TaxID', 'dt' => '0'),
                array('db' => 'TaxName', 'dt' => '1'),
                array('db' => 'TaxPercentage', 'dt' => '2', 'formatter' => function ($d, $row) {return Helper::NumberFormat($d, $this->Settings['percentage-decimals']);}),
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
                    'db' => 'TaxID',
                    'dt' => '4',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = 'tbl_tax';
            $data['PRIMARYKEY'] = 'TaxID';
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
