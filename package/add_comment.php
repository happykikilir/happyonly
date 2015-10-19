<?php
	session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	function send_data($status, $data) {
		$arr = array();
		$arr["status"] = $status;
		$arr["data"] = $data;
		echo json_encode($arr);
	}
	function html_encode($a) {
		if(is_array($a)) {
			$arr = array();
			foreach($a as $key=>$val) {
				$arr[$key] = htmlspecialchars($val);
			}
			return $arr;
		}
	}
	$data = html_encode($_POST);
	
	$arr = array();
	
	if(isset($_SESSION["login_status"])) {
		$faceimages = array(
			'啊'=>'http://happyonly.com.cn/images/emotion/a.gif',
			'抱抱'=>'http://happyonly.com.cn/images/emotion/baobao.gif',
			'闭嘴'=>'http://happyonly.com.cn/images/emotion/bizui.gif',
			'不公平'=>'http://happyonly.com.cn/images/emotion/bugongping.gif',
			'不好意思'=>'http://happyonly.com.cn/images/emotion/buhaoyisi.gif',
			'不理解'=>'http://happyonly.com.cn/images/emotion/bulijie.gif',
			'不耐'=>'http://happyonly.com.cn/images/emotion/bunai.gif',
			'不屑'=>'http://happyonly.com.cn/images/emotion/buxie.gif',
			'吃惊'=>'http://happyonly.com.cn/images/emotion/chijing.gif',
			'出走'=>'http://happyonly.com.cn/images/emotion/chuzou.gif',
			'大汗'=>'http://happyonly.com.cn/images/emotion/dahan.gif',
			'点头'=>'http://happyonly.com.cn/images/emotion/diantou.gif',
			'额'=>'http://happyonly.com.cn/images/emotion/e.gif',
			'感动'=>'http://happyonly.com.cn/images/emotion/gandong.gif',
			'汗'=>'http://happyonly.com.cn/images/emotion/han.gif',
			'惊讶'=>'http://happyonly.com.cn/images/emotion/jingya.gif',
			'开心'=>'http://happyonly.com.cn/images/emotion/kaixin.gif',
			'渴望'=>'http://happyonly.com.cn/images/emotion/kewang.gif',
			'狂笑'=>'http://happyonly.com.cn/images/emotion/kuangxiao.gif',
			'哭泣'=>'http://happyonly.com.cn/images/emotion/kuqi.gif',
			'啦啦啦'=>'http://happyonly.com.cn/images/emotion/lala.gif',
			'乐呵'=>'http://happyonly.com.cn/images/emotion/lehe.gif',
			'泪奔'=>'http://happyonly.com.cn/images/emotion/leibeng.gif',
			'怒气'=>'http://happyonly.com.cn/images/emotion/nuqi.gif',
			'拍手'=>'http://happyonly.com.cn/images/emotion/paishou.gif',
			'喷泪'=>'http://happyonly.com.cn/images/emotion/penlei.gif',
			'欠揍'=>'http://happyonly.com.cn/images/emotion/qianzou.gif',
			'撒娇'=>'http://happyonly.com.cn/images/emotion/sajiao.gif',
			'深井冰'=>'http://happyonly.com.cn/images/emotion/shenjingbing.gif',
			'耍赖'=>'http://happyonly.com.cn/images/emotion/shualai.gif',
			'叹气'=>'http://happyonly.com.cn/images/emotion/tanqi.gif',
			'晚安'=>'http://happyonly.com.cn/images/emotion/wanan.gif',
			'捂脸'=>'http://happyonly.com.cn/images/emotion/wulian.gif',
			'喜'=>'http://happyonly.com.cn/images/emotion/xi.gif',
			'鲜花'=>'http://happyonly.com.cn/images/emotion/xianhua.gif',
			'嚣张'=>'http://happyonly.com.cn/images/emotion/xiaozhang.gif',
			'羞羞'=>'http://happyonly.com.cn/images/emotion/xiuxiu.gif',
			'呀'=>'http://happyonly.com.cn/images/emotion/ya.gif',
			'隐身'=>'http://happyonly.com.cn/images/emotion/yinshen.gif',
			'郁闷'=>'http://happyonly.com.cn/images/emotion/yumen.gif',
			'贼笑'=>'http://happyonly.com.cn/images/emotion/ziexiao.gif',
			'做鬼脸'=>'http://happyonly.com.cn/images/emotion/zuoguilian.gif'
		);
		
		$content = $data["content"];
		$articalid = $data["articalid"];
		$userid = $_SESSION["userid"];
		$username = $_SESSION["username"];
		$nickname = $_SESSION["nickname"];
		$parentId = "";
		$time = date("Y-m-d H:i:s");
		
		if(empty($content)) {
			send_data("err", "请输入评论内容！");
			exit;
		}
		
		if(empty($articalid)) {
			send_data("err", "请输入评论文章的id！");
			exit;
		}
		
		foreach($faceimages as $key=>$val) {
			$content = str_replace("{".$key."}", '<img src="'.$val.'" title="'.$key.'" width="50" height="50"/>', $content);
		};
		
		if($dbc = mysql_connect("localhost", "songgenlei_root", "19850903song")) {
			mysql_query("SET NAMES 'UTF8'");
			mysql_select_db("songgenlei_blog", $dbc);
			
			//获取corder的值
			$result = mysql_query("SELECT * FROM comment_num where id=1");
			$row = mysql_fetch_array($result);
			$n = intval($row["artical_num"]);
			$n = $n + 1;
			$len = strlen($n);
			for($i = 0; $i < 10 - $len; $i++) {
				$n = "0".$n;
			}
			$sql = "UPDATE comment_num SET artical_num='$n' where id=1";
			mysql_query($sql);
			$corder = $n.$row["reply_num"];
			
			//读取用户数据
			$result = mysql_query("SELECT * FROM user where userID=".$_SESSION["userid"]);
			$row = mysql_fetch_array($result);
			$familyname = $row["familyname"];
			$faceimg = $row["faceimg"];
			if(!isset($familyname)) {
				$familyname = "";
			}
			
			//创建评论表
			$sql = "CREATE TABLE comment (
				commentID int NOT NULL AUTO_INCREMENT, 
				PRIMARY KEY(commentID),
				articalid varchar(20),
				content varchar(900),
				userid varchar(60),
				username  varchar(100),
				nickname  varchar(100),
				faceimg varchar(100),
				corder varchar(30),
				parentId varchar(20),
				parent_name varchar(100),
				parent_nickname varchar(100),
				parent_faceimg varchar(100),
				time datetime
			)TYPE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4";
			mysql_query($sql, $dbc);
			
			//向评论表中插入评论数据
			$sql = "INSERT INTO comment (
				`articalid`, 
				`content`,
				`userid`,
				`username`,
				`nickname`,
				`faceimg`,
				`parentId`,
				`corder`,
				`time`
			) VALUES (
				'".$articalid."', 
				'".$content."',
				'".$userid."', 
				'".$username."',
				'".$nickname."',
				'".$faceimg."',
				'".$parentId."', 
				'".$corder."',
				'".$time."'
			)";
			if(mysql_query($sql)) {
				
				send_data("ok", "评论发表成功");
				
				//在artical表里查询该文章，为comment_num字段加1
				$result = mysql_query("SELECT * FROM artical where articalID='$articalid'");
				$row = mysql_fetch_array($result);
				$comment_num = $row["comment_num"] + 1;
				$sql = "UPDATE artical SET comment_num='$comment_num' where articalID='$articalid'";
				mysql_query($sql);
			} else {
				send_data("err", "插入数据失败！");
			}
				
			mysql_close($dbc);
		}
	} else {
		send_data("err", "请登录后再评论！");
	}
?>