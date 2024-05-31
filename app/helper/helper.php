<?php
function dateTimeFormat($dateTime,$format,$isInput=false){
    if($isInput==true){
        return date("Y-m-d H:i:s",strtotime($dateTime));
    }
    return date($format,strtotime($dateTime));
}
function timeFormat($date,$format,$isInput=false){
    if($isInput==true){
        return date("Y-m-d",strtotime($date));
    }

    return date($format,strtotime($date));
}
function dateFormat($date,$format,$isInput=false){
    if($isInput==true){
        return date("Y-m-d",strtotime($date));
    }

    return date($format,strtotime($date));
}
function NumberFormat($Value,$Decimal){
    if($Decimal!="auto"){
        return number_format($Value,$Decimal,".","");
    }else{
        return $Value;
    }
}
function NumberSteps($Decimal){
    $Value="1";
    if($Decimal!="auto"){
        if($Decimal==0){
            return 1;
        }else{
            return "0.".str_pad($Value,$Decimal,"0",STR_PAD_LEFT);
        }
    }else{
        return $Value;
    }
}
?>