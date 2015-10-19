<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>HappyOnly--新建文章</title>
<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
<script type="text/javascript" src="js/login.js" ></script>
 <script type="text/javascript" charset="utf-8" src="js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="js/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="js/ueditor/lang/zh-cn/zh-cn.js"></script>
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
					<li><a href="myindex.php">我的主页</a></li>
					<li><a href="about.php">about only</a></li>
				</ul>
			</nav>
		</div>
	</div>
	<div class="top-photo">
		<div class="photo txxz"><img src="images/112.jpg"/></div>
		<h4><a href="usermsg.php?userid=4">樱心落影</a></h4>
		<div class="mood">你是自己的作者，何必要写那么难演的剧本。。</div>
	</div>
</header>
	<div class="editbox">
		<h4 class="edittitle"><input type="text" id="Title"value="添加标题"/></h4>
		<div  class="editcon">
			<script id="editor" type="text/plain" style="width:900px;height:350px;"></script>
		</div>
		<div class="editbtn">
			<a id="release">发布</a>
			<a>取消</a>
		</div>
	</div>
<footer>
		<div class="basewidth">
			<p>Copyright © 2014 樱心落影 All Right Reserved</p>
			<p>樱心落影 版权所有</p>
			<p>The Only ! Be Better !!</p>
		</div>
	<footer>	

<script type="text/javascript">
	var $title = $(".edittitle :text");
	btxt = "添加标题";	
	$title.focus(function(){
		if(($(this).val() == "") || ($title.val() == btxt)){
			$(this).val("");
		}
		
	})
	$title.blur(function(){
		if($(this).val() == ""){
			$(this).val(btxt);
		}		
	})
	
	var ue = UE.getEditor('editor');
	var encode = encodeURIComponent;
	
	$("#release").click(function(){
		var edittext = UE.getEditor('editor').getContent();
		if(($title.val() == "") || ($title.val()== btxt)){
			alert("请输入标题");
		}else{
			$.post( "http://happyonly.com.cn/package/write_arcical.php" ,{
				title : encode($("#Title").val()),
				content : encode(edittext)
			},function(result){
				if(result.status =='err'){
					alert(result.data)
				}else {
					location.href = "view.php?id="+result.id
				}
			},"json")
		}
	})
	
	
</script>
</body>
</html>
