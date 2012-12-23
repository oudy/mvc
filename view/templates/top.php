<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE1 {
	font-size: 12px;
	color: #ffffff;
}
.STYLE5 {font-size: 12}
.STYLE7 {font-size: 12px; color: #FFFFFF; }
#Scroll {CLEAR: both;  FONT-SIZE: 12px; MARGIN: 0px auto; WIDTH: 408px; COLOR: #c2130e; LINE-HEIGHT: 8px; HEIGHT: 26px; TEXT-ALIGN: left
}
#Scroll A {
 COLOR: #fff; MARGIN-RIGHT: 5px; TEXT-DECORATION: none
}
#Scroll A.s_end {
PADDING-RIGHT: 0px; MARGIN-LEFT: 8px; color:#fff;
}
.shell{
	background:url(/static/image/ad.gif) no-repeat 0px 0px;
	width:400px;
	font-size:12px;
	text-align:left;
	padding:2px 2px 2px 56px; 
}
#div4 a{ color:#FFF; text-decoration:none; line-height:18px; display:block}
.core{
	height:18px;
	overflow:hidden;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="69" background="/static/image/main_03.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="384" height="69" background="/static/image/main_01.gif">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="281" ><div style="text-align:right; padding-right:20px"><a href="#" style="color:#FFF; font-size:12px">系统首页</a> <a style="color:#FFF; font-size:12px" href="#">刷新</a></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="38" background="/static/image/main_31.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="8" height="38"><img src="/static/image/main_28.gif" width="8" height="38" /></td>
        <td width="26" background="/static/image/main_29.gif"></td>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="38"><span class="STYLE1">当前登录用户：admin &nbsp;用户角色：<?php //echo $adminSession->roleid;?></span></td>
            <td class="STYLE1" width="430" style="text-align:right">&nbsp;</td>
            <td height="38" width="10" background="/static/image/mm.gif" class="STYLE1">&nbsp;&nbsp;</td>
            <td  width="80" class="STYLE1"><img style="margin-right:4px" src="/static/image/xg.gif" width="14" height="12" /><a href="password.html" target="right" style="color:#FFF;">修改密码</a></td>
            <td height="38" width="10" background="/static/image/mm.gif" class="STYLE1">&nbsp;&nbsp;</td>
            <td class="STYLE1"><img src="/static/image/tc.gif" width="14" height="12" /><a target="_parent" href="/login/index/reset"  style="color:#FFF">退出</a></td>
            
          </tr>
        </table></td>
        <td width="17"><img src="/static/image/main_32.gif" width="20" height="38" /></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
<script>
function myGod(id,w,n){
	var box=document.getElementById(id),can=true,w=w||1500,fq=fq||10,n=n==-1?-1:1;
	box.innerHTML+=box.innerHTML;
	box.onmouseover=function(){can=false};
	box.onmouseout=function(){can=true};
	var max=parseInt(box.scrollHeight/2);
	new function (){
		var stop=box.scrollTop%18==0&&!can;
		if(!stop){
			var set=n>0?[max,0]:[0,max];
			box.scrollTop==set[0]?box.scrollTop=set[1]:box.scrollTop+=n;
		};
		setTimeout(arguments.callee,box.scrollTop%18?fq:w);
	};
};
myGod('div4',2000);
</script>
</html>
