define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'third/index' + location.search,
                    add_url: 'third/add',
                    edit_url: 'third/edit',
                    // del_url: 'third/del',
                    multi_url: 'third/multi',
                    import_url: 'third/import',
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
                        // {field: 'user_id', title: __('User_id')},
                        {field: 'user.username', title: __('User_id'), operate: false},
                        {field: 'company', title: __('Company'), operate: 'LIKE'},
                        {field: 'logo', title: __('Logo'), operate: false},
                        // {field: 'cert_type', title: __('Cert_type'), operate: false},
                        {field: 'code', title: __('Code'), operate: 'LIKE'},
                        {field: 'address', title: __('Address'), operate: 'LIKE'},
                        // {field: 'house', title: __('House'), operate: false},
                        {field: 'contact', title: __('Contact'), operate: false},
                        {field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
                        {field: 'ident', title: __('Ident'), operate: 'LIKE'},
                        // {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2'),"3":__('Type 3')}, formatter: Table.api.formatter.normal},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'open', title: __('Open'), searchList: {"0":__('Open 0'),"1":__('Open 1')}, formatter: Table.api.formatter.normal},
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
                                    url: 'third/base'
                                },
                                {
                                    name: 'status',
                                    text: __('审核通过'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-xs btn-success btn-ajax',
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
                                    classname: 'btn btn-xs btn-success btn-ajax',
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
                                    name: 'repair',
                                    text: __('维护/清洗记录'),
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-info btn-xs btn-detail btn-dialog',
                                    url: 'repair_record/index'
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
