<?php

namespace App\Http\Controllers\admin\home;

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
use Helper;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use App\Http\Controllers\admin\logController;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\homeController;


class contentController extends Controller{
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
		$this->ActiveMenuName="Page-Content";
		$this->PageTitle="Content";
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
			return view('admin.home.content.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/home/content/create');
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
			return view('admin.home.content.trash',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/home/content');
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/home/content/create');
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
			return view('admin.home.content.create',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/home/content');
		}else{
			return view('errors.403');
		}
	}
	
	public function EditView(Request $req,$Slug){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$homeController = new homeController();
			return $homeController->EditView($req, $Slug);
		}else{
			return view('errors.403');
		}
	}

	public function Edit(Request $req,$TranNo=null){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			$FormData['TranNo']=$TranNo;
			$FormData['Services']=[];
			$FormData['EditData']=DB::Table('tbl_home_contents')->where('TranNo',$TranNo)->where('DFlag',0)->get();
			if(count($FormData['EditData'])>0){
				$content = str_replace("{{url('/')}}", url('/') , $FormData['EditData'][0]->Content);
				$FormData['EditData'][0]->Content = $content;
				// return $FormData['EditData'][0];
				$FormData['After']=intval(substr($FormData['EditData'][0]->OrderBy,1));
				if($FormData['After']>1){
					$FormData['After']=$FormData['After']-1;
				}else{
					$FormData['After']="Begining";
				}
				return view('admin.home.content.create',$FormData);
			}else{
				return view('errors.400');
			}
		}else{
			return view('errors.403');
		}
	}
	
	public function getSectionNames(Request $req){
		$sql="Select * From tbl_home_contents Where ContentPosition='".$req->Position."' and DFlag=0 ";
		if($req->TranNo!=""){
			$sql.=" and TranNo<>'".$req->TranNo."'";
		}
		$sql.=" Order By OrderBy asc ";
		$return=DB::SELECT($sql);
		for($i=0;$i<count($return);$i++){
			$return[0]->Ordering=floatval(substr($return[0]->OrderBy,1));
		}
		return $return;
	}
	private function updateOrderBy($ContentPosition,$Ordering,$isDeleted=false){
		$sql="Select * from tbl_home_contents Where ContentPosition='".$ContentPosition."'";
		if($Ordering!="Begining"){
			$sql.=" and orderBy>'".$Ordering."'";
		}
		$sql.="order by OrderBy"; //echo $sql;
		$result=DB::SELECT($sql);
		$Order=$Ordering=="Begining"? $isDeleted?1:2:intval(substr($Ordering,1))+2;
		for($i=0;$i<count($result);$i++){
			$OrderBy="C".str_pad($Order, 5, '0', STR_PAD_LEFT);
			DB::Table('tbl_home_contents')->where('TranNo',$result[$i]->TranNo)->update(array("OrderBy"=>$OrderBy));
			$Order++;
		}
	}
	public function Save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $OldData=$NewData=array();$TranNo="";
			$rules=array(
				'SectionName' =>['required','min:3','max:100',new ValidUnique(array("TABLE"=>"tbl_home_contents","WHERE"=>" SectionName='".$req->SectionName."'"),"This Section Name is already exists.")],
			);
			$message=array();

			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Content Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$bannerImage="";
			try{
				$this->updateOrderBy($req->Position,$req->OrderBy);
				$TranNo=$this->DocNum->getDocNum("Home-Content");

				$Order=$req->OrderBy=="Begining"?1:intval(substr($req->OrderBy,1))+1;
				$OrderBy="C".str_pad($Order, 5, '0', STR_PAD_LEFT);
				$data=array(
					"TranNo"=>$TranNo,
					"SectionName"=>$req->SectionName,
					"Content"=>$req->Content,
					"ContentPosition"=>$req->Position,
					"OrderBy"=>$OrderBy,
					"createdOn"=>date("Y-m-d H:i:s"),
					"createdBy"=>$this->UserID
				);
				$status=DB::Table('tbl_home_contents')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$this->DocNum->updateDocNum("Home-Content");
				$NewData=DB::Table('tbl_home_contents')->where('TranNo',$TranNo)->get();
				$logData=array("Description"=>"New Content added ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD,"ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Content  added successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Content  add failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function Update(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $OldData=$NewData=[];
			$OldData=DB::table('tbl_home_contents')->get();
			DB::beginTransaction();
			$status=false;
			try{
				foreach($req->HomeContents as $row){
					$isSlugExists = DB::table('tbl_home_contents')->where('Slug',$row['Slug'])->exists();
					if(!$isSlugExists){
						$TranNo=$this->DocNum->getDocNum("Home-Content");
						$data=[
							"TranNo"=>$TranNo,
							"Slug"=>$row['Slug'],
							"Content"=>$row['Content'],
							"CreatedBy"=>$this->UserID
						];
						$status=DB::Table('tbl_home_contents')->insert($data);
						$this->DocNum->updateDocNum("Home-Content");
					}else{
						$data=[
							"Content"=>$row['Content'],
							"UpdatedOn"=>date("Y-m-d H:i:s"),
							"UpdatedBy"=>$this->UserID
						];
						$status=DB::Table('tbl_home_contents')->where('Slug',$row['Slug'])->update($data);	
					}
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::Table('tbl_home_contents')->get();
				$logData=array("Description"=>"Content updated","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE,"ReferID"=>"","OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Content updated successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Content update failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function ImageUpdate(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $OldData=$NewData=[];
			$OldData=DB::table('tbl_home_contents')->get();
			DB::beginTransaction();
			$status=false;
			try{
				$ImageUrl= "";

				if ($req->hasFile('croppedImage')) {
					$dir = "uploads/home/content/";
					if (!file_exists($dir)) {mkdir($dir, 0777, true);}
					$file = $req->file('croppedImage');
					$fileName1 =  $req->Slug . "-" . Helper::RandomString(10) . "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$ImageUrl=$dir.$fileName1;
				}
				if($ImageUrl){
					$isSlugExists = DB::table('tbl_home_contents')->where('Slug',$req->Slug)->exists();
					if(!$isSlugExists){
						$TranNo=$this->DocNum->getDocNum("Home-Content");
						$data=[
							"TranNo"=>$TranNo,
							"Slug"=>$req->Slug,
							"Content"=>$ImageUrl,
							"CreatedBy"=>$this->UserID
						];
						$status=DB::Table('tbl_home_contents')->insert($data);
						$this->DocNum->updateDocNum("Home-Content");
					}else{
						$data=[
							"Content"=>$ImageUrl,
							"UpdatedOn"=>date("Y-m-d H:i:s"),
							"UpdatedBy"=>$this->UserID
						];
						$status=DB::Table('tbl_home_contents')->where('Slug',$req->Slug)->update($data);
					}
				}

			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::Table('tbl_home_contents')->get();
				$logData=array("Description"=>"Content updated","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE,"ReferID"=>"","OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Image Content updated successfully",'ImageUrl'=>url('/')."/".$ImageUrl);
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Image Content update failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function Delete(Request $req,$TranNo){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_home_contents')->where('TranNo',$TranNo)->get();
				$status=DB::table('tbl_home_contents')->where('TranNo',$TranNo)->Delete();
				$this->updateOrderBy($OldData[0]->ContentPosition,"Begining",true);
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Home Content has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE,"ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Home Content deleted successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Home Content delete failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$TranNo){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_home_contents')->where('TranNo',$TranNo)->get();
				$status=DB::table('tbl_home_contents')->where('TranNo',$TranNo)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_home_contents')->where('TranNo',$TranNo)->get();
				$logData=array("Description"=>"Home Content has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE,"ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Home Content restored successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Home Content restore failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
                array( 'db' => 'TranNo', 'dt' => '0' ),
                array( 'db' => 'PageName', 'dt' => '1' ),
                array( 'db' => 'Slug', 'dt' => '2',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success m-5 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							return $html;
						} 
					),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_website_pages';
			$data['PRIMARYKEY']='TranNo';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=0 ";
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function RestoreTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
                array( 'db' => 'TranNo', 'dt' => '0' ),
                array( 'db' => 'SectionName', 'dt' => '1' ),
				array(
						'db' => 'TranNo', 
						'dt' => '2',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_home_contents';
			$data['PRIMARYKEY']='TranNo';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=1 ";
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
}
