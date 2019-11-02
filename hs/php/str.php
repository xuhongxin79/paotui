<?php
function jsonEB($arr)
{ 	
$str=strEB(json_encode($arr)); 	return $str;
} 






function jsonE($arr)
{ 	$str=strE(json_encode($arr)); 	return $str;
}



function jsonDB($str)
{ 	
$arr=json_decode(strDB($str),true); 	return $arr;
} 





function jsonD($str)
{
$arr=json_decode(strD($str),true); 	return $arr;
} 







function strEB($str){ 	
if(is_string($str)){  
$str=str_replace("&","【heb】",$str);
$str=str_replace("\r\n","【hhb】",$str);  	
$str=str_replace("\r","【hhb】",$str);
$str=str_replace("\n","【hhb】",$str);  
$str=str_replace("<","【xyhb】",$str);  
$str=str_replace(">","【dyhb】",$str);  
$str=str_replace("{","【zdhhb】",$str);  	
$str=str_replace("}","【ydhhb】", $str);  
$str=str_replace("[","【zzhhb】", $str);  	
$str=str_replace("]","【yzhhb】", $str);  
$str=str_replace("'","【pieb】",$str);  	
$str=str_replace("\"","【syhb】",$str);
$str=str_replace("%","【bfhb】",$str);  	
$str=str_replace("/","【zxkb】",$str);  
$str=str_replace(" ","【kbb】",$str);
$str=str_replace("=","【dengb】",$str);  
$str=str_replace("+","【jiab】",$str);  
$str=str_replace("-","【jianb】",$str); 	
}
return $str;

}

function strE($str){
if(is_string($str)){ 
$str=str_replace("<?","【xyh】?",$str); 
$str=str_replace("<%","【dyh】 %",$str); 	
$str=str_replace("<script","【xyh】script",$str); 	
$str=str_replace("<javascript","【dyh】 javascript",$str); 	
$str=str_replace("&","【he】",$str);
$str=str_replace("\r\n","【hh】",$str); 
$str=str_replace("\r","【hh】",$str); 	
$str=str_replace("\n","【hh】",$str); 
$str=str_replace("<","【xyh】",$str); 	
$str=str_replace(">","【dyh】",$str); 	
$str=str_replace("{","【zdhh】",$str);
$str=str_replace("}","【ydhh】", $str); 	
$str=str_replace("[","【zzhh】", $str); 	
$str=str_replace("]","【yzhh】", $str); 	
$str=str_replace("'","【pie】",$str); 	
$str=str_replace("\"","【syh】",$str); 	
$str=str_replace("%","【bfh】",$str); 	
$str=str_replace("\/","【zxk】",$str);
$str=str_replace("\\","【yxk】",$str); 	
$str=str_replace(" ","【kb】",$str); 	
$str=str_replace("=","【deng】",$str); 	
$str=str_replace("+","【jia】",$str); 
$str=str_replace("-","【jian】",$str); 	
$str=str_replace("#","【jh】",$str);
} 
}
return $str;
}






function strDB($str){
if(is_string($str)){ 
$str=str_replace("【jianb】","-",$str);  
$str=str_replace("【jiab】","+",$str);  	
$str=str_replace("【dengb】","=",$str);  
$str=str_replace("【kbb】"," ",$str);  
$str=str_replace("【heb】","&",$str);  	
$str=str_replace("【zdhhb】","{",$str);  	
$str=str_replace("【ydhhb】","}",$str);  
$str=str_replace("【zzhhb】","[",$str);  	
$str=str_replace("【yzhhb】","]",$str); 
$str=str_replace("【xyhb】","<",$str);  
$str=str_replace("【dyhb】",">",$str);  	
$str=str_replace("【pieb】","'",$str);  	
$str=str_replace("【syhb】","\"",$str);  	
$str=str_replace("【hhb】","<br />",$str);  	
$str=str_replace("【bfhb】","%",$str);  	
$str=str_replace("【yxkb】","\\",$str);  	
$str=str_replace("【zxkb】","/",$str);  	
$str=str_replace("\r\n","<br />",$str);  	
$str=str_replace("\n","<br />",$str);  	
$str=str_replace("\r","<br />",$str);    	
}
return $str;
}









function strD($str){
if(is_string($str)){
$str=str_replace("【jh】","#",$str);
$str=str_replace("【jian】","-",$str); 	
$str=str_replace("【jia】","+",$str); 	
$str=str_replace("【deng】","=",$str); 	
$str=str_replace("【kb】"," ",$str); 	
$str=str_replace("【he】","&",$str); 
$str=str_replace("【zdhh】","{",$str);
$str=str_replace("【ydhh】","}",$str); 	
$str=str_replace("【zzhh】","[",$str); 
$str=str_replace("【yzhh】","]",$str); 
$str=str_replace("【xyh】","<",$str); 	
$str=str_replace("【dyh】",">",$str); 	
$str=str_replace("【pie】","'",$str); 	
$str=str_replace("【syh】","\"",$str); 
$str=str_replace("【hh】","<br />",$str); 	
$str=str_replace("【bfh】","%",$str); 	
$str=str_replace("【yxk】","\\",$str); 
$str=str_replace("【zxk】","/",$str); 	
$str=str_replace("\r\n","<br />",$str); 	
$str=str_replace("\n","<br />",$str); 	
$str=str_replace("\r","<br />",$str); 	
$str=preg_replace("/\[BQ(\d+)\]/",'<img src="http://'.$_SERVER['HTTP_HOST'].'/image/qq/$1.gif" />',$str);
}	
return $str;
}
?>
