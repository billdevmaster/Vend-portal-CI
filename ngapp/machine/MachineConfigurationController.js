app.controller('MachineConfigurationController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.isFnbManager = $rootScope.isFnbManager;
            $scope.screensaverOptions = ["Enable", "Disable"];
            $scope.modeOptions = ["Single Banner Mode", "Dual Banner Mode", "Top Banner Ads Mode", "Full Screen Ads Mode", "Full Screen Slideshow Mode", "Keypad Vend Mode"];
            $scope.advertisementModeOptions = ["Continuous Advertisement", "Fragmented Advertisement"];
            $scope.infoButtonOptions = ["Enable", "Disable"];
            $scope.volumeControlOptions = ["Enable", "Disable"];
            $scope.wheelChairOptions = ["Enable", "Disable"];
            $scope.feedOptions = ["Enable", "Disable"];
            $scope.gameOptions = ["Enable", "Disable"];
            $scope.gameNameOptions = ["Memory Game", "Wheel Game"];
            $scope.assetTracking = ["Enable", "Disable"];
            $scope.advertisementReporting = ["Enable", "Disable"];
            $scope.helplineOptions = ["Enable", "Disable"];
            $scope.receiptOptions = ["Enable", "Disable"];
            $scope.advertisementTypeOptions = ["Video", "Image"];
            $scope.passcodeScreenOptions = ["Enable", "Disable"];
            $scope.jobNumberScreenOptions = ["Enable", "Disable"];
            $scope.screenSizeOptions = ["7 inch", "10 inch", "22 inch", "32 inch", "50 inch"];
            $scope.screenOrientationOptions = ["Portrait", "Landscape"];
            $scope.costCenterOptions = ["Enable", "Disable"];
            $scope.giftOptions = ["Enable", "Disable"];
            $scope.newsletterOptions = ["Enable", "Disable"];
            $scope.machineCategoryTypeOptions = ["Single Category", "Multiple Categories"];
            $http.get('/index.php/Machine_controller/getCurrentData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.machine = result.data;
                        console.log($scope.machine);
                        $scope.mode = $scope.modeOptions[$scope.machine.machine_mode - 1];
                        $scope.advertisement_mode = $scope.advertisementModeOptions[$scope.machine.machine_advertisement_mode - 1];

                        if ($scope.machine.screen_size === "7 inch") {
                            $scope.screen_size = $scope.screenSizeOptions[0];
                        }
                        else if ($scope.machine.screen_size === "10 inch") {
                            $scope.screen_size = $scope.screenSizeOptions[1];
                        }
                        else if ($scope.machine.screen_size === "22 inch") {
                            $scope.screen_size = $scope.screenSizeOptions[2];
                        }
                        else if ($scope.machine.screen_size === "32 inch") {
                            $scope.screen_size = $scope.screenSizeOptions[3];
                        }
                        else if ($scope.machine.screen_size === "50 inch") {
                            $scope.screen_size = $scope.screenSizeOptions[4];
                        }

                        if ($scope.machine.screen_orientation === "Portrait") {
                            $scope.screen_orientation = $scope.screenOrientationOptions[0];
                        }
                        else if ($scope.machine.screen_orientation === "Landscape") {
                            $scope.screen_orientation = $scope.screenOrientationOptions[1];
                        }

                        if ($scope.machine.machine_is_game_enabled == "1") {
                            $scope.game = $scope.gameOptions[0];
                        }
                        else {
                            $scope.game = $scope.gameOptions[1];
                        }

                        if ($scope.machine.machine_passcode_screen == "1") {
                            $scope.passcode_screen = $scope.passcodeScreenOptions[0];
                        }
                        else {
                            $scope.passcode_screen = $scope.passcodeScreenOptions[1];
                        }

                        if ($scope.machine.machine_is_job_number_enabled == "1") {
                            $scope.job_number_screen = $scope.jobNumberScreenOptions[0];
                        }
                        else {
                            $scope.job_number_screen = $scope.jobNumberScreenOptions[1];
                        }

                        if ($scope.machine.machine_is_cost_center_enabled == "1") {
                            $scope.cost_center = $scope.costCenterOptions[0];
                        }
                        else {
                            $scope.cost_center = $scope.costCenterOptions[1];
                        }

                        if ($scope.machine.machine_is_gift_enabled == "1") {
                            $scope.gift = $scope.giftOptions[0];
                        }
                        else {
                            $scope.gift = $scope.giftOptions[1];
                        }

                        if ($scope.machine.newsletter_enabled == "1") {
                            $scope.newsletter = $scope.newsletterOptions[0];
                        }
                        else {
                            $scope.newsletter = $scope.newsletterOptions[1];
                        }

                        $scope.advertisement_type = $scope.advertisementTypeOptions[$scope.machine.advertisement_type - 1];


                        if ($scope.machine.machine_volume_control_enabled == "1") {
                            $scope.volume_control = $scope.volumeControlOptions[0];
                        }
                        else {
                            $scope.volume_control = $scope.volumeControlOptions[1];
                        }

                        if ($scope.machine.machine_wheel_chair_enabled == "1") {
                            $scope.wheel_chair = $scope.wheelChairOptions[0];
                        }
                        else {
                            $scope.wheel_chair = $scope.wheelChairOptions[1];
                        }

                        if ($scope.machine.machine_is_feed_enabled == "1") {
                            $scope.feed = $scope.feedOptions[0];
                        }
                        else {
                            $scope.feed = $scope.feedOptions[1];
                        }

                        if ($scope.machine.machine_info_button_enabled == "1") {
                            $scope.info_button = $scope.infoButtonOptions[0];
                        }
                        else {
                            $scope.info_button = $scope.infoButtonOptions[1];
                        }

                        if ($scope.machine.machine_screensaver_enabled == "1") {
                            $scope.screensaver = $scope.screensaverOptions[0];
                        }
                        else {
                            $scope.screensaver = $scope.screensaverOptions[1];
                        }

                        $scope.game_name = $scope.gameNameOptions[$scope.machine.machine_game - 1];

                        if ($scope.machine.machine_is_asset_tracking == "1") {
                            $scope.asset_tracking = $scope.assetTracking[0];
                            $scope.showPasscodeSection = true;
                        }
                        else {
                            $scope.asset_tracking = $scope.assetTracking[1];
                            $scope.showPasscodeSection = false;
                        }

                        if ($scope.machine.machine_is_advertisement_reporting == "1") {
                            $scope.advertisement_reporting = $scope.advertisementReporting[0];
                        }
                        else {
                            $scope.advertisement_reporting = $scope.advertisementReporting[1];
                        }


                        if ($scope.machine.machine_helpline_enabled == "1") {
                            $scope.helpline = $scope.helplineOptions[0];
                        }
                        else {
                            $scope.helpline = $scope.helplineOptions[1];
                        }

                        if ($scope.machine.receipt_enabled == "1") {
                            $scope.receipt = $scope.receiptOptions[0];
                        }
                        else {
                            $scope.receipt = $scope.receiptOptions[1];
                        }

                        if ($scope.machine.machine_is_single_category == "1") {
                            $scope.machine_category_type = $scope.machineCategoryTypeOptions[0];
                            $scope.currentMachineCategoryType = $scope.machineCategoryTypeOptions[0];
                        }
                        else {
                            $scope.machine_category_type = $scope.machineCategoryTypeOptions[1];
                            $scope.currentMachineCategoryType = $scope.machineCategoryTypeOptions[1];
                        }

                        $scope.helpline_text = $scope.machine.machine_helpline;
                        $scope.customer_care_text = $scope.machine.machine_customer_care_number;
                        $scope.serial_port_number = $scope.machine.serial_port_number;
                        $scope.serial_port_speed = $scope.machine.serial_port_speed;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                });

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        $window.localStorage.setItem('token', null);
                        location.href = '/#/logout'
                    });
            }

            $scope.machineCategoryChange = function () {
                if ($scope.currentMachineCategoryType == $scope.machine_category_type) {
                    $scope.machine_category_type_message = "";
                }
                else {
                    $scope.machine_category_type_message = "Existing Product Planogram would be reset";
                }
            }

            $scope.machineCategoryChangeApiCall = function () {
                if ($scope.currentMachineCategoryType != $scope.machine_category_type) {
                    var fd = new FormData();
                    fd.append('machine_id', $scope.machine.id);
                    $http.post('/index.php/Machine_controller/resetMachineMapByMachineIdValue', fd, {
                        transformRequest: angular.identity,
                        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                    })
                        .success(function (result) {
                            if (result.code == 200) {
                                console.log('Machine Reset Successfully');
                            }
                            else if (result.code == 401) {
                                $scope.logout();
                            }
                        })
                        .error(function () {
                            console.log('Machine Reset Failed');
                        });

                }
            }

            $scope.assetTrackingChange = function () {
                if ($scope.asset_tracking == $scope.assetTracking[0]) {
                    $scope.showPasscodeSection = true;
                }
                else if ($scope.asset_tracking == $scope.assetTracking[1]) {
                    $scope.showPasscodeSection = false;
                }
            }

            $scope.saveMachineConfiguration = function () {
                var fd = new FormData();

                if ($scope.mode == $scope.modeOptions[0]) {
                    $scope.modeIndex = 1;
                }
                else if ($scope.mode == $scope.modeOptions[1]) {
                    $scope.modeIndex = 2;
                }
                else if ($scope.mode == $scope.modeOptions[2]) {
                    $scope.modeIndex = 3;
                }
                else if ($scope.mode == $scope.modeOptions[3]) {
                    $scope.modeIndex = 4;
                }
                else if ($scope.mode == $scope.modeOptions[4]) {
                    $scope.modeIndex = 5;
                }
                else if ($scope.mode == $scope.modeOptions[5]) {
                    $scope.modeIndex = 6;
                }

                if ($scope.advertisement_mode == $scope.advertisementModeOptions[0]) {
                    $scope.adIndex = 1;
                }
                else if ($scope.advertisement_mode == $scope.advertisementModeOptions[1]) {
                    $scope.adIndex = 2;
                }

                if ($scope.advertisement_type == $scope.advertisementTypeOptions[0]) {
                    $scope.adTypeIndex = 1;
                }
                else if ($scope.advertisement_type == $scope.advertisementTypeOptions[1]) {
                    $scope.adTypeIndex = 2;
                }

                if ($scope.game == $scope.gameOptions[0]) {
                    $scope.gameIndex = 1;
                }
                else if ($scope.game == $scope.gameOptions[1]) {
                    $scope.gameIndex = 0;
                }

                if ($scope.volume_control == $scope.volumeControlOptions[0]) {
                    $scope.volumeIndex = 1;
                }
                else if ($scope.volume_control == $scope.volumeControlOptions[1]) {
                    $scope.volumeIndex = 0;
                }

                if ($scope.wheel_chair == $scope.wheelChairOptions[0]) {
                    $scope.wheelChairIndex = 1;
                }
                else if ($scope.wheel_chair == $scope.wheelChairOptions[1]) {
                    $scope.wheelChairIndex = 0;
                }

                if ($scope.feed == $scope.feedOptions[0]) {
                    $scope.feedIndex = 1;
                }
                else if ($scope.feed == $scope.feedOptions[1]) {
                    $scope.feedIndex = 0;
                }

                if ($scope.info_button == $scope.infoButtonOptions[0]) {
                    $scope.infoButtonIndex = 1;
                }
                else if ($scope.info_button == $scope.infoButtonOptions[1]) {
                    $scope.infoButtonIndex = 0;
                }

                if ($scope.screensaver == $scope.screensaverOptions[0]) {
                    $scope.screensaverIndex = 1;
                }
                else if ($scope.screensaver == $scope.screensaverOptions[1]) {
                    $scope.screensaverIndex = 0;
                }

                if ($scope.game_name == $scope.gameNameOptions[0]) {
                    $scope.gameNameIndex = 1;
                }
                else if ($scope.game_name == $scope.gameNameOptions[1]) {
                    $scope.gameNameIndex = 2;
                }

                if ($scope.asset_tracking == $scope.assetTracking[0]) {
                    $scope.assetTrackingIndex = 1;
                }
                else if ($scope.asset_tracking == $scope.assetTracking[1]) {
                    $scope.assetTrackingIndex = 0;
                }

                if ($scope.advertisement_reporting == $scope.advertisementReporting[0]) {
                    $scope.advertisementReportingIndex = 1;
                }
                else if ($scope.advertisement_reporting == $scope.advertisementReporting[1]) {
                    $scope.advertisementReportingIndex = 0;
                }


                if ($scope.helpline == $scope.helplineOptions[0]) {
                    $scope.helplineIndex = 1;
                }
                else if ($scope.helpline == $scope.helplineOptions[1]) {
                    $scope.helplineIndex = 0;
                }

                if ($scope.receipt == $scope.receiptOptions[0]) {
                    $scope.receiptIndex = 1;
                }
                else if ($scope.receipt == $scope.receiptOptions[1]) {
                    $scope.receiptIndex = 0;
                }

                if ($scope.passcode_screen == $scope.passcodeScreenOptions[0]) {
                    $scope.passcodeScreenIndex = 1;
                }
                else if ($scope.passcode_screen == $scope.passcodeScreenOptions[1]) {
                    $scope.passcodeScreenIndex = 0;
                }

                if ($scope.job_number_screen == $scope.jobNumberScreenOptions[0]) {
                    $scope.jobNumberScreenIndex = 1;
                }
                else if ($scope.job_number_screen == $scope.jobNumberScreenOptions[1]) {
                    $scope.jobNumberScreenIndex = 0;
                }

                if ($scope.cost_center == $scope.costCenterOptions[0]) {
                    $scope.costCenterIndex = 1;
                }
                else if ($scope.cost_center == $scope.costCenterOptions[1]) {
                    $scope.costCenterIndex = 0;
                }

                if ($scope.machine_category_type == $scope.machineCategoryTypeOptions[0]) {
                    $scope.machineCategoryTypeIndex = 1;
                }
                else if ($scope.machine_category_type == $scope.machineCategoryTypeOptions[1]) {
                    $scope.machineCategoryTypeIndex = 0;
                }

                if ($scope.newsletter == $scope.newsletterOptions[0]) {
                    $scope.newsletterIndex = 1;
                }
                else if ($scope.newsletter == $scope.newsletterOptions[1]) {
                    $scope.newsletterIndex = 0;
                }

                if ($scope.gift == $scope.giftOptions[0]) {
                    $scope.receiptIndex = 1;
                    $scope.newsletterIndex = 1;
                    $scope.giftIndex = 1;
                }
                else if ($scope.gift == $scope.giftOptions[1]) {
                    $scope.giftIndex = 0;
                }

                console.log($scope.game_name);
                console.log($scope.gameNameIndex);

                fd.append('machine_mode', $scope.modeIndex);
                fd.append('machine_passcode_screen', $scope.passcodeScreenIndex);
                fd.append('advertisement_type', $scope.adTypeIndex);
                fd.append('machine_advertisement_mode', $scope.adIndex);
                fd.append('screen_size', $scope.screen_size);
                fd.append('screen_orientation', $scope.screen_orientation);
                fd.append('machine_is_game_enabled', $scope.gameIndex);
                fd.append('machine_game', $scope.gameNameIndex);
                fd.append('machine_info_button_enabled', $scope.infoButtonIndex);
                fd.append('machine_screensaver_enabled', $scope.screensaverIndex);
                fd.append('machine_volume_control_enabled', $scope.volumeIndex);
                fd.append('machine_wheel_chair_enabled', $scope.wheelChairIndex);
                fd.append('machine_is_asset_tracking', $scope.assetTrackingIndex);
                fd.append('machine_is_advertisement_reporting', $scope.advertisementReportingIndex);
                fd.append('machine_wheel_chair_enabled', $scope.wheelChairIndex);
                fd.append('machine_is_feed_enabled', $scope.feedIndex);
                fd.append('machine_helpline', $scope.helpline_text);
                fd.append('machine_customer_care_number', $scope.customer_care_text);
                fd.append('machine_helpline_enabled', $scope.helplineIndex);
                fd.append('receipt_enabled', $scope.receiptIndex);
                fd.append('machine_id', $scope.machine.id);
                fd.append('serial_port_number', $scope.serial_port_number);
                fd.append('serial_port_speed', $scope.serial_port_speed);
                fd.append('machine_is_job_number_enabled', $scope.jobNumberScreenIndex);
                fd.append('machine_is_cost_center_enabled', $scope.costCenterIndex);
                fd.append('machine_is_gift_enabled', $scope.giftIndex);
                fd.append('newsletter_enabled', $scope.newsletterIndex);
                fd.append('machine_is_single_category', $scope.machineCategoryTypeIndex);


                $http.post('/index.php/Machine_controller/configureMachine', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            console.log('Machine Configured Successfully');
                            $scope.machineCategoryChangeApiCall();
                            location.href = '/#/machine'
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }


                    })
                    .error(function () {
                        console.log('Machine Configuration Failed');
                    });

            }

        }]);
