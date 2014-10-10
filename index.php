<!DOCTYPE html>
<html ng-app="honorCard">
<head>
  <title>Honor Card</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=440, user-scalable=no">
  <link href='http://fonts.googleapis.com/css?family=Cinzel:400,700,900' rel='stylesheet' type='text/css'>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular-cookies.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular-route.js"></script>
  <script src="hcardAngular.js"></script>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<div ng-controller="headerCtrl">
  <header ng-show="isMobile">
    <h1>Honor Card</h1>
  </header>
  <header>
    <h1 ng-hide="isMobile">Honor Card</h1>
    <a ng-show="isLoggedIn()" href="#/lobby" ng-class="{active:checkLocation('/lobby')}">Lobby</a>
    <a ng-show="isLoggedIn()" href="#/board" ng-class="{active:checkLocation('/board')}">Board</a>
    <a ng-show="isLoggedIn()" href="#/deck" ng-class="{active:checkLocation('/deck')}">Deck</a>
    <a ng-show="isLoggedIn()" href="#/stats" ng-class="{active:checkLocation('/stats')}">Stats</a>
    <a ng-show="isLoggedIn()" ng-click="logout()" class="tail">Log Out</a>
    <a ng-hide="isLoggedIn() || isMobile" class="active tail">Log In</a>  
	</header>
</div>
	
<div id="container" ng-view>
</div>
</body>
</html>