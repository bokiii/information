"use strict";

var controllers = angular.module('information.controllers', []);

controllers.controller('StudentAcademicCtrl', function($scope, $http){
	
	var protocol = window.location.protocol + "//" + window.location.host;
	var fullUrl = protocol + window.location.pathname + window.location.search;
	
	// below is for getting the subjects
	//var studentAcademicUrl = fullUrl.replace("manage_students", "get_student_academic_data_via_angular");
	//var studentAcademicUrl = fullUrl.replace("manage_students", "get_student_academic_data_group_by_school_year");
	var studentAcademicUrl = fullUrl.replace("manage_students", "get_student_academic_data_group_by_school_year_and_term_id");
	
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
		if(data.file_name == null) {
			data.file_name = "blank.png";
		}
		
		$scope.mainData = data;   
	
	});
	
	$scope.getMainData = function(){
		$http.get(studentMainDataUrl).success(function(data){
			if(data.file_name == null) {
				data.file_name = "blank.png";
			}
			$scope.mainData = data;
		});
	};   

});

controllers.controller('StudentAccessAcademicCtrl', function($scope, $http){
	
	var protocol = window.location.protocol + "//" + window.location.host;
	var fullUrl = protocol + window.location.pathname + window.location.search;        

	// below is for getting the subjects
	//var studentAcademicUrl = fullUrl + "/get_student_academic_data_via_angular";   
	var studentAcademicUrl = fullUrl + "/get_student_academic_data_group_by_school_year_and_term_id";
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
	
	var studentMainDataUrl = fullUrl + "/get_student_main_data_via_angular";  
	$scope.mainData;
	
	$http.get(studentMainDataUrl).success(function(data){
		if(data.file_name == null) {
			data.file_name = "blank.png";
		}
		
		$scope.mainData = data;      
	});
	
	$scope.getMainData = function(){
		$http.get(studentMainDataUrl).success(function(data){
			if(data.file_name == null) {
				data.file_name = "blank.png";
			}
			$scope.mainData = data;
		});
	};
	
});

























