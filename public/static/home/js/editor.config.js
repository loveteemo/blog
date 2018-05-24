/**
 * Created by 隆航 on 2016/11/30 0030.
 */
//菜单顶部吸附
wangEditor.config.menuFixed = false;
//关闭打印log
wangEditor.config.printLog = false;
// 菜单
wangEditor.config.menus = [
    'emotion','link','unlink','fullscreen'
];
//表情
wangEditor.config.emotions = {
    'weibo': {
        title: '微博表情',
        data: '/static/editor/weiboemotions.data'
    },
    'qq':{
        title: 'QQ表情',
        data: '/static/editor/qqemotions.data'
    }
};
//wangEditor.config.emotionsShow = 'value';
var editor = new wangEditor('edit-content');

editor.create();
//初始化内容

//editor.$txt.html("<p>Ctrl + Enter 快速提交</p>");
