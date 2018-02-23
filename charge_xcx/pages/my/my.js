//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    user_id:'',
    budget:'',
    userInfo:{},
    sum:{},
    lists:[]
  },
  onShow: function (options) {
    // this.setData({budget:wx.getStorageSync('userInfo')['budget']})
    // console.log(wx.getStorageSync('userInfo'))
    this.getUserInfo()
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

  getUserInfo(){
    wx.getUserInfo({
      success:res=>{
        app.post('/mini/syncuser',{userInfo:res.userInfo},res=>{
            this.setData({budget:res.userInfo.budget})
        })
      },
      fail:res=>{
        console.log('fail')
        wx.openSetting()
      }
    })
  },
  


  // getList(user_id,year=0,month=0){
  //   app.get('/bill/lists',{user_id:user_id,year:year,month:month},res=>{
  //     this.setData({lists:res})
  //     // console.log(this.data.lists)
  //   })
  // }
  
})
