define([], function () {
    if ($('.kdniao').length > 0) {

    $('.kdniao').each(function () {
        var code = $(this).data('code');

        $(this).addClass('btn btn-xs bg-success').append('<i class="fa fa-truck"></i>' + code);
    });

    $('.kdniao').click(function () {
        var company = $(this).data('company');
        var code = $(this).data('code');

        if (company && code) {
            Layer.open({
                type: 2,
                area: ['700px', '450px'],
                fixed: false, //不固定
                maxmin: true,
                content: '/addons/kdniao/index/query?company=' + company + '&code=' + code
            });
        }
    });
}
window.UEDITOR_HOME_URL = Config.__CDN__ + "/assets/addons/ueditor/";
require.config({
    paths: {
        'ueditor.config': '../addons/ueditor/ueditor.config',
        'ueditor': '../addons/ueditor/ueditor.all.min',
        'ueditor.zh': '../addons/ueditor/i18n/zh-cn/zh-cn',
        'zeroclipboard': '../addons/ueditor/third-party/zeroclipboard/ZeroClipboard.min',
    },
    shim: {
        'ueditor': {
            deps: ['zeroclipboard', 'ueditor.config'],
            exports: 'UE',
            init: function (ZeroClipboard) {
                //导出到全局变量，供ueditor使用
                window.ZeroClipboard = ZeroClipboard;
            },
        },
        'ueditor.zh': ['ueditor']
    }
});
require(['form', 'upload'], function (Form, Upload) {
    var _bindevent = Form.events.bindevent;
    Form.events.bindevent = function (form) {
        _bindevent.apply(this, [form]);
        try {
            //绑定editor事件
            require(['ueditor', 'ueditor.zh'], function (UE, undefined) {
                UE.list = [];
                window.UEDITOR_CONFIG['uploadService'] = function (context, editor) {
                    return {
                        Upload: () => { return Upload },
                        Fast: () => { return Fast },
                    }
                };
                $(Config.ueditor.classname || '.editor', form).each(function () {
                    var id = $(this).attr("id");
                    var name = $(this).attr("name");
                    $(this).removeClass('form-control');
                    UE.list[id] = UE.getEditor(id, {
                        allowDivTransToP: false, //阻止div自动转p标签
                        initialFrameWidth: '100%',
                        initialFrameHeight: 320,
                        autoFloatEnabled: false,
                        // autoHeightEnabled: true, //自动高度
                        zIndex: 90,
                        xssFilterRules: false,
                        outputXssFilter: false,
                        inputXssFilter: false,
                        catchRemoteImageEnable: true
                    });
                    UE.list[id].addListener("contentChange", function () {
                        $('#' + id).val(this.getContent());
                        $('textarea[name="' + name + '"]').val(this.getContent());
                    })
                });
            })
        } catch (e) {
            console.log('绑定editor事件', e)
        }
    }
});
});