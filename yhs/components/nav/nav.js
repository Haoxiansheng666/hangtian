// components/nav/nav.js
Component({
    /**
     * 组件的属性列表
     */
    properties: {

    },

    /**
     * 组件的初始数据
     */
    data: {
        SelectNavID: 0,
        nvaList: [
            {
                id: 0,
                title: "一个月"
            },
            {
                id: 1,
                title: "两个月"
            },
            {
                id: 2,
                title: "三个月"
            }
        ]
    },

    /**
     * 组件的方法列表
     */
    methods: {
        SelectNav: function (e) {
            var that = this;
            that.setData({
                SelectNavID: e.currentTarget.dataset.id
            })
        }
    }
})