//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    date: '',
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    user_id:'',
    sum:{},
    lists:[]
  },
  onShow: function (options) {
    
       
    this.setData({user_id:wx.getStorageSync('userInfo')['id']})

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
      // console.log(this.data.sum)
    })
  },
  getList(user_id,year=0,month=0){
    app.get('/bill/lists',{user_id:user_id,year:year,month:month},res=>{
      console.log(res)
      if(res.code == "数据为空"){
        console.log('2')
        this.setData({lists:[]})
      }else{
         this.setData({lists:res})
        
      }
      
      console.log(this.data.lists)
    })
  },
  bindDateChange: function(e) {
    
    var y = e.detail.value.substr(0, 4);  //截取字符串从第0位开始截取4位
    var m = e.detail.value.substr(e.detail.value.length-2,2)
    this.getSum(this.data.user_id,y,m)
    this.getList(this.data.user_id,y,m)
  },
  
})
