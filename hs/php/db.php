<?php 
class MyDB extends SQLite3   {  
  function __construct($dbName){  	
    $this->open($dbName); 
  }
} 







function feng_ye($pageSize){ 	
  if(empty($_GET["start"])){ 
    $start=0; 	}else{  	
    $start=$_GET["start"]; 
  }   
  if(empty($_GET["len"])){
    $len=$pageSize;
  }else{
    $len=$_GET["len"];
  }   
  $get=$_GET;
  $ss=$start-$len;
  if($ss<0){ 
    $ss=0;
  }  
  $get["start"]=$ss;
  $get["len"]=$len;
  $qstr=arr_to_url($get);
  $url=$qstr; 
  $up='<a href="'.$url.'" >上页</a>';
  $get["start"]=$start+$len;
  $get["len"]=$len;
  $qstr=arr_to_url($get);
  $url=$qstr;
  $down='<a href="'.$url.'" >下页</a>';
  $rs["link"]=$up.$down;
  $rs["up"]=$up; 
  $rs["down"]=$down;
  $rs["start"]=$start;
  $rs["len"]=$len;
$rs["zfy"]='<div id="zfy">'.$down.$up.'</div>';
  return $rs;
}





function dirMade($Dir){ 	
  if(!is_dir($Dir)){
    mkdir($Dir,0777,true); 	
  }
} 





function dirFind($filepath){ 
  $pattern = '/(.+?)\//';
  preg_match_all($pattern, $filepath, $match); 
  $c=count($match[1]);
  if(!empty($match[1])){ 
    $DirPath=$match[1][0];
    for($i=0;$i<=$c-1;$i++){
      $Dir1=$match[1][$i];
      if($i!=0){ 
        $DirPath.="/".$Dir1;
      } 
      dirMade($DirPath);
    }
  }
} 








function dbq($dbArr){
  //设置数据库类型
  $banBen=PHP_VERSION;
  $banBen=floatval($banBen);
if($banBen>=5.3){
$dbArr["dbType"]=2; 
}else{
$dbArr["dbType"]=2;
} 
  $dbArr["arr"]=array();
  $method=$dbArr["method"];
  switch($method){  
case "tbls":
      $dbArr=db_get_tablename_all($dbArr);
      if(!empty($dbArr["tss"])){
        TS($dbArr["ts"]);
}
return $dbArr;
break;  	
    case "tj":/*添加*/ 
      $dbArr=dbAdd($dbArr);
      if(!empty($dbArr["tss"])){
        TS($dbArr["ts"]);
      }  
      return $dbArr;
      break;
    case "replace":
      $dbArr=dbReplace($dbArr); 
      if(!empty($dbArr["tss"])){
        TS($dbArr["ts"]);
      }  
      return $dbArr;
      break;
    case "xg":/*修改*/
      $dbArr=dbUpdata($dbArr);
      $ts=$dbArr["ts"];/*echo $ts;*/
      if(!empty($dbArr["tss"])){    
        TS($dbArr["ts"]);   
      }   	
      return $dbArr;  	
      break;
    
    case "zj":
      $dbArr=dbZuiJia($dbArr); 
      $ts=$dbArr["ts"];/*echo $ts;*/   
      if(!empty($dbArr["tss"])){ 
        TS($dbArr["ts"]); 
      }  
      return $dbArr;
      break; 
    
    case "djl":/*修改*/   
      $sql=$dbArr["sql"]; 
      if($dbArr["sql"]!=""){  
        $dbArr=dbRead($dbArr); 
        if(!empty($dbArr["arr"])){  
          $dbArr["sql"]=$sql; 
          $dbArr=dbDjl($dbArr); 
        }else{  
          $dbArr=dbAdd($dbArr); 
        } 
      }  
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]);
      } 
      return $dbArr;  
      break; 
    
    case "tjxg":/*添加修改*/  
      $sql=$dbArr["sql"]; 
      if($dbArr["sql"]!=""){
        $dbArr=dbRead($dbArr);  
        if(!empty($dbArr["arr"])){  
          $dbArr["sql"]=$sql; 
          $dbArr=dbUpdata($dbArr); 
        }else{  
          $dbArr=dbAdd($dbArr); 
        }
      }else{
        $dbArr=dbAdd($dbArr); 
      }  
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]);  
      }   
      return $dbArr; 
      break;
    
    case "tjkv": 
      $dbArr=dbRead($dbArr); 
      if(empty($dbArr["arr"])){ 
        $dbArr=dbAdd($dbArr); 
        $dbArr["ts"]="操作成功";  
      }else{
        $dbArr["ts"]="不能重复添加";  
      } 
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]);  
      }  
      return $dbArr; 
      break;
    
    
    case "read":/*读取*/  
      $dbArr=dbRead($dbArr); 
      $dbArr["ts"]="操作成功"; 
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]); 
      }
      return $dbArr; 
      break; 
    
    case "readfy":/*读取*/ 
      $dbArr["sql"]=$dbArr["sql"]." limit ".$dbArr["len"]." offset ".$dbArr["start"]; 
      $dbArr=dbRead($dbArr); 
      $dbArr["ts"]="操作成功"; 
      if(!empty($dbArr["tss"])){ 
        TS($dbArr["ts"]);  
      }  
      return $dbArr;  
      break;
    
    
    case "select":/*读取*/  
      $dbArr=dbSelect($dbArr); 
      $dbArr["ts"]="操作成功"; 
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]); 
      }   
      return $dbArr; 
      break;
    
    
    case "del":/*删除*/   
      $dbArr=dbDel($dbArr); 
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]); 
      }
      $dbArr["arr"]=array(); 
      return $dbArr;  
      break;
    
    case "clear":/*删除表*/  
      $dbArr=dbDelTable($dbArr); 
      if(!empty($dbArr["tss"])){  
        TS($dbArr["ts"]);  
      }  
      return $dbArr;  
      break;
    
    
    case "djl":/*点击率*/  
      $sql=$dbArr["sql"]; 
      $dbArr=dbRead($dbArr); 
      $dbArr["sql"]=$sql; 
      $data=$dbArr["data"]; 
      $ar=$dbArr["arr"];  
      if(!empty($ar)){  
        foreach($ar as $num=>$Item){ 
          foreach($data as $key=>$val){ 
            $val_db=$Item[$key]+$val;
            $data_db[$key]=$val_db; 
          }
        }
        $dbArr["data"]=$data_db; 
        $dbArr=dbUpdata($dbArr); 
      } 
      if(!empty($dbArr["tss"])){ 
        TS($dbArr["ts"]); 
      }
      return $dbArr; 
      break; 
    
    
    case "login":/*登录*/  
      $dbArr=dbRead($dbArr); 
      $ar=$dbArr["arr"];   
      if(!empty($ar)){  
        $dbArr["ts"]="操作成功";  
         	$_SESSION["un"]=$ar[0]["t1"];    	
        $_SESSION["uid"]=$ar[0]["n45"];    	
        $_SESSION["jiBie"]=$ar[0]["n4"];   	
      }else{    	
        $dbArr["ts"]="操作失败";   	
      }       	
      if(!empty($dbArr["tss"])){    
        TS($dbArr["ts"]);   	
      }    	return $dbArr;  
      break; 	
  }
} 
/*######################### 	
获取数据库表
###########################*/
function db_get_tablename_all($dbArr)
{
  $dbArr=dbCreate($dbArr); 
  $db=$dbArr["db"];
  $sql='SELECT  *   FROM sqlite_master WHERE type="table"'; 	
  $dbArr["sqltb"]=$sql;
  //$ret=$db->exec($sql); 
  $ret = dbQuerytb($dbArr); 
  $dbArr["tbl_names"]=array();
if($dbArr["dbType"]==2){
while($row = $ret->fetch(PDO::FETCH_ASSOC)){ 
  $dbArr["tbl_names"][]=$row["name"];
}
}else{
while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
if(!empty($row)){ 
  $dbArr["tbl_names"][]=$row["name"];
}
}
}
//print_r($dbArr["arrt"]);
return $dbArr;
}









/*修改记录*/
function dbZuiJia($dbArr){ 	
  /*db_create_table($dbArr);*/ 
  $dbArr=dbCreate($dbArr); 
  dbTable($dbArr); 
  //$dbArr=dbOpen($dbArr); 
  $db=$dbArr["db"];/*打开数据库*/ 
  $tableName=$dbArr["tableName"]; 
  $sql=$dbArr["sql"];
  $data=$dbArr["data"]; 	
  $str=''; 	
  //if(empty($data["n42"])){ 
// 	$data["n42"]=time()*1000;
//	} 
//	$data["t41"]="已同步"; 	
  //-------------------------------------------- 
  foreach($data as $key=>$val){ 
    if(searchText(array("t",$key))){
      if($tableName=="用户"&&($key=="t2"||$key=="t3")){ 
        $str.=$key."='".strE($val)."',";
      }else{ 
        //$str.=$key."=".$key."+'".strE($val)."',";  
        $str.=$key."=".$key."||'".strE($val)."',";
      }
    }else{ 
      if($val==""){ 
        $str.=$key."='',";  
      }else{  
        //$str.=$key."=".$key."+".$val.",";  
        $str.=$key."=".$key."+'".$val."',"; 
      }
    }
  }
  $str=substr($str,0,strlen($str)-1);
  $str=" set ".$str;
  if($dbArr["sql"]!=""){
    $sql=" UPDATE ".$dbArr["tableName"].$str." where ".$sql; 
  }else{
    $sql=" UPDATE ".$dbArr["tableName"].$str;
  }
  //echo $sql;
  $dbArr["sqlDo"]=$sql;
  $ret = dbExec($dbArr);
  if ($ret)   	{  
    $dbArr["ts"]='操作成功'; 
  }  else  { 
    $dbArr["ts"]='操作失败'; 
  }   
  dbClose($dbArr); 
  return $dbArr;
}






/*修改记录*/
function dbUpdata($dbArr){ 
  /*db_create_table($dbArr);*/ 
  $dbArr=dbCreate($dbArr);
  dbTable($dbArr);
  //$dbArr=dbOpen($dbArr); 
  $db=$dbArr["db"];/*打开数据库*/  	
  $tableName=$dbArr["tableName"];
  $sql=$dbArr["sql"]; 
  $data=$dbArr["data"]; 
  $str='';
  if(empty($data["n42"])){ 
    $data["n42"]=time()*1000; 
  }
  $data["t45"]=strE(date("Y-m-d H:i:s"));
  $data["t41"]="已同步"; 
  //--------------------------------------------
  foreach($data as $key=>$val){ 
    if(searchText(array("t",$key))){ 
      if($tableName=="用户"&&($key=="t2"||$key=="t3")){ 
        $str.=$key."='".strE($val)."',"; 
      }else{
        $str.=$key."='".strE($val)."',";
      }
    }else{ 
      if($val==""){
        $str.=$key."='',";  
      }else{
        $str.=$key."=".$val.","; 
      }
    }
  }
  $str=substr($str,0,strlen($str)-1);
  $str=" set ".$str; 
  if($dbArr["sql"]!=""){ 
    $sql=" UPDATE ".$dbArr["tableName"].$str." where ".$sql; 
  }else{
    $sql=" UPDATE ".$dbArr["tableName"].$str; 
  }
  $dbArr["sqlDo"]=$sql;
  $ret = dbExec($dbArr);
  if ($ret)   	{  
    $dbArr["ts"]='操作成功'; 
  }  else  { 
    $dbArr["ts"]='操作失败'; 
  }
  dbClose($dbArr); 
  return $dbArr;
}









/*######################### 
时间删除 	dbTimeDel2($arr);
###########################*/
function dbTimeDel2($a)
{
  $Days=$a[0];
  $tbn=$a[1]; 
  $Now=time()*1000;
  $Days=24*60*60*1000*$Days; 
  $c=$Now-$Days;
$dbjs=dbq(
array(  
  "tableName"=>$tbn, 
  "sql"=>"t44='".$tbn."' and n42<".$c,
  "tss"=>"",
  "method"=>"del",
  "data"=>""
  
)
);  
delFilesb(array("tbn"=>$tbn,"sql"=>$dbjs["sql"]));  
}




/*#########################
时间删除
###########################*/
function dbTimeDel($Days,$id,$DBTime)
{
  $Now=time(); 
  $DBTime2=strtotime($DBTime);
  $DaysChat=($Now-$DBTime2)/(24*60*60); 
  if($DaysChat>$Days){ 
    $dbjs=dbq(array("tableName"=>"论坛","sql"=>"n45=".$id,"tss"=>"","method"=>"del","data"=>"")); 
  }
} 







function dbTable($dbArr){ 
  $dbArr=dbCreate($dbArr);
  $tableName=$dbArr["tableName"];
  $db=$dbArr["db"]; 
  $sql='';
  for($i=1;$i<=45;$i++){ 
    $sql.="t".$i." TEXT,"; 
  }
  for($i=1;$i<=45;$i++){  
    if($i!=45){  
      $sql.="n".$i." REAL,"; 
    } 
  }
  $sql=substr($sql,0,(strlen($sql)-1)); 	
  $sql="CREATE TABLE ".$tableName."(n45 integer primary key,".$sql.")";/*UNIQUE 唯一的*//*创建表*/  	
  $dbArr=dbGetTables($dbArr); 
  $arrt=$dbArr["arrt"]; 	
  if(empty($arrt)){  
    $dbArr["sqlDo"]=$sql;  
    $ret =dbExec($dbArr); 
    if (empty($ret)){   	
      //$dbArr["ts"]=$db->lastErrorMsg();  
    }else{   	
      $dbArr["ts"]="创建表成功";  
    } 	
  } 	
  dbClose($dbArr);
  return $dbArr;
} 












/*###################################

# 	读取记录     	#
#        	#
#####################################*/
function dbSelect($dbArr){ 
  $dbArr=dbCreate($dbArr); 
  dbTable($dbArr); 
  //$dbArr=dbOpen($dbArr);
  $db=$dbArr["db"];/*打开数据库*/  
  $tableName=$dbArr["tableName"]; 
  $sql=$dbArr["sql"];
  $data=""; 
  if(!empty($dbArr["data"])){ 
    $data=$dbArr["data"]; 
  }
  $dbArr["sql"]=$sql; 
  $ret = dbQuery($dbArr); 
if($dbArr["dbType"]==2){
//$ret->setFetchMode(PDO::FETCH_NUM); 
//while($row = $ret->fetch()){
while($row = $ret->fetch(PDO::FETCH_ASSOC)){
  $dbArr["arr"][]=$row;
}
}else{
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ){ 
    /*if($row["t44"]=="yh"){   	$row["t2"]=strD($row["t2"]);   	$row["t3"]=strD($row["t3"]);  	}*/  
    $dbArr["arr"][]=$row; 
  }
} 	//if(!empty($arr_rs)){  
// 	$dbArr["arr"]=$arr_rs;
//	}else{
// 	$dbArr["arr"]="";
//	} 	dbClose($dbArr); 	return $dbArr;
}
/*修改记录*/
function dbReplace($dbArr){ 	
  /*db_create_table($dbArr);*/ 
  $dbArr=dbCreate($dbArr);
  dbTable($dbArr); 	
  //$dbArr=dbOpen($dbArr); 	
  $db=$dbArr["db"];/*打开数据库*/  
  $tableName=$dbArr["tableName"];  
  $sql=$dbArr["sql"]; 
  $data=$dbArr["data"]; 	
  $str='';     
  foreach($data as $key=>$val){  
    if(searchText(array("t",$key))){        
      $str.=$key."=replace(".$key.",'".$val[0]."','".strE($val[1])."'),";   
    } 	
  }
  $str=substr($str,0,strlen($str)-1);  
  $str=" set ".$str;   
  if($dbArr["sql"]!=""){    
    $sql=" UPDATE ".$dbArr["tableName"].$str." where ".$sql;
  }else{ 
    $sql=" UPDATE ".$dbArr["tableName"].$str;
  }
  $dbArr["sqlDo"]=$sql; 
  $ret = dbExec($dbArr);  
  if ($ret)   	{    
    $dbArr["ts"]='操作成功';  
  }  else  {   
    $dbArr["ts"]='操作失败';  
  }    	
  dbClose($dbArr);  
  return $dbArr;
} 



function dbRead($dbArr){ 
  $dbArr=dbCreate($dbArr); 
  dbTable($dbArr); 
  //$dbArr=dbOpen($dbArr); 
  $db=$dbArr["db"];/*打开数据库*/  
  $tableName=$dbArr["tableName"]; 
  $sql=$dbArr["sql"];  
  $data="";   
  if(!empty($dbArr["data"])){  
    $data=$dbArr["data"]; 
  }  	
  if(empty($dbArr["sql"])){  
    $sql="SELECT * from ".$dbArr["tableName"]; 
  }else{  	
    $sql="SELECT * from ".$dbArr["tableName"]." where ".$dbArr["sql"];  
  }   
  $dbArr["sql"]=$sql; 
  $ret = dbQuery($dbArr); 
if($dbArr["dbType"]==2){
while($row = $ret->fetch(PDO::FETCH_ASSOC)){   
  $dbArr["arr"][]=$row;
}
}else{ 	
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ){  
    if($row["t44"]=="用户"){  
      $row["t2"]=strD($row["t2"]);  
      $row["t3"]=strD($row["t3"]);    
      if(!empty($dbArr["isTB"])&&$dbArr["isTB"]==1){  
        $row["t2"]="";    
        $row["t3"]="";   
      }  
    }  
    $dbArr["arr"][]=$row; 	
  }
}   
  dbClose($dbArr); 	return $dbArr;
}


function dbQuerytb($dbArr){
if($dbArr["dbType"]==1){
  return $dbArr["db"]->query($dbArr["sqltb"]);
}
if($dbArr["dbType"]==2){ 
  $ret=$dbArr["db"]->query($dbArr["sqltb"]);
  return $ret;
}
}






function dbQuery($dbArr){ 	
  if($dbArr["dbType"]==1){  
    return $dbArr["db"]->query($dbArr["sql"]); 	
  }
if($dbArr["dbType"]==2){  
  return $dbArr["db"]->query($dbArr["sql"]); 
}
}





function dbJiBie($a)
{
$id=$a[0];
$jibie=$a[1];
$dbjs=dbq(array("tableName"=>"yh","sql"=>"t44='yh' and n45=".$id,"tss"=>"","method"=>"xg","data"=>array("n4"=>$jibie)));
return $dbjs;
} 







/*######################### 	
获取数据库表
###########################*/
function dbGetTables($dbArr)
{ 
  //$db=$dbArr["db"]; 
  $dbArr["sqltb"]='SELECT  *   FROM sqlite_master WHERE type="table" and name="'.$dbArr["tableName"].'"'; 	
  //$dbArr["sqltb"]=$sql; 	
  //$ret=$db->exec($sql);
$dbArr["arrt"]=array();  
if($dbArr["dbType"]==2){
$res = $dbArr["db"]->query($dbArr["sqltb"]); 
$res->setFetchMode(PDO::FETCH_NUM);
while($row = $res->fetch()){    
  $dbArr["arrt"][] = $row;
}
/*
while($row = $res->fetch(\PDO::FETCH_ASSOC)){    $dbArr["arrt"][] = $row;
}
*/
}else{
$ret = dbQuerytb($dbArr);  
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ){  	
    $dbArr["arrt"][]=$row;
  }
} 	return $dbArr;
} 




function dbExec($dbArr){ 	
  //if($dbArr["dbType"]==1){  
  return $dbArr["db"]->exec($dbArr["sqlDo"]); 
  //}
}







/*修改记录*/
function dbDjl($dbArr){ 	
  /*db_create_table($dbArr);*/ 	
  $dbArr=dbCreate($dbArr); 
  dbTable($dbArr); 	
  //$dbArr=dbOpen($dbArr); 	
  $db=$dbArr["db"];/*打开数据库*/  
  $tableName=$dbArr["tableName"];  
  $sql=$dbArr["sql"]; 	
  $data=$dbArr["data"]; 	
  $str=''; 	
  //-------------------------------------------- 	
  foreach($data as $key=>$val){   
    if(searchText(array("t",$key))){    
      $dbArr["ts"]="不能修改字符串字段。";  
    }else{    
      if($val==""){    
        $dbArr["ts"]="不能空白";  
      }   	else   	{   
        $str.=$key."=".$val."+".$key.",";  
      }   
    
    }  
  }   	
  if(empty($data["n42"])){  
    $data["n42"]=time()*1000; 
  } 	
  $str.="n42=".$data["n42"]; 
  //$str=substr($str,0,strlen($str)-1);  
  $str=" set ".$str;   	
  if($dbArr["sql"]!=""){    
    $sql=" UPDATE ".$dbArr["tableName"].$str." where ".$sql; 	
  }else{  
    $sql=" UPDATE ".$dbArr["tableName"].$str; 	
  } 	
  //print_r($sql); 
  $dbArr["sqlDo"]=$sql; 	
  $ret = dbExec($dbArr);    
  if ($ret)   	{     
    $dbArr["ts"]='操作成功';  
  }  else  {     	
    $dbArr["ts"]='操作失败';   
  }    
  dbClose($dbArr);  	
  return $dbArr;
}





function dbDelTable($dbArr){ 
  /*dbTable($dbArr);*/ 	
  $dbArr=dbCreate($dbArr); 
  //$dbArr=dbOpen($dbArr);  
  $db=$dbArr["db"];/*打开数据库*/  
  $tableName=$dbArr["tableName"];  
  $sql="DROP TABLE ".$dbArr["tableName"]; 
  $dbArr["sqlDo"]=$sql; 	
  $ret=dbExec($dbArr);    
  if($ret){     	
    $dbArr["ts"]="操作失败";  
  } else {      
    $dbArr["ts"]="操作成功";   
  }   
  dbClose($dbArr); 
  return $dbArr;
} 







/*删除*/
function dbDel($dbArr){ 	
  $dbArr=dbTable($dbArr); 	
  $dbArr=dbCreate($dbArr);  
  //$dbArr=dbOpen($dbArr); 	
  $db=$dbArr["db"]; 
  $tableName=$dbArr["tableName"]; 	
  $sql=$dbArr["sql"];  
  $data=$dbArr["data"];   
  if($sql!=""){   
    $dbsql="DELETE from ".$dbArr["tableName"]." where ".$sql;  
    $dbArr["sqlDo"]=$dbsql;  
    $ret=dbExec($dbArr);      
    if($ret){      
      $dbArr["ts"]="操作成功";    
    }else {    
      $dbArr["ts"]="操作失败";     
    }  
  }else{   
    $dbArr["ts"]="sql未配置";  
  } 	
  dbClose($dbArr); 	
  return $dbArr;
}








/*创建数据库*/
function dbCreate($dbArr){   
  /*检查数据库文件*/     
  //$pin = new pin(); 
  //$tbn=$pin->Pinyin($dbArr["tableName"],'UTF8');  
  if(empty($dbArr["dbName"])){   
    //$dbName=$dbArr["dbName"]="data/#appDb.db"; 
    $dbName=$dbArr["dbName"]="data1/#".$dbArr["tableName"].".db";  
  }else{   
    $dbName=$dbArr["dbName"];  
  }  	
  /*检查数据库文件*/  
  dirFind($dbName);
if($dbArr["dbType"]==1){
$db = new MyDB($dbName);
}
else if($dbArr["dbType"]==2)
{
//$db = sqlite_open($dbName);
$db = new PDO('sqlite:'.$dbName); 
# 设置数据库编码为utf-8
$db->exec('set names utf8'); 
}  
  if(!file_exists($dbName)){  
    if(!$db){ 
      echo $db->lastErrorMsg();   
    }else{   
      echo "打开数据库成功\n";   
    } 
  }  	
  $dbArr["db"]=$db; 
  return $dbArr;
}









function dbClose($dbArr){ 
  if($dbArr["dbType"]==1){  
    $dbArr["db"]->close(); 
  }
} 










/*
添加记录*/
function dbAdd($dbArr){ 
  $dbArr=dbTable($dbArr); 
  $dbArr=dbCreate($dbArr); 
  $db=$dbArr["db"]; 
  $tableName=$dbArr["tableName"];  
  $sql=$dbArr["sql"]; 
  //设置时间 	
  if(empty($data["n42"])){ 	
    $dbArr["data"]["n42"]=time()*1000; 
  } 
if(empty($dbArr["data"]["n24"])&&!empty($_SESSION["uid"])){
$dbArr["data"]["n24"]=$_SESSION["uid"];
}
if(empty($dbArr["data"]["t43"])&&!empty($_SESSION["un"])){
$dbArr["data"]["t43"]=$_SESSION["un"];
}  	
  $dbArr["data"]["t45"]=date("Y-m-d H:i:s"); 	
  //数据状态 	$dbArr["data"]["t41"]="已同步";
  //表名 	
  $dbArr["data"]["t44"]=$tableName; 
  $dbArr["data"]["n39"]=1;//点击率 	
  $data=$dbArr["data"]; 	
  for($i=1;$i<=45;$i++){  	
    $data2["t".$i]="";  	
    if($i!=45){   
      $data2["n".$i]=0;  	
    } 
  }
foreach($data as $k=>$v){ 	
  $data2[$k]=strE($v);
}    
  $sqlstr='';  
  $sqlstrb='';  
  foreach($data2 as $key=>$val){    
    if(searchText(array("t",$key))){   
      if($tableName=="yh"&&($key=="t2"||$key=="t3")){    
        $sqlstr.=$key;  
        $sqlstr.=',';   
        $sqlstrb.="'".strE($val)."'";  
        $sqlstrb.=',';   
      }else{    
        $sqlstr.=$key;    
        $sqlstr.=',';   
        $sqlstrb.="'".strE($val)."'";  
        $sqlstrb.=',';   
      }       
    }else{   
      $sqlstr.=$key;  
      $sqlstr.=',';   
      if($val==""){    
        $sqlstrb.="0";   
      }else{    
        $sqlstrb.=$val;   
      }   
      $sqlstrb.=',';  	
    } 
  } 
$sqlstr=substr($sqlstr,0,(strlen($sqlstr)-1));
$sqlstrb=substr($sqlstrb,0,(strlen($sqlstrb)-1)); 	
  $sqlstr='('.$sqlstr.')'; 
  $sqlstrb='('.$sqlstrb.')'; 
  $sqlc=$sqlstr." VALUES ".$sqlstrb; 	
  $dbsql="insert into ".$dbArr["tableName"].$sqlc; 
  $query=$dbsql; 
  $dbArr["sqlDo"]=$query; 
  if (dbExec($dbArr)){ 
    $dbArr["ts"]='操作成功';  
  }else{  
    $dbArr["ts"]='添加失败';  	
  } 
  dbClose($dbArr);  
  return $dbArr;
}
?>
