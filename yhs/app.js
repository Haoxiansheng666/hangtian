// app.js
var app = getApp();
App({
  wxRequest(url, data) {
    return new Promise((resolve, reject) => {
      wx.request({
        url: "https://yhs.junhebrand.cn/" + url,
        method: "POST",
        data: data,
        header: {
          // application/x-www-form-urlencoded
          'content-type': 'application/json;charset=UTF-8',
          'Accept': 'application/json',
          // 'token': token
        },
        dataType: 'json',
        success: function (res) {
          // callback(res);
          if (res.data.code === 1) {
            resolve(res.data);
          } else if (res.data.code === 2) {
            wx.showToast({
              title: res.data.msg || '登录信息失效',
              icon: 'none'
            })
            wx.removeStorageSync("y_openid")
            wx.removeStorageSync("y_token")
            wx.navigateTo({
              url: '/pages/login/login',
            })
          } else {
            wx.showToast({
              title: res.data.msg || '系统出小差了',
              icon: 'none'
            })
          }
        },
        fail: function (err) {
          // errFun(err);
          reject(err);
        }
      })
    })
  },

  onLaunch() {
    // 登录
    wx.login({
      success: res => {
        if (res.errMsg == "login:ok") {
          wx.setStorageSync('y_code', res.code)
        }
      },
      fail: (err) => {
        wx.showToast({
          title: '获取Code失败',
          icon: "none"
        })
      }
    })

    if (!(wx.getStorageSync('y_openid'))) {
      wx.redirectTo({
        url: '/pages/login/login',
      })
    } else {
      wx.request({
        url: 'https://yhs.junhebrand.cn/api/login/is_mobile',
        method: "POST",
        data: {
          openid: wx.getStorageSync('y_openid')
        },
        success(res) {
          if (res.data.data.status == 1) {
            return;
          } else {
            wx.redirectTo({
              url: '/pages/login/login',
            })
          }
        }
      })
    }
  },
  globalData: {
    userInfo: null
  }
})
