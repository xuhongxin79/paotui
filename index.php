<?php
ob_start();
session_start();
//开启错误提示
ini_set('display_errors','On');
//中国时区
date_default_timezone_set('PRC');
?>
<?php
//用于异步请求
//如果有get到lf执行这里，否则执行常规页面
if(isset($_GET["lf"])){
//这个是要执行的php函数名，原来php的函数名也能用字符串表示并执行。
$f=$_GET["lf"];
//这里是动态插入这个函数，不用一次性插入，太多了
//每个函数写一个页面，以4开头，归类。如4xx.php
include("hs/php/4".$f.".php");
$f();
}
//以下是常规页面正常HTML输出
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">
<title>跑腿网页教程</title>
<script language="JavaScript" type="text/javascript">
var webBt="shangyawo";
var menuJson={};
</script>
<link href="hs/css/style.css" rel="stylesheet" type="text/css" />
</head> 
<body>
<?php
//把导航条插入这里，作为全部页面使用
//也可以在需要插入的页面中使用
include("hs/php/nav.php");
?>
<div id="bodyOut">
<div id="show">
<?php
//常规页面放这里执行
//默认执行main首页
$f="main";
if(isset($_GET["f"])){
$f=$_GET["f"];
}
//插入要执行的文件，文件名比函数名多1字
include("hs/php/1".$f.".php");
//执行
$f();
?>
</div>
</div>
</body>
</html>
<?php }?>
