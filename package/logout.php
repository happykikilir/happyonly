<?php
	session_start();
	unset($_SESSION);
	$_SESSION = array();
	session_destroy();
	
	function send_data($status, $data) {
		$arr = array();
		$arr["status"] = $status;
		$arr["data"] = $data;
		echo json_encode($arr);
	}
	
	send_data("ok", "登出成功！");
?>