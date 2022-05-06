define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'company/index' + location.search,
                    add_url: 'company/add',
                    edit_url: 'company/edit',
                    // del_url: 'company/del',
                    multi_url: 'company/multi',
                    import_url: 'company/import',
                    table: 'company',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        // {field: 'user_id', title: __('User_id'),operate: false},
                        {field: 'user.username', title: __('User.username'), operate: 'LIKE'},
                        {field: 'company', title: __('Company'), operate: 'LIKE'},
                        {field: 'logo', title: __('Logo'), operate: false},
                        {field: 'cert_type', title: __('Cert_type'), operate: false},
                        {field: 'code', title: __('Code'), operate: false},
                        {field: 'address', title: __('Address'), operate: 'LIKE'},
                        // {field: 'house', title: __('House'), operate: false},
                        {field: 'contact', title: __('Contact'), operate: 'LIKE'},
                        {field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
                        {field: 'ident', title: __('Ident'), operate: 'LIKE'},
                        // {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2'),"3":__('Type 3')}, formatter: Table.api.formatter.normal},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'open', title: __('Open'), searchList: {"0":__('Open 0'),"1":__('Open 1')}, formatter: Table.api.formatter.normal},
                        // {field: 'user.username', title: __('User.username'), operate: 'LIKE'},
                        // {field: 'user.mobile', title: __('User.mobile'), operate: 'LIKE'},
                        //{field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                        {field: 'operate', title: '操作', table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'base',
                                    text: __('基本信息'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'company/base'
                                },
                                {
                                    name: 'status',
                                    text: __('审核通过'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-xs btn-success btn-magic btn-ajax',
                                    url: 'company/agree/status/1',
                                    confirm: "确认审核通过吗？",
                                    success: function () {
                                        table.bootstrapTable('refresh');
                                    },
                                    disable: function (row) {
                                        //已付款
                                        if (row.status == 0) {
                                            return false;
                                        }
                                        return true;
                                    },
                                },
                                {
                                    name: 'status',
                                    text: __('审核拒绝'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-xs btn-success btn-magic btn-ajax',
                                    url: 'company/agree/status/2',
                                    confirm: "确认审核拒绝吗？",
                                    success: function () {
                                        table.bootstrapTable('refresh');
                                    },
                                    disable: function (row) {
                                        //已付款
                                        if (row.status == 0) {
                                            return false;
                                        }
                                        return true;
                                    },
                                },
                                {
                                    name: 'outlet',
                                    text: __('排口信息'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'outlet/index'
                                },
                                {
                                    name: 'record',
                                    text: __('评分记录'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'record/index'
                                },
                                {
                                    name: 'noice',
                                    text: __('噪音检测'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'noice/record/index'
                                },
                                {
                                    name: 'repair',
                                    text: __('维护/清洗记录'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'repair_record/index'
                                },
                                {
                                    name: 'complaint',
                                    text: __('投诉记录'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'complaint/index'
                                },
                                {
                                    name: 'records',
                                    text: __('问题整改'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'record/index/type/1'
                                },
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
