<?php
	session_start();
	
	header("Content-type: text/html; charset=utf-8");
	
	function send_data($status, $data) {
		$arr = array();
		$arr["status"] = $status;
		$arr["data"] = $data;
		echo json_encode($arr);
	}
	
	$data = $_GET;
	
	$arr = array();
	
	$id = $data["id"];
	
	if(empty($id)) {
		send_data("err", "缺少文章id！");
		exit;
	}

	$username = $_SESSION["username"];
	$userid = $_SESSION["userid"];

	
	$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
	
	if($dbc) {
		mysql_select_db("songgenlei_blog", $dbc);
		mysql_query("SET NAMES 'UTF8'");
		
		$result = mysql_query("SELECT * FROM artical where articalID='$id'");
		$row = mysql_fetch_array($result);
        if($row) {
            $arr["status"] = "ok";
            $arr["data"] = array(
                'articalid'=> $row['articalID'],
                'title'=> $row['title'],
                'part_content'=> $row['part_content'],
                'content'=> $row['content'],
                'artical_cls'=> $row['artical_cls'],
                'author'=> $row['author'],
                'userid'=> $row['userid'],
                'comment_num'=> $row['comment_num'],
                'comment_num'=> $row['comment_num']
            );
            echo json_encode($arr);
        } else {
            $arr["status"] = "ok";
            $arr["data"] = "文章不存在！";
            echo json_encode($arr);
        }
		
		mysql_close($dbc);
	}
?>