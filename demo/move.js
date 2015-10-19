
function getByClass(sClassName,oPar){
	var oParent=oPar||document;
	var aEle=oParent.getElementsByTagName("*");
	var aResult=[];
	var reg=new RegExp("\\b"+sClassName+"\\b","i");
	for(var i=0;i<aEle.length;i++){
		if(reg.test(aEle[i].className)){
		aResult.push(aEle[i]);
		}
	}
	return aResult;
}
//函数取元素样式，并设置
function getStyle(obj,attr,value){
	if(arguments.length==2){
		if(obj.currentStyle){
			return obj.currentStyle[attr];
		}else{
			return getComputedStyle(obj,false)[attr];
		}
	}else if(arguments.length==3){
		obj.style[attr]=value;
	}
}
//运动框架
function startMove(obj,json,fn){
	obj && clearInterval(obj.timer);
	obj.timer=setInterval(function(){
		var bStop=true;//假设一次运动一达到目标值
		for (var attr in json){
			//取当前值
			var iCur=0;
			if(attr=="opacity"){
				iCur=parseInt(parseFloat(getStyle(obj,attr))*100);
			}else{
			iCur=parseInt(getStyle(obj,attr));
			}
			//计算速度
			var iSpeed=(json[attr]-iCur)/10;
			iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
			//检测停止
			if(iCur!=json[attr]){
				bStop=false;
			}
			if(attr=="opacity"){
			obj.style.filter="alpha(opacity:"+iCur+iSpeed+")";
			obj.style.opacity=(iCur+iSpeed)/100;
			}
			else{
			obj.style[attr]=iCur+iSpeed+"px";
			}
		}
		if(bStop){
			clearInterval(obj.timer);
			if(fn){
				fn();
			}
		}
	},30)
}


//老版
/*function getStyle(obj, name)
{
	if(obj.currentStyle)
	{
		return obj.currentStyle[name];
	}
	else
	{
		return getComputedStyle(obj, false)[name];
	}
}

function startMove(obj, attr, iTarget)
{
	clearInterval(obj.timer);
	obj.timer=setInterval(function (){
		var cur=0;
		
		if(attr=='opacity')
		{
			cur=Math.round(parseFloat(getStyle(obj, attr))*100);
		}
		else
		{
			cur=parseInt(getStyle(obj, attr));
		}
		
		var speed=(iTarget-cur)/6;
		speed=speed>0?Math.ceil(speed):Math.floor(speed);
		
		if(cur==iTarget)
		{
			clearInterval(obj.timer);
		}
		else
		{
			if(attr=='opacity')
			{
				obj.style.filter='alpha(opacity:'+(cur+speed)+')';
				obj.style.opacity=(cur+speed)/100;
				
				document.getElementById('txt1').value=obj.style.opacity;
			}
			else
			{
				obj.style[attr]=cur+speed+'px';
			}
		}
	}, 30);
}

*/