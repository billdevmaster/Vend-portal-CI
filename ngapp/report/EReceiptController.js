app.controller('EReceiptController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/EReceipt_controller/getEReceiptDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_ereceipts = result.data;
                            $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            }
            else {
                $http.get('/index.php/EReceipt_controller/getEReceiptData', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_ereceipts = result.data;
                            $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            }

            $scope.startDate = moment().subtract(60, "days");
            $scope.endDate = moment();
            $scope.date = {
                startDate: moment().subtract(60, "days"),
                endDate: moment()
            };

            $scope.filterReport = function () {
                var start = moment($scope.startDate, 'YYYY-MM-DD HH:mm:ss').toDate();
                var end = moment($scope.endDate, 'YYYY-MM-DD HH:mm:ss').toDate();
                $scope.ereceipts = [];
                $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                if ($scope.search_text === undefined) {
                    $scope.search = "";
                }
                else {
                    $scope.search = $scope.search_text.toLowerCase();
                }
                $scope.searchList = $scope.search.split(',');

                angular.forEach($scope.data_ereceipts, function (value, key) {
                    $scope.countFilter = 0;

                    var array = value.date_time.split(' ');
                    var inputDate = new Date(array[0] + " " + array[1] + " " + array[2]);

                    for (var i = 0; i < $scope.searchList.length; i++) {
                        $scope.searchItem = $scope.searchList[i];
                        if (value.machine_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.transaction_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.name.toLowerCase().indexOf($scope.searchItem) > -1 || value.email.toLowerCase().indexOf($scope.searchItem) > -1 || value.mobile_number.toLowerCase().indexOf($scope.searchItem) > -1) {
                            $scope.countFilter++;
                        }
                    }
                    if (start < inputDate && inputDate < end && ($scope.searchList.length == $scope.countFilter || $scope.search_text === undefined)) {
                        $scope.ereceipts.push(value);
                    }
                });
            }

            $scope.download = function ($ereceipt) {
                $http({
                    method: 'GET',
                    url: $ereceipt.url,
                    responseType: 'blob'
                }).then(function (response) {
                    var blob = response.data;
                    startBlobDownload(blob, $ereceipt.url.substr($ereceipt.url.lastIndexOf("/") + 1))
                });
            }

            $scope.$watch('date', function (newDate) {
                $scope.startDate = moment(newDate.startDate._d).format('YYYY-MM-DD HH:mm:ss');
                $scope.endDate = moment(newDate.endDate._d).format('YYYY-MM-DD HH:mm:ss');
                $scope.filterReport();
            }, false);

            function startBlobDownload(dataBlob, suggestedFileName) {
                if (window.navigator && window.navigator.msSaveOrOpenBlob) {
                    // for IE
                    window.navigator.msSaveOrOpenBlob(dataBlob, suggestedFileName);
                } else {
                    // for Non-IE (chrome, firefox etc.)
                    var urlObject = URL.createObjectURL(dataBlob);

                    var downloadLink = angular.element('<a>Download</a>');
                    downloadLink.css('display', 'none');
                    downloadLink.attr('href', urlObject);
                    downloadLink.attr('download', suggestedFileName);
                    angular.element(document.body).append(downloadLink);
                    downloadLink[0].click();

                    // cleanup
                    downloadLink.remove();
                    URL.revokeObjectURL(urlObject);
                }
            }

        }]);
