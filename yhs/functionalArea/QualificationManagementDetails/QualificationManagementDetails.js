var app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    DataLs:null,
    dataList: [
      {
        title: "资质名称",
        ds: "资质名称",
      },
      {
        title: "证书编号",
        ds: "5646213466",
      },
      {
        title: "发证时间",
        ds: "2021-12-18",
      },
      {
        title: "到期时间",
        ds: "2021-12-31",
      },
      {
        title: "发证机构",
        ds: "河南省郑州市",
      }
    ],
    SelectNavID: 0,
    nvaList: [
      {
        id: 0,
        title: "详情",
      },
      {
        id: 1,
        title: "标准",
      }
    ],
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id,
    });
  },
  // 获取详情内容
  getDetail(id) {
    app.wxRequest("api/company/certDetail", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      id: id
    }).then(res => {
      this.setData({
        DataLs: res.data
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
      title: "资质管理详情",
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