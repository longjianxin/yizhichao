$(function(){
	if (myBrowser()==0) {
		layer.msg("为了你的更好体验，请更换最新的浏览器！！", {time: 0,shade:1});
		return false;
	};
	initPage();
	if(getCookie('data_num')){//初始化导航
		reflushNav(getCookie('data_num'));
	}else{
		reflushNav('0');
	}
	
	initPageCLeftPostion();
	/**方式一 modify:wm (需要修改样式)**/
	/*$(window).scroll(function(){
		initPageCLeftPostion();
	});

	function initPageCLeftPostion(){
		if ($(window).scrollTop()<76) {
			$(".left-layout").css({
				"top":76-$(this).scrollTop(),
				"height":$(".left-layout").height()+$(window).scrollTop()
			}); 
		}else{ 
			if ($(window).scrollTop()>76) { //$(".header").css({"position":"fixed","top":0,"left":0,"width":"100%","z-index":99});
				$(".left-layout").css({"top":0, "height":$(window).height()});  
				 
			}else{
				$(".left-layout").css({"top":76}); 
			}
		}
	}*/
 	/**方式二 modify:wm**/
	function initPageCLeftPostion(){
		if ($(".left-layout").height()<$(window).height()-50) {
			height=$(window).height()-50+$(window).scrollTop();
		}else{
			height=$(".left-layout").height()+$(window).scrollTop();
		}
		$(".left-layout").css({ 
			"height":height
		});  
	}

	$(window).resize(function(){
		initPageCLeftPostion();
	});
	$(".left-layout").mCustomScrollbar({
		autoHideScrollbar:true,
		theme:"minimal-dark",
		callbacks:{
		    onInit: function(){
		    	 
		    }
		}
	});
	
	var tophtml="<div id=\"izl_rmenu\" class=\"izl-rmenu\"><a href=\"tencent://Message/?Uin=361145187&websiteName=yizhichao.club=&Menu=yes\" class=\"btn btn-qq\"></a><div class=\"btn btn-wx\"><img class=\"pic\" src=\""+static_base_url+"static/image/lib/weixin.jpg\" onclick=\"window.location.href=\'http://www.yizhichao.club\'\"/></div><div class=\"btn btn-phone\"><div class=\"phone\">13430332489</div></div><div class=\"btn btn-top\"></div></div>";
	$("#top").html(tophtml);
	$("#izl_rmenu").each(function(){
		$(this).find(".btn-wx").mouseenter(function(){
			$(this).find(".pic").fadeIn("fast");
		});
		$(this).find(".btn-wx").mouseleave(function(){
			$(this).find(".pic").fadeOut("fast");
		});
		$(this).find(".btn-phone").mouseenter(function(){
			$(this).find(".phone").fadeIn("fast");
		});
		$(this).find(".btn-phone").mouseleave(function(){
			$(this).find(".phone").fadeOut("fast");
		});
		$(this).find(".btn-top").click(function(){
			$("html, body").animate({
				"scroll-top":0
			},"fast");
		});
	});
	var lastRmenuStatus=false;
	$(window).scroll(function(){
		var _top=$(window).scrollTop();
		if(_top>200){
			$("#izl_rmenu").data("expanded",true);
		}else{
			$("#izl_rmenu").data("expanded",false);
		}
		if($("#izl_rmenu").data("expanded")!=lastRmenuStatus){
			lastRmenuStatus=$("#izl_rmenu").data("expanded");
			if(lastRmenuStatus){
				$("#izl_rmenu .btn-top").slideDown();
			}else{
				$("#izl_rmenu .btn-top").slideUp();
			}
		}
	});

	var clipboard = new Clipboard('.btn-copy');
	clipboard.on('success', function(e){		    
	    e.clearSelection();
	    layer.msg("复制成功", {time:1000});
	});
	clipboard.on('error', function(e){
		layer.msg("复制失败", {time:1000});
	});
	
	$(".menu_title").click(function(){//左侧一级菜单
		if($(this).siblings('.menu_item').length == 0){
			reflushNav($(this).attr('data-num'));
			$(".menu_box .menu_item").removeClass('selected');
			$(".menu_box .menu_title[data-num="+$(this).attr('data-num')+"]").addClass('selected');
			clickMenu($(this).attr('data-val'), $(this).attr('data-num'));
		}
	});
	$(".menu_item").click(function(){//左侧二级菜单
		reflushNav($(this).attr('data-num'));
		$(".menu_box,.menu_title,.menu_item").removeClass('selected');		
		$(".menu_box .menu_item[data-num="+$(this).attr('data-num')+"]").addClass('selected');
		clickMenu($(this).attr('data-val'), $(this).attr('data-num'));
	});
	
	function reflushNav(nav_id){//异步更新导航
		console.log(nav_id);
		var a = nav_id.split('-');
		
		$("ul.navbar-nav li").removeClass('active');//顶部
		$("ul.navbar-nav li#navbar-nav-"+a[0]).addClass('active');
		
		$(".menuBar").hide();//左侧
		$("#menuBar_"+a[0]).show();		
	}
	
    $("body").on("click", "ul.pagination > li", function(){//翻页
		var page = parseInt($(this).find("a").attr('data-ci-pagination-page'));
		if(! isNaN(page) && require_page_url){
			var data = {};
			var select_data;
			if(select_data = getCookie('select_data')){
				data.select = JSON.parse(select_data);
			}
			data.cur_page =  page;
			clickPage(require_page_url, data);
		}
	});
	function myBrowser(){  
		// console.log(navigator.userAgent);
	    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
	    var isOpera = userAgent.indexOf("Opera") > -1; //判断是否Opera浏览器
	    var isIE = ((userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1) || userAgent.indexOf('rv') > -1) && !isOpera; //判断是否IE浏览器
	    var isFF = userAgent.indexOf("Firefox") > -1; //判断是否Firefox浏览器
	    var isSafari = userAgent.indexOf("Safari") > -1; //判断是否Safari浏览器
	    var isChrome = userAgent.indexOf("Chrome") > -1; //判断是否Chrome浏览器

	    if (isIE) {
	        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
	        reIE.test(userAgent);
	        var fIEVersion = parseInt(RegExp["$1"]);

	        return (fIEVersion < 9) ? 0 : 1 ; 
	    } 

	    if(/AppleWebKit.*Mobile/i.test(userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(userAgent))){  
		    if(window.location.href.indexOf("?mobile")<0){
				try{
					if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(userAgent)){
						return 1;
					}else if(/iPad/i.test(userAgent)){
		              	return 0;
					}else{
						return 0;
					}
				}catch(e){}
			}
		}

	    return (isFF||isOpera||isChrome)? 1 : 0;
	}
});