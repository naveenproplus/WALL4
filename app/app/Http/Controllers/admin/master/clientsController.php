<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\admin\logController;
use App\Http\Controllers\Controller;
use App\Models\DocNum;
use App\Models\general;
use App\Models\ServerSideProcess;
use App\Models\support;
use App\Rules\ValidDB;
use App\Rules\ValidUnique;
use Auth;
use cruds;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
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
        $this->ActiveMenuName = "Clients";
        $this->PageTitle = "Manage Clients";
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
            return view('admin.master.clients.view', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/clients/create');
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
            return view('admin.master.clients.trash', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/clients');
        } elseif ($this->general->isCrudAllow($this->CRUD, "Add") == true) {
            return Redirect::to('/admin/master/clients/create');
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
            return view('admin.master.clients.client', $FormData);
        } elseif ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            return Redirect::to('/admin/master/clients');
        } else {
            return view('errors.403');
        }
    }

    public function Edit(Request $req, $ClientID = null)
    {
        if ($this->general->isCrudAllow($this->CRUD, "edit") == true) {
            $sql = "Select UI.ClientID,UI.Name,UI.ClientType,UI.DOB,UI.GenderID,UI.Address,UI.Testimonial,UI.VideoURL,UI.CityID,UI.StateID,UI.CountryID,UI.PostalCodeID,UI.EMail,UI.MobileNumber,UI.ProfileImage,UI.ActiveStatus From tbl_client as UI";
            $sql .= " Where UI.DFlag=0 and UI.ClientID='" . $ClientID . "'";
            $FormData = $this->general->UserInfo;
            $FormData['ActiveMenuName'] = $this->ActiveMenuName;
            $FormData['PageTitle'] = $this->PageTitle;
            $FormData['isEdit'] = true;
            $FormData['menus'] = $this->Menus;
            $FormData['crud'] = $this->CRUD;
            $FormData['ClientID'] = $ClientID;
            $FormData['EditData'] = DB::SELECT($sql);
            if (count($FormData['EditData']) > 0) {
                return view('admin.master.clients.client', $FormData);
            } else {
                return view('errors.400');
            }
        } else {
            return view('errors.403');
        }
    }

    public function getUserRoles(request $req)
    {
        return DB::Table('tbl_user_roles')->where('ActiveStatus', 1)->where('DFlag', 0)->where('isShow', 1)->get();
    }
    public function Save(Request $req)
    {
        if ($this->general->isCrudAllow($this->CRUD, "add") == true) {

            if($req->PostalCode==$req->PostalCodeID){
                $req->merge(['PostalCodeID' => $this->general->Check_and_Create_PostalCode($req->PostalCode,$req->CountryID,$req->StateID,$this->DocNum)]);
            }
            $OldData = $NewData = array();
            $UserID = $this->UserID;
            $ValidDB = array();
            //Cities
            $ValidDB['City']['TABLE'] = "tbl_cities";
            $ValidDB['City']['ErrMsg'] = "City name does  not exist";
            $ValidDB['City']['WHERE'][] = array("COLUMN" => "CityID", "CONDITION" => "=", "VALUE" => $req->City);
            $ValidDB['City']['WHERE'][] = array("COLUMN" => "StateID", "CONDITION" => "=", "VALUE" => $req->State);
            $ValidDB['City']['WHERE'][] = array("COLUMN" => "CountryID", "CONDITION" => "=", "VALUE" => $req->Country);

            //States
            $ValidDB['State']['TABLE'] = "tbl_states";
            $ValidDB['State']['ErrMsg'] = "State name does  not exist";
            $ValidDB['State']['WHERE'][] = array("COLUMN" => "StateID", "CONDITION" => "=", "VALUE" => $req->State);
            $ValidDB['State']['WHERE'][] = array("COLUMN" => "CountryID", "CONDITION" => "=", "VALUE" => $req->Country);

            //Country
            $ValidDB['Country']['TABLE'] = "tbl_countries";
            $ValidDB['Country']['ErrMsg'] = "Country name  does not exist";
            $ValidDB['Country']['WHERE'][] = array("COLUMN" => "CountryID", "CONDITION" => "=", "VALUE" => $req->Country);

            //Postal Code
            $ValidDB['PostalCode']['TABLE'] = "tbl_postalcodes";
            $ValidDB['PostalCode']['ErrMsg'] = "Postal Code  does not exist";
            $ValidDB['PostalCode']['WHERE'][] = array("COLUMN" => "PID", "CONDITION" => "=", "VALUE" => $req->PostalCode);

            //Gender
            $ValidDB['Gender']['TABLE'] = "tbl_genders";
            $ValidDB['Gender']['ErrMsg'] = "Gender  does not exist";
            $ValidDB['Gender']['WHERE'][] = array("COLUMN" => "GID", "CONDITION" => "=", "VALUE" => $req->Gender);

            $rules = array(
                'Name' => 'required|min:3|max:50',
                'Address' => 'required|min:10',
                'MobileNumber' => ['required', new ValidUnique(array("TABLE" => "users", "WHERE" => " EMail='" . $req->MobileNumber . "' "), "This Mobile Number is already taken.")],
                'Gender' => ['required', new ValidDB($ValidDB['Gender'])],
                'State' => ['required', new ValidDB($ValidDB['State'])],
                'City' => ['required', new ValidDB($ValidDB['City'])],
                'Country' => ['required', new ValidDB($ValidDB['Country'])],
                'PostalCode' => ['required', new ValidDB($ValidDB['PostalCode'])],

            );
            $message = array(
            );
            if ($req->ProfileImage != "") {$rules['PImage'] = 'mimes:jpeg,jpg,png,gif,bmp';}
            if ($req->EMail != "") {$rules['EMail'] = ['required', 'email', new ValidUnique(array("TABLE" => "tbl_client", "WHERE" => " email='" . $req->EMail . "' "), "This E-Mail is already taken.")];}

            $validator = Validator::make($req->all(), $rules, $message);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Client Create Failed", 'errors' => $validator->errors());
            }
            DB::beginTransaction();
            $status = false;
            $ProfileImage = "";
            try {

                $ClientID = $this->DocNum->getDocNum("Clients");

                if ($req->hasFile('ProfileImage')) {
                    $dir = "uploads/admin/master/clients/";
                    if (!file_exists($dir)) {mkdir($dir, 0777, true);}
                    $file = $req->file('ProfileImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $ProfileImage = $dir . $fileName1;
                }

                $status = true;
                if ($status) {
                    $data = array(
                        "ClientID" => $ClientID,
                        "Name" => $req->Name,
                        "ClientType" => $req->ClientType,
                        "GenderID" => $req->Gender,
                        "Address" => $req->Address,
                        "Testimonial" => $req->Testimonial,
                        "VideoURL" => $req->VideoURL,
                        "CityID" => $req->City,
                        "StateID" => $req->State,
                        "CountryID" => $req->Country,
                        "PostalCodeID" => $req->PostalCode,
                        "Email" => $req->EMail,
                        "MobileNumber" => $req->MobileNumber,
                        "ProfileImage" => $ProfileImage,
                        "ActiveStatus" => $req->ActiveStatus,
                        "CreatedOn" => date("Y-m-d H:i:s"),
                        "CreatedBy" => $this->UserID,
                    );

                    Log::info('Received data:', $data);

                    $status = DB::Table('tbl_client')->insert($data);
                }
            } catch (Exception $e) {
                $status = false;
            }
            if ($status == true) {
                DB::commit();
                $this->DocNum->updateDocNum("Clients");
                $NewData = DB::Table('tbl_client')->where('ClientID', $ClientID)->get();
                return array('status' => true, 'message' => "Client Create Successfully");
            } else {
                if ($ProfileImage != "") {
                    if (file_exists($ProfileImage)) {
                        unlink($ProfileImage);
                    }
                }
                DB::rollback();
                return array('status' => false, 'message' => "Client Create Failed");
            }
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

    public function Update(Request $req, $ClientID)
    {
        Log::info('Received Client ID: ' . $ClientID);

        if ($this->general->isCrudAllow($this->CRUD, "edit")) {

            if($req->PostalCode==$req->PostalCodeID){
                $req->merge(['PostalCodeID' => $this->general->Check_and_Create_PostalCode($req->PostalCode,$req->CountryID,$req->StateID,$this->DocNum)]);
            }
            $OldData = DB::table('tbl_client')->where('ClientID', $ClientID)->get();
            $NewData = array();
            $ValidDB = array();
            //Cities
            $ValidDB['City']['TABLE'] = "tbl_cities";
            $ValidDB['City']['ErrMsg'] = "City name does  not exist";
            $ValidDB['City']['WHERE'][] = array("COLUMN" => "CityID", "CONDITION" => "=", "VALUE" => $req->City);
            $ValidDB['City']['WHERE'][] = array("COLUMN" => "StateID", "CONDITION" => "=", "VALUE" => $req->State);
            $ValidDB['City']['WHERE'][] = array("COLUMN" => "CountryID", "CONDITION" => "=", "VALUE" => $req->Country);

            //States
            $ValidDB['State']['TABLE'] = "tbl_states";
            $ValidDB['State']['ErrMsg'] = "State name does  not exist";
            $ValidDB['State']['WHERE'][] = array("COLUMN" => "StateID", "CONDITION" => "=", "VALUE" => $req->State);
            $ValidDB['State']['WHERE'][] = array("COLUMN" => "CountryID", "CONDITION" => "=", "VALUE" => $req->Country);

            //Country
            $ValidDB['Country']['TABLE'] = "tbl_countries";
            $ValidDB['Country']['ErrMsg'] = "Country name  does not exist";
            $ValidDB['Country']['WHERE'][] = array("COLUMN" => "CountryID", "CONDITION" => "=", "VALUE" => $req->Country);

            //Postal Code
            $ValidDB['PostalCode']['TABLE'] = "tbl_postalcodes";
            $ValidDB['PostalCode']['ErrMsg'] = "Postal Code  does not exist";
            $ValidDB['PostalCode']['WHERE'][] = array("COLUMN" => "PID", "CONDITION" => "=", "VALUE" => $req->PostalCode);

            //Gender
            $ValidDB['Gender']['TABLE'] = "tbl_genders";
            $ValidDB['Gender']['ErrMsg'] = "Gender  does not exist";
            $ValidDB['Gender']['WHERE'][] = array("COLUMN" => "GID", "CONDITION" => "=", "VALUE" => $req->Gender);

            // Validation rules
            $rules = [
                'Name' => 'required|min:3|max:50',
                'Gender' => 'required|exists:tbl_genders,GID',
                'State' => 'required|exists:tbl_states,StateID',
                'City' => 'required|exists:tbl_cities,CityID',
                'Country' => 'required|exists:tbl_countries,CountryID',
                'PostalCode' => 'required|exists:tbl_postalcodes,PID',
            ];

            // Perform validation
            $validator = Validator::make($req->all(), $rules);

            if ($validator->fails()) {
                return ['status' => false, 'message' => "Client Update Failed", 'errors' => $validator->errors()];
            }

            DB::beginTransaction();
            $status = false;
            $ProfileImage = "";
            try {
                // Construct the data for update
                $data = [
                    "Name" => $req->Name,
                    "ClientType" => $req->ClientType,
                    "GenderID" => $req->Gender,
                    "Address" => $req->Address,
                    "Testimonial" => $req->Testimonial,
                    "VideoURL" => $req->VideoURL,
                    "CityID" => $req->City,
                    "StateID" => $req->State,
                    "CountryID" => $req->Country,
                    "PostalCodeID" => $req->PostalCode,
                    "Email" => $req->EMail,
                    "MobileNumber" => $req->MobileNumber,
                    "ActiveStatus" => $req->ActiveStatus,
                    "UpdatedOn" => now(),
                ];

                // Check if there's a profile image and update accordingly
                if ($req->hasFile('ProfileImage')) {
                    $dir = "uploads/admin/master/clients/";
                    $fileName = md5($req->file('ProfileImage')->getClientOriginalName() . time()) . "." . $req->file('ProfileImage')->getClientOriginalExtension();
                    $req->file('ProfileImage')->move($dir, $fileName);
                    $data["ProfileImage"] = $dir . $fileName;
                }

                // Update the record
                DB::table('tbl_client')->where('ClientID', $ClientID)->update($data);

                DB::commit();

                return ['status' => true, 'message' => "Client Update Successfully"];
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Client Update Failed: ' . $e->getMessage());
                return ['status' => false, 'message' => "Client Update Failed"];
            }
        } else {
            return response(['status' => false, 'message' => "Access Denied"], 403);
        }
    }

    public function Delete(Request $req, $ClientID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {

                $status = DB::table('tbl_client')->where('ClientID', $ClientID)->update(array("DFlag" => 1, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {
                Log::error($e->getMessage());

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Service has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ClientID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
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

    public function Restore(Request $req, $ClientID)
    {
        $OldData = $NewData = array();
        if ($this->general->isCrudAllow($this->CRUD, "delete") == true) {
            DB::beginTransaction();
            $status = false;
            try {

                $status = DB::table('tbl_client')->where('ClientID', $ClientID)->update(array("DFlag" => 0, "DeletedBy" => $this->UserID, "DeletedOn" => date("Y-m-d H:i:s")));
            } catch (Exception $e) {
                Log::error($e->getMessage());

            }
            if ($status == true) {
                DB::commit();
                $logData = array("Description" => "Service has been Deleted ", "ModuleName" => $this->ActiveMenuName, "Action" => cruds::DELETE, "ReferID" => $ClientID, "OldData" => $OldData, "NewData" => $NewData, "UserID" => $this->UserID, "IP" => $req->ip());
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

    public function TableView(Request $request)
    {
        if ($this->general->isCrudAllow($this->CRUD, "view") == true) {
            $ServerSideProcess = new ServerSideProcess();
            $columns = array(
                array('db' => 'UI.Name', 'dt' => '0'),
                array('db' => 'UI.MobileNumber', 'dt' => '1'),
                array('db' => 'UI.EMail', 'dt' => '2'),
                array('db' => 'UI.Address', 'dt' => '3'),
                array('db' => 'CI.CityName', 'dt' => '4'),
                array('db' => 'S.StateName', 'dt' => '5'),
                array('db' => 'UI.ActiveStatus', 'dt' => '6'),
                array('db' => 'UI.ClientID', 'dt' => '7'),
                array('db' => 'UI.ClientType', 'dt' => '8'),
            );
            $columns1 = array(
                array('db' => 'Name', 'dt' => '0'),
                array('db' => 'ClientType', 'dt' => '1'),
                array('db' => 'MobileNumber', 'dt' => '2'),
                array('db' => 'EMail', 'dt' => '3'),
                array('db' => 'Address', 'dt' => '4'),
                array('db' => 'CityName', 'dt' => '5'),
                array('db' => 'StateName', 'dt' => '6'),
                array(
                    'db' => 'ActiveStatus',
                    'dt' => '7',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'ClientID',
                    'dt' => '8',
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
            $data['TABLE'] = ' tbl_client as UI LEFT JOIN tbl_countries as C ON C.CountryID=UI.CountryID LEFT JOIN tbl_genders as G ON G.GID=UI.GenderID  LEFT JOIN tbl_states as S ON S.StateID=UI.StateID LEFT JOIN tbl_cities as CI ON CI.CityID=UI.CityID';
            $data['PRIMARYKEY'] = 'UI.ClientID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = " UI.DFlag=0";
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
                array('db' => 'UI.Name', 'dt' => '0'),
                array('db' => 'UI.MobileNumber', 'dt' => '1'),
                array('db' => 'UI.EMail', 'dt' => '2'),
                array('db' => 'UI.Address', 'dt' => '3'),
                array('db' => 'CI.CityName', 'dt' => '4'),
                array('db' => 'S.StateName', 'dt' => '5'),
                array(
                    'db' => 'UI.ActiveStatus',
                    'dt' => '6',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'UI.ClientID',
                    'dt' => '7',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $columns1 = array(
                array('db' => 'Name', 'dt' => '0'),
                array('db' => 'MobileNumber', 'dt' => '1'),
                array('db' => 'EMail', 'dt' => '2'),
                array('db' => 'Address', 'dt' => '3'),
                array('db' => 'CityName', 'dt' => '4'),
                array('db' => 'StateName', 'dt' => '5'),
                array(
                    'db' => 'ActiveStatus',
                    'dt' => '6',
                    'formatter' => function ($d, $row) {
                        if ($d == "1") {
                            return "<span class='badge badge-success m-1'>Active</span>";
                        } else {
                            return "<span class='badge badge-danger m-1'>Inactive</span>";
                        }
                    },
                ),
                array(
                    'db' => 'ClientID',
                    'dt' => '7',
                    'formatter' => function ($d, $row) {
                        $html = '<button type="button" data-id="' . $d . '" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
                        return $html;
                    },
                ),
            );
            $data = array();
            $data['POSTDATA'] = $request;
            $data['TABLE'] = ' tbl_client as UI LEFT JOIN tbl_countries as C ON C.CountryID=UI.CountryID LEFT JOIN tbl_genders as G ON G.GID=UI.GenderID  LEFT JOIN tbl_states as S ON S.StateID=UI.StateID LEFT JOIN tbl_cities as CI ON CI.CityID=UI.CityID';
            $data['PRIMARYKEY'] = 'UI.ClientID';
            $data['COLUMNS'] = $columns;
            $data['COLUMNS1'] = $columns1;
            $data['GROUPBY'] = null;
            $data['WHERERESULT'] = null;
            $data['WHEREALL'] = " UI.DFlag=1";
            return $ServerSideProcess->SSP($data);
        } else {
            return response(array('status' => false, 'message' => "Access Denied"), 403);
        }
    }

}
