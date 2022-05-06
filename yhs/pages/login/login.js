Page({
  data: {
    nums: "获取验证码",
    timer: null,
    userInfo: {},
    hasUserInfo: false,
    canIUseGetUserProfile: false,
    loginS: true,
    uPhone: "",
    UCode: "",
    bPhone: ""
  },
  onLoad(e) {
    if (e.phone) {
      this.setData({
        bPhone: e.phone,
        loginS: false
      })
      return;
    }
    if (wx.getStorageSync('y_token')) {
      this.ckP()
    }
  },
  onReady() {
  },
  quits(){
    wx.navigateBack({
      delta: 1,
    })
  },
  sumNum() {
    var that = this;
    if (that.data.nums == 0) {
      console.log("再次获取")
      clearInterval(that.data.timer)
      this.setData({
        nums: "获取验证码"
      })
      return;
    }
    that.setData({
      nums: this.data.nums - 1
    })
  },
  ckP() {
    app.wxRequest("api/login/is_mobile", {
      openid: wx.getStorageSync('y_openid')
    }).then(res => {
      if (res.data.status == 1) {
        wx.reLaunch({
          url:"/pages/index/index"
        })
      }
    })
    this.setData({
      loginS: false
    })
  },
  ChangePhone(e) {
    this.setData({
      uPhone: e.detail.value
    })
  },
  ChangeCode(e) {
    this.setData({
      UCode: e.detail.value
    })
  },
  // 获取验证码
  getCode() {
    if (this.data.uPhone.length != 11) {
      wx.showToast({
        title: '请输入正确的手机号',
        icon: "none"
      })
      return;
    }
    var that = this;
    if (that.data.nums !== "获取验证码") {
      return;
    }
    app.wxRequest("api/login/mobile_msg", { mobile: this.data.uPhone })
      .then(res => {
        wx.showToast({
          title: '发送成功',
          icon: "none"
        })
        that.data.nums = 60
        that.data.timer = setInterval(() => {
          this.sumNum()
        }, 1000);
      })
  },
  // 修改手机号
  editPh() {
    var pages = getCurrentPages();
    var currPage = pages[pages.length - 2]; //当前页面
    currPage.setData({
      "uPhone": this.data.uPhone
    })
    app.wxRequest("api/company/change_mobile", {
      openid: wx.getStorageSync('y_openid'),
      token: wx.getStorageSync('y_token'),
      mobile: this.data.uPhone,
      code: this.data.UCode,
    }).then(res => {
      wx.showToast({
        title: '修改成功',
        icon: "none"
      })
      setTimeout(() => {
        wx.navigateBack({
          delta: 1
        })
      }, 300)
    })
  },
  // 保存
  entSave() {
    if (this.data.bPhone !== "") {
      this.editPh()
      return;
    }
    app.wxRequest("api/login/bind_mobile", {
      openid: wx.getStorageSync('y_openid'),
      mobile: this.data.uPhone,
      code: this.data.UCode,
      nickname: this.data.userInfo.nickName,
      avatarUrl: this.data.userInfo.avatarUrl,
      gender: this.data.userInfo.gender
    }).then(res => {
      wx.showToast({
        title: '绑定成功',
        icon: "none"
      })
      wx.setStorageSync('y_token', res.data.token)
      setTimeout(() => {
        wx.reLaunch({
          url: '/pages/index/index',
        })
      }, 200)
    })
  },
  getUserProfile(e) {
    wx.getUserProfile({
      desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
      success: (res) => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
        var ui = {
          js_code: wx.getStorageSync('y_code')
        }
        this.wx_login(ui)
      },
      fail: (err) => {
        wx.login({
          success: res => {
            if (res.errMsg == "login:ok") {
              wx.setStorageSync('y_code', res.code)
            }
          }
        })
      }
    })
  },
  wx_login(ui) {
    app.wxRequest("api/login/wx_login", ui).then(res => {
      wx.setStorageSync('y_openid', res.data.openid)
      wx.setStorageSync('y_token', res.data.token)
      this.ckP()
      // 登录
      wx.login({
        success: res => {
          if (res.errMsg == "login:ok") {
            wx.setStorageSync('y_code', res.code)
          }
        }
      })
    })
  }
})
const app = getApp();