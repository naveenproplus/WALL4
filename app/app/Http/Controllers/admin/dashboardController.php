<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\logController;
use App\Http\Controllers\Controller;
use App\Models\general;
use App\Models\support;
use Auth;
use DB;
use Illuminate\Http\Request;

class dashboardController extends Controller
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
        $this->PageTitle = "Dashboard";
        $this->ActiveMenuName = "Dashboard";
        $this->middleware('auth');
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
    public function dashboard(Request $req)
    {
        $FormData = $this->general->UserInfo;
        $FormData['ActiveMenuName'] = $this->ActiveMenuName;
        $FormData['PageTitle'] = $this->PageTitle;
        $FormData['menus'] = $this->Menus;
        $FormData['crud'] = $this->CRUD;
        $FormData['Services'] = $this->getServiceCounts();
        $FormData['Users'] = $this->getUsersCounts();
        $FormData['cruds_1'] = array(
            "Services" => $this->general->getCrudOperations("Services"),
            "ServiceEnquiries" => $this->general->getCrudOperations("Service-Enquiry"),
            "ContactEnquiries" => $this->general->getCrudOperations("Contact-Us-Enquiry"),
        );
        $FormData['RecentServices'] = $this->getRecentServices();
        $FormData['ServiceEnquiries'] = $this->getRecentServiceEnquiries();
        $FormData['ContactEnquiries'] = $this->getRecentContactEnquiries();
        return view('admin.dashboard', $FormData);
    }
    private function getServiceCounts()
    {
        $return = array("Active" => 0, "Inactive" => 0, "Deleted" => 0, "Total" => 0);
        $return['Active'] = DB::Table('tbl_services')->where('DFlag', 0)->where('ActiveStatus', 1)->count();
        $return['Inactive'] = DB::Table('tbl_services')->where('DFlag', 0)->where('ActiveStatus', 0)->count();
        $return['Deleted'] = DB::Table('tbl_services')->where('DFlag', 1)->count();
        $return['Total'] = DB::Table('tbl_services')->count();
        return $return;
    }
    private function getUsersCounts()
    {
        $return = array("Active" => 0, "Inactive" => 0, "Deleted" => 0, "Total" => 0);
        $return['Active'] = DB::Table('users')->where('isShow', 1)->where('DFlag', 0)->where('ActiveStatus', 1)->count();
        $return['Inactive'] = DB::Table('users')->where('isShow', 1)->where('DFlag', 0)->where('ActiveStatus', 0)->count();
        $return['Deleted'] = DB::Table('users')->where('isShow', 1)->where('DFlag', 1)->count();
        $return['Total'] = DB::Table('users')->where('isShow', 1)->count();
        return $return;
    }
    private function getRecentServices()
    {

        $sql = "SELECT P.CreatedOn, P.ServiceID, P.ServiceName, P.Slug, P.ServiceImage, P.CID as CategoryID, C.CName as CategoryName, P.Price, P.UOM as UID, U.UCode, U.UName, P.Decimals, P.TaxID, T.TaxName, T.TaxPercentage, P.TaxType, P.HSNSAC, P.Title, P.Description1, P.ActiveStatus ";
        $sql .= " From tbl_services as P  LEFT JOIN tbl_category as C ON C.CID=P.CID ";
        $sql .= " LEFT JOIN tbl_uom as U ON U.UID=P.UOM LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID ";
        $sql .= " Where P.DFlag=0  Order By P.CreatedOn Desc Limit 5";
        return DB::Select($sql);
    }
    private function getRecentServiceEnquiries()
    {
        $sql = "SELECT E.TranNo, E.TranDate, E.ServiceID, P.ServiceName, P.Slug, P.ServiceImage, E.Name, E.Email, E.MobileNumber, E.Subject, E.Message, E.CreatedOn FROM tbl_service_enquiries as E LEFT JOIN tbl_services as P ON P.ServiceID=E.ServiceID Where E.DFlag=0 Order By E.CreatedOn desc Limit 5";
        return DB::SELECT($sql);
    }
    private function getRecentContactEnquiries()
    {
        $sql = "SELECT TranNo, TranDate,  Name, Email, MobileNumber, Subject, Message, CreatedOn FROM tbl_contact_enquiries  Where DFlag=0 Order By CreatedOn desc Limit 5";
        return DB::SELECT($sql);
    }
    public function getGraphicalServiceEnquiry(Request $req)
    {
        $labels = $series = array();
        if (($req->Month != "") && ($req->Year != "")) {
            for ($i = 1; $i <= intval(date("t", strtotime($req->Year . "-" . $req->Month . "-01"))); $i++) {
                $date = date("Y-m-d", strtotime($req->Year . "-" . $req->Month . "-" . $i));
                $labels[] = str_pad($i, 2, '0', STR_PAD_LEFT);

                $sql = "Select * From tbl_service_enquiries Where DFlag=0 and DATE_FORMAT(CreatedOn,'%Y-%m-%d')='" . date("Y-m-d", strtotime($date)) . "'";
                $series[] = count(DB::SELECT($sql));
            }
        } elseif (($req->Month == "") && ($req->Year != "")) {
            for ($i = 1; $i <= 12; $i++) {
                $date = date("Y-m-d", strtotime($req->Year . "-" . $i . "-01"));
                $labels[] = date("M", strtotime($date));

                $sql = "Select * From tbl_service_enquiries Where DFlag=0 and DATE_FORMAT(CreatedOn,'%Y-%m')='" . date("Y-m", strtotime($date)) . "'";
                $series[] = count(DB::SELECT($sql));
            }
        } else {
            for ($i = intval($this->Settings['app-init-year']); $i <= intval(date("Y")); $i++) {
                $labels[] = $i;

                $sql = "Select * From tbl_service_enquiries Where DFlag=0 and DATE_FORMAT(CreatedOn,'%Y')='" . $i . "'";
                $series[] = count(DB::SELECT($sql));
            }
        }
        $data = array();
        $data["labels"] = $labels;
        $data["series"][] = $series;
        return $data;
    }
}
