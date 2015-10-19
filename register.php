<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>HappyOnly</title>
<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
</head>
<body>
<div class="loginbox" id="Loginmsg">
	<span class="closebox close">x</span>
	<h4 class="title">注册新用户</h4>
	<div class="loginmsg" >
		<p><span>用户名/邮箱：</span><input id="username" type="text"/></p>
		<p><span>昵称：</span><input id="nickname" type="text"/></p>
		<p><span>密码：</span><input id="password" type="password"/></p>
		<p><span>确认密码：</span><input id="rpassword" type="password"/></p>
		<p><span>&nbsp;</span><a class="red"></a>&nbsp;</p>
		<!--<p class="point"><span>&nbsp;</span><input type="checkbox" class="checkinput"/>我看过并同意《站内网络服务协议》</p>
		-->
		<p><span>&nbsp;</span><a id ="registerBtn" class="loginbtn" >注册</a>
			<a id="Close" class ="loginbtn close">取消</a></p>
		<!--
		<p class="cr-login"><span>关联账号登陆：</span><a href="#">新浪微博</a><a href="#">腾讯QQ</a><a href="#">人人</a><a href="#">豆瓣</a></p>
	
		-->
	</div>
</div>
<script type="text/javascript">

	$("#Loginmsg").on("click",".close",function(){
		
		$("#Lock",parent.document.body).remove();
		$("#Loginbox",parent.document.body).remove();		
	})
	
	$(":input").change(function(){
		$(this).css({"background":"#fafafa"})
	})
	$("#registerBtn").click(function(){
		$.get( "http://happyonly.com.cn/package/regist.php" ,{
			username : $("#username").val(),
			nickname : $("#nickname").val(),
			password : $("#password").val(),
			rpassword : $("#rpassword").val()
		},function(result){
			if(result.status == "err"){
				$("#Loginmsg .red").html(result.data)
			} else {
				parent.location.reload();
			}
		},"json")
	})
</script>
</body>
</html>
