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
	
	$data = html_encode($_GET);
	
	$username =$data["username"];
	$nickname =$data["nickname"];
	$password = $data["password"];
	$rpassword = $data["rpassword"];
	
	$arr = array ();
	$emailReg = "^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$";
	$passwordReg = "^[0-9a-z-]+$";
    $time = date("Y-m-d h:i:sa");
	
	if(empty($username)) {
		send_data("err", "用户名为空！");
		return;
	}
	
	if(!eregi($emailReg, $username)) {
		send_data("err", "用户名格式不对！");
		return;
	}
	
	if(empty($nickname)) {
		send_data("err", "昵称为空！");
		return;
	}
	
	if(empty($password)) {
		send_data("err", "密码为空！");
		return;
	}
	
	if(!eregi($passwordReg, $password)) {
		send_data("err", "密码格式不正确！");
		return;
	}
	
	if($password != $rpassword) {
		send_data("err", "两次输入的密码不一致！");
		return;
	}
	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc); 
		mysql_query("SET NAMES 'UTF8'");
		
		//创建user表
		$sql = "CREATE TABLE user (
			userID int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(userID),
			username varchar(60),
			nickname  varchar(60),
			password varchar(30),
			faceimg varchar(100),
			gender varchar(10),
			birthday varchar(60),
			province varchar(30),
			company varchar(120),
			department varchar(120),
			job varchar(120),
			jobtime varchar(120),
			university varchar(120),
			seniorschool varchar(120),
			juniorschool varchar(120),
			QQ varchar(120),
			hobbies varchar(120),
			movie varchar(120),
			book varchar(120),
			food varchar(120),
			mobile varchar(20),
			personalwebsite varchar(120),
			motto varchar(300),
            login_time DATETIME
		)TYPE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=4";
		mysql_query($sql,$dbc);
		
		//判断用户是否已经存在
		$isexit = 0;
		if($result = mysql_query("SELECT * FROM user where username='$username' OR nickname='$nickname'")) {
			while($row = mysql_fetch_array($result))
			{
				$isexit=1;
			}
			if($isexit == 1) {
				send_data("err", "用户名或昵称已存在！");
			} else {
				//添加用户
				$sql = "INSERT INTO user (
					`username`, 
					`nickname`, 
					`password`,
					`faceimg`,
                    `login_time`
				) VALUES (
					'".$username."', 
					'".$nickname."', 
					'".$password."',
					'http://happyonly.com.cn/images/112.jpg',
                    '".$time."',
				)";
				mysql_query($sql);
				$result = mysql_query("SELECT * FROM user where username='$username' and password='$password'");
				$row = mysql_fetch_array($result);
				if($row) {
					$userid = $row["userID"];
				}
				$_SESSION["login_status"] = 1;
				$_SESSION["username"] = $username;
				$_SESSION["nickname"] = $nickname;
				$_SESSION["userid"] = $userid;
				send_data("ok", array(
					'username' => $username,
					'userid' => $userid
				));
			}
		} else {
			send_data("err", "查询数据库错误！");
		}
		mysql_close($dbc);
	} else {
		send_data("err", "数据库连接错误！");
	}
?>