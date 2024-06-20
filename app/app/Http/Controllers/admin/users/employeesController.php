<?php

namespace App\Http\Controllers\admin\users;

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
use Illuminate\Support\Facades\Storage;

class employeesController extends Controller{
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
    public function __construct(){
		$this->ActiveMenuName="Employees";
		$this->PageTitle="Employees";
        $this->middleware('auth');
        $this->DocNum=new DocNum();
        $this->support=new support();
    
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
			return view('admin.users.employees.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/users-and-permissions/employees/create');
		}else{
			return view('errors.403');
		}
	}
	
	public function restoreView(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			return view('admin.users.employees.trash',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/users-and-permissions/users');
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/users-and-permissions/employees/create');
		}else{
			return view('errors.403');
		}
	}
	public function Create(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"Add")==true){
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			$FormData['isEdit']=false;
			return view('admin.users.employees.employee',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/users-and-permissions/users');
		}else{
			return view('errors.403');
		}
	}
	
	public function Edit(Request $req,$UserID=null){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$sql="Select UI.UserID,UI.FirstName,UI.LastName,UI.DOB,UI.Designation,UI.DeptID,D.Dept,D.Level,UI.GenderID,UI.Address,UI.CityID,UI.StateID,UI.CountryID,UI.PostalCodeID,UI.EMail,UI.MobileNumber,U.RoleID,U.isLogin,UI.ProfileImage,UI.ActiveStatus From tbl_user_info as UI LEFT JOIN users AS U ON U.UserID=UI.UserID LEFT JOIN tbl_dept AS D ON D.DeptID=UI.DeptID";
			$sql.=" Where D.DFlag=0 and D.ActiveStatus=1 and UI.DFlag=0 and UI.UserID='".$UserID."'";
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			$FormData['UserID']=$UserID;
			$FormData['EditData']=DB::SELECT($sql);
			if(count($FormData['EditData'])>0){
				return view('admin.users.employees.employee',$FormData);
			}else{
				return view('errors.400');
			}
		}else{
			return view('errors.403');
		}
	}
    public function getUserRoles(request $req){
        return DB::Table('tbl_user_roles')->where('ActiveStatus',1)->where('DFlag',0)->where('isShow',1)->get();
    }
    public function getDept(request $req){
        return DB::Table('tbl_dept')->where('ActiveStatus',1)->where('DFlag',0)->get();
    }
	public function getDesignation(request $req){
        return DB::Table('tbl_user_info')->distinct('Designation')->select('Designation','ProfileImage')->get();
    }
	public function Save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){

			if($req->PostalCode==$req->PostalCodeID){
				$req->merge(['PostalCodeID' => $this->general->Check_and_Create_PostalCode($req->PostalCode,$req->CountryID,$req->StateID,$this->DocNum)]);
			}
			$OldData=$NewData=array();$UserID="";			
			$ValidDB=array();
			//Cities
			$ValidDB['City']['TABLE']="tbl_cities";
			$ValidDB['City']['ErrMsg']="City name does  not exist";
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$req->City);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			
			//States
			$ValidDB['State']['TABLE']="tbl_states";
			$ValidDB['State']['ErrMsg']="State name does  not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			
			//Country
			$ValidDB['Country']['TABLE']="tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name  does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			
			//Postal Code
			$ValidDB['PostalCode']['TABLE']="tbl_postalcodes";
			$ValidDB['PostalCode']['ErrMsg']="Postal Code  does not exist";
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$req->PostalCodeID);
			
			//Gender
			$ValidDB['Gender']['TABLE']="tbl_genders";
			$ValidDB['Gender']['ErrMsg']="Gender  does not exist";
			$ValidDB['Gender']['WHERE'][]=array("COLUMN"=>"GID","CONDITION"=>"=","VALUE"=>$req->Gender);

			
			//User Roles
			$ValidDB['UserRole']['TABLE']="tbl_user_roles";
			$ValidDB['UserRole']['ErrMsg']="User Role  does not exist";
			$ValidDB['UserRole']['WHERE'][]=array("COLUMN"=>"RoleID","CONDITION"=>"=","VALUE"=>$req->UserRole);
			$ValidDB['UserRole']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['UserRole']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			
			$rules=array(
				'FirstName' =>'required|min:3|max:50',
				'LastName' =>'max:50',
				//'Address' => 'required|min:10',
				'MobileNumber' =>['required',new ValidUnique(array("TABLE"=>"tbl_user_info","WHERE"=>" MobileNumber='".$req->MobileNumber."' "),"This Mobile Number is already taken.")],
				'EMail' => ['required','email',new ValidUnique(array("TABLE"=>"users","WHERE"=>" email='".$req->EMail."' "),"This E-Mail is already taken.")],
				// 'Gender'=>['required',new ValidDB($ValidDB['Gender'])],
				'StateID'=>['required',new ValidDB($ValidDB['State'])],
				'City'=>['required',new ValidDB($ValidDB['City'])],
				'CountryID'=>['required',new ValidDB($ValidDB['Country'])],
				'PostalCodeID'=>['required',new ValidDB($ValidDB['PostalCode'])],
				'Password' =>'required|min:3|max:20',
				'ConfirmPassword' =>'required|min:3|max:20|same:Password',
			);
			$message=array(
			);
			if($req->ProfileImage!=""){$rules['PImage']='mimes:jpeg,jpg,png,gif,bmp';}

			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"User Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$ProfileImage="";
			try{

				$UserID=$this->DocNum->getDocNum("USER");
				$dir="uploads/admin/employees/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}

				if($req->hasFile('ProfileImage')){
					$file = $req->file('ProfileImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$ProfileImage=$dir.$fileName1;
				}elseif($req->ProfileImage){
					$Img=json_decode($req->ProfileImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$ProfileImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}

				$Name =  $req->FirstName." ".$req->LastName;
				$password=$req->Password;
				$pwd1=Hash::make($password);
				$pwd2=$this->support->EncryptDecrypt("encrypt",$password);

				$data=array(
					"UserID"=>$UserID,
					"Name"=>$Name,
					"EMail"=>$req->EMail,
					"Password"=>$pwd1,
					"Password1"=>$pwd2,
					"RoleID"=>$req->UserRole,
					"isLogin"=>$req->LoginStatus,
					"ActiveStatus"=>$req->ActiveStatus,
					"created_at"=>date("Y-m-d H:i:s"),
					"createdBy"=>$this->UserID
				);
				$status=DB::Table('users')->insert($data);
				if($status){
					$data=array(
						"UserID"=>$UserID,
						"Name"=>$Name,
						"FirstName"=>$req->FirstName,
						"LastName"=>$req->LastName,
						"GenderID"=>$req->Gender,
						"DOB"=>$req->DOB,
						"DeptID"=>$req->DeptID,
						"Designation"=>$req->Designation,
						"Address"=>$req->Address,
						"CityID"=>$req->City,
						"StateID"=>$req->StateID,
						"CountryID"=>$req->CountryID,
						"PostalCodeID"=>$req->PostalCodeID,
						"Email"=>$req->EMail,
						"MobileNumber"=>$req->MobileNumber,
						"ProfileImage"=>$ProfileImage,
						"ActiveStatus"=>$req->ActiveStatus,
						"CreatedOn"=>date("Y-m-d H:i:s"),
						"CreatedBy"=>$this->UserID
					);
					$status=DB::Table('tbl_user_info')->insert($data);
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$this->DocNum->updateDocNum("USER");
				$NewData=DB::Table('tbl_user_info')->where('UserID',$UserID)->get();
				$logData=array("Description"=>"New User Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD,"ReferID"=>$UserID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"User Create Successfully");
			}else{
				if($ProfileImage!=""){
					if(file_exists($ProfileImage)){
						unlink($ProfileImage);
					}
				}
				DB::rollback();
				return array('status'=>false,'message'=>"User Create Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function Update(Request $req,$UserID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){

			if($req->PostalCode==$req->PostalCodeID){
				$req->merge(['PostalCodeID' => $this->general->Check_and_Create_PostalCode($req->PostalCode,$req->CountryID,$req->StateID,$this->DocNum)]);
			}
			$OldData=DB::table('tbl_user_info')->where('UserID',$UserID)->get();$NewData=array();
			$ValidDB=array();
			//Cities
			$ValidDB['City']['TABLE']="tbl_cities";
			$ValidDB['City']['ErrMsg']="City name does  not exist";
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$req->City);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			
			//States
			$ValidDB['State']['TABLE']="tbl_states";
			$ValidDB['State']['ErrMsg']="State name does  not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			
			//Country
			$ValidDB['Country']['TABLE']="tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name  does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			
			//Postal Code
			$ValidDB['PostalCode']['TABLE']="tbl_postalcodes";
			$ValidDB['PostalCode']['ErrMsg']="Postal Code does not exist";
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$req->PostalCodeID);
			
			//Gender
			$ValidDB['Gender']['TABLE']="tbl_genders";
			$ValidDB['Gender']['ErrMsg']="Gender  does not exist";
			$ValidDB['Gender']['WHERE'][]=array("COLUMN"=>"GID","CONDITION"=>"=","VALUE"=>$req->Gender);

			
			//Gender
			$ValidDB['UserRole']['TABLE']="tbl_user_roles";
			$ValidDB['UserRole']['ErrMsg']="User Role  does not exist";
			$ValidDB['UserRole']['WHERE'][]=array("COLUMN"=>"RoleID","CONDITION"=>"=","VALUE"=>$req->UserRole);
			$ValidDB['UserRole']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['UserRole']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			
			$rules=array(
				'FirstName' =>'required|min:3|max:50',
				'LastName' =>'max:50',
				'EMail' =>['required',new ValidUnique(array("TABLE"=>"users","WHERE"=>" email='".$req->EMail."'  and UserID<>'".$UserID."' "),"This Email is already taken.")],
				'MobileNumber' =>['required',new ValidUnique(array("TABLE"=>"tbl_user_info","WHERE"=>" MobileNumber='".$req->MobileNumber."'  and UserID<>'".$UserID."' "),"This Mobile Number is already taken.")],
				'Gender'=>['required',new ValidDB($ValidDB['Gender'])],
				'StateID'=>['required',new ValidDB($ValidDB['State'])],
				'City'=>['required',new ValidDB($ValidDB['City'])],
				'CountryID'=>['required',new ValidDB($ValidDB['Country'])],
				'PostalCodeID'=>['required',new ValidDB($ValidDB['PostalCode'])],
			);
			$message=array(
			);
			if($req->ProfileImage!=""){$rules['PImage']='mimes:jpeg,jpg,png,gif,bmp';}

			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"User Update Failed",'errors'=>$validator->errors());
			}
			DB::beginTransaction();
			$status=false;
			$ProfileImage="";
			try{
				$CPImage="";
				$dir="uploads/admin/employees/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ProfileImage')){
					$file = $req->file('ProfileImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$ProfileImage=$dir.$fileName1;
					
					$result=DB::Table('tbl_user_info')->where('UserID',$UserID)->get();
					if(count($result)>0){
						$CPImage=$result[0]->ProfileImage;
					}
				}elseif($req->ProfileImage){
					$Img=json_decode($req->ProfileImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$ProfileImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				$Name =  $req->FirstName." ".$req->LastName;

				$data=array(
					"Name"=>$Name,
					"email"=>$req->EMail,
					"RoleID"=>$req->UserRole,
					"isLogin"=>$req->LoginStatus,
					"ActiveStatus"=>$req->ActiveStatus,
					"updated_at"=>date("Y-m-d H:i:s"),
					"UpdatedBy"=>$this->UserID
				);
				$status=DB::Table('users')->where('UserID',$UserID)->update($data);
				if($status){
					$data=array(
						"Name"=>$Name,
						"FirstName"=>$req->FirstName,
						"LastName"=>$req->LastName,
						"GenderID"=>$req->Gender,
						"DOB"=>$req->DOB,
						"DeptID"=>$req->DeptID,
						"Designation"=>$req->Designation,
						"Address"=>$req->Address,
						"CityID"=>$req->City,
						"StateID"=>$req->StateID,
						"CountryID"=>$req->CountryID,
						"PostalCodeID"=>$req->PostalCodeID,
						"Email"=>$req->EMail,
						"MobileNumber"=>$req->MobileNumber,
						"ActiveStatus"=>$req->ActiveStatus,
						"UpdatedOn"=>date("Y-m-d H:i:s"),
						"UpdatedBy"=>$this->UserID
					);
					if($ProfileImage!=""){
						$data["ProfileImage"]=$ProfileImage;
					}
					$status=DB::Table('tbl_user_info')->where('UserID',$UserID)->Update($data);
				}
				
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();

				if($CPImage!=""){
					if(file_exists($CPImage)){
						unlink($CPImage);
					}
				}
				$NewData=DB::Table('tbl_user_info')->where('UserID',$UserID)->get();
				$logData=array("Description"=>"User Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE,"ReferID"=>$UserID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"User Update Successfully");
			}else{
				if($ProfileImage!=""){
					if(file_exists($ProfileImage)){
						unlink($ProfileImage);
					}
				}
				DB::rollback();
				return array('status'=>false,'message'=>"User Update Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function Delete(Request $req,$UserID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('users')->where('UserID',$UserID)->get();
				$status=DB::table('users')->where('UserID',$UserID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"Deleted_at"=>date("Y-m-d H:i:s")));
				if($status==true){
					$status=DB::table('tbl_user_info')->where('UserID',$UserID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
				}
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"User has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE,"ReferID"=>$UserID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"User Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"User Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$UserID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('users')->where('UserID',$UserID)->get();
				$status=DB::table('users')->where('UserID',$UserID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"Updated_at"=>date("Y-m-d H:i:s")));
				if($status==true){
					$status=DB::table('tbl_user_info')->where('UserID',$UserID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
				}
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('users')->where('UserID',$UserID)->get();
				$logData=array("Description"=>"User has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE,"ReferID"=>$UserID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"User Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"User Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
                array( 'db' => 'UI.Name', 'dt' => '0' ),
                array( 'db' => 'UI.MobileNumber', 'dt' => '1' ),
                array( 'db' => 'UI.EMail', 'dt' => '2' ),
                array( 'db' => 'UI.Address', 'dt' => '3' ),
                array( 'db' => 'CI.CityName', 'dt' => '4' ),
                array( 'db' => 'S.StateName', 'dt' => '5' ),
                array( 'db' => 'U.Password', 'dt' => '6'),
				array( 'db' => 'UI.ActiveStatus', 'dt' => '7' ),
				array( 'db' => 'UI.UserID', 'dt' => '8'),
				array( 'db' => 'UI.Designation', 'dt' => '9'),
				array( 'db' => 'D.Dept', 'dt' => '10'),
			);

			$columns1 = array(
                array( 'db' => 'Name', 'dt' => '0' ),
                array( 'db' => 'Designation', 'dt' => '1' ),
                array( 'db' => 'MobileNumber', 'dt' => '2' ),
                array( 'db' => 'EMail', 'dt' => '3' ),
                array( 'db' => 'Address', 'dt' => '4' ),
                array( 'db' => 'CityName', 'dt' => '5' ),
                array( 'db' => 'Password', 'dt' => '6','formatter' => function( $d, $row ) {  return '<span id="pwd-'.$row['UserID'].'">******</span>';} ),
				array( 'db' => 'ActiveStatus', 'dt' => '7',
						'formatter' => function( $d, $row ) {
							return $d == "1" ? "<span class='badge badge-success m-1'>Active</span>" : "<span class='badge badge-danger m-1'>Inactive</span>";
						} 
                    ),
				array( 
						'db' => 'UserID', 
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"ShowPwd")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info m-5 btnPassword" data-original-title="Show Password"><i class="fa fa-key" aria-hidden="true"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success m-5 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
							}
							return $html;
						} 
					),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=' tbl_user_info as UI LEFT JOIN users as U ON U.UserID=UI.UserID LEFT JOIN tbl_countries as C ON C.CountryID=UI.CountryID LEFT JOIN tbl_genders as G ON G.GID=UI.GenderID  LEFT JOIN tbl_states as S ON S.StateID=UI.StateID LEFT JOIN tbl_cities as CI ON CI.CityID=UI.CityID LEFT JOIN tbl_dept AS D ON D.DeptID=UI.DeptID';
			$data['PRIMARYKEY']='UI.UserID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" D.DFlag=0 and D.ActiveStatus=1 and UI.DFlag=0 and U.isShow=1";
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function RestoreTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
                array( 'db' => 'UI.Name', 'dt' => '0' ),
                array( 'db' => 'UI.MobileNumber', 'dt' => '1' ),
                array( 'db' => 'UI.EMail', 'dt' => '2' ),
                array( 'db' => 'UI.Address', 'dt' => '3' ),
                array( 'db' => 'CI.CityName', 'dt' => '4' ),
                array( 'db' => 'S.StateName', 'dt' => '5' ),
				array( 
						'db' => 'UI.ActiveStatus', 
						'dt' => '6',
						'formatter' => function( $d, $row ) {
							if($d=="1"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array(
						'db' => 'UI.UserID', 
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$columns1 = array(
                array( 'db' => 'Name', 'dt' => '0' ),
                array( 'db' => 'MobileNumber', 'dt' => '1' ),
                array( 'db' => 'EMail', 'dt' => '2' ),
                array( 'db' => 'Address', 'dt' => '3' ),
                array( 'db' => 'CityName', 'dt' => '4' ),
                array( 'db' => 'StateName', 'dt' => '5' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '6',
						'formatter' => function( $d, $row ) {
							if($d=="1"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'UserID', 
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=' tbl_user_info as UI LEFT JOIN users as U ON U.UserID=UI.UserID LEFT JOIN tbl_countries as C ON C.CountryID=UI.CountryID LEFT JOIN tbl_genders as G ON G.GID=UI.GenderID  LEFT JOIN tbl_states as S ON S.StateID=UI.StateID LEFT JOIN tbl_cities as CI ON CI.CityID=UI.CityID';
			$data['PRIMARYKEY']='UI.UserID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" UI.DFlag=1 and U.isShow=1";
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function getPassword(request $req){
		$password="";
		$result=DB::Table('users')->where('UserID',$req->UserID)->get();
		if(count($result)>0){
			$password=$this->support->EncryptDecrypt("decrypt",$result[0]->Password1);
		}
		return array("password"=>$password);
	}
}
