// homePage/certificate/certificate.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    DetailsLs:null,
    dataList: [
      {
        title: "证书名称",
        ds: "二级建造师职业资格证书"
      },
      {
        title: "姓名",
        ds: "奥特曼"
      },
      {
        title: "证书编号",
        ds: "1245123123123"
      },
      {
        title: "专业",
        ds: "土木工程专业"
      },
      {
        title: "发证时间",
        ds: "2021-12-16"
      },
      {
        title: "到期时间",
        ds: "2021-12-16"
      },
      {
        title: "发证机构",
        ds: "河南省郑州市建筑机构"
      },
    ]
  },
  getDetails(id) {
    app.wxRequest("api/company/certDetail", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      id: id
    }).then(res => {
      this.setData({
        DetailsLs: res.data
      })
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getDetails(options.id)
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    wx.setNavigationBarTitle({
      title: "证书详情",
    });
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})