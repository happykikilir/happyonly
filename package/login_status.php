<?php
	session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	function send_data($status, $data) {
		$arr = array();
		$arr["status"] = $status;
		$arr["data"] = $data;
		echo json_encode($arr);
	}
	
	if(isset($_SESSION["login_status"]) && $_SESSION["login_status"] == 1) {
		$data = array(
			'username' => $_SESSION["username"],
			'nickname' => $_SESSION["nickname"],
			'userid' => $_SESSION["userid"]
		);
		send_data("ok", $data);
	} else {
		send_data("err", "用户当前没登录！");
	}
?>