var map = {

    points: false,
    points_data: new Array(),
    map: false,
    placemarks: new Array(),
    iam: false,

    init: function(){
        ymaps.ready(init);
        function init(){
            // Создание карты.
            map.map = new ymaps.Map("main-map", {
                // Координаты центра карты.
                // Порядок по умолчанию: «широта, долгота».
                // Чтобы не определять координаты центра карты вручную,
                // воспользуйтесь инструментом Определение координат.
                center: [43.31, 45.06],
                // Уровень масштабирования. Допустимые значения:
                // от 0 (весь мир) до 19.
                zoom: 17,
                controls: []
            });

            map.loadPoints()
        }
    },

    setRoute: function(){
        m = this
        ymaps.geolocation.get({
            provider: 'browser',
            mapStateAutoApply: true
        }).then(function (res) {

            map.iam = map.createPlacemark(res.geoObjects.get(0).geometry.getCoordinates(), 'Мое местоположение', 'Это я')
            map.map.geoObjects.add(map.iam);
            map.printRoute(res.geoObjects.get(0).geometry.getCoordinates())

        }, function (e) {
            // Если местоположение невозможно получить, то просто создаем карту.
            map.printRoute(false)
        })
        
    },

    printRoute: function(my){

        let referencePoints = []

        if (my){
            referencePoints.push(my)
        }

        this.points.forEach((item) => {
            referencePoints.push(JSON.parse(item.coords))
        })

        var multiRoute = new ymaps.multiRouter.MultiRoute({
            // Описание опорных точек мультимаршрута.
            referencePoints: referencePoints,
            // Параметры маршрутизации.
            params: {
                // Ограничение на максимальное количество маршрутов, возвращаемое маршрутизатором.
                results: 2
            }
        }, {
            // Автоматически устанавливать границы карты так, чтобы маршрут был виден целиком.
            boundsAutoApply: true
        });

        this.map.geoObjects.add(multiRoute);

    },

    loadPoints: function(){

        xhr.sendRequest('/points', 'savePoints', false, map)

    },

    savePoints: function(s, data, el){
        this.points_data['my'] = data.data
        this.points = this.points_data['my']
        content.points = this.points
        this.drawPoints()
    },

    drawPoints: function(){

        this.map.geoObjects.removeAll()
        if (this.points.length > 0){
            this.map.setCenter(JSON.parse(this.points[0].coords))
            for (key in this.points){

                point = this.points[key]
                this.addPointOnMap(point)

            }

        }

        this.setRoute()

    },

    addPointOnMap: function(point){
        let myPlacemark = this.createPlacemark(JSON.parse(point.coords), point.who, point.address+' - '+ point.action);
        this.map.geoObjects.add(myPlacemark);
        this.placemarks[point.id] = myPlacemark
    },

    createPlacemark: function(coords, caption, address) {
        return new ymaps.Placemark(coords, {
            iconCaption: caption,
            balloonContent: address
        }, {
            preset: 'islands#violetDotIconWithCaption',
            draggable: false
        });
    }
}