// functionalArea/myDetails/myDetails.js
var app = getApp()
Page({
  /**
   * 页面的初始数据
   */
  data: {
    array: ['男', '女'],
    index: 0,
    myDetail: null,
    myimg: "",
    limg: "",
    newName: "",
    newData: null,
  },
  // 更改头像
  ChangeImg() {
    var that = this;
    wx.chooseImage({
      count: 1,
      sizeType: ['original', 'compressed'],
      sourceType: ['album', 'camera'],
      success(res) {
        console.log(res.tempFilePaths[0])
        wx.uploadFile({
          url: 'https://yhs.junhebrand.cn/api/company/upload', //仅为示例，非真实的接口地址
          filePath: res.tempFilePaths[0],
          name: 'file',
          success(res) {
            that.setData({
              newData: JSON.parse(res.data).data,
              limg: JSON.parse(res.data).data.url,
              myimg: JSON.parse(res.data).data.fullurl
            })
          }
        })
      }
    })
  },
  // 修改手机号
  ChangePhone() {
    wx.navigateTo({
      url: '/pages/login/login?phone=' + this.data.myDetail.mobile,
    })
  },
  // 修改性别
  bindPickerChange(e) {
    this.setData({
      index: e.detail.value
    })
  },
  getUuer() {
    app.wxRequest("api/company/index", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token')
    }).then(res => {
      this.setData({
        myDetail: res.data,
        index: res.data.sex == 1 ? 0 : 1,
        myimg: res.data.avatar,
        newName: res.data.nickname
      })
    })
  },
  ChangeName(e) {
    this.setData({
      newName: e.detail.value
    })
  },
  saveDetail() {
    if (this.data.limg !== '') {
      this.data.myimg = this.data.limg
    }
    app.wxRequest("api/company/change", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      nickname: this.data.newName,
      avatar: this.data.myimg,
      sex: this.data.index == 0 ? '1' : 2
    }).then(res => {
      wx.showToast({
        title: '修改成功',
        icon: "none"
      })
      setTimeout(() => {
        wx.navigateBack({
          delta: 1,
        })
      }, 300)
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) { },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    wx.setNavigationBarTitle({
      title: "个人信息",
    });
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    this.getUuer()
  },

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
