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
	<h4 class="title">登陆</h4>
	<div class="loginmsg" >
		<p><span>用户名/邮箱：</span><input id="username" type="text"/></p>
		<p><span>密码：</span><input id="password" type="password"/></p>
		<p><span>&nbsp;</span><a class="red"></a>&nbsp;</p>
		<p><span>&nbsp;</span>
			<a class ="loginbtn" id="Loginbtn">登录</a>
			<a id="Close" class ="loginbtn close" >取消</a>
		</p>
		<!--<p class="cr-login"><span>关联账号登陆：</span><a href="#">新浪微博</a><a href="#">腾讯QQ</a><a href="#">人人</a><a href="#">豆瓣</a></p>
		-->
	</div>
</div>
<script type="text/javascript">
	
	$(".loginbox").on("click",".close",function(){
		$("#Lock",parent.document.body).remove();
		$("#Loginbox",parent.document.body).remove();		
	})
	$(":input").change(function(){
		$(this).css({"background":"#fafafa"})
	})
	
	$("#Loginbtn").click(function(){
		$.get( "http://happyonly.com.cn/package/login.php" ,{
			username : $("#username").val(),
			password : $("#password").val()
		},function(result){
			if(result.status == "ok"){
				parent.location.reload();
			} else {
				alert("err")
				$("#Loginmsg .red").html(result.data);
			}
			
		},"json")
	})
	
</script>
</body>
</html>
