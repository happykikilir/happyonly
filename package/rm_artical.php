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
	
	$id = $_GET["id"];
	
	if(!empty($id)) {
		$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
        if($dbc) {
            mysql_select_db("songgenlei_blog", $dbc);
            mysql_query("SET NAMES 'UTF8'");
            
            $result = mysql_query("SELECT * FROM artical where articalID='$id'");
            $row = mysql_fetch_array($result);
            if($row) {
                if($row["userid"] == $_SESSION["userid"]) {
                    mysql_query("DELETE FROM artical where articalID='$id'");
                }
            }
        }
        mysql_close($dbc);
	}

    if(isset($_SERVER["HTTP_REFERER"])) {
		header("location: http://happyonly.com.cn/myindex.php");
	}
?>