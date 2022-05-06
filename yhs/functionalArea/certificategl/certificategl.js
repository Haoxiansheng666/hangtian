// functionalArea/certificategl/certificategl.js
var app = getApp();
Page({
  /**
   * 页面的初始数据
   */
  data: {
    dataLs: [],
    getID: null,
    page: 1,
    SelectNavID: 0,
    NavLs: null,
    typeID: 0,
  },
  // 获取内容
  getCentLs(id) {
    app
      .wxRequest("api/company/cert", {
        openid: wx.getStorageSync("y_openid"),
        token: wx.getStorageSync("y_token"),
        page: this.data.page,
        pageSize: 20,
        cate_id: id,
      })
      .then((res) => {
        let dm = this.data.dataLs.concat(res.data.list)
        this.setData({
          dataLs: dm
        });
      });
  },
  // 清除
  clearData() {
    this.data.page = 1;
    this.data.dataLs = []
  },
  // 获取导航
  getNavLs() {
    app
      .wxRequest("api/company/cert_cate", {
        type: 2,
      })
      .then((res) => {
        this.setData({
          NavLs: res.data,
        });
        this.clearData();
        this.getCentLs(this.data.NavLs[this.data.SelectNavID].id);
      });
  },
  SelectNav: function (e) {
    var that = this;
    that.setData({
      SelectNavID: e.currentTarget.dataset.id,
      getID: e.currentTarget.dataset.id,
      typeID: 0,
    });
    this.clearData();
    this.getCentLs(this.data.NavLs[this.data.SelectNavID].id);
  },
  SelectType: function (e) {
    var that = this;
    that.setData({
      typeID: e.currentTarget.dataset.id,
      getID: e.currentTarget.dataset.id,
    });
    this.clearData();
    this.getCentLs(
      this.data.NavLs[this.data.SelectNavID].child[this.data.typeID].id
    );
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getNavLs();
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    wx.setNavigationBarTitle({
      title: "证书管理",
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
    this.getCentLs(this.data.getID)
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () { },
});
