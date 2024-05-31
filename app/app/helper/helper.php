<?php
namespace App\helper;
class helper{
    
	public static function EncryptDecrypt($action, $string){
		$output = false;$action=strtoupper($action);
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'gKWRyB9FZ34jQn1CjSl8';
		$secret_iv = 'wVHvDuqDaXkr0PXROT0E2E3wGJEYcwfFcAi8qgnPOcq2pZcUEjn7wruspR1Z';
		$key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if($action=='ENCRYPT'){
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = strrev(base64_encode($output));
		}
		elseif($action=='DECRYPT'){
			$output = openssl_decrypt(base64_decode(strrev($string)), $encrypt_method, $key, 0, $iv);;
		}
		return $output;
	}
	public static function RandomString($len){
		$validCharacters = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuXxYyVvWwZz1234567890";
		$validCharNumber = strlen($validCharacters);
		$result ="";
		for ($i = 0; $i < $len; $i++){
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		return $result;
	}
	public static function OTP_Generator($len){
		$validCharacters = "1234567890";
		$validCharNumber = strlen($validCharacters);
		$result ="";
		for ($i = 0; $i < $len; $i++){
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		return $result;
    }
	public static function getDateDifferenceinDays($Date1,$Date2){
		$date1=date_create(date("Y-m-d",strtotime($Date1)));
		$date2=date_create(date("Y-m-d",strtotime($Date2)));
		$diff=date_diff($date1,$date2);
		return $diff->format("%a")+1;
	}
	public static function getDateDifference($Date1,$Date2){
        $start=strtotime($Date1);
        $end=strtotime($Date2);
        $min=($end - $start) / 60;
        return self::MinsToGeneral($min);
	}
	public static function getDateDifferenceInMins($Date1,$Date2){
        $start=strtotime($Date1);
        $end=strtotime($Date2);
        $min=($end - $start) / 60;
        return $min;
	}
	public static function HoursToMins($Duration){
		$t=explode(":",$Duration);
		$mins=intval($t[0])*60;
		if(count($t)>1){
			$mins+$t[1];
		}
		return $mins;
	}
	public static function LPad($String,$Length,$PadString){
		return str_pad($String, $Length, $PadString, STR_PAD_LEFT);
	}
	public static function RPad($String,$Length,$PadString){
		return str_pad($String, $Length, $PadString);
	}
    
	public static function NumberFormat($Value,$Decimal){
		if($Decimal!="auto"){
			return number_format($Value,$Decimal,".","");
		}else{
			return $Value;
		}
	}
	public static function checkTableExists($DBName,$TableName){
        $sql="SELECT * FROM information_schema.tables WHERE table_schema = '".$DBName."' AND table_name = '".$TableName."' LIMIT 1;";
        $result=DB::SELECT($sql);
        if(count($result)>0){
            return true;
        }
        return false;
	}
}
