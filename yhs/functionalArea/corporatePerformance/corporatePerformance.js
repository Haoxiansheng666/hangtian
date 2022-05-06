// functionalArea/corporatePerformance/corporatePerformance.js
var app = getApp()
Page({
  /**
   * 页面的初始数据
   */
  data: {
    page: 1,
    SelectNavID: 0,
    nvaList: [],
    Datals: [],
  },
  CPD: function (e) {
    wx.navigateTo({
      url: "/functionalArea/corporatePerformanceDetails/corporatePerformanceDetails?id=" + e.currentTarget.dataset.id,
    });
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id,
    });
    this.clearData()
    this.getDatals(this.data.nvaList[this.data.SelectNavID].id)
  },
  // 业绩
  getNavls() {
    app.wxRequest("api/company/perform_cate", {}).then(res => {
      this.setData({
        nvaList: res.data
      })
      this.getDatals(this.data.nvaList[this.data.SelectNavID].id)
    })
  },
  // 内容查询
  getDatals(id) {
    app.wxRequest("api/company/perform", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      cate_id: id,
      page: this.data.page,
      pageSize: 20
    }).then(res => {
      let md = this.data.Datals.concat(res.data.list)
      this.setData({
        Datals: md
      })
    })
  },
  // 清除
  clearData() {
    this.data.page = 1
    this.data.Datals = []
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) { },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.getNavls()
    wx.setNavigationBarTitle({
      title: "公司业绩",
    });
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () { },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () { },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () { },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () { },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    this.data.page++
    this.getDatals(this.data.nvaList[this.data.SelectNavID].id)
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () { },
});
