// functionalArea/corporatePerformanceDetails/corporatePerformanceDetails.js
var app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    Details:null,
    dataList: [
      {
        title: "工程类别",
        ds: "类别名称",
      },
      {
        title: "工程承包方式",
        ds: "承包方式",
      },
      {
        title: "工程规模",
        ds: "规模大小",
      },
      {
        title: "开工时间",
        ds: "2021-12-18",
      },
      {
        title: "竣工时间",
        ds: "2021-12-31",
      },
      {
        title: "其他说明",
        ds: "其他说明",
      },
      {
        title: "合同金额",
        ds: "100000万元",
      },
    ],
  },
  getDetail(id) {
    app.wxRequest("api/company/performDetail", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      id: id
    }).then(res => {
      this.setData({
        Details: res.data
      })
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getDetail(options.id)
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    wx.setNavigationBarTitle({
      title: "公司业绩详情",
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
  onReachBottom: function () { },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () { },
});
