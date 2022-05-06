// pages/my/my.js
var app = getApp()
Page({
  /**
   * 页面的初始数据
   */
  data: {
    myDetail:null,
    dataList: [
      {
        id: 0,
        url: "/static/image/4.png",
        name: "公司简介",
      },
      {
        id: 1,
        url: "/static/image/5.png",
        name: "公司业绩",
      },
      {
        id: 2,
        url: "/static/image/6.png",
        name: "资质标准",
      },
      {
        id: 3,
        url: "/static/image/7.png",
        name: "资质管理",
      },
      {
        id: 4,
        url: "/static/image/8.png",
        name: "证书管理",
      },
    ],
    btmDataList: [
      {
        id: 0,
        url: "/static/image/9.png",
        name: "安全生产许可证",
      },
      {
        id: 1,
        url: "/static/image/10.png",
        name: "电脑端地址",
      },
    ],
  },
  myDetails: function () {
    wx.navigateTo({
      url: "/functionalArea/myDetails/myDetails",
    });
  },
  functionalArea: function (e) {
    if (this.data.dataList[e.currentTarget.dataset.index].id == 0) this.jump("/functionalArea/company/company");
    if (this.data.dataList[e.currentTarget.dataset.index].id == 1) this.jump("/functionalArea/corporatePerformance/corporatePerformance");
    if (this.data.dataList[e.currentTarget.dataset.index].id == 2) this.jump("/functionalArea/QualificationCriteria/QualificationCriteria");
    if (this.data.dataList[e.currentTarget.dataset.index].id == 3) this.jump("/functionalArea/QualificationManagement/QualificationManagement");
    if (this.data.dataList[e.currentTarget.dataset.index].id == 4) this.jump("/functionalArea/certificategl/certificategl");
  },
  functionalBtom: function (e) {
    if (this.data.dataList[e.currentTarget.dataset.index].id == 0) this.jump("/functionalArea/permit/permit");
    if (this.data.dataList[e.currentTarget.dataset.index].id == 1) this.jump("/functionalArea/pcAddress/pcAddress?address=" + this.data.myDetail.url);
  },
  jump: function (val) {
    wx.navigateTo({
      url: val,
    });
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
    wx.setNavigationBarTitle({
      title: "个人中心",
    });
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () { this.getUuer() },

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
  onReachBottom: function () { },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () { },
});
