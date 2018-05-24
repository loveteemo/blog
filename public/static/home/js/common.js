$(document).ready(function() {
	imgerror();
	menu();
	//小提示
	$('[data-toggle="tooltip"]').tooltip();
	//=== Blog 返回顶部动画 ===//
	$(window).scroll(function() {
		if ($(this).scrollTop() != 0) {
			$(".toTop").fadeIn();
		} else {
			$(".toTop").fadeOut();
		}
	});
	//=== Blog 返回顶部加载 ===//
	$(".toTop").click(function() {
		$("body,html").animate({scrollTop: 0}, 800)
	});
    //=== Blog 微信 ===//
    $("#weixin").click(function(){
        layer.open({
            type: 1,
            content: '<div class="weinxi-open"><img src="./static/home/img/icon/weixin.jpg"></div>',
            title: false
        });
    });

    // === Blog 点击下载 === //
    $(".inc-sum").click(function () {
        var url = $(this).data("url");
        var id = $(this).data("id");
        layer.msg('正在加载数据', {icon:16, shade: 0.1, time:0});
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
			data:{"id":id},
            success: function (data) {
                if(data.err==0){
                    layer.msg(data.msg,{icon:1});
                    if(data.path){
                        window.open(data.path);
                    }
                }else{
					layer.msg(data.msg,{icon:5});
                }
            },
            error:function () {
                layer.msg('网络错误',{icon:3});
            }
        });
    });

	//=== Blgog QQ登陆 ===//
	$(".qqlogin").click(function(){
		var url = $(this).data('url');
		// === 新增根据浏览器判断显示宽度 === //
		( $(window).width() < 400 )
		?
			location.href=url+'?form=m'
		:
			layer.open({
				type: 2,
				id: 'qqlogin',
				title: false,
				shadeClose: true,
				closeBtn: 0,
				shade: [0.1,'#fff'],
				area: ['500px','400px'],
				content: [url, 'no']
			})
		;
	});
    //=== Blog 更多 ===//
	$(document).on("click",".loadingmore",function(){
		var _this = $(this);
		var id = _this.data("id")?_this.data("id"):0;
		var lenth = _this.data("lenth");
		var url = _this.data("url");
		var key = _this.data("key");
		layer.msg('正在加载数据', {icon:16, shade: 0.1, time:0});
		$.ajax({
			type: 'post',
			url: url,
			dataType: 'json',
			data: {"id": id, "lenth": lenth,"key":key},
			success: function (data) {
				if(data.err==0){
					layer.msg(data.msg,{icon:1});
					$('.more').before(data.data);
					imgerror();
					_this.data('lenth',lenth+1);
				}else if(data.err==2){
                    layer.msg(data.msg,{icon:0});
                    $('.loadingmore').attr("disable",true).html(data.msg);
				}else{
					layer.msg(data.msg,{icon:2});
				}
			},
			error:function () {
				layer.msg('网络错误',{icon:3});
			}
		});
	});

	$('.tab-content a[href="#art"]').tab('show');
	$('.tab-content a[href="#content"]').tab('show');
	$('.tab-content a[href="#hot"]').tab('show');

    //=== 图片错误处理 ===//
    function imgerror() {
        $("img").one("error", function(e){
            $(this).attr("src", "/static/home/img/default.jpg");
        });
    }
    //=== 导航菜单鼠标移上选中效果 ===//
    function menu(){
		var $liCur = $(".menu ul li.menu-active"),
			curP = $liCur.position().left,
			curW = $liCur.outerWidth(true),
			$slider = $(".menu-bar"),
			$navBox = $(".menu");
			$targetEle = $(".menu ul li a");
			$slider.animate({
				"left":curP,
				"width":curW
			});
		$targetEle.mouseenter(function () {
			var $_parent = $(this).parent(),
				_width = $_parent.outerWidth(true),
				posL = $_parent.position().left;
			if($_parent.parent('ul').hasClass('dropdown-menu')){

			}else {
				$slider.stop(true, true).animate({
					"left": posL,
					"width": _width
				}, "fast");
			}
		});
		$navBox.mouseleave(function (cur, wid) {
			cur = curP;
			wid = curW;
			$slider.stop(true, true).animate({
				"left":cur,
				"width":wid
			}, "fast");
		});
	}

    console.log("%c Love Teemo %c Copyright \xa9 %s", 'font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size:64px;color:#00bbee;-webkit-text-fill-color:#00bbee;-webkit-text-stroke: 1px #00bbee;', "font-size:12px;color:#999999;", (new Date).getFullYear());

});
