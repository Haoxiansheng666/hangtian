// functionalArea/company/company.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    myDetail: null,
    region: ['广东省', '广州市', '海珠区'],
  },
  getUuer() {
    app.wxRequest("api/company/index", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token')
    }).then(res => {
      this.setData({
        myDetail: res.data
      })
    })
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

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    this.getUuer()
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