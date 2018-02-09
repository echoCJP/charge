//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },
  onLoad: function () {
    this.getSum()
  },
  getSum(){
    app.get('/bill/counts',{user_id:1,year:2017,month:3},res=>{
      console.log(res)
    })
  },
  
})
