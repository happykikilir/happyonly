window.onload = function(){
	var $userPic = $("#userPic");
	var $userImg = $userPic.find("img").eq(0);
	var $choosePic = $("<div class='choosepic'></div>");
	var $pic = [
		"21","22","23","24","25","26",
		"31","32","33","34","35","36"
	]
	for(var i = 0 ; i<$pic.length ; i++){(function(i){
			$img = $("<img/>");
			$img.attr("src","images/userpic/"+$pic[i]+".jpg");
			$img.on("click",function(e){
				e.stopPropagation();
				$userImg.attr("src",$(this).attr("src")).show(1300)
			})
			$img.appendTo($choosePic);
		}(i))
	}
	$userPic.click(function(e){
		e.stopPropagation();
		$userPic.append($choosePic);
		$choosePic.slideDown("slow").css({"left":"206px","top":"20px"});
	})
	$("body").on("click",function(){
		$choosePic.slideUp("slow").detach();
	})
	
}