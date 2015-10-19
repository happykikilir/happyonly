<?php
	session_start();
	
	header("Content-type: text/html; charset=utf-8");
	include "simple_html_dom.php";
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
	
	$data = $_POST;
	
	$arr = array();
	
	$title = $data["title"];
	$content = $data["content"];
	$comment_num = 0;
	$time = date("Y-m-d h:i:sa");
	
	if(empty($_SESSION["login_status"])) {
		send_data("err", "请登录后再发表文章！");
		exit;
	}
	
	if(empty($title)) {
		send_data("err", "请输入文章的标题！");
		exit;
	}
	$title = htmlspecialchars($title);
	
	if(empty($content)) {
		send_data("err", "请输入文章的内容！");
		exit;
	}
	$content = preg_replace('/<script.*>(.|\n|\r|\t|<br\/>|<br>)*(<\/script>)*/', '', $content);
    $html = new simple_html_dom();
    $html->load(urldecode($content));
    $part_content = $html->find("p", 0).$html->find("p", 1).$html->find("p", 2);
	if(empty($time)) {
		send_data("err", "请输入文章的文章的发表日期！");
		exit;
	}
	
	$username = $_SESSION["username"];
	$userid = $_SESSION["userid"];

	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("SET NAMES 'UTF8'");
		
		$sql = "CREATE TABLE artical (
			articalID int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(articalID),
			title varchar(100),
			part_content varchar(10000),
			content varchar(60000),
			artical_cls varchar(60),
			author varchar(60),
			userid varchar(30),
			comment_num varchar(30),
			time date
		)TYPE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		mysql_query($sql,$dbc);
		
		$sql = "INSERT INTO artical (
			`title`, 
			`part_content`,
			`content`,
			`artical_cls`,
			`author`,
			`userid`,
			`comment_num`,
			`time`
		) VALUES (
			'".$title."', 
			'".$part_content."', 
			'".$content."',
			'".$artical_cls."',
			'".$username."',
			'".$_SESSION["userid"]."',
			'".$comment_num."',
			'".$time."'
		)";
		mysql_query($sql, $dbc);
		
		$result = mysql_query("SELECT * FROM artical order by articalID desc");
		$row = mysql_fetch_array($result);
		
		$arr["status"] = "ok";
		$arr["data"] = "发表成功！";
		$arr["id"] = $row["articalID"];
		setcookie("re", "1", time() + 36000, "/");
		echo json_encode($arr);
		
		mysql_close($dbc);
	}
?>