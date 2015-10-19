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
	
	//$arr = array();

	$data = html_encode($_POST);
	$gender = isset($data["gender"]) ?  $data["gender"] : "";
	$birthday = isset($data["birthday"]) ?  $data["birthday"] : "";
	$province = isset($data["province"]) ?  $data["province"] : "";
	$company = isset($data["company"]) ?  $data["company"] : "";
	$QQ = isset($data["QQ"]) ?  $data["QQ"] : "";
	$hobbies = isset($data["hobbies"]) ?  $data["hobbies"] : "";
	$personalwebsite = isset($data["website"]) ?  $data["website"] : "";
	$movie = isset($data["movie"]) ?  $data["movie"] : "";
	$book = isset($data["book"]) ?  $data["book"] : "";
	$food = isset($data["food"]) ?  $data["food"] : "";
	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	mysql_query("SET NAMES 'UTF8'");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("ALTER TABLE user ");
		$sql = "UPDATE user SET 
		gender='$gender', 
		birthday='$birthday', 
		province = '$province',
		company='$company',
		QQ = '$QQ', 
		hobbies='$hobbies', 
		movie = '$movie', 
		book='$book', 
		food = '$food', 
		personalwebsite='$personalwebsite' 
		where userID=".$_SESSION["userid"];

		if(mysql_query($sql, $dbc)) {
			send_data("ok", "保存成功");
		} else {
			send_data("err", "参数错误");
		}
		
		mysql_close($dbc);
	}
?>