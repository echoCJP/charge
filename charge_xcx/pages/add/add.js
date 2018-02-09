Page({
  data: {
    cateList: [
      {'a':'http://img02.tooopen.com/images/20150928/tooopen_sy_143912755726.jpg'},
      // {'a':'http://img06.tooopen.com/images/20160818/tooopen_sy_175866434296.jpg'},
      {'a':'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'}
    ],
  },
  //日期选择
  bindDateChange: function(e) {
    this.setData({
      date: e.detail.value
    })
  },
  
  
})