var app = angular.module('VendWebApp');
app.controller('DashboardController',
    ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
        function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
            $scope.isMediaManager = $rootScope.isAdManager;
            var i, j;
            $http.get('/index.php/Advertisement_controller/getData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.advertisement = result.data;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                });

            if ($rootScope.isLoggedIn == true || $rootScope.isLoggedIn == 'true') {
                if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                    var fd = new FormData();
                    fd.append('client_id', $rootScope.clientId);
                    $http.post('/index.php/Feed_controller/getFeedByClientId', fd, {
                        transformRequest: angular.identity,
                        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                    })
                        .success(function (result) {
                            if (result.code == 200) {
                                $scope.feeds = result.feed;
                                for (i = 0; i < $scope.feeds.length; i++) {
                                    //var date = new Date($scope.feeds[i].created_on);
                                    var date = moment($scope.feeds[i].created_on, 'YYYY-MM-DD HH:mm:ss').toDate();
                                    $scope.feeds[i].created_on = moment(date).format('MMM DD , HH:mm:ss');
                                }
                            }
                            else if (result.code == 401) {
                                $scope.logout();
                            }
                            else {
                                $scope.logout();
                            }

                        });
                    setInterval(function () {
                        if ($rootScope.isLoggedIn == true || $rootScope.isLoggedIn == 'true') {
                            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                                var fd = new FormData();
                                fd.append('client_id', $rootScope.clientId);
                                $http.post('/index.php/Feed_controller/getFeedByClientId', fd, {
                                    transformRequest: angular.identity,
                                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                                })
                                    .success(function (result) {
                                        if (result.code == 200) {
                                            $scope.feeds = result.feed;
                                            for (i = 0; i < $scope.feeds.length; i++) {
                                                //            var date = new Date($scope.feeds[i].created_on);
                                                var date = moment($scope.feeds[i].created_on, 'YYYY-MM-DD HH:mm:ss').toDate();
                                                $scope.feeds[i].created_on = moment(date).format('MMM DD , HH:mm:ss');
                                            }
                                        }
                                        else if (result.code == 401) {
                                            $scope.logout();
                                        }
                                        else {
                                            $scope.logout();
                                        }
                                    });
                            }
                        }
                    }, 15000)
                }
                else {
                    $http.get('/index.php/Feed_controller/getFeed', {
                        transformRequest: angular.identity,
                        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                    })
                        .success(function (result) {

                            if (result.code == 200) {
                                $scope.feeds = result.feed;
                                for (i = 0; i < $scope.feeds.length; i++) {
                                    //  var date = new Date($scope.feeds[i].created_on);
                                    var date = moment($scope.feeds[i].created_on, 'YYYY-MM-DD HH:mm:ss').toDate();
                                    $scope.feeds[i].created_on = moment(date).format('MMM DD , HH:mm:ss');
                                }
                            }
                            else if (result.code == 401) {
                                $scope.logout();
                            }
                            else {
                                $scope.logout();
                            }

                        });
                    setInterval(function () {
                        if ($rootScope.isLoggedIn == true || $rootScope.isLoggedIn == 'true') {
                            if ($rootScope.isClient == false || $rootScope.isClient == 'false') {
                                $http.get('/index.php/Feed_controller/getFeed', {
                                    transformRequest: angular.identity,
                                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                                })
                                    .success(function (result) {
                                        if (result.code == 200) {
                                            $scope.feeds = result.feed;
                                            for (i = 0; i < $scope.feeds.length; i++) {
                                                //        var date = new Date($scope.feeds[i].created_on);
                                                var date = moment($scope.feeds[i].created_on, 'YYYY-MM-DD HH:mm:ss').toDate();
                                                $scope.feeds[i].created_on = moment(date).format('MMM DD , HH:mm:ss');
                                            }
                                        }
                                        else if (result.code == 401) {
                                            $scope.logout();
                                        }
                                        else {
                                            $scope.logout();
                                        }

                                    });
                            }
                        }
                    }, 15000)
                }
            }

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        location.href = '/#/logout'
                    });
            }


            $scope.myMap = function () {
                var myLatLng = { lat: -33.8036396, lng: 151.03246680000007 };
                if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                    var fd = new FormData();
                    fd.append('client_id', $rootScope.clientId);
                    $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                        transformRequest: angular.identity,
                        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                    })
                        .success(function (result) {
                            if (result.code == 200) {
                                $scope.data = result.data;

                                var i;

                                if ($scope.data.length > 0) {
                                    myLatLng = { lat: parseFloat($scope.data[0].machine_latitude), lng: parseFloat($scope.data[0].machine_longitude) };
                                }

                                $scope.map = new google.maps.Map(document.getElementById('googleMap'), {
                                    zoom: 4,
                                    center: myLatLng
                                });


                                var markers = [];
                                var contents = [];
                                $scope.infowindow = new google.maps.InfoWindow();

                                for (i = 0; i < $scope.data.length; i++) {
                                    myLatLng = { lat: parseFloat($scope.data[i].machine_latitude), lng: parseFloat($scope.data[i].machine_longitude) };

                                    //console.log($scope.data[i].id + " " + $scope.feedSelectedMachineId);
                                    if (angular.equals($scope.data[i].id, $scope.feedSelectedMachineId)) {
                                        //console.log("Matches");
                                        $scope.icon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                                    }
                                    else {
                                        //console.log("Doesn't Matches");
                                        $scope.icon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                                    }

                                    var marker = new google.maps.Marker({
                                        position: new google.maps.LatLng($scope.data[i].machine_latitude, $scope.data[i].machine_longitude),
                                        map: $scope.map,
                                        animation: google.maps.Animation.DROP,
                                        title: $scope.data[i].machine_name,
                                        icon: $scope.icon
                                    });

                                    var adContent = "";

                                    for (j = 0; j < $scope.advertisement.length; j++) {
                                        if ($scope.advertisement[j].ads_machine_name == $scope.data[i].machine_name) {
                                            adContent = adContent + '<br/>' + $scope.advertisement[j].ads_name;
                                        }
                                    }

                                    var content = '<div>' +
                                        '<h4>' + $scope.data[i].machine_name + '</h4>'
                                        + '<h6>' + $scope.data[i].machine_address + '</h6><br/>Current Ads :<br/>'
                                        + adContent
                                        + '</div>';

                                    contents.push(content);

                                    google.maps.event.addListener(marker, 'dblclick', function (evt) {
                                        $scope.map.setZoom(15);
                                        $scope.map.setCenter(evt.latLng);
                                    });

                                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                        return function () {
                                            $scope.infowindow.setContent(contents[i]);
                                            $scope.infowindow.open($scope.map, marker);
                                        }
                                    })(marker, i));

                                    markers.push(marker);

                                }
                            }
                            else if (result.code == 401) {
                                $scope.logout();
                            }
                        });
                }
                else {
                    $http.get('/index.php/Machine_controller/getData', {
                        transformRequest: angular.identity,
                        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                    })
                        .success(function (result) {
                            if (result.code == 200) {
                                $scope.data = result.data;

                                var i;
                                $scope.map = new google.maps.Map(document.getElementById('googleMap'), {
                                    zoom: 4,
                                    center: myLatLng
                                });


                                var markers = [];
                                var contents = [];
                                $scope.infowindow = new google.maps.InfoWindow();

                                for (i = 0; i < $scope.data.length; i++) {
                                    myLatLng = { lat: parseFloat($scope.data[i].machine_latitude), lng: parseFloat($scope.data[i].machine_longitude) };

                                    //console.log($scope.data[i].id + " " + $scope.feedSelectedMachineId);
                                    if (angular.equals($scope.data[i].id, $scope.feedSelectedMachineId)) {
                                        //console.log("Matches");
                                        $scope.icon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                                    }
                                    else {
                                        //console.log("Doesn't Matches");
                                        $scope.icon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                                    }

                                    var marker = new google.maps.Marker({
                                        position: new google.maps.LatLng($scope.data[i].machine_latitude, $scope.data[i].machine_longitude),
                                        map: $scope.map,
                                        animation: google.maps.Animation.DROP,
                                        title: $scope.data[i].machine_name,
                                        icon: $scope.icon
                                    });

                                    var adContent = "";

                                    for (j = 0; j < $scope.advertisement.length; j++) {
                                        if ($scope.advertisement[j].ads_machine_name == $scope.data[i].machine_name) {
                                            adContent = adContent + '<br/>' + $scope.advertisement[j].ads_name;
                                        }
                                    }

                                    var content = '<div>' +
                                        '<h4>' + $scope.data[i].machine_name + '</h4>'
                                        + '<h6>' + $scope.data[i].machine_address + '</h6><br/>Current Ads :<br/>'
                                        + adContent
                                        + '</div>';

                                    contents.push(content);

                                    google.maps.event.addListener(marker, 'dblclick', function (evt) {
                                        $scope.map.setZoom(15);
                                        $scope.map.setCenter(evt.latLng);
                                    });

                                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                        return function () {
                                            $scope.infowindow.setContent(contents[i]);
                                            $scope.infowindow.open($scope.map, marker);
                                        }
                                    })(marker, i));

                                    markers.push(marker);

                                }
                            }
                            else if (result.code == 401) {
                                $scope.logout();
                            }

                        });
                }
            }

            $scope.updateMap = function () {

                var i;

                var markers = [];
                var contents = [];

                for (i = 0; i < $scope.data.length; i++) {
                    myLatLng = { lat: parseFloat($scope.data[i].machine_latitude), lng: parseFloat($scope.data[i].machine_longitude) };

                    //console.log($scope.data[i].id + " " + $scope.feedSelectedMachineId);
                    if (angular.equals($scope.data[i].id, $scope.feedSelectedMachineId)) {
                        //console.log("Matches");
                        $scope.icon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                    }
                    else {
                        //console.log("Doesn't Matches");
                        $scope.icon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                    }

                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng($scope.data[i].machine_latitude, $scope.data[i].machine_longitude),
                        map: $scope.map,
                        title: $scope.data[i].machine_name,
                        icon: $scope.icon
                    });

                    var adContent = "";

                    for (j = 0; j < $scope.advertisement.length; j++) {
                        if ($scope.advertisement[j].ads_machine_name == $scope.data[i].machine_name) {
                            adContent = adContent + '<br/>' + $scope.advertisement[j].ads_name;
                        }
                    }

                    var content = '<div>' +
                        '<h4>' + $scope.data[i].machine_name + '</h4>'
                        + '<h6>' + $scope.data[i].machine_address + '</h6><br/>Current Ads :<br/>'
                        + adContent
                        + '</div>';

                    contents.push(content);

                    google.maps.event.addListener(marker, 'dblclick', function (evt) {
                        $scope.map.setZoom(15);
                        $scope.map.setCenter(evt.latLng);
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            $scope.infowindow.setContent(contents[i]);
                            $scope.infowindow.open($scope.map, marker);
                        }
                    })(marker, i));

                    markers.push(marker);

                }


            }


            $scope.feedSelect = function (selectedFeed) {
                $scope.selectedFeed = selectedFeed;
                $scope.feedSelectedMachineId = $scope.selectedFeed.machine_id;
                $scope.updateMap();
            };



            $scope.loadScript = function () {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAYkO-tjV5uV62B8OBez5U-2s8JFBRhk1k';
                document.body.appendChild(script);
                setTimeout(function () {
                    $scope.myMap();
                }, 500);
            }

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Sale_Report_controller/getSaleReportDataLast15DaysByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.sale_reports = result.data;
                            //console.log("Report Size : " + $scope.sale_reports.length);
                            for (i = 0; i < $scope.sale_reports.length; i++) {
                                //  var date = new Date($scope.sale_reports[i].timestamp);
                                var date = moment($scope.sale_reports[i].timestamp, 'YYYY-MM-DD HH:mm:ss').toDate();
                                $scope.sale_reports[i].timestamp = moment(date).format('MMM DD');
                                //console.log($scope.sale_reports[i]);
                            }
                            var labels = [];
                            var totalSale = [];
                            var labelDate = new Date();
                            labelDate.setDate(labelDate.getDate() - 15);
                            for (i = 0; i < 15; i++) {
                                labels.push(moment(labelDate.setDate(labelDate.getDate() + 1)).format('MMM DD'));
                                totalSale[i] = 0;
                            }
                            var todayDate = new Date();
                            var todayDateString = moment(todayDate.setDate(todayDate.getDate())).format('DD-MM-YYYY');
                            //console.log(todayDateString);
                            var index = 0;
                            for (i = 0; i < $scope.sale_reports.length; i++) {
                                index = labels.indexOf($scope.sale_reports[i].timestamp);
                                totalSale[index] = parseInt(totalSale[index]) + parseInt($scope.sale_reports[i].product_price);
                            }
                            /*console.log("Label Date : "+labelDate);
                            console.log("Total Sale : "+totalSale);
                            console.log("Labels : "+labels);*/

                            var myConfig = {
                                type: "area",
                                stacked: true,
                                title: {
                                    text: "Last 15 Days Sales Report",
                                    fontColor: "#424242",
                                    adjustLayout: true,
                                    marginTop: 15
                                },
                                subtitle: {
                                    text: "In $",
                                    fontColor: "#616161",
                                    adjustLayout: true,
                                    marginTop: 45
                                },
                                plot: {
                                    aspect: "spline",
                                    alphaArea: 0.6
                                },
                                plotarea: {
                                    margin: "dynamic"
                                },
                                tooltip: { visible: true },
                                scaleY: {
                                    short: true,
                                    shortUnit: '',
                                    lineColor: "#AAA5A5",
                                    tick: {
                                        lineColor: "#AAA5A5"
                                    },
                                    item: {
                                        fontColor: "#616161",
                                        paddingRight: 5
                                    },
                                    guide: {
                                        lineStyle: "dotted",
                                        lineColor: "#AAA5A5"
                                    },
                                    label: {
                                        text: "Total Sale",
                                        fontColor: "#616161"
                                    }
                                },
                                scaleX: {
                                    lineColor: "#AAA5A5",
                                    labels: labels,
                                    tick: {
                                        lineColor: "#AAA5A5"
                                    },
                                    item: {
                                        fontColor: "#616161",
                                        paddingTop: 5
                                    },
                                    label: {
                                        text: "2019",
                                        fontColor: "#616161"
                                    }
                                },
                                crosshairX: {
                                    lineColor: "#AAA5A5",
                                    plotLabel: {
                                        backgroundColor: "#EBEBEC",
                                        borderColor: "#AAA5A5",
                                        borderWidth: 2,
                                        borderRadius: 2,
                                        thousandsSeparator: ',',
                                        fontColor: '#616161'
                                    },
                                    scaleLabel: {
                                        backgroundColor: "#EBEBEC",
                                        borderColor: "#AAA5A5",
                                        fontColor: "#424242"
                                    }
                                },
                                series: [
                                    {
                                        values: totalSale,
                                        text: "Total Sale",
                                        backgroundColor: "#077a46",
                                        lineColor: "#077a46",
                                        marker: {
                                            backgroundColor: "#077a46",
                                            borderColor: "#077a46"

                                        }
                                    }
                                ]
                            };

                            zingchart.render({
                                id: 'myChart',
                                data: myConfig,
                            });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });
            }
            else {
                $http.get('/index.php/Sale_Report_controller/getSaleReportDataLast15Days', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.sale_reports = result.data;
                            //console.log("Report Size : " + $scope.sale_reports.length);
                            for (i = 0; i < $scope.sale_reports.length; i++) {
                                // var date = new Date($scope.sale_reports[i].timestamp);
                                var date = moment($scope.sale_reports[i].timestamp, 'YYYY-MM-DD HH:mm:ss').toDate();
                                $scope.sale_reports[i].timestamp = moment(date).format('MMM DD');
                                //console.log($scope.sale_reports[i]);
                            }
                            var labels = [];
                            var totalSale = [];
                            var labelDate = new Date();
                            labelDate.setDate(labelDate.getDate() - 15);
                            for (i = 0; i < 15; i++) {
                                labels.push(moment(labelDate.setDate(labelDate.getDate() + 1)).format('MMM DD'));
                                totalSale[i] = 0;
                            }
                            var todayDate = new Date();
                            var todayDateString = moment(todayDate.setDate(todayDate.getDate())).format('DD-MM-YYYY');
                            //console.log(todayDateString);
                            var index = 0;
                            for (i = 0; i < $scope.sale_reports.length; i++) {
                                index = labels.indexOf($scope.sale_reports[i].timestamp);
                                totalSale[index] = parseInt(totalSale[index]) + parseInt($scope.sale_reports[i].product_price);
                            }
                            /*console.log("Label Date : "+labelDate);
                            console.log("Total Sale : "+totalSale);
                            console.log("Labels : "+labels);*/

                            var myConfig = {
                                type: "area",
                                stacked: true,
                                title: {
                                    text: "Last 15 Days Sales Report",
                                    fontColor: "#424242",
                                    adjustLayout: true,
                                    marginTop: 15
                                },
                                subtitle: {
                                    text: "In $",
                                    fontColor: "#616161",
                                    adjustLayout: true,
                                    marginTop: 45
                                },
                                plot: {
                                    aspect: "spline",
                                    alphaArea: 0.6
                                },
                                plotarea: {
                                    margin: "dynamic"
                                },
                                tooltip: { visible: true },
                                scaleY: {
                                    short: true,
                                    shortUnit: '',
                                    lineColor: "#AAA5A5",
                                    tick: {
                                        lineColor: "#AAA5A5"
                                    },
                                    item: {
                                        fontColor: "#616161",
                                        paddingRight: 5
                                    },
                                    guide: {
                                        lineStyle: "dotted",
                                        lineColor: "#AAA5A5"
                                    },
                                    label: {
                                        text: "Total Sale",
                                        fontColor: "#616161"
                                    }
                                },
                                scaleX: {
                                    lineColor: "#AAA5A5",
                                    labels: labels,
                                    tick: {
                                        lineColor: "#AAA5A5"
                                    },
                                    item: {
                                        fontColor: "#616161",
                                        paddingTop: 5
                                    },
                                    label: {
                                        text: "2019",
                                        fontColor: "#616161"
                                    }
                                },
                                crosshairX: {
                                    lineColor: "#AAA5A5",
                                    plotLabel: {
                                        backgroundColor: "#EBEBEC",
                                        borderColor: "#AAA5A5",
                                        borderWidth: 2,
                                        borderRadius: 2,
                                        thousandsSeparator: ',',
                                        fontColor: '#616161'
                                    },
                                    scaleLabel: {
                                        backgroundColor: "#EBEBEC",
                                        borderColor: "#AAA5A5",
                                        fontColor: "#424242"
                                    }
                                },
                                series: [
                                    {
                                        values: totalSale,
                                        text: "Total Sale",
                                        backgroundColor: "#077a46",
                                        lineColor: "#077a46",
                                        marker: {
                                            backgroundColor: "#077a46",
                                            borderColor: "#077a46"

                                        }
                                    }
                                ]
                            };

                            zingchart.render({
                                id: 'myChart',
                                data: myConfig,
                            });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            }

        }]);
