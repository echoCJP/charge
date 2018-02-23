//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    user_id:'',
    sum:{},
    lists:[]
  },
  onShow: function (options) {
    console.log(wx.getStorageSync('userInfo'))
  },
  showClause: function () {
    wx.navigateTo({
      url: './setting/setting',
      success: function (res) {
        // success
      },
      fail: function () {
        // fail
      },
      complete: function () {
        // complete
      }
    })
  },
  showHelp: function () {
    wx.navigateTo({
      url: './help/help',
      success: function (res) {
        // success
      },
      fail: function () {
        // fail
      },
      complete: function () {
        // complete
      }
    })
  },
  showFeedback: function () {
    wx.navigateTo({
      url: './feedback/feedback',
      success: function(res){
        // success
      },
      fail: function() {
        // fail
      },
      complete: function() {
        // complete
      }
    })
  }

  // getSum(user_id,year=0,month=0){
  //   app.get('/bill/counts',{user_id:user_id,year:year,month:month},res=>{
  //     this.setData({sum:res})
  //     // console.log(this.data.sum)
  //   })
  // },
  // getList(user_id,year=0,month=0){
  //   app.get('/bill/lists',{user_id:user_id,year:year,month:month},res=>{
  //     this.setData({lists:res})
  //     // console.log(this.data.lists)
  //   })
  // }
  
})
