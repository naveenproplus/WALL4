<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use URL;
class addWaterMark{
    private $Settings;
    public function __construct(){
        $this->getSettings();
    }
    private  function getSettings(){
	    $this->Settings=array("WaterMarkText"=>"Rajam Snacks","FontSize"=>50,"Font"=>"assets/fonts/calibri.ttf","Color"=>array("r"=>255,"g"=>255,"b"=>255));
	    $result=DB::Table('tbl_settings')->get();
	    for($i=0;$i<count($result);$i++){
			if(strtolower($result[$i]->SType)=="serialize"){
				$this->Settings[$result[$i]->KeyName]=unserialize($result[$i]->KeyValue);
			}elseif(strtolower($result[$i]->SType)=="json"){
				$this->Settings[$result[$i]->KeyName]=json_decode($result[$i]->KeyValue,true);
			}elseif(strtolower($result[$i]->SType)=="boolean"){
				$this->Settings[$result[$i]->KeyName]=intval($result[$i]->KeyValue)==1?true:false;
			}elseif(strtolower($result[$i]->SType)=="number"){
				$this->Settings[$result[$i]->KeyName]=floatval($result[$i]->KeyValue);
			}else{
				$this->Settings[$result[$i]->KeyName]=$result[$i]->KeyValue;
			}	        
	    }
    }

    private function imgSave($ext,$file,$UploadPath){
        if($ext=="gif"){return  imagegif($file,$UploadPath);}
        elseif($ext=="jpg"){return  imagejpeg($file,$UploadPath);}
        elseif($ext=="jpeg"){return  imagejpeg($file,$UploadPath);}
        elseif($ext=="png"){return  imagepng($file,$UploadPath);}
        elseif($ext=="avif"){imageavif($file,$UploadPath);}
        elseif($ext=="bmp"){return  imagebmp($file,$UploadPath);}
        elseif($ext=="wbmp"){return  imagewbmp($file,$UploadPath);}
        elseif($ext=="webp"){return  imagewebp($file,$UploadPath);}
    }
    private function imageCreateFromUrl($url){
        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION)); 
        $img;
        switch ($ext) {
            case 'png':
                $img=imagecreatefrompng($url);
                break;
            
            case 'jpg':
                    $img=imagecreatefromjpg($url);
                    break;
            default:
                $img=imagecreatefromany($url);
                break;
        }
        return $img;
    }

    private function getWaterMarkImg(){
        if($this->Settings['WaterMarkImage']!=""){
            return $this->imageCreateFromUrl(url('/')."/".$this->Settings['WaterMarkImage']);
        }
        return null;
    }
    public function addWaterMark($file,$UploadDir,$UploadName,$isUrl=false){
        if($this->Settings['isEnabledWaterMark']==true){
            ini_set("memory_limit", "-1");
            set_time_limit(0);
            if($isUrl==true){
                $img = $this->imageCreateFromUrl($file);
            }else{
    
            }
            list ($width, $height) = getimagesize($file);
            $newImg = imagecreatetruecolor($width, $height);
            $WMImg=$this->getWaterMarkImg();
            imagecopyresampled($newImg, $img, 0, 0, 0, 0, $width, $height, $width, $height);
            if(($WMImg!=null)&&($this->Settings['isWaterMarkImage']==1)){
                list ($wWidth, $wHeight) = getimagesize($this->Settings['WaterMarkImage']);

                $marge_right = 20;
                $marge_bottom = 20;
                $sx = imagesx($WMImg);
                $sy = imagesy($WMImg);
                $WMImgCopy=imagecreatetruecolor($wWidth, $wHeight);
                imagesavealpha($WMImgCopy, true);
                $color = imagecolorallocatealpha($WMImgCopy, 0, 0, 0, 127);
                imagefill($WMImgCopy, 0, 0, $color);
                imagecopyresized($WMImgCopy, $WMImg, 0, 0, 0, 0, $wWidth, $wHeight, imagesx($WMImg), imagesy($WMImg));
    
                imagecopy($newImg, $WMImgCopy, $width-($wWidth+$marge_right), $height-($wHeight+$marge_bottom), 0, 0, $wWidth, $wHeight);
            }else{
                
                $fontSize=$this->Settings['FontSize'];
                $font=$this->Settings['Font'];
                $WaterMarkText=$this->Settings['WaterMarkText'];
                $angle=45;

                $color = imagecolorallocate($newImg, $this->Settings['Color']["r"],$this->Settings['Color']["g"],$this->Settings['Color']["b"]);

                list($left, $bottom, $right, , , $top) = imageftbbox($fontSize, $angle, $font, $WaterMarkText);

                $centerX = $width / 2;
                $centerY = $height / 2;
                $left_offset = ($right - $left) / 2;
                $top_offset = ($bottom - $top) / 2;
                // Generate coordinates
                $x = $centerX - $left_offset;
                $y = $centerY + $top_offset;

                imagettftext($newImg, $fontSize, $angle, $x, $y, $color, $font, $WaterMarkText);
            }
            if($isUrl==true){
                $ext=pathinfo($file, PATHINFO_EXTENSION);
            }else{
                $ext=$file->getClientOriginalExtension();
            }
            $uploadPath=$UploadDir.$UploadName;
            $this->imgSave($ext,$newImg,$uploadPath);
            if($WMImg!=null){ imagedestroy($WMImg);}
            return $uploadPath;
        }else{
            if($isUrl==true){
                $uploadPath=$UploadDir.$UploadName;
                copy($file,$uploadPath);
                return $uploadPath;
            }else{
                $file->move($UploadDir,$UploadName);
                $uploadPath=$UploadDir.$UploadName;
                return $uploadPath;
            }
        }
    }
    /*
    private function curlRead($url){

        $ch = curl_init();
        $timeout = 0;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        
        // Getting binary data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        
        $image = curl_exec($ch);
        curl_close($ch);
        return imagecreatefromstring($image);
    }
    private function imageCreateFromAny($filepath,$isUrl=false) {
        $ext="";
        if($isUrl==true){
            $ext = strtolower(pathinfo($this->Settings['WaterMarkImage'], PATHINFO_EXTENSION));    
        }else{
            try {
                $ext = strtolower($filepath->getClientOriginalExtension());
            } catch (\Throwable $th) {
                
            }
        }
        return $this->curlRead($filepath);
        return $filepath;
    }
    private function imgSave($ext,$file,$UploadPath){
        if($ext=="gif"){return  imagegif($file,$UploadPath);}
        elseif($ext=="jpg"){return  imagejpeg($file,$UploadPath);}
        elseif($ext=="jpeg"){return  imagejpeg($file,$UploadPath);}
        elseif($ext=="png"){return  imagepng($file,$UploadPath);}
        elseif($ext=="avif"){imageavif($file,$UploadPath);}
        elseif($ext=="bmp"){return  imagebmp($file,$UploadPath);}
        elseif($ext=="wbmp"){return  imagewbmp($file,$UploadPath);}
        elseif($ext=="webp"){return  imagewebp($file,$UploadPath);}
    }
    private function getWaterMarkImg(){
        if($this->Settings['WaterMarkImage']!=""){
            return $this->imageCreateFromAny(url('/')."/".$this->Settings['WaterMarkImage'],true);
        }
        return null;
    }
    public function addWaterMark($file,$UploadDir,$UploadName,$isUrl=false){
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        list ($width, $height) = getimagesize($file);
        $newImg = imagecreatetruecolor($width, $height);
        $img = $this->imageCreateFromAny($file);
        $WMImg=$this->getWaterMarkImg();
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $width, $height, $width, $height);
        if(($WMImg!=null)&&($this->Settings['isWaterMarkImage']==1)){
            $marge_right = 20;
            $marge_bottom = 20;
            $sx = imagesx($WMImg);
            $sy = imagesy($WMImg);
            $WMWidth = ($width*30)/100;
            $WMheight = ($height*10)/100;
            $WMImgCopy=imagecreatetruecolor($WMWidth, $WMheight);
            imagesavealpha($WMImgCopy, true);
            $color = imagecolorallocatealpha($WMImgCopy, 0, 0, 0, 127);
            imagefill($WMImgCopy, 0, 0, $color);
            imagecopyresized($WMImgCopy, $WMImg, 0, 0, 0, 0, $WMWidth, $WMheight, imagesx($WMImg), imagesy($WMImg));

            imagecopy($newImg, $WMImgCopy, imagesx($newImg) - $WMWidth - $marge_right, 20, 0, 0, $WMWidth, $WMheight);
        }else{
            $txtcolor = imagecolorallocate($newImg, $this->Settings['Color']["r"],$this->Settings['Color']["g"],$this->Settings['Color']["b"]);
            imagettftext($newImg, $this->Settings['FontSize'], 0, $width-(strlen($this->Settings['WaterMarkText'])*(($this->Settings['FontSize']/2)+20)), 120, $txtcolor, $this->Settings['Font'], $this->Settings['WaterMarkText']);            
        }
        if($isUrl==true){
            $ext=pathinfo($file, PATHINFO_EXTENSION);
        }else{
            $ext=$file->getClientOriginalExtension();
        }
        $uploadPath=$UploadDir.$UploadName;
        $this->imgSave($ext,$newImg,$uploadPath);
        // imagedestroy($newImg);
        // imagedestroy($img);
        if($WMImg!=null){ imagedestroy($WMImg);}
        return $uploadPath;
    }
    public function addWaterMarkBase64($img,$UploadDir,$UploadName){
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        
        $width=imagesx($img);
        $height=imagesy($img);
        //list ($width, $height) = getimagesize($file);
        $newImg = imagecreatetruecolor($width, $height);
        $WMImg=$this->getWaterMarkImg();
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $width, $height, $width, $height);
        if(($WMImg!=null)&&($this->Settings['isWaterMarkImage']==1)){
            $marge_right = 20;
            $marge_bottom = 20;
            $sx = imagesx($WMImg);
            $sy = imagesy($WMImg);
            $WMWidth = ($width*30)/100;
            $WMheight = ($height*10)/100;
            $WMImgCopy=imagecreatetruecolor($WMWidth, $WMheight);
            imagesavealpha($WMImgCopy, true);
            $color = imagecolorallocatealpha($WMImgCopy, 0, 0, 0, 127);
            imagefill($WMImgCopy, 0, 0, $color);
            imagecopyresized($WMImgCopy, $WMImg, 0, 0, 0, 0, $WMWidth, $WMheight, imagesx($WMImg), imagesy($WMImg));

            imagecopy($newImg, $WMImgCopy, imagesx($newImg) - $WMWidth - $marge_right, 20, 0, 0, $WMWidth, $WMheight);
        }else{
            $txtcolor = imagecolorallocate($newImg, $this->Settings['Color']["r"],$this->Settings['Color']["g"],$this->Settings['Color']["b"]);
            imagettftext($newImg, $this->Settings['FontSize'], 0, $width-(strlen($this->Settings['WaterMarkText'])*(($this->Settings['FontSize']/2)+20)), 120, $txtcolor, $this->Settings['Font'], $this->Settings['WaterMarkText']);            
        }
        $ext="png";
        $uploadPath=$UploadDir.$UploadName;
        $this->imgSave($ext,$newImg,$uploadPath);
        // imagedestroy($newImg);
        // imagedestroy($img);
        if($WMImg!=null){ imagedestroy($WMImg);}
        return $uploadPath;
    }*/
}