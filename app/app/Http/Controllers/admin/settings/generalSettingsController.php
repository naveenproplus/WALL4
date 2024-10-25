<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\DocNum;
use App\Models\support;
use App\Models\general;
use App\Models\ServerSideProcess;
use DB;
use Auth;
use Hash;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use App\Http\Controllers\admin\logController;
class generalSettingsController extends Controller{
	private $general;
	private $support;
	private $DocNum;
	private $UserID;
	private $LoginType;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $logs;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName="General-Settings";
		$this->PageTitle="General Settings";
        $this->middleware('auth');
		$this->DocNum=new DocNum();
		$this->support=new support();
    
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->LoginType=auth()->user()->LoginType;
			$this->general=new general($this->UserID,$this->ActiveMenuName,auth()->user()->LoginType);
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
			$FormData['DateFormats']=DB::Table("tbl_formats")->where('FType','date')->get();
			$FormData['TimeFormats']=DB::Table("tbl_formats")->where('FType','time')->get();

			$MetaData = DB::table('tbl_meta_data as M')
				->leftJoin('tbl_services as S', function ($join) { $join->on('S.ServiceID', '=', 'M.Slug'); })
				->where('M.DFlag', 0)->where('M.ActiveStatus', 1)
				->where(function ($query) {
					$query->where('S.DFlag', 0)
						->where('S.ActiveStatus', 1)
						->orWhereNull('S.ServiceID');
				})
				->select('M.Slug', 'M.Title', 'M.MetaTitle', 'M.Description')->get()->toArray();

			$ServiceData = DB::table('tbl_services')->where('DFlag', 0)->where('ActiveStatus', 1)
			->select(DB::raw('ServiceID as Slug'),DB::raw('ServiceName as Title'),DB::raw('"" as MetaTitle'),DB::raw('"" as Description'))
			->get()->toArray();
			
			$existingSlugs = array_column($MetaData, 'Slug');
			foreach ($ServiceData as $service) {
				if (!in_array($service->Slug, $existingSlugs)) {
					$MetaData[] = $service;
				}
			}
			
			$FormData['MetaData'] = (object) $MetaData;
			return view('admin.settings.general.index',$FormData);
		}else{
			return view('errors.403');
		}
	}
	
	public function Update(Request $req){
		
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$status=true;
			try{
				$sType=$req->sType;
				if($sType == "meta"){
					$MetaData = json_decode($req->MetaData);
					$Slugs = [];
					foreach($MetaData as $item) {
						$isSlugExists = DB::table('tbl_meta_data')->where('Slug', $item->Slug)->exists();
						
						$updateData = (array) $item;
						$updateData['UpdatedOn'] = now();
						$updateData['UpdatedBy'] = $this->UserID;
					
						if ($isSlugExists) {
							$status = DB::table('tbl_meta_data')->where('Slug', $item->Slug)->update($updateData);
						} else {
							$updateData['CreatedOn'] = now();
							$updateData['CreatedBy'] = $this->UserID;
							$status = DB::table('tbl_meta_data')->insert($updateData);
						}
						$Slugs[]=$item->Slug;
					}
					// DB::table('tbl_meta_data')->whereNotIn('Slug', $Slugs)->update(['DFlag' =>1, 'DeletedBy' =>$this->UserID, 'DeletedOn' =>now()]);
									
				}else{
					$data=(array)$req->all();
					unset($data['sType']);
					unset($data['PostalCode']);
					foreach($data as $KeyName=>$KeyValue){
						if($status){
							$Rnd=$this->support->OTPGenerator(1);
							$Rnd1=$this->support->OTPGenerator(2);
							$UKey=$this->support->RandomString($Rnd1);
							if($sType=="social-media-links"){
								$sql="Update tbl_company_settings Set KeyValue='".$KeyValue."',UKey='".$UKey."',UpdatedBy='".$this->UserID."',UpdatedOn='".date('Y-m-d H:i:s',strtotime($Rnd." min "))."' Where KeyName='".$KeyName."'";
								$status=DB::Update($sql);
							}elseif($sType=="map"){
								$sql="Update tbl_company_settings Set KeyValue='".$KeyValue."',UKey='".$UKey."',UpdatedBy='".$this->UserID."',UpdatedOn='".date('Y-m-d H:i:s',strtotime($Rnd." min "))."' Where KeyName='".$KeyName."'";
								$status=DB::Update($sql);
							}else{
								$sql="Update tbl_settings Set KeyValue='".$KeyValue."',UKey='".$UKey."',UpdatedBy='".$this->UserID."',UpdatedOn='".date('Y-m-d H:i:s',strtotime($Rnd." min "))."' Where KeyName='".$KeyName."'";
								$status=DB::Update($sql);
							}
						}
					}
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				if($sType=="company"){
					return array('status'=>true,'message'=>"Social media links updated successfully");
				}elseif($sType=="map"){
					return array('status'=>true,'message'=>"Map  updated successfully");
				}elseif($sType=="meta"){
					return array('status'=>true,'message'=>"Meta Data updated successfully");
				}else{
					return array('status'=>true,'message'=>"General settings updated successfully");
				}
			}else{
				DB::rollback();
				if($sType=="company"){
					return array('status'=>false,'message'=>"Company Info update failed");
				}elseif($sType=="map"){
					return array('status'=>false,'message'=>"Map update failed");
				}elseif($sType=="meta"){
					return array('status'=>false,'message'=>"Meta Data update failed");
				}else{
					return array('status'=>false,'message'=>"General settings update failed");
				}
			}
		}else{
			return view('errors.403');
		}
		
	}
}
