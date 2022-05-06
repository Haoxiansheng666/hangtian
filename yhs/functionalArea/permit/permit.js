// functionalArea/permit/permit.js
var app = getApp()
Page({
  /**
   * 页面的初始数据
   */
  data: {
    datals:'',
    dataList: [
      {
        title: "企业名称",
        ds: "河南省郑州市君和数字创意",
      },
      {
        title: "证书编号",
        ds: "542546864544",
      },
      {
        title: "发证时间",
        ds: "2021-12-16",
      },
      {
        title: "到期时间",
        ds: "2021-12-16",
      },
      {
        title: "发证机构",
        ds: "河南省郑州市建筑机构",
      },
    ],
  },
  permitLs() {
    app
      .wxRequest("api/company/permit", {
        openid: wx.getStorageSync("y_openid"),
        token: wx.getStorageSync("y_token"),
      })
      .then((res) => {
        this.setData({
          datals: res.data
        })
      });
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {},

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    this.permitLs();
    wx.setNavigationBarTitle({
      title: "安全许可证信息",
    });
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {},

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {},

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {},

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {},

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {},

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {},
});
