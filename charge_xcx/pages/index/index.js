//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    user_id:'',
    sum:{}
  },
  onLoad: function (options) {
    
       
    //解决异步请求返回慢的问题,加载全局变量到this.d
    if(app.d.userInfo){
      this.setData({d:app.d})
      // this.setData({user_id:app.d.userInfo.id})
      this.getSum(app.d.userInfo.id)
    }else{
      app.requestReady = (res)=>{
        // console.log(app.d.userInfo.id)
        this.setData({d:app.d})
        // this.setData({user_id:app.d.userInfo.id})
        // console.log(app.d.userInfo.id)
        this.getSum(app.d.userInfo.id)
      }
    }

    console.log(app.d)
    

    
  },
  getSum(user_id,year,month){
    app.get('/bill/counts',{user_id:user_id,year:year,month:month},res=>{
      this.setData({sum:res})
    })
  },
  getList(){

  }
  
})
