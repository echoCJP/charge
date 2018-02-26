
const app = getApp()

Page({
  data: {
    cate:[],
    chooseCate:{},
    cateIndex:0,
    type:'consume',
    type_name:'支出',
    user_id:'',
    is_add:false,
    cate_id:'',
    current:0,
    edit_content:{},
    date:'',
    swiper_index:'',
    id:''//>0即时修改
  },
  onLoad: function (options) {
      if(options.id > 0){
        this.setData({edit_content:options,id:options.id,cate_id:options.cate_id,date:options.time})
      }else{
        var todayDate = new Date();
        var date = todayDate.getDate();
        var month= todayDate.getMonth() +1;
        var year= todayDate.getFullYear();
        // if(month<10){
        //   month = "0"+month;
        // }

        // if(date<10){
        //   date = "0"+date;
        // }
        this.setData({date:year+"-"+month+"-"+date})
      }
      
      if(options.cost_type == 1){
        this.setData({type:'income',type_name:'收入',swiper_index:1})
      }else{
        this.setData({type:'consume',type_name:'支出',swiper_index:0})
      }

      

      this.getCate(this.data.type,options.cate_id)
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
  getCate(type,cate_id){
    app.get('/bill/cate',{type:type},res=>{
      this.setData({cate:res})
      if(cate_id > 0){
        for (var i = 0; i < this.data.cate.length; i++) {
            if(this.data.cate[i]['id'] == this.data.cate_id){
               this.setData({cateIndex:i})
            }
        }
        this.setData({chooseCate:this.data.cate[this.data.cateIndex]})
      }else{
        this.setData({chooseCate:this.data.cate[0]})
      }
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
  addone(){
    this.setData({is_add:true})
  },

  formSubmit(e){
    // console.log(e)
    wx.vibrateShort()
    var data=e.detail.value
    data['bill_id'] = this.data.id
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
      console.log(res)
      if(res.code == 200){
          wx.showToast({title:'提交成功'})
          if(!this.data.is_add){
            setTimeout(function(){
              wx.navigateBack()

            },1000)
          }
          this.setData({is_add:false})
      }else{
          wx.showToast({title:'操作失败'})
      }
      

    })
  },

  del(){
    app.get('/bill/del',{bill_id:this.data.id},res=>{
      if(res.code == 200){
          wx.showToast({title:'提交成功'})
          if(!this.data.is_add){
            setTimeout(function(){
              wx.navigateBack()
            },1000)
          }
          this.setData({is_add:false})
      }else{
          wx.showToast({title:'操作失败'})
      }
    })
  },




  
  
})