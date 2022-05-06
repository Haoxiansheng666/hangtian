// functionalArea/expire/expire.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    page: 1,
    SelectNavID: 1,
    dataLs: [],
    nvaList: [
      {
        id: 1,
        title: "一个月"
      },
      {
        id: 2,
        title: "两个月"
      },
      {
        id: 3,
        title: "三个月"
      }
    ]
  },
  clearData() {
    this.data.page = 1
    this.data.dataLs = []
  },
  getDatals() {
    app.wxRequest("api/index/cert", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      type: this.data.SelectNavID,
      page: this.data.page,
      pageSize: 20
    }).then(res => {
      let md = this.data.dataLs.concat(res.data.list)
      this.setData({
        dataLs: md
      })
    })
  },
  SelectNav: function (e) {
    this.clearData()
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id
    })
    this.getDatals()
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.getDatals()
    wx.setNavigationBarTitle({
      title: '即将到期',
    })
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
    this.data.page++
    this.getDatals()
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})