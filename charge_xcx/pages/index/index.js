//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    sum:{}
  },
  onLoad: function () {
    this.getSum()
  },
  getSum(){
    app.get('/bill/counts',{user_id:1,year:2017,month:3},res=>{
      this.setData({sum:res})
      // console.log(app.globalData)
    })
  },
  
})
