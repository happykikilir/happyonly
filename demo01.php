<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="charset=utf-8" />
<title>HappyOnly</title>
<link  rel="stylesheet" type="text/css" href="css/base.css" />
<link  rel="stylesheet" type="text/css" href="css/demo.css" />
<script type="text/javascript" src="js/jQuery_v1.11.js" ></script>
</head>
<body>
<div class="demobox" id="demomsg">
	<a href="#" class="close">关闭</a>
	<div class="bigimg">
		<div class="hand" id="hand"></div>
		<ul id = "bigLi">
			<li><img src="images/demo/n1.jpg"/></li>
			<li><img src="images/demo/n2.jpg"/></li>
			<li><img src="images/demo/n3.jpg"/></li>
			<li><img src="images/demo/n4.jpg"/></li>
			<li><img src="images/demo/n5.jpg"/></li>
		<ul>
	</div>
	<div class="miniimg">
		<ul id="miniLi">
			<li><img src="images/demo/s1.jpg"/></li>
			<li><img src="images/demo/s2.jpg"/></li>
			<li><img src="images/demo/s3.jpg"/></li>
			<li><img src="images/demo/s4.jpg"/></li>
			<li><img src="images/demo/s5.jpg"/></li>
		</ul>
	</div>
	<div class="tobig" id="toBig">
		<img src="images/demo/b1.jpg"/>
	</div>
</div>
<script type="text/javascript">
	var $box = $("#demomsg"), 
		$bigli = $("#bigLi li"),
		$minili = $("#miniLi li"),
		$tobig = $("#toBig"),
		$hand = $("#hand"),
		index = 0;
	$bigli.eq(0).show();
	$minili.click(function(){
		index = $(this).index() ;				
		$bigli.eq(index).show().siblings().hide();
		$tobig.find("img").attr("src","images/demo/b"+(index+1)+".jpg")
	})
	$bigli.mouseover(function(){
			$tobig.show();
			$hand.show()
	})
	$hand.mouseover(function(e){
		$tobig.show();
		$hand.show();
		
		e.stopPropagation();
	})
	$bigli.mouseout(function(){
		$tobig.hide();
		$hand.hide()
	})
	$bigli.mousemove(function(e){
		var  x= e.clientX - $box.position().left - $bigli.position().left - $hand.width()/2;
		var  y= e.clientY - $box.position().top - $bigli.position().top - $hand.height()/2;
		if(x < 0 ){
			x = 0;
		}else if(x > $bigli.width() - $hand.width()){
			x = $bigli.width() - $hand.width()
		}
		if(y < 0){
			y = 0;
		}else if(y >$bigli.height() - $hand.height()){
			y = $bigli.height() - $hand.height()	
		}		
		console.log(x,y)
		$hand.css({
			"top": y + "px",
			"left" : x + "px"		
		})

		var percentX = x/($bigli.width() - $hand.width());
		var percentY = y/($bigli.height() - $hand.height());
		var $bigImg = $tobig.find("img")
		$bigImg.css({
			"top": -percentX*($bigImg.width()) + "px",
			"left" : -percentY*($bigImg.height())  + "px"		
		})
	})
</script>
</body>
</html>
