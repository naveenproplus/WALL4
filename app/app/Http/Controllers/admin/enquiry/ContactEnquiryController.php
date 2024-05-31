<?php

namespace App\Http\Controllers\admin\enquiry;

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

class ContactEnquiryController extends Controller{
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
		$this->ActiveMenuName="Contact-Us-Enquiry";
		$this->PageTitle="Contact Enquiry";
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
			return view('admin.enquiry.contact.view',$FormData);
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
			return view('admin.enquiry.contact.trash',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/enquiry/contact');
		}else{
			return view('errors.403');
		}
	}
	
	public function Delete(Request $req,$TranNo){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_contact_enquiries')->where('TranNo',$TranNo)->get();
				$status=DB::table('tbl_contact_enquiries')->where('TranNo',$TranNo)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Enquiry has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE,"ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Enquiry Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Enquiry Delete Failed");
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
				$OldData=DB::table('tbl_contact_enquiries')->where('TranNo',$TranNo)->get();
				$status=DB::table('tbl_contact_enquiries')->where('TranNo',$TranNo)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_contact_enquiries')->where('TranNo',$TranNo)->get();
				$logData=array("Description"=>"Enquiry has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE,"ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Enquiry Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Enquiry Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
                array( 'db' => 'CreatedOn', 'dt' => '0','formatter' => function( $d, $row ) {return date($this->Settings['date-format']." ".$this->Settings['time-format'],strtotime($d));}  ),
                array( 'db' => 'Name', 'dt' => '1' ),
                array( 'db' => 'MobileNumber', 'dt' => '2' ),
                array( 'db' => 'Email', 'dt' => '3' ),
				array( 'db' => 'Subject', 'dt' => '4'),
				array(
						'db' => 'TranNo', 
						'dt' => '5',
						'formatter' => function( $d, $row ) {
							$html='';
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-primary m-5 btnView" data-original-title="Delete"><i class="fa fa-eye" aria-hidden="true"></i></button>';
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';

							}
							return $html;
						} 
					),
			);
			$where=" DFlag=0 and TranDate>='".date("Y-m-d",strtotime($request->FromDate))."' and TranDate<='".date("Y-m-d",strtotime($request->ToDate))."' ";
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_contact_enquiries ';
			$data['PRIMARYKEY']='TranNo';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=$where;
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function RestoreTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
                array( 'db' => 'CreatedOn', 'dt' => '0','formatter' => function( $d, $row ) {return date($this->Settings['date-format']." ".$this->Settings['time-format'],strtotime($d));}  ),
                array( 'db' => 'Name', 'dt' => '1' ),
                array( 'db' => 'MobileNumber', 'dt' => '2' ),
                array( 'db' => 'Email', 'dt' => '3' ),
				array( 'db' => 'Subject', 'dt' => '4'),
				array(
						'db' => 'TranNo', 
						'dt' => '5',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
					),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_contact_enquiries';
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
	public function getDetails(Request $req,$TranNo){
		$sql="SELECT E.TranNo, E.TranDate,  E.Name, E.Email, E.MobileNumber, E.Subject, E.Message, E.CreatedOn FROM tbl_contact_enquiries as E Where E.DFlag=0  and E.TranNo='".$TranNo."'";
		$result=DB::SELECT($sql);
		if(count($result)>0){
			return view('admin.enquiry.contact.details',array("data"=>$result[0],"Settings"=>$this->Settings));
		}else{
			return "";
		}
	}
}
