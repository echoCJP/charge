
const app = getApp()

Page({
  data: {
    // cateType: [//consume-消费、income-收入
    //   {'type':'consume'},
    //   {'type':'income'}
    // ],
    cate:[],
    type:'consume',
    type_name:'支出'
  },
  onLoad: function (options) {

      this.getCate(this.data.type)

      //解决异步请求返回慢的问题,加载全局变量到this.d
      if(app.d.userInfo){
        this.setData({d:app.d})
        
      }else{
        app.requestReady = (res)=>{
          this.setData({d:app.d})
          
          // this.getList(app.d.userInfo.id)
        }
      } 
  },
  //日期选择
  bindDateChange: function(e) {
    this.setData({
      date: e.detail.value
    })
  },
  getCate(type){
    app.get('/bill/cate',{type:type},res=>{
      this.setData({cate:res})
      console.log(this.data.cate)
    })
  },
  swiperChange:function(event){
    if(event.detail.currentItemId == "income"){
      this.setData({type:'income',type_name:'收入'})
    }else{
      this.setData({type:'consume',type_name:'支出'})
    }

    this.getCate(this.data.type)
    
  },


  
  
})