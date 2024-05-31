<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocNum extends Model
{
    use HasFactory;
    public function getDocNum($DocType)
    {
        $result = DB::Select("SELECT SLNO,DocType,Prefix,Length,CurrNum,IFNULL(Suffix,'') as Suffix,IFNULL(Year,'') as Year FROM tbl_docnum Where DocType='" . $DocType . "'");
        if (count($result) > 0) {
            $DocNum = $result[0];
            if ($DocNum->Year != "") {
                if (intval($DocNum->Year) != intval(date("Y"))) {
                    DB::table('tbl_docnum')->where('DocType', $DocType)->update(array("Year" => date("Y"), "CurrNum" => 1));
                    return $this->getDocNum($DocType);
                }
            }
            $return = $DocNum->Prefix . date("Y") . "-" . str_pad($DocNum->CurrNum, $DocNum->Length, '0', STR_PAD_LEFT);
            if ($this->checkDocNum($DocType, $return) == true) {
                return $this->getDocNum($DocType);
            }
            return $return;
        }
        return '';
    }
    public function updateDocNum($DocType)
    {
        $sql = "Update tbl_docnum SET CurrNum=CurrNum+1 WHERE DocType='" . $DocType . "'";
        $result = DB::statement($sql);
    }
    private function checkDocNum($DocType, $DocNum)
    {
        $DocType = strtolower($DocType);
        if ($DocType == "category") {
            $t = DB::Table('tbl_category')->where('CID', $DocNum)->get();
            return count($t) > 0 ? true : false;
        } else if ($DocType == "tax") {
            $t = DB::Table('tbl_tax')->where('TaxID', $DocNum)->get();
            return count($t) > 0 ? true : false;
        } else if ($DocType == "uom") {
            $t = DB::Table('tbl_uom')->where('UID', $DocNum)->get();
            return count($t) > 0 ? true : false;
        } else if ($DocType == "services") {
            $t = DB::Table('tbl_services')->where('ServiceID', $DocNum)->get();
            return count($t) > 0 ? true : false;
        } else if ($DocType == "Services-Gallery") {
            $t = DB::Table('tbl_services_gallery')->where('SLNO', $DocNum)->get();
            return count($t) > 0 ? true : false;
        } else if ($DocType == "log") {
            $t = DB::Table('tbl_log')->where('LogID', $DocNum)->get();
            return count($t) > 0 ? true : false;
        }
    } //
}
