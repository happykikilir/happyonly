<?php
	session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	function send_data($status, $data) {
		$arr = array();
		$arr["status"] = $status;
		$arr["data"] = $data;
		echo json_encode($arr);
	}
	
	$username = $_POST["username"] ? $_POST["username"] : $_GET["username"];
	$password = $_POST["password"] ? $_POST["password"] : $_GET["password"];
    $time = date("Y-m-d H:i:sa");
	
	$emailReg = "^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$";
	
	if(empty($username)) {
		send_data("err", "缺少用户名！");
		return;
	}
	
	if(!eregi($emailReg, $username)) {
		send_data("err", "用户名格式不对！");
		return;
	}
	
	if(empty($password)) {
		send_data("err", "缺少密码！");
		return;
	}
	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("set names 'utf8'");
		
		$result = mysql_query("SELECT * FROM user where username='$username' and password='$password'");
		$row = mysql_fetch_array($result);
		if($row) {
			$userid = $row["userID"];
			$nickname = $row["nickname"];
		}
		if(isset($userid)) {
			$_SESSION["login_status"] = 1;
			$_SESSION["username"] = $username;
			$_SESSION["nickname"] = $nickname;
			$_SESSION["userid"] = $userid;
			$data = array(
				'username' => $username,
				'userid' => $userid
			);
            
            $sql = "UPDATE user SET login_time='$time' where username='$username'";
            mysql_query($sql);
            
			send_data("ok", $data);
		} else {
			send_data("err", "用户名或密码错误！");
		}
		mysql_close($dbc);
	}
?>