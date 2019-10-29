<?php
//设置文档标题
function BT($str)
{
$str=strip_tags($str);
echo '<script language="JavaScript" type="text/javascript">webBt="'.$str.'";document.title=webBt;</script>';
}
?>
