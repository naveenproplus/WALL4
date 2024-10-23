<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\DocNum;
use App\Models\general;
use App\Models\support;
use App\Models\ServerSideProcess;
use DB;
use Auth;
use Hash;
use cruds;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use App\Http\Controllers\admin\logController;
class CompanySettingsController extends Controller{
	private $support;
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $logs;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName="Company-Settings";
		$this->PageTitle="Company Settings";
        $this->middleware('auth');
		$this->support=new support();
		$this->DocNum=new DocNum();
    
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->logs=new logController();
			$this->Settings=$this->general->getSettings();
			return $next($request);
		});
    }
	public function index(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			return view('admin.settings.company.index',$FormData);
		}else{
			return view('errors.403');
		}
	}
	public function Update(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			if($req->PostalCode==$req->PostalCodeID){
				$req->merge(['PostalCodeID' => $this->general->Check_and_Create_PostalCode($req->PostalCode,$req->CountryID,$req->StateID,$this->DocNum)]);
			}
			$data=(array)$req->all();
			unset($data['sType']);
			unset($data['PostalCode']);
			DB::beginTransaction();
			$status=true;
			try{
				foreach($data as $KeyName=>$KeyValue){
					if($KeyName=="Logo"){
						if($req->hasFile('Logo')){
							$dir="uploads/settings/company/logo/";
							if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}

							$oldFilePath = $dir . 'logo.png';
							if (file_exists($oldFilePath)) {unlink($oldFilePath);}

							$file = $req->file('Logo');
							$fileName = 'logo.png';
							$file->move($dir, $fileName);  
							$KeyValue = $dir . $fileName;
						}
					}
					if($KeyName=="Logo-Light"){
						if($req->hasFile('Logo-Light')){
							$dir="uploads/settings/company/logo/";
							if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}

							$oldFilePath = $dir . 'logo-light.png';
							if (file_exists($oldFilePath)) {unlink($oldFilePath);}

							$file = $req->file('Logo-Light');
							$fileName = 'logo-light.png';
							$file->move($dir, $fileName);  
							$KeyValue = $dir . $fileName;
						}
					}
					$Rnd=$this->support->OTPGenerator(1);
					$Rnd1=$this->support->OTPGenerator(2);
					$UKey=$this->support->RandomString($Rnd1);
					$sql="Update tbl_company_settings Set KeyValue='".$KeyValue."',UKey='".$UKey."',UpdatedBy='".$this->UserID."',UpdatedOn='".date('Y-m-d H:i:s',strtotime($Rnd." min "))."' Where KeyName='".$KeyName."'";
					$status=DB::Update($sql);
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				return array('status'=>true,'message'=>"Company Info updated successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Company Info update failed");
			}
		}else{
			return view('errors.403');
		}
	}
}
