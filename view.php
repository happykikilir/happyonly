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
			$userid = $row["userid"];
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scale=0"/>
<title>HappyOnly</title>

<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
<script type="text/javascript" src="js/login.js" ></script>
<script type="text/javascript">
$(document).ready(function(){
		$.get( "http://happyonly.com.cn/package/get_artical.php",{
			id:query("id")
		},function(result){
				if(result.status == "ok"){
					$("title").html("happyOnly --" + decodeURIComponent(result.data.title))
					$("#Title").html(decodeURIComponent(result.data.title))
					$("#Content").html(decodeURIComponent(result.data.content))
					$("#commentNum").html("评论 " + decodeURIComponent(result.data.comment_num))
				}else{
					alert(result.data)
				}
		},"json")
		$(".userreponse").on("click",".response",function(e){
			$.post("http://happyonly.com.cn/package/add_comment.php",{
				articalid :	query("id"),
				content : $(this).parent().parent().find("textarea").val()
			},function(result){
				if(result.status == "err"){
					alert(result.data)
					e.preventDefault();
				}else{
					location.reload();
				}
			},"json")
		})	
		$(".commentlist").on("click",".responseSubmit",function(e){
			
			$.post("http://happyonly.com.cn/package/add_commentp.php",{
				articalid :	query("id"),
				content : $(this).parent().parent().find("textarea").val(),
				commentid : $(this).attr('commentid')
			},function(result){				
				if(result.status == "err"){
					alert(result.data)
					e.preventDefault();
				}else{
					location.reload();
				}
				
			},"json")
		})
		
	})

</script>
</head>
<body>
	<div class="top">
		<div class="basewidth">
			<span class="right" id="userLoginBox"><a  id="username" ></a><a href="javascript:void(0)" id="Register">注册</a><a href="javascript:void(0)" id="Login">登陆</a></span>
			<!--<div class="search"><input type="text" class="inptext" value="请输入您要查询的内容"/><input class="inpbtn" type="button"/></div>-->
			<div class="logo">HappyOnly</div>
			<ul class="nav">
				<li class=""><a href="index.php">首页</a></li>
				<li><a href="myindex.php">我的主页</a></li>
				<li><a href="about.php">about only</a></li>
			</ul>
		</div>
	</div>
	<div class="head">
		<div class="photo txxz"><img src="images/112.jpg"/></div>
		<h4>樱心落影</h4>
		<div class="mood">你是自己的作者，何必要写那么难演的剧本。。</div>
	</div>	
	<div class="articlebox">
			<h4 class="articletitle" id="Title"></h4>
			<?php if( isset($id) && isset($userid) && ($_SESSION["userid"] == $userid) ) { ?>
				<p class="aticaltool">&nbsp;<a class="aticaledit" id="aticalEdit" href="redit.php?id=<?php echo $id;?>">编辑</a><a href="package/rm_artical.php?id=<?php echo $id;?>" class="aticaldelete">删除</a></p>
			<?php } ?> 
			<div class="articlemsg"><a href="#">浏览</a><a href="javascript:void(0)" id="commentNum">评论</a></div>
			<div class="" id="Content"></div>
	</div>
	<div class="commentback">
		<div class="comment-responsive">
			<div class="commentbox">
				<div class="userimg"><img src="images/g.jpg"/></div>
				<div class="userreponse">
					<div class="tareabox"><textarea >看完就写评论是个好习惯哦</textarea></div>
					<div class="responsebtn" id="responseBox">
						<a href="javascript:void(0)" class="response">说两句</a>
						<span href="javascript:void(0)"  class="emotionpic">表情</span>
						<a href="#">赞一个</a>
						<a href="#">踩一脚</a>	
					</div>
				</div>
			</div>
			<div class="commentlist" id="commentList">
				<ul>
					<?php $result = mysql_query("SELECT * FROM comment where articalid='$id'"); ?>
					<?php while($row = mysql_fetch_array($result)) {?>
						<?php if(empty($row["parentId"])) {?>
							<li>
								<div class="userimg">
									<a href="http://happyonly.com.cn/usermsg.php?userid=<?php echo $row["userid"];?>">
										<img src="<?php echo $row["faceimg"];?>"/>
									</a>
								</div>
								<div class="responsebox">
									<h5><a href="http://happyonly.com.cn/usermsg.php?userid=<?php echo $row["userid"];?>"><?php echo $row["nickname"];?></a></h5>
									<p><?php echo $row["content"];?></p>
									<div><span class="time"><?php echo $row["time"];?></span><a href="javascript:void(0)" class="answerResp" commentid="<?php echo $row["commentID"];?>">回复</a></div>
								</div>
							</li>
						<?php } else { ?>
							<li class="responseLi">
								<div class="userimg">
									<a href="http://happyonly.com.cn/usermsg.php?userid=<?php echo $row["userid"];?>">
										<img src="<?php echo $row["faceimg"];?>"/>
									</a>
								</div>
								<div class="responsebox">
									<h5>
										<a href="http://happyonly.com.cn/usermsg.php?userid=<?php echo $row["userid"];?>"><?php echo $row["nickname"];?></a>
										<span>回复</span>
										<a href="http://happyonly.com.cn/usermsg.php?userid=<?php echo $row["userid"];?>"><?php echo $row["parent_nickname"];?></a>
									</h5>
									<p><?php echo $row["content"];?></p>
									<div><span class="time"><?php echo $row["time"];?></span><a href="javascript:void(0)" class="answerResp" commentid="<?php echo $row["commentID"];?>">回复</a></div>
								</div>
							</li>
						<?php } ?>
						
					<?php } ?>
				</ul>
			</div>
		</div>
		
	</div>
	<div class="footer">
		<div class="basewidth">
			<p>Copyright © 2014 樱心落影 All Right Reserved</p>
			<p>樱心落影 版权所有</p>
			<p>The Only ! Be Better !!</p>
		</div>
	</div>
	
	
<script type="text/javascript">
	$(".userreponse").on("focus","textarea",function(e){
		if($(this).val()=="" ||$(this).val()=="看完就写评论是个好习惯哦"){
			$(this).val("")
		}
	});
	
	$(".comment-responsive").on("click", ".answerResp", function(e){
		$(".answsr_response").remove();
		$resdiv = $("<div class='answsr_response'><textarea id='answer_res_textarea'></textarea><div class='responsebtn'><a href='javascript:void(0)' class='cancelres'>取消</a><a href='javascript:void(0)' commentid = '"+$(this).attr('commentid')+"'class='responseSubmit'>回复</a><span  class='emotionpic'>表情</span></div></div>")
		$(this).parent().after($resdiv);
		e.preventDefault();
		e.stopPropagation();
	});
	
	$(".comment-responsive").on("click", ".cancelres", function(e){
		e.preventDefault();
		e.stopPropagation();
        $(".answsr_response").remove();
	});

	var $picbox = $("<div class='emotionbox'></div>");
	$(".comment-responsive").on("click", ".emotionpic", function(e){
        e.stopPropagation();
		$(this).parent().append($picbox);
		
	});
	$("body").on("click",function(){
		$picbox.detach();
	});
    
	var emotionpic = {
		'a.gif' : '啊',
		'baobao.gif' : '抱抱',
		'bizui.gif':'闭嘴',
		'bugongping.gif':'不公平',
		'buhaoyisi.gif':'不好意思',
		'bulijie.gif':'不理解',
		'bunai.gif':'不耐',
		'buxie.gif':'不屑',
		'chijing.gif':'吃惊',
		'chuzou.gif':'出走',
		'dahan.gif':'大汗',
		'diantou.gif':'点头',
		'e.gif':'额',
		'gandong.gif':'感动',
		'han.gif':'汗',
		'jingya.gif':'惊讶',
		'kaixin.gif':'开心',
		'kewang.gif':'渴望',
		'kuangxiao.gif':'狂笑',
		'kuqi.gif':'哭泣',
		'lala.gif':'啦啦啦',
		'lehe.gif':'乐呵',
		'leibeng.gif':'泪奔',
		'nuqi.gif':'怒气',
		'paishou.gif':'拍手',
		'penlei.gif':'喷泪',
		'qianzou.gif':'欠揍',
		'sajiao.gif':'撒娇',
		'shenjingbing.gif':'深井冰',
		'shualai.gif':'耍赖',
		'tanqi.gif':'叹气',
		'wanan.gif':'晚安',
		'wulian.gif':'捂脸',
		'xi.gif':'喜',
		'xianhua.gif':'鲜花',
		'xiaozhang.gif':'嚣张',
		'xiuxiu.gif':'羞羞',
		'ya.gif':'呀',
		'yinshen.gif':'隐身',
		'yumen.gif':'郁闷',
		'ziexiao.gif':'贼笑',
		'zuoguilian.gif':'做鬼脸'
	}
	var isrc = '';
	for(isrc in emotionpic){
		var $img = $("<img/>")
		$img.attr('src', "images/emotion/" + isrc);
		$img.attr('alt',  emotionpic[isrc]);
		$picbox.append($img);
		$img.on("click",function(e){
			
            e.stopPropagation();
			var  $alt = $(this).attr('alt');
			$(this).parent().parent().prev("textarea").insertAtCursor("{"+$alt+"}");
			
			setTimeout(function(){
				$picbox.detach();
			},100)
		})
	}
	
</script>
</body>
</html>
