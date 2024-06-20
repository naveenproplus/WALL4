<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class ValidUniqueModel extends Model{
    use HasFactory;
    
	public function Validate_Unique($data){
		$return =false;
		if (is_array($data)){
			if(array_key_exists("TABLE",$data)){
				try{
					$sql="SELECT COUNT(*) as RCOUNT FROM ".$data['TABLE']." WHERE 1=1";
					if(array_key_exists("WHERE",$data)){
						$sql.=" AND ".$data['WHERE'];
					}
					$result=DB::select($sql);
					if (count($result)>0){
						if($result[0]->RCOUNT==0){
							$return=true;
						}
					}
				}
				catch(Exception $e) {
				}
			}
		}
		return $return;
	}
	public function check_data($data){
		$return =false;
		if (is_array($data)){
			if(array_key_exists("TABLE",$data)){
				try{
					$sql="SELECT COUNT(*) as RCOUNT FROM ".$data['TABLE']." WHERE 1=1";
					if(array_key_exists("WHERE",$data)){
						foreach($data['WHERE'] AS $KeyName=>$KeyValue){
							$sql.=" AND ".$KeyValue['COLUMN'].$KeyValue['CONDITION']."'".$KeyValue['VALUE']."'";
						}
					}
					if(array_key_exists("WHERECUSTOM",$data)){
						$sql.= $data['WHERECUSTOM'];
					}
					$result=DB::select($sql);//echo $sql;
					if (count($result)>0){
						if($result[0]->RCOUNT>0){
							$return=true;
						}
					}
				}
				catch(Exception $e) {
				}
			}
		}
		return $return;
	}

	
    public function getDesignation(){
        $dd = DB::Table('tbl_user_info')->pluck('ProfileImage');
		$destinationDirectory = 'uploads/admin/emp/';

		if (!file_exists( $destinationDirectory)) {mkdir( $destinationDirectory, 0777, true);}
	
		foreach ($dd as $item) {
			if ($item) {
				$fileName = basename($item);
	
				$newPath = $destinationDirectory . $fileName;
				
				if(file_exists($item)){
					copy($item,$newPath);
					unlink($item);
				}
			}
		}
    }
}
