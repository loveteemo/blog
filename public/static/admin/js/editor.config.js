/**
 * Created by 隆航 on 2016/11/16 0016.
 * 此文件的作用是配置编辑器，在需要的地方引入编辑器的函数自动创建
 * <link rel="stylesheet" href="com_editor/css/wangEditor.min.css">
 * <script src="home_js/jquery-1.10.1.min.js"></script>
 * <script src="com_editor/js/wangEditor.min.js"></script>
 *
 * <script src="admin_js/editor.config.js"></script>
 * 注意：需要放在底部加载
 */

//百度API
wangEditor.config.mapAk = 'WGWtOnep8LLGfUAHRToRvPGrd9SQD1LY';
//菜单顶部吸附
wangEditor.config.menuFixed = false;
//上传路径
wangEditor.config.uploadImgUrl = '/Admin/Article/uploadimage';
//上传图片名称 用于FILE获取
wangEditor.config.uploadImgFileName = 'image';
//插入代码默认
wangEditor.config.codeDefaultLang = 'php';
//关闭打印log
wangEditor.config.printLog = false;
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
var editor = new wangEditor('editor');

editor.create();