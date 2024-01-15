var content = {
    
    teams : new Array(),
    active_team: -1,
    active_point: -1,
    active_filter: 'person',
    map: false,
    searchControll: {},
    coords: [],
    address: '',
    team_points: false,

    showTeams: function(){

        popups.showTeams()
        xhr.sendRequest('/teams', 'setTeams', false, content)

    },

    setTeams: function(status, data, el){
        
        this.teams = data
        $('.teams > div').html('')

        $('.teams > div').append($('#teams').tmpl({
            items: this.teams,
            user: auth.user
        }))

    },

    showTeamPersons: function(team_id){
        this.active_team = team_id
        this.active_filter = 'person'
        xhr.sendRequest('/teams/'+team_id+'/persons', 'renderTeamPersons', false, content)
    },

    showTeamInvitations: function(team_id = false){
        if (!team_id) team_id = this.active_team
        this.active_team = team_id
        this.active_filter = 'inv'
        xhr.sendRequest('/teams/'+team_id+'/invitations', 'renderTeamPersons', false, content)
    },

    saveTeam: function(){
		fd = new FormData(document.getElementById('add-team'))
        popups.hideAll()

		xhr.sendRequest('/teams', 'showTeams', null, content, 'POST', fd)
    },

    deleteTeam: function(team_id){
        xhr.sendRequest('/teams/'+team_id, 'showTeams', null, content, 'DELETE')
    },

    removePersonFromTeam: function(person_id){
        xhr.sendRequest('/teams/'+this.active_team+'/persons/'+person_id, 'renderTeamPersons', false, content, 'DELETE')
    },

    sendInv: function(team_id){

        fd = new FormData(document.getElementById('add-person-team'))
        popups.hideAll()
        this.active_filter = 'inv'

		xhr.sendRequest('/teams/'+this.active_team+'/invitations', 'sendInvBr', null, content, 'POST', fd)

    },

    sendInvBr: function(s, data, el){
        popups.hide($('.add-person-team'))
        popups.showTeams()

        this.renderTeamPersons(s, data, el)
    },

    acceptInv: function(team_id, el){
        xhr.sendRequest('/teams/'+team_id+'/invitations/accept', 'invAccepted', el, content)    
    },

    invAccepted: function(s, data, el){
        el.closest('.team-item').remove()

        if ($('.invs-list').find('.team-item').length < 1){
            $('.new-invc').remove()
        }else{
           count = parseInt($('.new-invc').text())
           $('.new-invc').text(count-1)
        }
    },

    rejectInv: function(team_id, el){
        xhr.sendRequest('/teams/'+team_id+'/invitations/reject', 'invRejected', el, content)
    },

    invRejected: function(s, data, el){
        if (el.hasClass('team-remove')){
            el.closest('.team-item').remove()
        }else{
            this.invAccepted(s, data, el)
        }
    },

    renderTeamPersons: function(status, data, el){

        let list = $('#teams-persons').tmpl({
            team_id: this.active_team,
            af: this.active_filter,
            items: data.data
        })

        $('.teams > div').find('.team-persons').remove()
        $('.teams > div').append(list)
        $('.teams-list').slideUp(100, function(){
            list.slideDown(100)
        })

    },

    showPoints: function(s=false, data=false, el=false){
        if (data){
            map.points_data['my'].push(data.data)
            map.addPointOnMap(data.data)
        }
        xhr.sendRequest('/points', 'renderPointsList', false, content)
    },

    renderPointsList: function(s, data, el){
        let list = $('#points').tmpl({
            items: data.data
        })

        $('.points > div').html('')
        $('.points > div').append(list)
        popups.showPoints()
    },

    addPoint: function(){
        popups.hideAll()
        popups.showAddPoint()
        ymaps.ready(init);
        function init(){
            // Создание карты.
            var myPlacemark
            myPlacemark, content.map = new ymaps.Map("addmap", {
                // Координаты центра карты.
                // Порядок по умолчанию: «широта, долгота».
                // Чтобы не определять координаты центра карты вручную,
                // воспользуйтесь инструментом Определение координат.
                center: [43.31, 45.06],
                // Уровень масштабирования. Допустимые значения:
                // от 0 (весь мир) до 19.
                zoom: 7,
                controls: []
            });

            searchControl = new ymaps.control.SearchControl({
                options: {
                    provider: 'yandex#map',
                    noPlacemark: true
                }
            });
            
            content.map.controls.add(searchControl);

            searchControl.events.add('resultselect', function (e) {
                var index = e.get('index');
                searchControl.getResult(index).then(function (res) {
                    coords = res.geometry.getCoordinates()
                    console.log(coords)
                    createOrUpdatePlacemark(coords)
                });
            })

            content.map.events.add('click', function(e){
                var coords = e.get('coords');
                createOrUpdatePlacemark(coords)
            })

            function createOrUpdatePlacemark(coords){
                content.coords = coords
                // Если метка уже создана – просто передвигаем ее.
                if (myPlacemark) {
                    myPlacemark.geometry.setCoordinates(coords);
                }
                // Если нет – создаем.
                else {
                    myPlacemark = createPlacemark(coords);
                    content.map.geoObjects.add(myPlacemark);
                    // Слушаем событие окончания перетаскивания на метке.
                    myPlacemark.events.add('dragend', function () {
                        getAddress(myPlacemark.geometry.getCoordinates());
                    });
                }
                getAddress(coords);
            }

            function createPlacemark(coords) {
                return new ymaps.Placemark(coords, {
                    iconCaption: 'поиск...'
                }, {
                    preset: 'islands#violetDotIconWithCaption',
                    draggable: true
                });
            }
            
            // Определяем адрес по координатам (обратное геокодирование).
            function getAddress(coords) {
                myPlacemark.properties.set('iconCaption', 'поиск...');
                ymaps.geocode(coords).then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);
                    content.address = firstGeoObject.getAddressLine()
                    myPlacemark.properties
                        .set({
                            // Формируем строку с данными об объекте.
                            iconCaption: [
                                // Название населенного пункта или вышестоящее административно-территориальное образование.
                                firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                                // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                                firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                            ].filter(Boolean).join(', '),
                            // В качестве контента балуна задаем строку с адресом объекта.
                            balloonContent: firstGeoObject.getAddressLine()
                        });
                });
            }
        }

    },

    savePoint: function(e){
        e.preventDefault()
		fd = new FormData(document.getElementById('point-form'))
		fd.append('coords[]', content.coords[0])
		fd.append('coords[]', content.coords[1])
		fd.append('address', content.address)
        popups.hideAll()

		xhr.sendRequest('/points', 'showPoints', null, content, 'POST', fd)
    },

    deletePoint: function(point_id, el){
        xhr.sendRequest('/points/'+point_id, 'pointDeleted', el, content, 'DELETE')
    },

    pointDeleted: function(s, data, el){
        el.closest('.points-item').remove()
        map.map.geoObjects.remove(map.placemarks[data.point_id])
    },

    linkWithTeam: function(point_id){
        this.active_point = point_id
        xhr.sendRequest('/teams', 'showTeamsForLink', false, content)
    },

    showTeamsForLink: function(s, data, el){
        popups.hideAll()
        $('.teams > div').html('')
        $('.teams > div').append($('#link-teams').tmpl({
            items: data,
            point_id: this.active_point
        }))
        popups.showTeams()
    },

    linkWithThisTeam: function(team_id, point_id){
        let fd = new FormData()
        fd.append('points[]', point_id)
        xhr.sendRequest('/teams/'+team_id+'/points', 'pointLinked', false, content, 'POST', fd)
    },

    pointLinked: function(s, data, el){
        popups.hideAll()
        content.showPoints()
    },

    unlinkFromTeam: function(team_id, point_id){
        xhr.sendRequest('/teams/'+team_id+'/points?points[]='+point_id, 'pointUnLinked', false, content, 'DELETE')
    },

    pointUnLinked: function(s, data, el){
        popups.hideAll()
        content.showPoints()
    },

    showTeamPoints: function(team_id){
        this.active_team = team_id
        xhr.sendRequest('/teams/'+team_id+'/points', 'renderTeamPoints', false, content)
    },

    renderTeamPoints: function(s, data, el){
        let list = $('#team-points').tmpl({
            team_id: this.active_team,
            items: data.data
        })
        map.points_data[this.active_team] = data.data
        $('.teams > div').find('.team-points-container').remove()
        $('.teams > div').append(list)
        $('.teams-list').slideUp(100, function(){
            list.slideDown(100)
        })
    },

    showTeamPointsOnMap: function(){
        map.points = map.points_data[this.active_team]
        map.drawPoints()
    },

    changeSource: function(el){
        if (map.points_data[el.val()] != undefined){
            map.points = map.points_data[el.val()]
            map.drawPoints()
        }else{
            xhr.sendRequest('/teams/'+el.val()+'/points', 'setTeamPoints', el, content)
        }

        let team = false;

        this.teams.forEach((item) => {
            if (item.id == el.val()){
                team = item
            }
        })

        $('.persons').html('')
        $('.persons').append($('<option value="-1">Все</option>'))

        if (team){
            team.persons.forEach((item) => {
                $('.persons').append($('<option value="'+item.user.id+'">'+item.user.username+'</option>'))
            })
        }

    },

    changePerson: function(el){
        let val = el.val()

        let list = map.points_data[$('.sources').val()]
        if (val < 0){
            map.points = list
            map.drawPoints()
            return true
        }

        let points = []

        list.forEach((item) => {
            if (item.user.id == val){
                points.push(item)
            }
        })

        map.points = points
        map.drawPoints()
    },

    setTeamPoints: function(s, data, el){
        this.active_team = el.val()
        map.points_data[el.val()] = data.data
        this.showTeamPointsOnMap()
    },

    setFilterSources: function(){
        $('.sources').html('')
        $('.sources').append($('<option value="my">Мои точки</option>'))

        this.teams.forEach((item) => {
            $('.sources').append($('<option value="'+item.id+'">'+item.description+'</option>'))
        })
    }
}