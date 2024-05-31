<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DocNum;
use DB;

class logController extends Controller
{
    private $DocNum;
    public function __construct()
    {
        $this->DocNum = new DocNum();
    }
    private function getLogID()
    {
        $LogID = $this->DocNum->getDocNum("LOG");
        $result = DB::Table('tbl_log')->where('LogID', $LogID)->get();
        if (count($result) > 0) {
            $this->DocNum->updateDocNum("LOG");
            return $this->getLogID();
        }
        return $LogID;
    }
    public function Store($data)
    {

        $tdata = array(
            'LogID' => $this->getLogID(),
            'Description' => $data['Description'],
            'ModuleName' => $data['ModuleName'],
            'Action' => $data['Action'],
            'ReferID' => $data['ReferID'],
            'OldData' => serialize($data['OldData']),
            'NewData' => serialize($data['NewData']),
            'IPAddress' => $data['IP'],
            'UserID' => $data['UserID'],
            'logTime' => date("Y-m-d H:i:s"),
        );
        $status = DB::Table('tbl_log')->insert($tdata);
        if ($status) {
            $this->DocNum->updateDocNum("Log");
        }
    }
}
