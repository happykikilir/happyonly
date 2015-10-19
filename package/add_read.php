<?php
	session_start();
	
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
	if(!isset($_SESSION["login_status"])) {
		header("location: http://happyonly.com.cn");
	}
	
	header("Content-type: text/html; charset=utf-8");

	$data = html_encode($_POST);
	$read = isset($data["read"]) ? $data["read"] : "";
	$time = date("Y-m-d");
	
	if(empty($read)) {
		send_data("err", "请填写内容！");
		exit;
	}
	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("SET NAMES 'UTF8'");
		
		$sql = "CREATE TABLE bookread (
			readID int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(readID),
			userid varchar(10),
			rd varchar(300),
			time date
		)TYPE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		mysql_query($sql,$dbc);

		$sql = "INSERT INTO bookread (
			`userid`, 
			`rd`,
			`time`
		) VALUES (
			'".$_SESSION["userid"]."', 
			'".$read."',
			'".$time."'
		)";
		if(mysql_query($sql, $dbc)) {
			send_data("ok", "保存成功");
		} else {
			send_data("err", "参数错误");
		}
		
		mysql_close($dbc);
	}
?>