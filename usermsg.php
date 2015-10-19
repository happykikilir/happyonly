<?php 
session_start();
$userid = isset($_GET["userid"]) ? $_GET["userid"] : "";
if(empty($userid)) {
	header("location: http://happyonly.com.cn");
}
require("package/base.php");
$mysql = new Mysql();
$dbc = $mysql->connect_db();
?>
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

	<div class="articlebox userbox">
		<?php
			$result = mysql_query("SELECT * FROM user where userID=".$userid);
			$row = mysql_fetch_array($result);
		?>
		<?php if($userid == $_SESSION["userid"]) { ?><a href="useredit.php" class="editmsg">编辑</a><?php } ?>
		<div class="userimg" id="userPic"><img src="<?php echo $row["faceimg"];?>"/>
			<p><span id="changePic">点击更换头像</span></p>
		</div>
		<div class="userdetail">
			<p><span>用户名：</span><a href="#"><?php echo $row["username"];?></a></p>
			<p><span>昵称：</span><a href="#"><?php echo $row["nickname"];?></a></p>
			<p><span>QQ：</span><a href="#"><?php echo $row["QQ"];?></a></p>
			<p><span>爱好：</span><a href="#"><?php echo $row["hobbies"];?></a></p>
			<p><span>最喜欢的书：</span><a href="#"><?php echo $row["book"];?></a></p>
			<p><span>最喜欢的电影：</span><a href="#"><?php echo $row["movie"];?></a></p>
			<p><span>最喜欢的食物：</span><a href="#"><?php echo $row["food"];?></a></p>
		</div>
	</div>
	
	<div class="articlebox recently">
		<?php
			$result = mysql_query("SELECT * FROM bookread where userID='$userid' order by readID desc limit 0,5");
		?>
		<h4>最近阅读</h4>
		<?php while($row = mysql_fetch_array($result)) {?>
			<p><?php echo $row["rd"];?></p>
		<?php } ?>
	</div>
	<div class="articlebox wishlist">
		<h4>心愿单</h4>
		<?php
			$result = mysql_query("SELECT * FROM wish where userID='$userid' order by readID desc limit 0,5");
		?>
		<?php while($row = mysql_fetch_array($result)) {?>
			<p><?php echo $row["wh"];?></p>
		<?php } ?>
	</div>
	<footer>
		<div class="basewidth">
			<p>Copyright © 2014 樱心落影 All Right Reserved</p>
			<p>樱心落影 版权所有</p>
			<p>The Only ! Be Better !!</p>
		</div>
	<footer>
</body>
</html>
