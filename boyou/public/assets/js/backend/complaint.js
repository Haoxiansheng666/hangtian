define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'complaint/index/id/' + Fast.api.query('ids') + location.search,
                    add_url: 'complaint/add',
                    edit_url: 'complaint/edit',
                    // del_url: 'complaint/del',
                    multi_url: 'complaint/multi',
                    import_url: 'complaint/import',
                    table: 'complaint',
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
                        {field: 'company.company', title: __('Company_id'), operate: false},
                        {field: 'company.address', title: __('经营地址'), operate: false},
                        {field: 'tou_time', title: __('Tou_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'reason', title: __('Reason'), operate: false},
                        {field: 'user_id', title: __('User_id'),operate: false},
                        {field: 'remark', title: __('Remark'), operate: false},
                        {field: 'is_level', title: '是否降级', searchList: {"0":__('Is_level 0'),"1":__('Is_level 1')}, formatter: Table.api.formatter.normal},
                        {field: 'check_id', title: __('Check_id'),operate: false},
                        {field: 'check_time', title: __('Check_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'result', title: __('Result'), operate: false},
                        {field: 'gai_time', title: __('Gai_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'status', title: '投诉状态', searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2'),"3":__('Status 3'),"4":__('Status 4'),"5":__('Status 5')}, formatter: Table.api.formatter.status},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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
