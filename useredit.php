<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>HappyOnly-用户信息</title>
<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
<script type="text/javascript" src="js/login.js" ></script>
<script type="text/javascript" src="js/face.js" ></script>
</head>
<body>
<header>
	<div class="top">		
		<div class="basewidth">
			<span class="right" id="userLoginBox"><a href="usermsg.php" id="username" ></a><a href="#" id="Register">注册</a><a href="#" id="Login">登陆</a></span>
			<!--<div class="search"><input type="text" class="inptext" value="请输入您要查询的内容"/><input class="inpbtn" type="button"/></div>-->
			<div class="logo"><a href="happyonly.com.cn">HappyOnly</a></div>
			<nav>
				<ul>
					<li ><a href="index.php">首页</a></li>
					<li class="sele"> <a href="myindex.php">我的主页</a></li>
					<li><a href="about.php">about only</a></li>
				</ul>
			</nav>
		</div>
	</div>	
	<div class="head">
		<div class="photo txxz"><img src="images/112.jpg"/></div>
		<h4><a href="usermsg.php?userid=4">樱心落影</a></h4>
		<div class="mood">你是自己的作者，何必要写那么难演的剧本。。</div>
	</div>
</header>
	<!--<p class="articlebox userintroduce">
		<a class="right" id="saveIntroduce">保存</a>
		<input  type="text" id="Introduce" value="说点什么，让大家认识你吧"/>
	</p>-->
		
	<div class="articlebox userbox">
		<a class="right" id="saveUserMsg" >保存</a>
		<div class="userimg" id="userPic">
			<div><img src="images/userpic/31.jpg"/></div>
			<p>
				<a href="javascript:void(0)" id="changePic">点击更换头像</a>
			</p>
		</div>
		<div class="userdetail useredit " id="personalMsg">
			<p><span>用户名：</span><input type="text" name="username" value="用户名" disabled="disabled" /></p> 
			<p><span>昵称：</span><input type="text"  name="nickname" disabled="disabled" /></p>
			<p><span>性别：</span><input type="radio" name="gender"  value="男"/>男<input type="radio" value="女" name="gender" />女</p>
			<p><span>生日：</span><input name="birthday" type="text"/></p>
			<p><span>所在地：</span><input name="province" type="text"/></p>
			<p><span>公司：</span><input name="company" type="text"/></p>
			<p><span>QQ：</span><input name="QQ" type="text"/></p>
			<p><span>爱好：</span><input name="hobbies" type="text"/></p>
			<p><span>个人站点：</span><input name="website" type="text"/></p>
			<p><span>最喜欢的书：</span><input name="book"  type="text"/></p>
			<p><span>最喜欢的电影：</span><input name="movie" type="text"/></p>
			<p><span>最喜欢的食物：</span><input  name="food" type="text"/></p>
		</div>
			
	</div>
	
	<div class="articlebox recently" >
		<a class="right" id="saveRecently">保存</a>
		<h4>最近阅读</h4>
		<div id="recentMsg"></div>
		<p class="addbox"><span>添加</span></p>
	</div>
	<div class="articlebox wishlist">
		<a class="right" id="saveWishList">保存</a>
		<h4>心愿单</h4>
		<div id="wishList"></div>
		<p class="addbox"><span>添加</span></p>
	</div>
	
	<footer>
		<div class="basewidth">
			<p>Copyright © 2014 樱心落影 All Right Reserved</p>
			<p>樱心落影 版权所有</p>
			<p>The Only ! Be Better !!</p>
		</div>
	<footer>
	
<script type="text/javascript">
	$add = $(".addbox span");
	$add.click(function(){
		$("<p><input type='text'/></p>").appendTo($(this).parent().prev())
	})
	/*var intromsg = "说点什么，让大家认识你吧";
	var $intro = $("#Introduce");
	$intro.focus(function(){
		if(($(this).val() == "")||($(this).val() == intromsg)){
			$(this).val("");
		}
	})
	$intro.blur(function(){
		if(($(this).val() == "")||($(this).val() == intromsg)){
			$(this).val(intromsg);
		}
	})*/
	
	$("input[disabled = disabled]").css({"border":"0px"})
	$("#saveUserMsg").click(function(){
		$.post("http://happyonly.com.cn/package/write_personal.php",{
			gender :$("#personalMsg input[name=gender]:checked").val(),
			birthday : $("#personalMsg input[name=birthday]").val(),
			province : $("#personalMsg input[name=province]").val(),
			company : $("#personalMsg input[name=company]").val(),
			QQ : $("#personalMsg input[name=QQ]").val(),
			hobbies : $("#personalMsg input[name=hobbies]").val(),
			movie : $("#personalMsg input[name=movie]").val(),
			book : $("#personalMsg input[name=book]").val(),
			food : $("#personalMsg input[name=food]").val(),
			website : $("#personalMsg input[name=website]").val()
		},function(result){
			if(result.status == "ok"){
				alert(result.data)
				window.location("usermsg.php")
			}
		},"json")
	})
	$("#saveRecently").click(function(){
		$.post("http://happyonly.com.cn/package/add_read.php",{			
			read : $("#recentMsg input").val()
		},function(result){
			if(result.status == "ok"){
				$p = $("<p></p>");
				$p.html($("#recentMsg input").val());
				$p.insertBefore($("#recentMsg"));
				($("#recentMsg p")).remove();
			}else{
				alert(result.data.read)
			}
		},"json")
	})
	$("#saveWishList").click(function(){
		$.post("http://happyonly.com.cn/package/add_wish.php",{			
			wish : $("#wishList input").val()
		},function(result){
			if(result.status == "ok"){
				$p = $("<p></p>");
				$p.html($("#wishList input").val());
				$p.insertBefore($("#wishList"));
				($("#wishList p")).remove();
			}else{
				alert(result.data)
				//console.log(result.data.read)
			}
		},"json")
	})
	
	
  
</script>
</body>
</html>
