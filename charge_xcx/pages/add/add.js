
const app = getApp()

Page({
  data: {
    cate:[],
    chooseCate:{},
    cateIndex:0,
    type:'consume',
    type_name:'支出',
    user_id:''
  },
  onLoad: function (options) {

      this.getCate(this.data.type)
      this.setData({user_id:wx.getStorageSync('userInfo')['id']})
      


      //解决异步请求返回慢的问题,加载全局变量到this.d
      if(app.d.userInfo){
        this.setData({d:app.d})
        
      }else{
        app.requestReady = (res)=>{
          this.setData({d:app.d})

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
      this.setData({chooseCate:this.data.cate[0]})
    })
  },
  swiperChange:function(event){
    if(event.detail.currentItemId == "income"){
      this.setData({type:'income',type_name:'收入'})
    }else{
      this.setData({type:'consume',type_name:'支出'})
    }
    this.getCate(this.data.type)
    this.setData({cateIndex:0})
  },
  choose:function(event){
    this.setData({cateIndex:event.currentTarget.dataset.id})
    this.setData({chooseCate:this.data.cate[this.data.cateIndex]})
  },
  formSubmit(e){
    console.log(e)
    wx.vibrateShort()
    var data=e.detail.value
    data['user_id'] = this.data.user_id
    data['cate_id'] = this.data.chooseCate.id
    data['date'] = data.datePicker
    data['cost'] = data.cost
    data['type'] = this.data.type
    data['remark'] = data.remark

    // $bill_id = $request->bill_id; //账单ID（edit）

    if(!data.cost){
      app.tipMsg('请填写金额')
      return
    }

    if(!data.date){
      app.tipMsg('请选择时间')
      return
    }
    
    if(!(data['user_id']>0)){
      app.tipMsg('服务器有误');
      return
    }

    app.post('/bill/consume',data,res=>{
      wx.showToast({title:'提交成功'})
      
      setTimeout(function(){
        wx.navigateBack()
      },1000)

    })




  }


  
  
})