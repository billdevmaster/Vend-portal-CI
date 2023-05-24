app.controller('ApprovalScheduleReportController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        $scope.isClient = $rootScope.isClient;
        $scope.clientId = $rootScope.clientId;

        $http.get('/index.php/Approval_controller/getScheduleReportList', {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
            .success(function (result) {
                if (result.code == 200) {
                    console.log(result);
                    $scope.scheduleReports = result.schedule_report_approval;
                }
                else if (result.code == 401) {
                    $scope.logout();
                }
            });

        $scope.activateScheduleReport = function (scheduleReport) {
            $scope.scheduleReport = scheduleReport;
            var fd = new FormData();
            fd.append('id', $scope.scheduleReport.id);
            fd.append('client_id', $scope.scheduleReport.client_id);
            fd.append('type', $scope.scheduleReport.report_type);
            $http.post('/index.php/Approval_controller/activateScheduleReportList', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/approval/schedule_report'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

                });
        };

        $scope.deactivateScheduleReport = function (scheduleReport) {
            $scope.scheduleReport = scheduleReport;
            var fd = new FormData();
            fd.append('id', $scope.scheduleReport.id);
            fd.append('client_id', $scope.scheduleReport.client_id);
            fd.append('type', $scope.scheduleReport.report_type);
            $http.post('/index.php/Approval_controller/deactivateScheduleReportList', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/approval/schedule_report'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

                });
        };

        $scope.logout = function () {
            $http.get('/index.php/Session_controller/setLoginStatus')
                .success(function (result) {
                    $rootScope.isLoggedIn = false;
                    $window.localStorage.setItem('token', null);
                    location.href = '/#/logout'
                });
        }
    }]);
