/**
 * Created with JetBrains PhpStorm.
 * User: alex
 * Date: 07/03/14
 * Time: 13:35
 * To change this template use File | Settings | File Templates.
 */
var app = angular.module('TerraTest',['ngRoute']);

app.config(function($routeProvider){

$routeProvider.when('/social',{
            templateUrl:'pages/social.html',
            controller: 'SocialCtrl'
        })
    .when('/news',{
        templateUrl: 'pages/news.html',
        controller: 'NewsCtrl'
    });
});

app.controller('MainCtrl', function($scope,$http) {

});

app.controller('SocialCtrl', function($scope,$http) {
    $scope.results = false;
    $scope.students = null;
    $scope.likes = null;

    $http.get('test.php?data=students').success(function(data){
        $scope.students = data;
    });
    $http.get('test.php?data=likes').success(function(data){
        $scope.likes = data;
    });

    $scope.showButtons = function(){
        $scope.buttons = true;
    };

    $scope.case1 = function(){
        $http.get('test.php?data=case1').success(function(data){
            $scope.result = data;
            $scope.results = true;
        });
    };

    $scope.case2 = function(){
        $http.get('test.php?data=case2').success(function(data){
            $scope.result = data;
            $scope.results = true;
        });
    }

    $scope.case3 = function(){
        $http.get('test.php?data=case3').success(function(data){
            $scope.result = data;
            $scope.results = true;
        });
    }

});

app.controller('NewsCtrl', function($scope,$http) {

    $scope.showNews = function(){
         $scope.news = true;
    };

    $http.get('test.php?data=news').success(function(data){
      $scope.lastNews = data;
    });

});
