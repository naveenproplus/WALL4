<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DocNum;
use App\Models\general;
use App\Models\support;
use Auth;
use DB;
use Illuminate\Http\Request;

class generalController extends Controller
{
    private $general;
    private $support;
    private $UserID;
    private $Settings;
    private $Menus;
    private $DocNum;
    public function __construct()
    {
        $this->middleware('auth');
        $this->DocNum = new DocNum();
        $this->support = new support();
        $this->middleware(function ($request, $next) {
            $this->UserID = auth()->user()->UserID;
            $this->general = new general($this->UserID, "");
            $this->Settings = $this->general->getSettings();
            $this->Menus = $this->general->loadMenu();
            return $next($request);
        });
    }
    public function getMenus(Request $req)
    {
        return $this->Menus;
    }
    public function getMenuData(request $req)
    {
        return $this->general->getMenus(array("Level" => "L001"));
    }

    public function ThemeUpdate(Request $req)
    {
        try {
            $Theme = json_decode($req->Theme, true);
            if (is_array($Theme)) {
                foreach ($Theme as $key => $value) {
                    $result = DB::table('tbl_user_theme')->where('UserID', $this->UserID)->where('Theme_option', $key)->get();
                    if (count($result) > 0) {
                        $data = array($key => $value);
                        DB::table('tbl_user_theme')->where('UserID', $this->UserID)->where('Theme_option', $key)->update(array("Theme_Value" => $value));
                    } else {
                        DB::table('tbl_user_theme')->insert(array('UserID' => $this->UserID, 'Theme_option' => $key, "Theme_Value" => $value));
                    }
                }
            }

        } catch (Exception $e) {

        }
    }
    public function RoleData()
    {
        $data = DB::Table('tbl_user_roles')->Where("DFlag", 0)->get();

        return $data;
    }
    public function tmpUploadImage(Request $req)
    {
        $dir = "uploads/admin/tmp/" . date("Ymd") . "/";
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $name = md5($file->getClientOriginalName() . time());
            $fileName = $name . "." . $file->getClientOriginalExtension();
            $fileName1 = $name . "-tmp." . $file->getClientOriginalExtension();
            $file->move($dir, $fileName1);
            return array("uploadPath" => $dir . $fileName1, "fileName" => $fileName, "referData" => $req->referData);
        } else if ($req->image != "") {
            $file = $req->image;

            $rnd = $this->support->RandomString(10) . "_" . date("YmdHis");
            $fileName = $rnd . "." . pathinfo($file, PATHINFO_EXTENSION);
            $fileName1 = $rnd . "-tmp." . pathinfo($file, PATHINFO_EXTENSION);
            $imgData = $this->getImageData($req->image);
            file_put_contents($dir . $fileName1, $imgData);
            return array("uploadPath" => $dir . $fileName1, "fileName" => $fileName, "referData" => $req->referData);
        }
    }
    private function getImageData($base64)
    {
        $base64_str = substr($base64, strpos($base64, ",") + 1);
        $image = base64_decode($base64_str);
        return $image;
    }
    public function getCSRFToken(Request $req)
    {
        return csrf_token();
    }
    public function uploadImageCKEditor(request $req)
    {
        if ($req->hasFile('file')) {
            $dir = "uploads/ckeditor/" . date("Y-m-d") . "/";
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $req->file('file');
            $fileName = $file->getClientOriginalName();
            $fileName1 = $fileName;
            $file->move($dir, $fileName1);
            return array("default" => url('/') . "/" . $dir . $fileName1);
        } elseif ($req->hasFile('upload')) {
            $dir = "uploads/ckeditor/" . date("Y-m-d") . "/";
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $req->file('upload');
            $fileName = $file->getClientOriginalName();
            $fileName1 = $fileName;
            $file->move($dir, $fileName1);
            return array(
                "uploaded" => 1,
                "fileName" => $fileName1,
                "url" => url('/') . "/" . $dir . $fileName1,
            );
        }
        return array();
    }
    public function tempUpload(Request $req)
    {
        if ($req->hasFile('image')) {
            $tempPath = 'uploads/temp/' . date("Ymd") . "/";
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }
            $file = $req->file('image');

            $fileName1 = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $customFileName = $this->support->RandomString(6) . '_' . date("YmdHis") . "." . $fileExtension;
            if ($file->move($tempPath, $customFileName)) {
                return ['status' => true, 'message' => 'File uploaded successfully', "referData" => $req->referData, "uploadDir" => $tempPath, "OriginalFileName" => $fileName1, "fileName" => $customFileName, "uploadURL" => $tempPath . $customFileName];
            } else {
                return ['status' => false, 'message' => 'File upload failed'];
            }
        } else {
            return ['status' => false, 'message' => 'File upload failed'];
        }
    }
}
