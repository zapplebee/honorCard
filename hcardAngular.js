var app = angular.module('honorCard', ['ngRoute','ngCookies']);

app.directive('focusOn', function() {
  return {
    link: function(scope, element, attrs) {
      scope.$watch(attrs.focusOn, function(value) {
        if(value === true) { 
 
            element[0].focus();

        }
      });
    }
  };
});

app.config(['$routeProvider',function($routeProvider){

  $routeProvider
    .when('/login', {
      templateUrl : "templates/login.html",
      controller :  "loginCtrl"  
    })
  $routeProvider
    .when('/lobby', {
      templateUrl : "templates/lobby.html",
      controller :  "lobbyCtrl"  
    })
  $routeProvider
    .when('/board', {
      templateUrl : "templates/board.html",
      controller :  "boardCtrl"  
    })
  $routeProvider
    .when('/deck', {
      templateUrl : "templates/deck.html",
      controller :  "deckCtrl"  
    })
  $routeProvider
    .when('/stats', {
      templateUrl : "templates/stats.html",
      controller :  "statsCtrl"  
    })
	.otherwise({ redirectTo: '/sales'})

}]);

app.run(function($rootScope, $timeout, $interval, $location, $cookies,api,$window) {


  $rootScope.isLoggedIn = function(){
    return (angular.isDefined($cookies.apitoken));
  }
  
  $rootScope.location = function(){
    return $location.path();
  
  }

  $rootScope.$watch($rootScope.isLoggedIn, function(value){
  
    if(value){

    if($location.path() == "/login"){
        $location.path('/lobby');

      }

		}else{
    
    $location.path('/login');
    
    }

    
  
  });
  

  
  
  $rootScope.redirectToLogin = function(){
    if(!$rootScope.isLoggedIn()){
      $location.path('/login');
    }
  }
  
  $rootScope.redirectToLogin();
  
  $rootScope.$watch($rootScope.location, function(value){
    
    $rootScope.redirectToLogin();
  
  });
  

  


  
  $rootScope.$watch(function(){return $window.innerWidth;}, function(value) {
    
      if(value <= 440){
       
        $rootScope.isMobile = true;
       
      }
      else{
       
        $rootScope.isMobile = false;
       
      }
   });
  


});

app.controller('headerCtrl', function($scope,$location,$rootScope,$cookies,api){

  $scope.checkLocation = function(path){

    return path === $location.path();

  }

  $scope.logout = function(){
  
    api.logout();
  }

});

app.controller('loginCtrl', function($scope,api,$cookies,$cookieStore,$rootScope){


  
	$scope.signup = function(){
  
    api.signup($scope.signUpCreds,checkIfExists);
	
	}
  
  $scope.login = function(){
  
    console.log($scope.loginCreds);
    
    api.login($scope.loginCreds,checkIfValid);
    
    
  
  
  }
  
  checkIfValid = function(response){
  
    console.log(response);
    
    if(angular.isDefined(response.failed)){
    
      console.log("Failed\n" + response.failed);
      
        $scope.loginfailed = response.failed;
    
    }
    
    if(angular.isDefined(response.token)){
    
      console.log("Token\n" + response.token);
      $cookieStore.put('apitoken', response.token);
      $rootScope.authUser = $scope.loginCreds.username;
      delete $scope.loginCreds.password;
    
    }
    
    
    
    }
  
  $scope.$watchCollection('[signUpCreds.password, signUpCreds.passwordConfirm]',function(array){
  if(array[0] === array[1]){
    $scope.signup_form.passwordConfirm.$setValidity("isEqual", true);
  }else
  {
    $scope.signup_form.passwordConfirm.$setValidity("isEqual", false);
  }
  });
  
  $scope.$watchCollection('[signUpCreds.email, signUpCreds.emailConfirm]',function(array){
  if(array[0] === array[1]){
    $scope.signup_form.emailConfirm.$setValidity("isEqual", true);
  }else
  {
    $scope.signup_form.emailConfirm.$setValidity("isEqual", false);
  }
  });
  
  
  checkIfExists = function(response){

    if(angular.isDefined(response.failed)){
    
      console.log("Failed\n" + response.failed);
      
        $scope.failed = response.failed;
    
    }
    
    if(angular.isDefined(response.token)){
    
      console.log("Token\n" + response.token);
      console.log("Token\n" + response.token);
      $rootScope.authUser = $scope.signUpCreds.username;
      $cookieStore.put('apitoken', response.token);
    
    }

      
      
      
  }
  

});


app.controller('lobbyCtrl', function($rootScope,api,$scope){

  $scope.enterGame = function(){
  
  
  }

});

app.controller('boardCtrl', function(){

});

app.controller('deckCtrl', function(){

});

app.controller('statsCtrl', function(){

});





app.service('api', function($rootScope,$cookieStore,$http,$cookies){

  this.login = function(credentials,callback){
    
      $http({
        url:'api/login.php',
        method:'POST',
        data: credentials
      })
      .success(function(data){
        callback(data);

      })
      .error(function(data){
        callback(JSON.parse({failed:"Error with HTTP Service"}));
      });

    }
  
  this.signup = function(credentials,callback){
  
  
      $http({
        url:'api/signup.php',
        method:'POST',
        data: credentials
      })
      .success(function(data){
        callback(data);

      })
      .error(function(data){
        callback({failed:"Error with HTTP Service"});
      });
      
      

  
  
  }

  
  this.logout = function(){

    $cookieStore.remove('apitoken');
    
  }
  
  this.call = function(action,data,callback){

    if(angular.isDefined($cookies.apitoken)){
      $http({
        url:'api/action.php',
        method:'POST',
        data: {"token":$cookies.apitoken,"action":action,"data":data}
      })
      .success(function(response){
        callback(response,true);

      })
      .error(function(data){
        callback(response,false);
        console.log(response);
      });
    
    
    }
  
  
  }

});