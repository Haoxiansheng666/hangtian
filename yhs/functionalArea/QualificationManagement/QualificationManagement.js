var app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    page: 1,
    SelectNavID: 0,
    nvaList: [],
    dataLs: [],
  },
  // 获取内容
  getDataLs() {
    app
      .wxRequest("api/company/naturals", {
        openid: wx.getStorageSync("y_openid"),
        token: wx.getStorageSync("y_token"),
        cate_id: this.data.nvaList[this.data.SelectNavID].id,
        page: this.data.page,
        pageSize: 20,
      })
      .then((res) => {
        let md = this.data.dataLs.concat(res.data.list)
        this.setData({
          dataLs: md
        })
      });
  },
  clearData() {
    this.data.page = 1
    this.data.dataLs = []
  },
  // 获取头部列表导航
  getNavLs() {
    app
      .wxRequest("api/company/cert_cate", {
        type: 1,
      })
      .then((res) => {
        this.setData({
          nvaList: res.data,
        });
        this.getDataLs();
      });
  },
  CPD: function (e) {
    wx.navigateTo({
      url: "/functionalArea/QualificationManagementDetails/QualificationManagementDetails?id=" + e.currentTarget.dataset.id,
    });
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id,
    });
    this.clearData()
    this.getDataLs()
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) { },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.getNavLs();
    wx.setNavigationBarTitle({
      title: "资质管理",
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
  onPullDownRefresh: function () {
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    this.data.page++
    this.getDataLs()
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () { },
});
