$(document).ready(function(){
var	$username = $("#username"),
		$register = $("#Register"),
		$login = $("#Login"),
		$quiet = $("<a  id='Quiet'>退出</a>"),
		$userloginbox = $("#userLoginBox");
		
	$.get( "http://happyonly.com.cn/package/login_status.php",function(result){
		if(result.status == "ok"){
			$username.html(result.data.nickname);
			$username.attr("href","usermsg.php?userid="+result.data.userid)
			$userloginbox.append($quiet);
			$register.remove();
			$login.remove();
		} 
	},"json")
	$quiet.click(function(){
		$.get("http://happyonly.com.cn/package/logout.php",function(){
			parent.location.reload();
		})
	})
	$login.bind("click",function(){
		openShow("login.php","600","300")
	})
	$register.bind("click",function(){ 
		openShow("register.php","600","380")
	})
})

function openShow(url,iwidth,iheight){
	var clientheight = document.documentElement.clientHeight ;
	var clientwidth = document.documentElement.clientWidth ;
	//var lockwidth =	getInner().width;
	//var lockheight =	getInner().height;
	var $odiv = $("<div class='logincontent' id='Loginbox'></div>");
	var $oiframe = $("<iframe width='100%' id='openIframe' height='100%' framespacing=0 frameborder=0  ></iframe>");
	var $lock = $("<div id='Lock'></div>");
	var itop = (clientheight- iheight)/2;
	var ileft= (clientwidth - iwidth)/2;
	$lock.css({"position":"absolute","top":"0px","left":"0px","zIndex":"999","opacity":"0.5","background":"#333"});
	$odiv.height(iheight).width(iwidth).css({"left":ileft +"px","top": itop +"px","zIndex":"1000"});
	$oiframe.attr("src",url);
	$openbox = $odiv.append($oiframe);
	$(document.body).append($openbox);
	$(document.body).append($lock);
}

function query(key, url) {
	var reg = new RegExp(key + "=([^=&#]+)"),
		  url = url || location.href;
	var data = url.match(reg);
	data = data ? data[1] : null;
	return data;
}
/*
function getInner(){
	if(typeof  window.innerWidth != 'undefined'){
		return{
			width : window.innerWidth,
			height : window.innerHeight
		}
	}else{
		return{
			width : document.documentElement.clientWidth,
			height : document.documentElement.clientHeight
		}
	}
}
*/
