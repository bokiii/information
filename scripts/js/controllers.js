'use strict';

var controllers = angular.module('information.controllers', []);

/*
var protocol = window.location.protocol + "/";
var fullUrl = protocol + window.location.pathname + window.location.search;

window.location.protocol = "http:"
window.location.host = "css-tricks.com"
window.location.pathname = "example/index.html"
*/


controllers.controller('StudentAcademicCtrl', function($scope, $http){
	
	var protocol = window.location.protocol + "//" + window.location.host;
	var fullUrl = protocol + window.location.pathname + window.location.search;
	var fixedFullUrl = fullUrl.replace("manage_students", "get_student_academic_data_via_angular");
	
	$scope.subjects;
	
	$http.get(fixedFullUrl).success(function(data){
		$scope.subjects = data.subjects;
	});
	
	$scope.getSubjects = function() {
		
		$http.get(fixedFullUrl).success(function(data){
			$scope.subjects = data.subjects;
		});
	}

});


























