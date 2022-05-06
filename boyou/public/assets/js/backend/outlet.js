define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'outlet/index/id/' + Fast.api.query('ids') + location.search,
                    add_url: 'outlet/add',
                    edit_url: 'outlet/edit',
                    // del_url: 'outlet/del',
                    multi_url: 'outlet/multi',
                    import_url: 'outlet/import',
                    table: 'outlet',
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
                        // {field: 'detail_id', title: __('Detail_id')},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'is_open', title: __('Is_open'), searchList: {"1":__('Is_open 1'),"0":__('Is_open 0')}, formatter: Table.api.formatter.normal},
                        {field: 'install_time', title: __('Install_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'type', title: __('Type'), operate: 'LIKE'},
                        {field: 'model', title: __('Model'), operate: 'LIKE'},
                        {field: 'displace', title: __('Displace'), operate: 'LIKE'},
                        {field: 'width', title: __('Width'), operate: 'LIKE'},
                        {field: 'length', title: __('Length'), operate: 'LIKE'},
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
