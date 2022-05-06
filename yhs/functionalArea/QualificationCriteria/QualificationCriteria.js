// functionalArea/QualificationCriteria/QualificationCriteria.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    SelectNavID: 0,
    nvaList: [],
  },
  CPD: function (e) {
    wx.navigateTo({
      url: "/functionalArea/QualificationCriteriaDetails/QualificationCriteriaDetails?id=" + e.currentTarget.dataset.id,
    });
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id,
    });
    console.log(this.data.SelectNavID)
  },
  // 获取导航
  getNavLs() {
    app.wxRequest("api/company/natural_cate", {})
      .then(res => {
        this.setData({
          nvaList: res.data
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
    this.getNavLs()
    wx.setNavigationBarTitle({
      title: "资质标准",
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