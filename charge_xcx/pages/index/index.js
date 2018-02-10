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
  onLoad: function (options) {
    
       
    //解决异步请求返回慢的问题,加载全局变量到this.d
    if(app.d.userInfo){
      this.setData({d:app.d})
      this.getSum(app.d.userInfo.id)
      this.getList(app.d.userInfo.id)
    }else{
      app.requestReady = (res)=>{
        this.setData({d:app.d})
        this.getSum(app.d.userInfo.id)
        this.getList(app.d.userInfo.id)
      }
    } 

    
  },
  getSum(user_id,year=0,month=0){
    app.get('/bill/counts',{user_id:user_id,year:year,month:month},res=>{
      this.setData({sum:res})
      console.log(this.data.sum)
    })
  },
  getList(user_id,year=0,month=0){
    app.get('/bill/lists',{user_id:user_id,year:year,month:month},res=>{
      this.setData({lists:res})
      console.log(this.data.lists)
    })
  }
  
})
