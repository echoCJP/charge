//app.js
import { devhost } from 'env.js'
App({
  d:{
    userInfo:null,
    staff:null,
    wallet:null,
    company:null,
    site:null,
    token:null,
    path:'',
    imgHost:'https://xcx.1024cc.cn/uploads/'
  },

  onLaunch: function (e) {
    this.path=e.path
    // 展示本地存储能力
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        this.get('/mini/session',{code:res.code},res=>{
          this.setGlobal('token', res.token)
          console.log(res.token)
          this.getUserInfo()
        })
      }
    })
  },

  globalData: {
    userInfo: null
  },

  getUserInfo(){
    wx.getUserInfo({
      success:res=>{
        this.post('/mini/syncuser',{userInfo:res.userInfo},res=>{
          console.log(res.userInfo)
          this.setGlobal('userInfo',res.userInfo);

          if (this.requestReady) {
            this.requestReady(res)
          }

        })
      }
    })
  },

  //响应预处理
  response(res,func){
    if (res.statusCode==200||res.statusCode==201){
      func(res.data)
    }else{
      if(res.data.message){
        this.msg(res.data.message)
      }
      console.log(res)
    }
  },

  //提示
  msg(text){
    wx.showToast({
      title: text,
      // image: '/img/error.png',
    })
  },


  //是否为开发环境
  isDevtool(){
    var devtool = false;
    wx.getSystemInfo({
      success: (res => {
        if (res.brand == "devtools") {
          devtool = true
        }
      })
    })
    return devtool;
  },

  //设置全局变量
  setGlobal(key, value) {
    this.d[key] = value
    // wx.setStorageSync('d', this.d)
  },

  //请求域名
  host(){
    var res;
    if (this.isDevtool()){
      res = devhost
    } else {
      res = 'https://xcx.1024cc.cn'
    }
    return res+'/api'
  },


  //get请求
  get(path, data, func) {
    wx.request({
      url: this.host() + path,
      data: data,
      header: {
        'content-type': 'application/json',
        'token': this.d.token
      },
      success: (res => {
        this.response(res, func)
      })
    })
  },

  //post请求
  post(path,data,func){
    wx.request({
      url: this.host() + path,
      method:'POST',
      dataType:'json',
      data: data,
      header: {
        'content-type': 'application/json',
        'token': this.d.token
      },
      success: (res => {
        this.response(res, func)
      })
    })
  },

  
})