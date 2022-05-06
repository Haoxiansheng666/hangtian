define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: "record/index/id/" + Fast.api.query('ids') + "/type/" + Fast.api.query('type') + location.search,
                    add_url: 'record/add',
                    edit_url: 'record/edit',
                    // del_url: 'record/del',
                    multi_url: 'record/multi',
                    import_url: 'record/import',
                    table: 'record',
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
                        // {field: 'qrcode', title: __('Qrcode'), operate: false},
                        {field: 'company', title: __('Company'), operate: false},
                        {field: 'contact', title: __('Contact'), operate: false},
                        // {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"2":__('Status 2'),"3":__('Status 3')}, formatter: Table.api.formatter.status},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'company_id', title: __('被检测企业'),operate: false},
                        {field: 'score', title: __('Score'),operate: false},
                        {field: 'is_change', title: __('Is_change'), searchList: {"1":__('Is_change 1'),"2":__('Is_change 2')}, formatter: Table.api.formatter.normal},
                        {field: 'user.username', title: __('User.username'), operate: 'LIKE'},
                        {field: 'user.mobile', title: __('User.mobile'), operate: 'LIKE'},
                        {field: 'ident', title: __('身份证'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
