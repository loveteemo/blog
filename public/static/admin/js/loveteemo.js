$(document).ready(function(){

	// === 菜单选中 === //
	$('.submenu > a').click(function(e)
	{
		e.preventDefault();
		var submenu = $(this).siblings('ul');
		var li = $(this).parents('li');
		var submenus = $('#sidebar li.submenu ul');
		var submenus_parents = $('#sidebar li.submenu');
		if(li.hasClass('open'))
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenu.slideUp();
			} else {
				submenu.fadeOut(250);
			}
			li.removeClass('open');
		} else 
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenus.slideUp();			
				submenu.slideDown();
			} else {
				submenus.fadeOut(250);			
				submenu.fadeIn(250);
			}
			submenus_parents.removeClass('open');		
			li.addClass('open');	
		}
	});
	
	var ul = $('#sidebar > ul');
	
	$('#sidebar > a').click(function(e)
	{
		e.preventDefault();
		var sidebar = $('#sidebar');
		if(sidebar.hasClass('open'))
		{
			sidebar.removeClass('open');
			ul.slideUp(250);
		} else 
		{
			sidebar.addClass('open');
			ul.slideDown(250);
		}
	});
	
	// === 控制窗口 === //
	$(window).resize(function()
	{
		if($(window).width() > 479)
		{
			ul.css({'display':'block'});	
			$('#content-header .btn-group').css({width:'auto'});		
		}
		if($(window).width() < 479)
		{
			ul.css({'display':'none'});
			fix_position();
		}
		if($(window).width() > 768)
		{
			$('#user-nav > ul').css({width:'auto',margin:'0'});
            $('#content-header .btn-group').css({width:'auto'});
		}
	});
	if($(window).width() < 468)
	{
		ul.css({'display':'none'});
		fix_position();
	}
	if($(window).width() > 479)
	{
	   $('#content-header .btn-group').css({width:'auto'});
		ul.css({'display':'block'});
	}
	
	// === 小提示 === //
	$('.tip').tooltip();	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });	
	

	// === 头部定位 === //
	function fix_position()
	{
		var uwidth = $('#user-nav > ul').width();
		$('#user-nav > ul').css({width:uwidth,'margin-left':'-' + uwidth / 2 + 'px'});
        
        var cwidth = $('#content-header .btn-group').width();
        $('#content-header .btn-group').css({width:cwidth,'margin-left':'-' + uwidth / 2 + 'px'});
	}
	
	// === 菜单主题按钮 === //
	$('#style-switcher i').click(function()
	{
		if($(this).hasClass('open'))
		{
			$(this).parent().animate({marginRight:'-=190'});
			$(this).removeClass('open');
		} else 
		{
			$(this).parent().animate({marginRight:'+=190'});
			$(this).addClass('open');
		}
		$(this).toggleClass('icon-arrow-left');
		$(this).toggleClass('icon-arrow-right');
	});

	// === 切换颜色 === //
	$('#style-switcher a').click(function()
	{
		var style = $(this).attr('href').replace('#','');
		var url = $(this).parent('div').data('url');
		$('.skin-color').attr('href','../static/admin/css/loveteemo.'+style+'.css');
		$(this).siblings('a').css({'border-color':'transparent'});
		$(this).css({'border-color':'#aaaaaa'});
		$.get(url,{color:style});
	});

    // === 删除缓存 === //
	$('.cleancache').click(function(){
		var url = $(this).data('url');
		layer.open({
			type: 2,
			title: "清空缓存",
			shade: [0],
			area: ['500px', '400px'],
			shift: 2,
			content: url
		});
	});

	// === 退出 ===
	$('.logout').click(function(){
		var url = $(this).data('url');
		layer.confirm('确定要退出后台管理么？', {
			btn: ['确定','取消']
		}, function(){
			$.get(url,function (data) {
				location.reload();
			});
		});
	});

    // === 系统设置 === //
	$('.sysform').click(function(){
        $(this).attr('disabled', true);
        var _this = $(this);
        var url = $(this).data('url');
		layer.msg('后台数据处理中',{icon:16});
        $.ajax({
            data    : $(this).parents("form").serialize(),
            type    : "Post",
            dataType: "Json",
            url     : url,
            success :function (data) {
                if(data.err==0){
                    layer.msg(data.msg,{icon:1,time:500},function () {
                        location.reload();
                    });
                }else{
                    layer.msg(data.msg,{icon:2,time:500});
                    _this.removeAttr('disable');
                }
            },
            error   :function () {
				layer.msg('网络错误',{icon:2,time:500});
                _this.removeAttr('disable');
            }
        });
	});

	// === 改变显示状态 ===
	$('.changgeview').click(function () {
		$(this).attr('disabled', true);
        var _this = $(this);
		var url = $(this).data('url');
		var id = $(this).data('id');
		var view = $(this).data('view');
		var str = (view == 1)　? '不' : '';
		layer.confirm('确定要切换到' + str  +'显示状态么？', {
			btn: ['确定','取消']
		}, function(){
			layer.msg('后台数据处理中',{icon:16});
			$.ajax({
				data    : {"id":id,"view":view},
				type    : "Post",
				dataType: "Json",
				url     : url,
				success :function (data) {
					if(data.err==0){
						layer.msg(data.msg,{icon:1,time:500},function () {
							location.reload();
						});
					}else{
						layer.msg(data.msg,{icon:2,time:500});
                        _this.removeAttr('disable');
					}
				},
				error   :function () {
                    _this.removeAttr('disable');
				}
			});
		});
	});

    // === 设置管理员 ===
    $('.setadmin').click(function () {
    	$(this).attr('disabled', true);
    	var _this = $(this);
        var url = $(this).data('url');
        var id = $(this).data('id');
        var auth = $(this).data('auth');
        var str = (auth == 0)　? "确定要设置改用户为管理员么?" : '确定要取消改用户的管理员资格么?';
        layer.confirm(str, {
            btn: ['确定','取消']
        }, function(){
            layer.msg('后台数据处理中',{icon:16});
            $.ajax({
                data    : {"id":id,"auth":auth},
                type    : "Post",
                dataType: "Json",
                url     : url,
                success :function (data) {
                    if(data.err==0){
                        layer.msg(data.msg,{icon:1,time:500},function () {
                            location.reload();
                        });
                    }else{
                        layer.msg(data.msg,{icon:2,time:500});
                        _this.removeAttr('disable');
                    }
                },
                error   :function () {
                    _this.removeAttr('disable',false);
                }
            });
        },function(){
            _this.removeAttr("disabled");
		});
    });

	// === 排序 === //
	$('.sort').click(function(){
		var url = $(this).data('url');
		layer.msg('后台数据处理中',{icon:16});
		$.ajax({
			data    : $(this).parents("form").serialize(),
			type    : "Post",
			dataType: "Json",
			url     : url,
			success :function (data) {
				if(data.err==0){
					layer.msg(data.msg,{icon:1,time:500},function () {
						location.reload();
					});
				}else{
					layer.msg(data.msg,{icon:2,time:500});
				}
			},
			error   :function () {
				layer.msg('网络错误',{icon:2,time:500});
			}
		});
	});

	// === 修改 === //
	$('.edit').click(function(){
		var h = $(this).data('height');
		var w = $(this).data('width');
		if(!w){
			w = 500;
		}
		var url = $(this).data('url');
		layer.open({
			type: 2,
			title: "修改",
			shade: [0],
			area: [w+'px', h+'px'],
			shift: 2,
			scrollbar: false,
			content: url
		});
	});

	// === 添加 === //
	$('.add').click(function(){
		var h = $(this).data('height');
		var url = $(this).data('url');
		layer.open({
			type: 2,
			title: "添加",
			shade: [0],
			area: ['500px', h+'px'],
			shift: 2,
			scrollbar: false,
			content: url
		});
	});

	// === 修改 + 添加 保存 === //
	$('.editsave').click(function () {
		var url = $('form').attr('action');
		layer.msg('后台数据处理中',{icon:16});
		$.ajax({
			data    : $("form").serialize(),
			type    : "Post",
			dataType: "Json",
			url     : url,
			success :function (data) {
				if(data.err==0){
					layer.msg(data.msg,{icon:1,time:500},function () {
						layer.closeAll();
						parent.location.reload();
					});
				}else{
					layer.msg(data.msg,{icon:2,time:500});
				}
			},
			error   :function () {
				layer.msg('网络错误',{icon:2,time:500});
			}
		});
	});

	// === 删除 ===
	$('.delete').click(function () {
		$(this).attr('disabled', true);
        var _this = $(this);
        var url = $(this).data('url');
		var id = $(this).data('id');
		layer.confirm('确定要删除这条数据么？', {
			btn: ['确定','取消']
		}, function(){
			layer.msg('后台数据处理中',{icon:16});
			$.ajax({
				data    : {"id":id},
				type    : "Post",
				dataType: "Json",
				url     : url,
				success :function (data) {
					if(data.err==0){
						layer.msg(data.msg,{icon:1,time:500},function () {
							location.reload();
						});
					}else{
						layer.msg(data.msg,{icon:2,time:500});
                        _this.removeAttr('disable');
					}
				},
				error   :function () {
                    _this.removeAttr('disable');
				}
			});
		},function(){
            _this.removeAttr('disable');
        });
	});

	// === 转跳 === //
	$('.redirect').click(function () {
		var tourl = $(this).data('url');
		location.href = "" + tourl;
	});


});
