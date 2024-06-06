<?php

namespace App\Http\Controllers;

use App\Models\DocNum;
use App\Models\support;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class homeController extends Controller
{
    private $support;
    private $DocNum;
    private $FormData;
    public function __construct(){
        $this->DocNum = new DocNum();
        $this->support = new support();
        
        $this->FormData = [
            "Settings" => $this->getSettings(),
            "Company" => $this->getCompanySettings(),
            "Gallery" => $this->getGallery(),
            "isEdit"=>false,
            "Contents"=>$this->getHomeContents(),
            "LatestProjects"=>$this->getLatestProjects(""),
            "TopClients"=>DB::table('tbl_client')->where('ClientType','Company')->get(),
            "Services"=>DB::table('tbl_services')->where('DFlag',0)->where('ActiveStatus',1)->get(),
            "FAQ"=> DB::table('tbl_faq')->where('DFlag', 0)->where('ActiveStatus',1)->get(),
            "Employees"=> DB::table('tbl_user_info as UI')->leftJoin('users AS U', 'U.UserID', '=', 'UI.UserID')->leftJoin('tbl_designation AS D', 'D.DesignationID', '=', 'UI.DesignationID')
                            ->where('D.DFlag', 0)->where('D.ActiveStatus', 1)->where('UI.DFlag', 0)->where('UI.ActiveStatus', 1)->where('U.isShow', 1)
                            ->select('UI.UserID', 'UI.FirstName', 'UI.LastName', 'UI.DOB', 'D.Designation', 'D.Level', 'UI.GenderID', 'UI.Address', 'UI.CityID', 'UI.StateID', 'UI.CountryID', 'UI.PostalCodeID', 'UI.EMail', 'UI.MobileNumber', 'U.RoleID', 'U.isLogin', 'UI.ActiveStatus' ,DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProfileImage, ""), "assets/images/male-icon.png")) AS ProfileImage'))
                            ->inRandomOrder()->get(),

        ];
    }

    public function HomeView(Request $req){
        $FormData = $this->FormData;
        return view('home.home', $FormData);
    }
    
    public function AboutUsView(Request $req){
        $FormData = $this->FormData;
        $FormData['PageTitle'] = "About Us";
        $FormData['Clients'] = DB::table('tbl_client as C')->leftJoin('tbl_cities as CI','CI.CityID','C.CityID')->where('C.DFlag', 0)->where('C.ActiveStatus',1)->whereNot('C.Testimonial',NULL)->inRandomOrder()->get();
        $FormData['Projects'] =  DB::table('tbl_projects as P')->leftJoin('tbl_project_type as PT','PT.PID','P.ProjectType')->leftJoin('tbl_services as S','S.ServiceID','P.ServiceID')->where('P.DFlag',0)
                                ->select('P.ProjectID','P.ProjectName','P.ProjectAddress','S.ServiceName','P.Slug','PT.ProjectTypeName','P.ProjectType',DB::raw('CONCAT("'.url('/').'/",COALESCE(NULLIF(ProjectImage, ""),"assets/images/no-image.png")) as ProjectImage'))->inRandomOrder()->get();      
        return view('home.about-us', $FormData);
    }
    
    public function TeamsView(Request $req){
        $FormData = $this->FormData;
        $FormData['PageTitle'] = "Teams";   
        
        $FormData['CEO'] = $FormData['Employees']->where('Designation','CEO')->first();
        $FormattedEmployees = [];
        foreach ($FormData['Employees']->sortBy('Level') as $item) {
            $FormattedEmployees[$item->Designation][] = $item;
        }
        $FormData['FormattedEmployees'] = $FormattedEmployees;

        return view('home.teams', $FormData);
    }

    public function ServicesView(Request $req){

        $FormData = $this->FormData;
        $FormData['PageTitle'] = "Our Services";
        $FormData['Services'] = DB::table('tbl_services')->where('DFlag',0)->get();
        return view('home.services', $FormData);
    }
    public function ServicesDetailsView(Request $req,$Slug){
        $ServiceData = DB::table('tbl_services')->where('Slug',$Slug)->where('DFlag',0)->where('ActiveStatus',1)->first();
        if($ServiceData){
            $FormData = $this->FormData;
            $FormData['PageTitle'] = "Services Details";
            $ServiceData->ServiceGallery = DB::table('tbl_services_gallery')->where('ServiceID',$ServiceData->ServiceID)->inRandomOrder()->pluck('ImageUrl');
            $FormData['Service'] = $ServiceData;
            return view('home.service-details',$FormData);
        }else{
            return view('errors.400');
        }
    }

    public function ProjectsView(Request $req){
        $FormData = $this->FormData;
        $FormData['PageTitle'] = "Projects";
        $FormData['ProjectType'] = DB::table('tbl_project_type')->where('DFlag',0)->where('ActiveStatus',1)->get();
        $FormData['Projects'] = DB::table('tbl_projects as P')->leftJoin('tbl_project_type as PT','PT.PID','P.ProjectType')->leftJoin('tbl_services as S','S.ServiceID','P.ServiceID')->where('P.DFlag',0)
        ->select('P.*','S.ServiceName','PT.ProjectTypeName')
        ->get();
        return view('home.projects', $FormData);
    }

    public function ProjectDetailsView(Request $req,$Slug){
        $ProjectData = DB::table('tbl_projects as P')->leftJoin('tbl_project_type as PT','PT.PID','P.ProjectType')->leftJoin('tbl_services as S','S.ServiceID','P.ServiceID')->where('P.DFlag',0)->where('P.Slug',$Slug)
        ->select('P.*','S.ServiceName','PT.ProjectTypeName')->first();
        if($ProjectData){
            $FormData = $this->FormData;
            $FormData['LatestProjects'] = $this->getLatestProjects($Slug);
            $FormData['PageTitle'] = "Projects Details";
            $ProjectData->ProjectGallery = DB::table('tbl_projects_gallery')->where('ProjectID',$ProjectData->ProjectID)->pluck('ImageUrl');
            $FormData['Project'] = $ProjectData;

            return view('home.project-details',$FormData);
        }else{
            return view('errors.400');
        }
    }

    public function ContactUsView(Request $req){
        $FormData = $this->FormData;
        $FormData['PageTitle'] = "Contact Us";
        return view('home.contact-us', $FormData);
    }

    public function FAQView(Request $req){
        $FormData = $this->FormData;
        $FormData['PageTitle'] = "FAQs";
        return view('home.faq', $FormData);
    }

    public function EditView(Request $req,$Slug){
        $FormData = $this->FormData;
        $FormData['isEdit'] = true;
        $FormData['PageTitle'] = DB::Table('tbl_website_pages')->where('Slug',$Slug)->value('PageName');
        $FormData['Clients'] = DB::table('tbl_client as C')->leftJoin('tbl_cities as CI','CI.CityID','C.CityID')->where('C.DFlag', 0)->where('C.ActiveStatus',1)->whereNot('C.Testimonial',NULL)->inRandomOrder()->get();
        $FormData['ProjectType'] = DB::table('tbl_project_type')->where('DFlag',0)->where('ActiveStatus',1)->get();
        $FormData['Projects'] =  DB::table('tbl_projects as P')->leftJoin('tbl_project_type as PT','PT.PID','P.ProjectType')->leftJoin('tbl_services as S','S.ServiceID','P.ServiceID')->where('P.DFlag',0)
                                ->select('P.ProjectID','P.ProjectName','P.ProjectAddress','S.ServiceName','P.Slug','PT.ProjectTypeName','P.ProjectType',DB::raw('CONCAT("'.url('/').'/",COALESCE(NULLIF(ProjectImage, ""),"assets/images/no-image.png")) as ProjectImage'))->inRandomOrder()->get();
        return view('home.'.$Slug, $FormData);
    }
    public function PrivacyPolicyView(Request $req){ return view('errors.404');
        $FormData = $this->FormData;
        $FormData['PageTitle'] = DB::Table('tbl_page_content')->where('DFlag', 0)->Where('Slug', 'privacy-policy')->value('PageName');
        $FormData['PageContent'] = DB::Table('tbl_page_content')->where('DFlag', 0)->Where('Slug', 'privacy-policy')->first();
        if ($FormData['PageContent']) {
            return view('home.privacy-policy', $FormData);
        } else {
            return view('errors.404');
        }
    }

    public function ContactEnquirySave(Request $req){
        DB::beginTransaction();
        $status = false;
        try {

            $CID = $this->DocNum->getDocNum("Contact-Enquiry");
            $Name = $req->FName . ($req->LName ? ' ' . $req->LName : '');
            $data = array(
                "TranNo" => $CID,
                "TranDate" => date("Y-m-d"),
                "Name" => $Name ,
                "Email" => $req->Email,
                "MobileNumber" => $req->MobileNumber,
                "Subject" => $req->Subject,
                "Message" => $req->Message,
                "createdOn" => date("Y-m-d H:i:s"),
            );
            $status = DB::Table('tbl_contact_enquiries')->insert($data);
            if ($this->FormData['Company']['enable-mail-contact-us'] == true) {
                if ($this->FormData['Company']["contact-us-email"] != "") {
                    try {
                        
                        $email = $req->Email;
                        $messageData = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get()->pluck('KeyValue', 'KeyName')->toArray();
                        $messageData['UserName'] = $req->FName;
                        Mail::send('emails.contacts', $messageData, function ($message) use ($email) {$message->to($email)->subject('Contact Enquiry');});
                    } catch (Exception $e) {
                        DB::rollback();
                        return array('status' => false, 'message' => 'E-Mail has been not sent due to SMTP configuration !!!');
                    }
                }
            }
        } catch (Exception $e) {
            $status = false;
        }
        if ($status == true) {
            $this->DocNum->updateDocNum("Contact-Enquiry");
            DB::commit();
            return array('status' => true, 'message' => "Your enquiry submitted. Our Team will callback you soon!");
        } else {
            DB::rollback();
            return array('status' => false, 'message' => "Your enquiry not submitted");
        }
    }

    public function ServiceEnquirySave(Request $req){
        $rules = array(
            'Name' => 'required',
            'MobileNumber' => 'required',
        );
        $message = array();
        $validator = Validator::make($req->all(), $rules, $message);

        if ($validator->fails()) {
            return array('status' => false, 'message' => "Your  enquiry not submitted", 'errors' => $validator->errors());
        }
        DB::beginTransaction();
        $status = false;
        try {

            $CID = $this->DocNum->getDocNum("Service-Enquiry");

            $data = array(
                "TranNo" => $CID,
                "TranDate" => date("Y-m-d"),
                "ServiceID" => $req->ServiceID,
                "Name" => $req->Name,
                "MobileNumber" => $req->MobileNumber,
                "createdOn" => date("Y-m-d H:i:s"),
            );
            $status = DB::Table('tbl_service_enquiries')->insert($data);
        } catch (Exception $e) {
            $status = false;
        }
        if ($status == true) {
            $this->DocNum->updateDocNum("Service-Enquiry");
            DB::commit();
            return array('status' => true, 'message' => "Your enquiry submitted. Our Team will callback you soon!");
        } else {
            DB::rollback();
            return array('status' => false, 'message' => "Your enquiry not submitted");
        }
    }

    private function getSettings(){
        $settings = array("isEnabledTermsConditions" => false, "isEnabledPrivacyPolicy" => false, "isEnabledHelp" => false);
        $result = DB::Table('tbl_settings')->get();
        for ($i = 0; $i < count($result); $i++) {
            if (strtolower($result[$i]->SType) == "serialize") {
                $settings[$result[$i]->KeyName] = unserialize($result[$i]->KeyValue);
            } elseif (strtolower($result[$i]->SType) == "json") {
                $settings[$result[$i]->KeyName] = json_decode($result[$i]->KeyValue, true);
            } else {
                $settings[$result[$i]->KeyName] = $result[$i]->KeyValue;
            }
        }
        //Check Privacy Policy enable or not
        $t = DB::Table('tbl_page_content')->where('ActiveStatus', 1)->where('DFlag', 0)->where('Slug', 'privacy-policy')->get();
        if (count($t) > 0) {
            $settings['isEnabledPrivacyPolicy'] = true;
        }
        //Check Privacy Policy enable or not
        $t = DB::Table('tbl_page_content')->where('ActiveStatus', 1)->where('DFlag', 0)->where('Slug', 'terms-condition')->get();
        if (count($t) > 0) {
            $settings['isEnabledTermsConditions'] = true;
        }
        //Check help enable or not
        $t = DB::Table('tbl_page_content')->where('ActiveStatus', 1)->where('DFlag', 0)->where('Slug', 'help')->get();
        if (count($t) > 0) {
            $settings['isEnabledHelp'] = true;
        }
        return $settings;
    }

    private function getCompanySettings(){
        $settings = array("FullAddress" => "", "CountryName" => "", "CallCode" => "", "StateName" => "", "CityName" => "", "PostalCode" => "", "BankName" => "", "BankBranchName" => "", "IFSCCode" => "", "MICR" => "", "AccountType" => "");
        $result = DB::Table('tbl_company_settings')->get();
        for ($i = 0; $i < count($result); $i++) {
            if (strtolower($result[$i]->SType) == "serialize") {
                $settings[$result[$i]->KeyName] = unserialize($result[$i]->KeyValue);
            } elseif (strtolower($result[$i]->SType) == "json") {
                $settings[$result[$i]->KeyName] = json_decode($result[$i]->KeyValue, true);
            } elseif (strtolower($result[$i]->SType) == "boolean") {
                $settings[$result[$i]->KeyName] = intval($result[$i]->KeyValue) == 1 ? true : false;
            } elseif (strtolower($result[$i]->SType) == "number") {
                $settings[$result[$i]->KeyName] = floatval($result[$i]->KeyValue);
            } else {
                $settings[$result[$i]->KeyName] = $result[$i]->KeyValue;
            }
        }
        $settings['Logo'] = url('/').'/'.$settings['Logo'];
        $Address = "";
        if (array_key_exists("CountryID", $settings)) {
            $tmp = $this->support->getCountry(array("CountryID" => $settings["CountryID"]));
            if (count($tmp) > 0) {$settings['CountryName'] = $tmp[0]->CountryName;
                $settings['CallCode'] = $tmp[0]->PhoneCode;}
        }
        if (array_key_exists("StateID", $settings)) {
            $tmp = $this->support->getState(array("StateID" => $settings["StateID"]));
            if (count($tmp) > 0) {$settings['StateName'] = $tmp[0]->StateName;}
        }
        if (array_key_exists("CityID", $settings)) {
            $tmp = $this->support->getCity(array("CityID" => $settings["CityID"]));
            if (count($tmp) > 0) {$settings['CityName'] = $tmp[0]->CityName;}
        }
        if (array_key_exists("PostalCodeID", $settings)) {
            $tmp = $this->support->getPostalCode(array("PostalCodeID" => $settings["PostalCodeID"]));
            if (count($tmp) > 0) {$settings['PostalCode'] = $tmp[0]->PostalCode;}
        }
        if (array_key_exists("BankName", $settings)) {
            $settings["BankID"] = $settings['BankName'];
            $tmp = $this->support->getBanks(array("BankID" => $settings["BankID"]));
            if (count($tmp) > 0) {$settings['BankName'] = $tmp[0]->NameOfBanks;}
        }
        if (array_key_exists("BankBranchName", $settings)) {
            $settings["BankBranchID"] = $settings['BankBranchName'];
            $tmp = $this->support->getBankBranch(array("BranchID" => $settings["BankBranchID"]));
            if (count($tmp) > 0) {
                $settings['BankBranchName'] = $tmp[0]->BranchName;
                $settings['IFSCCode'] = $tmp[0]->IFSCCode;
                $settings['MICR'] = $tmp[0]->MICR;
            }
        }
        if (array_key_exists("BankAccountType", $settings)) {
            $settings["BankAccountTypeID"] = $settings['BankAccountType'];
            $tmp = $this->support->getBankAccountType(array("AccountTypeID" => $settings["BankAccountTypeID"]));
            if (count($tmp) > 0) {$settings['BankAccountType'] = $tmp[0]->AccountType;}
        }

        if ($settings['Address'] != "") {$Address = $settings['Address'];}
        if ($settings['CityName'] != "") {if ($Address != "") {$Address .= ", ";}$Address .= $settings['CityName'];}
        if ($settings['StateName'] != "") {if ($Address != "") {$Address .= ", ";}$Address .= $settings['StateName'];}
        if ($settings['CountryName'] != "") {if ($Address != "") {$Address .= ", ";}$Address .= $settings['CountryName'];}
        if ($settings['PostalCode'] != "") {if ($Address != "") {$Address .= " - ";}$Address .= $settings['PostalCode'];}
        $settings['FullAddress'] = $Address;
        return $settings;
    }

    public function getGallery() {
        return DB::Table('tbl_gallery_images as GI')->leftJoin('tbl_gallery_master as GM','GM.GalleryID','GI.GalleryID')->where('GI.DFlag', 0)->get();
    }

    private function getHomeContents(){
        $result = DB::Table('tbl_home_contents')->select('Slug','Content')->get();

        $content = [];
        foreach ($result as $row){
            $content[$row->Slug]=$row->Content;
        }
        return $content;
    }

    private function getLatestProjects($Slug){
        $query = DB::table('tbl_projects as P')
        ->leftJoin('tbl_project_type as PT','PT.PID','P.ProjectType')
        ->leftJoin('tbl_services as S','S.ServiceID','P.ServiceID')
        ->where('P.DFlag',0)->where('P.ActiveStatus',1)->where('S.DFlag',0)->where('S.ActiveStatus',1)
        ->select('P.ProjectID','P.ProjectName','P.ProjectAddress','S.ServiceName','P.Slug','PT.ProjectTypeName','P.ProjectType',DB::raw('CONCAT("'.url('/').'/",COALESCE(NULLIF(ProjectImage, ""),"assets/images/no-image.png")) as ProjectImage'))
        ->orderBy('P.CreatedOn')->get();

        return $Slug ? $query->where('Slug','!=',$Slug) : $query;
    }
}
