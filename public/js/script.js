$('document').ready(function(){

    if (!auth.token && $.cookie('token') == null){
      auth.init()
    }else{
      auth.token = $.cookie('token')
    }

    if (auth.token && $.cookie('token') != null){
      $('.slideUp-container').click(function(){
          popups.hide($(this))
      })

      $('.slideUp-container-content').click(function(e){
          e.stopPropagation()
      })
      auth.loadUser()
      map.init()
    }
})