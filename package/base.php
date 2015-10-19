<?php
	class Mysql {
		//连接数据库
		public function connect_db() {
			$dbc = mysql_connect("localhost", "songgenlei_root", "19850903song");
			mysql_query("SET NAMES 'UTF8'");
			mysql_select_db("songgenlei_blog", $dbc);
			return $dbc;
		}
		//关闭数据库
		public function close_db($dbc) {
			mysql_close($dbc);
		}
		//创建数据库
		public function create_database($db) {
			$dbc = $this->connect_db();
			$sql = 'CREATE DATABASE '.$db;
			mysql_query($sql, $dbc);
			$this->close_db($dbc);
		}
		//在数据库中创建表
		public function create_form($fromname, $sql) {
			$dbc = $this->connect_db();
			mysql_query($sql);
			$this->close_db();
		}
		function __destruct() {
		}
	}
	$artical_cls_txt = array("100"=>"技术专业", "101"=>"随笔", "102"=>"面试总结", "103"=>"兴趣爱好", "104"=>"前端观察");
	function get_header() {
		require("templates/header.php");
	}
	function get_footer() {
		require("templates/footer.php");
	}
	function get_ge_part() {
		require("templates/ge_part.php");
	}
	function change_null($val) {
		if(isset($val)) {
			return $val;
		} else {
			return "";
		}
	}
	function html_decode($a) {
		if(is_array($a)) {
			$arr = array();
			foreach($a as $key=>$val) {
				$arr[$key] = htmlspecialchars_decode($val);
			}
			return $arr;
		}
	};
	function ch_page($total, $num, $page, $url) {
		$total_page = ceil($total/$num);
		if($total_page > 1) {
			if($page == 1) {
				echo "<span>首页</span>";
				echo "<span>上一页</span>";
			} else {
				echo '<a href="'.$url.'1">首页</a>';
				echo '<a href="'.$url.''.($page-1).'">上一页</a>';
			}
			if($total_page < 9) {
				for($i = 1; $i <= $total_page; $i++) {
					if($i == $page) {
						echo "<span>".$i."</span>";
					} else {
						echo '<a href="'.$url.''.$i.'">'.$i.'</a>';
					}
				}
			} else {
				if($page < 5) {
					for($i = 1; $i <= 6; $i++) {
						if($i == $page) {
							echo "<span>".$i."</span>";
						} else {
							echo '<a href="'.$url.''.$i.'">'.$i.'</a>';
						}
					}
					echo "<span>...</span>";
					echo '<a href="'.$url.''.$total_page.'">'.$total_page.'</a>';
				} else if($page > $total_page - 4) {
					echo '<a href="'.$url.'1">1</a>';
					echo "<span>...</span>";
					for($i = $total_page - 4; $i <= $total_page; $i++) {
						if($i == $page) {
							echo "<span>".$i."</span>";
						} else {
							echo '<a href="'.$url.''.$i.'">'.$i.'</a>';
						}
					}
				} else {
					echo '<a href="'.$url.'1">1</a>';
					echo "<span>...</span>";
					for($i = $page - 2; $i <= $page + 2; $i++) {
						if($i == $page) {
							echo "<span>".$i."</span>";
						} else {
							echo '<a href="'.$url.''.$i.'">'.$i.'</a>';
						}
					}
					echo "<span>...</span>";
					echo '<a href="'.$url.''.$total_page.'">'.$total_page.'</a>';
				}
			}
			if($total_page == $page) {
				echo "<span>下一页</span>";
				echo "<span>尾页</span>";
			} else {
				echo '<a href="'.$url.'1">下一页</a>';
				echo '<a href="'.$url.''.$total_page.'">尾页</a>';
			}
		}
	}
?>
