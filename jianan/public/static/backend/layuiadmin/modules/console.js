/**

 @Name：layuiAdmin 主页控制台
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：GPL-2
    
 */


layui.define(function(exports){
  
  /*
    下面通过 layui.use 分段加载不同的模块，实现不同区域的同时渲染，从而保证视图的快速呈现
  */
  
  
  //区块轮播切换
  layui.use(['admin', 'carousel'], function(){
    var $ = layui.$
    ,admin = layui.admin
    ,carousel = layui.carousel
    ,element = layui.element
    ,device = layui.device();

    //轮播切换
    $('.layadmin-carousel').each(function(){
      var othis = $(this);
      carousel.render({
        elem: this
        ,width: '100%'
        ,arrow: 'none'
        ,interval: othis.data('interval')
        ,autoplay: othis.data('autoplay') === true
        ,trigger: (device.ios || device.android) ? 'click' : 'hover'
        ,anim: othis.data('anim')
      });
    });
    element.render('progress');
  });


  //最新订单
  layui.use('table', function(){
    var $ = layui.$
    ,table = layui.table;
    
    //今日热搜
    table.render({
      elem: '#LAY-index-topSearch'
      ,url: "/backend/task/getMyData" //数据接口
     // ,page: true
      ,cols: [[
         {field: 'id',title: '编号', width: 80, sort: true}
        ,{field: 'title', title: '标题',  sort: false}
        ,{field: 'content', title: '内容',  sort: false}
        ,{field: 'action_time_text', title: '开始时间', sort: false}
        ,{field: 'end_time_text', title: '结束时间', sort: false}
        ,{field: 'add_time', title: '创建时间', sort: false}
      ]]
      ,skin: 'line'
    });

    //公告通知
    table.render({
      elem: '#LAY-index-notice'
      ,url: "/backend/notice/getData" //数据接口
     // ,page: true
      ,cols: [[
         {field: 'id',title: '编号', width: 80, sort: true}
        ,{field: 'title', title: '标题',  sort: false}
        ,{field: 'add_time', title: '创建时间', sort: false}
      ]]
      ,skin: 'line'
    });

    //触发行单击事件
    table.on('row(task)', function(obj){
      // console.log(obj.tr) //得到当前行元素对象
      // console.log(obj.data) //得到当前行数据
      layer.msg(obj.data.content,{
        title:obj.data.title,
        time:0,
        closeBtn:2,
        area: ['60%', '90%'],
        maxmin: true,
        resize:true
      })
    });

    table.on('row(notice)', function(obj){
      // console.log(obj.tr) //得到当前行元素对象
      // console.log(obj.data) //得到当前行数据
      layer.msg(obj.data.content,{
        title:obj.data.title,
        time:0,
        closeBtn:2,
        area: ['60%', '90%'],
        maxmin: true,
        resize:true
      })
    });
    
    
  });
  
  exports('console', {})
});