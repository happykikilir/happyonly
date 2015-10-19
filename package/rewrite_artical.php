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
	
	$id = htmlspecialchars($data["id"]);
	$title = $data["title"];
	$part_content = $data["part_content"];
	$content = $data["content"];
	//$artical_cls = $data["artical_cls"];
	$time = date("Y-m-d");
	
	if(empty($_SESSION["login_status"])) {
		send_data("err", "请登录后再发表文章！");
		exit;
	}
	
	if(empty($id)) {
		send_data("err", "请输入文章的id！");
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
	
	/*if(empty($artical_cls)) {
		send_data("err", "请输入文章的分类！");
		exit;
	}
	$artical_cls = htmlspecialchars($artical_cls);*/
	
	$username = $_SESSION["username"];
	//$userid = $_SESSION["userid"];

	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("SET NAMES 'UTF8'");
		
		$result = mysql_query("SELECT * FROM artical where articalID='$id'");
		$row = mysql_fetch_array($result);
		
		if($row) {
			$userid = $row["userid"];
			
			if($userid == $_SESSION["userid"]) {
				$sql = "UPDATE artical  SET
				title='$title', 
				part_content='$part_content',
				content='$content',
				artical_cls='$artical_cls',
				author='$username',
				userid='$userid',
				time='$time' 
				where articalID='$id'";
				mysql_query($sql, $dbc);
				
				$arr["status"] = "ok";
				$arr["data"] = "修改成功！";
				$arr["id"] = $id;
				setcookie("re", "1", time() + 36000, "/");
				echo json_encode($arr);
			} else {
				$arr["status"] = "err";
				$arr["data"] = "您没权限修改当前文章！";
				echo json_encode($arr);
			}
		} else {
			$arr["status"] = "err";
			$arr["data"] = "当前文章不存在！";
			echo json_encode($arr);
		}

		mysql_close($dbc);
	}
?>