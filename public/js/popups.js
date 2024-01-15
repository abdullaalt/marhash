var popups = {
    showAddTeam: function(){

        $('.add-team').css('bottom', '0%')

    },

    showTeams: function(){
        $('.teams').css('bottom', '0%')
    },

    showAuth: function(){
        this.hideAll()
        if (auth.token && $.cookie('token') != null){
            $('.profile-info').css('bottom', '0%')
        }else{
            $('.auth').css('bottom', '0%')
        }
    },

    showPoints: function(){
        $('.points').css('bottom', '0%')
    },

    showAddPoint: function(){
        $('.add-point').css('bottom', '0%')
    },

    hideAll: function(){
        $('.slideUp-container').css('bottom', '-100%')
        if (content.map){
            content.map.destroy()
            content.map = false
        }
    },

    hide: function(el){
        el.css('bottom', '-100%')
    },

    slideDown: function(el){
        el.parent().slideUp(100, function(){
            $('.teams-list').slideDown(100),
            el.parent().remove()
        })
    },

    addPersonInTeam: function(){
        this.hideAll()
        $('.add-person-team').css('bottom', '0%')
    }
}