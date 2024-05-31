<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use App\Models\support;

class supportController extends Controller{
	private $support;
    public function __construct(){
		$this->support=new support();
	}
	public function GetCountry(request $req){
		$return=array();
		$result=DB::table('tbl_countries')->where('ActiveStatus',1)->where('DFlag',0)->orderBy('CountryName','asc')->get();
		return $result;
	}
	public function GetState(request $req){
		$return=array();
		$sql="Select * from tbl_states Where ActiveStatus=1 and Dflag=0 and CountryID='".$req->CountryID."'";
		if($req->sortBy=="code"){
			$sql.=" Order By StateCode_UnderGST";
		}else{
			$sql.=" Order By StateName";
		}
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			$return[]=array("StateID"=>$result[$i]->StateID,"StateName"=>$result[$i]->StateName,"CountryID"=>$result[$i]->CountryID,"Code"=>$result[$i]->StateCode_UnderGST,);
		}
		return $return;
	}
	public function GetCity(request $req){
		$return=array();
		$result=DB::table('tbl_cities')->where('StateID',$req->StateID)->get();
		for($i=0;$i<count($result);$i++){
			$return[]=array("CityID"=>$result[$i]->CityID,"CityName"=>$result[$i]->CityName,"StateID"=>$result[$i]->StateID);
		}
		return $return;
	}
	public function getPostalCode(request $req){
		$return=array();
		
		$result=DB::table('tbl_postalcodes')->where('CountryID',$req->CountryID)->where('StateID',$req->StateID)->where('ActiveStatus',1)->where('DFlag',0)->get();
		return $result;
	}
	public function GetGender(request $req){
		$return=array();
		
		$result=DB::table('tbl_genders')->where('ActiveStatus',1)->where('DFlag',0)->get();

		return $result;
	}
	
	private function getHomeContentPlaces($after){
	}
}
