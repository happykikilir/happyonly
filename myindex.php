<?php 
session_start();
if(!isset($_SESSION["login_status"])) {
	header("location: http://happyonly.com.cn");
}
require("package/base.php");
$cur_page = isset($_GET["p"]) ? intval($_GET["p"], 10) : 1;
$mysql = new Mysql();
$dbc = $mysql->connect_db();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>HappyOnly</title>
<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
<script type="text/javascript" src="js/login.js" ></script>
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
	
	<div class="main basewidth">
		<div class="leftside">
			<?php
				$mysql = new Mysql();
				$dbc = $mysql->connect_db();
				$num = 10;
				$m = $num * ($cur_page - 1);
				$total = mysql_query("SELECT count(*) FROM artical where userid=".$_SESSION["userid"]);
				if(!empty($total)) {
					$artical_total = mysql_fetch_array($total);
				}
			?>
			<?php if($result = mysql_query("SELECT * FROM artical where userid=".$_SESSION["userid"] . " order by articalID desc limit $m,10")){ ?>
				<?php while($row = mysql_fetch_array($result)) { ?>
					<div class="datalist">
						<div class="data-article">
							<?php 
								$time = explode(" ", $row["time"]);
								$time = explode("-", $time[0]);
							?>
							<span class="month"><?php echo $time[1]."月";?></span>
							<span class="day"><?php echo $time[2];?></span>
						</div>
						<h4 class="datatitle"><a href="http://happyonly.com.cn/view.php?id=<?php echo $row["articalID"];?>"><?php echo urldecode($row["title"]);?></a>
						</h4>
						<h5 class="articlemsg"><span class="comment">评论  <?php echo $row["comment_num"];?></span></h5>
						<div class="article"><?php echo urldecode($row["part_content"]);?></div>
						<div class="morebtn">
							<a href="view.php?id=<?php echo $row["articalID"];?>">阅读全文</a>
						</div>
					</div>
				<?php } ?>
			<?php } else {?>
				<div class="datalist">您还没有写过文章哦！</div>
			<?php } ?>
			<div class="fen_page"><?php ch_page($artical_total[0], 2, $cur_page, "http://happyonly.com.cn/myindex.php?p=");?></div>
	
		</div>
		<div class="rightbox">
			<div class="buttonpart"><a href="edit.php">写文字</a></div>
			
			<aside>
				<h4>活跃用户</h4>
				<div class="visitor">
					<?php $result = mysql_query("SELECT * FROM user order by login_time desc");?>
					<?php while($row = mysql_fetch_array($result)) { ?>
						<a href="http://happyonly.com.cn/usermsg.php?userid=<?php echo $row["userID"];?>" title="<?php echo $row["nickname"];?>"><img src="<?php echo $row["faceimg"]?>" /></a>
					<?php } ?>
				</div>
			</aside>
			<aside>
				<h4>最新文章</h4>
					<div>
						<ul>
							<?php $result = mysql_query("SELECT * FROM artical order by time desc")?>
							<?php while($row = mysql_fetch_array($result)) { ?>
								<?php $time = split(" ", $row["time"]);?>
								<li>
									<p><a href="http://happyonly.com.cn/view.php?id=<?php echo $row["articalID"];?>"><?php echo urldecode($row["title"]);?></a></p>
									<span class="time"><?php echo $time[0];?></span>
									<a><?php echo $row["comment_num"];?>评论</a>
								</li>
							<?php } ?>
						</ul>
					</div>
			</aside>
			<aside>
					<h4>友情链接</h4>
					<div class="link">
						<a href="http://chblog.cn" >葡萄藤</a>
					</div>
				</aside>
		
		</div>
		
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
