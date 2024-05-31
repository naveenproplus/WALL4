<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class support extends Model{
    use HasFactory;
	public function getCountry($data=array()){
		$sql="Select * From tbl_countries Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){$sql.=" and CountryID='".$data['CountryID']."'";}
			if(array_key_exists("sortname",$data)){$sql.=" and sortname='".$data['sortname']."'";}
			if(array_key_exists("CountryName",$data)){$sql.=" and CountryName='".$data['CountryName']."'";}
			if(array_key_exists("PhoneCode",$data)){$sql.=" and PhoneCode='".$data['PhoneCode']."'";}
			
		}
		$sql.=" Order By CountryName asc";
		return DB::SELECT($sql);
	}
	public function getState($data=array()){
		
		$sql="Select * From tbl_states Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){$sql.=" and CountryID='".$data['CountryID']."'";}
			if(array_key_exists("StateID",$data)){$sql.=" and StateID='".$data['StateID']."'";}
			if(array_key_exists("StateName",$data)){$sql.=" and StateName='".$data['StateName']."'";}
			
		}
		$sql.=" Order By StateName asc";
		return DB::SELECT($sql);
	}
	public function getCity($data=array()){
		$sql="Select * From tbl_cities Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){$sql.=" and CountryID='".$data['CountryID']."'";}
			if(array_key_exists("StateID",$data)){$sql.=" and StateID='".$data['StateID']."'";}
			if(array_key_exists("CityID",$data)){$sql.=" and CityID='".$data['CityID']."'";}
			if(array_key_exists("CityName",$data)){$sql.=" and CityName='".$data['CityName']."'";}
			
		}
		$sql.=" Order By CityName asc ";
		return DB::SELECT($sql);
	}
	public function getPostalCode($data=array()){
		$sql="Select * From tbl_postalcodes Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){$sql.=" and CountryID='".$data['CountryID']."'";}
			if(array_key_exists("StateID",$data)){$sql.=" and StateID='".$data['StateID']."'";}
			if(array_key_exists("PostalCodeID",$data)){$sql.=" and PID='".$data['PostalCodeID']."'";}
			
		}
		$sql.=" Order By PostalCode asc ";
		return DB::SELECT($sql);
	}
	public function getBanks($data=array()){
		$sql="Select * From tbl_banklist Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("BankID",$data)){$sql.=" and SLNO='".$data['BankID']."'";}
			
		}
		$sql.=" Order By NameOfBanks asc ";
		return DB::SELECT($sql);
	}
	public function getBankBranch($data=array()){
		$sql="Select * From tbl_bank_branches Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("BankID",$data)){$sql.=" and BankID='".$data['BankID']."'";}
			if(array_key_exists("BranchID",$data)){$sql.=" and SLNO='".$data['BranchID']."'";}
			
		}
		$sql.=" Order By BranchName asc ";
		return DB::SELECT($sql);
	}
	public function getBankAccountType($data=array()){
		$sql="Select * From tbl_bank_account_type Where ActiveStatus=1 and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("AccountTypeID",$data)){$sql.=" and SLNO='".$data['AccountTypeID']."'";}
			
		}
		$sql.=" Order By AccountType asc ";
		return DB::SELECT($sql);
	}    
	public function EncryptDecrypt($action, $string){
		$output = false;$action=strtoupper($action); 
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'hSEjc5LcDzxLSoP';
		$secret_iv = 'n2dg7g4MerIxrnEPu3xLEeZOBZOUJ6b2UkHpbKLCxZSabegSVB';
		$key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if($action=='ENCRYPT'){
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = strrev(base64_encode($output));
		}elseif($action=='DECRYPT'){
			$output = openssl_decrypt(base64_decode(strrev($string)), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
	public function RandomString($len){
		$validCharacters = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuXxYyVvWwZz1234567890";
		$validCharNumber = strlen($validCharacters);
		$result ="";
		for ($i = 0; $i < $len; $i++){
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		return $result;
	}
	public function OTPGenerator($len){
		$validCharacters = "1234567890";
		$validCharNumber = strlen($validCharacters);
		$result ="";
		for ($i = 0; $i < $len; $i++){
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		return $result;
	}
}
