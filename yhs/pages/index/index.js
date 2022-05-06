// pages/my/my.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    SelectNavID: 1,
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
    ],
    indexList: [],
    page: 1,
    navType: 1,
    popupShow: false,
    dataList: [
      {
        id: 0,
        name: "张三",
        type: "二级建造师",
        endTime: "2021-12-21"
      },
      {
        id: 1,
        name: "张三",
        type: "一级建造师",
        endTime: "2021-12-21"
      },
      {
        id: 2,
        name: "张三",
        type: "二级建造师",
        endTime: "2021-12-21"
      },
      {
        id: 3,
        name: "张三",
        type: "一级建造师",
        endTime: "2021-12-21"
      }
    ],
    popupIndex: 1,
  },
  tanc() {
    app.wxRequest("api/index/cert_end", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token')
    }).then(res => {
      if (res.data.type !== (1 || 2 || 3)) return;
      this.setData({
        popupIndex: res.data.type,
        popupShow: true
      })
    })
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id
    })
    this.setData({
      indexList: []
    })
    that.getIndex()
  },
  close: function () {
    this.setData({
      popupShow: false
    })
  },
  lookDetails() {
    wx.navigateTo({
      url: "/functionalArea/expire/expire",
    })
  },
  certificateDetails: function (e) {
    wx.navigateTo({
      url: '/homePage/certificate/certificate?id=' + e.currentTarget.dataset.id,
    })
  },
  getIndex() {
    app.wxRequest("api/index/index", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      type: this.data.SelectNavID,
      page: this.data.page,
      pageSize: 20
    }).then(res => {
      this.setData({
        indexList: res.data.list
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
    this.tanc()
    wx.setNavigationBarTitle({
      title: '谊和顺LOGO',
    })
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    if (wx.getStorageSync('y_token')) {
      this.setData({
        indexList: []
      })
      this.getIndex()
    }
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