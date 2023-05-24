app.controller('TransactionController',
    ['$rootScope','$scope','$http','$window',
    function ($rootScope,$scope,$http,$window) {
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        $scope.data=[];
        $scope.filteredData=[];
        $http.get('/index.php/Session_controller/getLoginStatus')
                .success(function(result){
                  console.log("Inside getLoginStatus of homeController");
                  $scope.datas=result;
                    if($scope.datas.loggedin==='true'){
                        $rootScope.isLoggedIn=true;
                        $http.get('/index.php/Transaction_controller/getTransactionData')
                        .success(function(result){
                            $scope.datas=result;
                
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Card No.","Date", "Time", "Store","Amount","Debit","Credit"]);
                            angular.forEach($scope.datas, function(value, key) {
                                $scope.exportData.push([value.card_no,value.date,value.time, value.store,value.amount,value.amount_debit,value.amount_credit]);
                            });   
                        });
                    }
                    else{
                        location.href='/#/'
                    }  
                }); 
    }]);
app.directive('excelExport',
  function () {
    return {
      restrict: 'A',
      scope: {
          fileName: "@",
          data: "&exportData"
      },
      replace: true,
      template: '<button class="btn btn-primary btn-ef btn-ef-3 btn-ef-3c mb-10" ng-click="download()">Export to Excel <i class="fa fa-download"></i></button>',
      link: function (scope, element) {
          
          scope.download = function() {

              function datenum(v, date1904) {
                  if(date1904) v+=1462;
                  var epoch = Date.parse(v);
                  return (epoch - new Date(Date.UTC(1899, 11, 30))) / (24 * 60 * 60 * 1000);
              };
              
              function getSheet(data, opts) {
                  var ws = {};
                  var range = {s: {c:10000000, r:10000000}, e: {c:0, r:0 }};
                  for(var R = 0; R != data.length; ++R) {
                      for(var C = 0; C != data[R].length; ++C) {
                          if(range.s.r > R) range.s.r = R;
                          if(range.s.c > C) range.s.c = C;
                          if(range.e.r < R) range.e.r = R;
                          if(range.e.c < C) range.e.c = C;
                          var cell = {v: data[R][C] };
                          if(cell.v == null) continue;
                          var cell_ref = XLSX.utils.encode_cell({c:C,r:R});
                          
                          if(typeof cell.v === 'number') cell.t = 'n';
                          else if(typeof cell.v === 'boolean') cell.t = 'b';
                          else if(cell.v instanceof Date) {
                              cell.t = 'n'; cell.z = XLSX.SSF._table[14];
                              cell.v = datenum(cell.v);
                          }
                          else cell.t = 's';
                          
                          ws[cell_ref] = cell;
                      }
                  }
                  if(range.s.c < 10000000) ws['!ref'] = XLSX.utils.encode_range(range);
                  return ws;
              };
              
              function Workbook() {
                  if(!(this instanceof Workbook)) return new Workbook();
                  this.SheetNames = [];
                  this.Sheets = {};
              }
               
              var wb = new Workbook(), ws = getSheet(scope.data());
              /* add worksheet to workbook */
              wb.SheetNames.push(scope.fileName);
              wb.Sheets[scope.fileName] = ws;
              var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});

              function s2ab(s) {
                  var buf = new ArrayBuffer(s.length);
                  var view = new Uint8Array(buf);
                  for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
                  return buf;
              }
              
              saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), scope.fileName+'.xlsx');
              
          };
      
      }
    };
  }
);
