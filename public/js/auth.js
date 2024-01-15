auth = {
	
	token: false,
	user: false,

	init: function(){
		
		popups.showAuth();
		
	},
	
	authorize: function(e){

		e.preventDefault()
		fd = new FormData(document.getElementById('auth-form'))
		fd.append('device_name', 'site')

		xhr.sendRequest('/sanctum/token', 'authResult', null, auth, 'POST', fd)
		
	},

	register: function(e){

		e.preventDefault()
		fd = new FormData(document.getElementById('reg-form'))

		xhr.sendRequest('/register', 'authResult', null, auth, 'POST', fd)
		
	},

	authResult: function(s, data, el){
		if (s > 200) {
			alert('Неправильный логин или пароль')
			return false
		}
		this.token = data.token
		
		$.cookie('token', this.token, { expires: 60, path: '/' });
		popups.hideAll()
		window.location.reload()
	},

	loadUser: function(){
		xhr.sendRequest('/user', 'showInv', false, auth)
	},

	showInv: function(s, data, el){
		$('.user-profile').append($('#profile').tmpl({
			user: data.user,
			invs: data.invs
		}))

		this.user = data.user
		content.teams = data.teams
		content.setFilterSources()

		if (data.invs.length > 0){
			$('.menu-button.profile').append($('<span class="new-invc">'+data.invs.length+'</span>'))
		}
	},

	logOut: function(){
		$.removeCookie('token', { path: '/' })
		window.location.reload()
	},

	regForm: function(){
		popups.hideAll()
		$('.reg').css('bottom', '0%')
	}
	
}