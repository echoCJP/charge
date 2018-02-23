// pages/settings/clause/clause.js

const app = getApp()

Page({
  data:{
    user_id:'',
    is_add:false
  },
  onLoad:function(options){
    // 页面初始化 options为页面跳转所带来的参数
    this.setData({user_id:wx.getStorageSync('userInfo')['id']})
  },

  formSubmit(e){
    // console.log(e)
    wx.vibrateShort()
    var data=e.detail.value
    data['user_id'] = this.data.user_id

    console.log(data)
    // $bill_id = $request->bill_id; //账单ID（edit）

    if(!data.budget){
      app.tipMsg('请填写金额')
      return
    }

    if(!(data['user_id']>0)){
      app.tipMsg('服务器有误');
      return
    }


    app.post('/bill/setting',data,res=>{
      wx.showToast({title:'提交成功'})
      
      if(!this.data.is_add){
        setTimeout(function(){
          wx.navigateBack()
        },1000)
      }
      this.setData({is_add:false})

    })
  }

})