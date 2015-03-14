"use strict";

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
	
	// below is for getting the subjects
	var studentAcademicUrl = fullUrl.replace("manage_students", "get_student_academic_data_via_angular");
	$scope.subjects;
	
	$http.get(studentAcademicUrl).success(function(data){
		$scope.subjects = data.subjects;
	});
	
	$scope.getSubjects = function() {
		$http.get(studentAcademicUrl).success(function(data){
			$scope.subjects = data.subjects;
		});
	};
	
	// below is for getting the main data
	var studentMainDataUrl = fullUrl.replace("manage_students", "get_student_main_data_via_angular");
	$scope.mainData;
	
	$http.get(studentMainDataUrl).success(function(data){
		$scope.mainData = data;
	});
	
	$scope.getMainData = function(){
		$http.get(studentMainDataUrl).success(function(data){
			$scope.mainData = data;
		});
	};
	
});


























