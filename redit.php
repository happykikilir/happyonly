<?php 
session_start();
$id = $_GET["id"];
if(!empty($id)) {
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("SET NAMES 'UTF8'");
		
		$result = mysql_query("SELECT * FROM artical where articalID='$id'");
		$row = mysql_fetch_array($result);
		if($row) {
			//$row = json_encode($row);
			$userid = $row["userid"];
			$title = urldecode($row["title"]);
			$content = urldecode($row["content"]);
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>HappyOnly--<?php echo $title;?></title>
<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
<script type="text/javascript" src="js/login.js" ></script>
 <script type="text/javascript" charset="utf-8" src="js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="js/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="js/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
	<div class="top">
		<div class="basewidth">
			<span class="right" id="userLoginBox"><a href="usermsg.php" id="username" ></a><a href="#" id="Register">注册</a><a href="#" id="Login">登陆</a></span>
			<!--<div class="search"><input type="text" class="inptext" value="请输入您要查询的内容"/><input class="inpbtn" type="button"/></div>-->
			<div class="logo">HappyOnly</div>
			<ul class="nav">
				<li class=""><a href="index.php">首页</a></li>
				<li class=""><a href="myindex.php">我的主页</a></li>
				<li><a href="about.php">about only</a></li>
			</ul>
		</div>
	</div>
	<div class="head">
		<div class="photo txxz"><img src="images/112.jpg"/></div>
		<h4>樱心落影</h4>
		<div class="mood">你是自己的作者，何必要写那么难演的剧本。。</div>
	</div>
	<div class="editbox">
		<?php if( isset($userid) && ($userid == $_SESSION["userid"]) ) {?>
			<h4 class="edittitle"><input type="text" id="Title" value="<?php echo $title;?>"/></h4>
			<div  class="editcon">
				<script id="editor" type="text/plain" style="width:900px;height:350px;"><?php echo $content;?></script>
			</div>
		<?php } ?>
		
		<div class="editbtn">
			<a id="release">发布</a>
			
			<a>取消</a>
		</div>
	</div>
	

<script type="text/javascript">
var $title = $(".edittitle :text");
btxt = "添加标题";	
$title.focus(function(){
	if(($(this).val() == "") || ($title.val() == btxt)){
		$(this).val("");
	}
	
});
$title.blur(function(){
	if($(this).val() == ""){
		$(this).val(btxt);
	}		
});
	
var ue = UE.getEditor('editor');
var encode = encodeURIComponent;

$("#release").click(function(){
	var edittext = UE.getEditor("editor").getContent();
	if(($title.val == "")|| ($title.val()==btxt)){
		alert("请输入标题")
	}else{
		$.post("http://happyonly.com.cn/package/rewrite_artical.php",{
				id : query("id"),
				title : encode($title.val()),
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