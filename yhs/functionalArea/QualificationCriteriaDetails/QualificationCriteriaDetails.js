// functionalArea/QualificationCriteriaDetails/QualificationCriteriaDetails.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    SelectNavID: 0,
    nvaList: [],
    Datals: '',
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id,
    });
    this.getDetail(this.data.nvaList[this.data.SelectNavID].id)
  },
  // 获取导航
  getNavLs(id) {
    app.wxRequest("api/company/natural", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      cate_id: id
    }).then(res => {
      this.setData({
        nvaList: res.data.list
      })
      this.getDetail(this.data.nvaList[this.data.SelectNavID].id)
    })
  },
  // 获取详情
  getDetail(id) {
    app.wxRequest("api/company/naturalDetail", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      id: id
    }).then(res => {
      this.setData({
        Datals: res.data
      })
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getNavLs(options.id)
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    wx.setNavigationBarTitle({
      title: "资质标准详情",
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