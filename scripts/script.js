var headerModule = (function() {
	
	var search_input = function(){
		
		$("#header form #search").focus(function(){
			$(this).css({
				"border": "1px solid #4285F4"
			});
		}).blur(function(){
			$(this).css({
				"border": "1px solid #CCCCCC"
			});
		});
		
	};
	
	return {
		search_input: search_input
	}
	
})()

// execute header module below 

headerModule.search_input();


var popupModule = (function() {
	
	var $add_button = $("#add_button");
	var $popup_container = $("#popup_container");
	var $popup_close = $("#popup_container #popup_content a.close");
	var $clear_button = $("#popup_container #popup_content .clear");
	
	// below are the variables for centering the popup content 
	var $popup_content = $("#popup_container #popup_content");
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popup_content_width = $popup_content.width();
	var popup_content_height = $popup_content.height();
	
	
	var add_click = function() {
	
		$add_button.click(function(){
			$popup_container.fadeIn('fast');
			return false;
		}); 
		
	};
	
	var close_click = function() {
	
		$popup_close.click(function(){
			$clear_button.trigger('click');
			$popup_container.fadeOut('fast');
			return false;
		});
	};
	
	var center_popup = function() {
		$popup_content.css({
			"top": windowHeight/2-popup_content_height/2,
			"left": windowWidth/2-popup_content_width/2
		});
	}
	
	return {
		close_click: 	close_click,
		add_click:		add_click,
		center_popup:	center_popup
	}
	
})()

// execute popup module below 

popupModule.close_click();
popupModule.add_click();
popupModule.center_popup();

var loginModule = (function() {

	var login_input = function() {
	
		$("#content #login .login_input").focus(function(){
			$(this).css({
				"border": "1px solid #4285F4"
			});
		}).blur(function(){
			$(this).css({
				"border": "1px solid #CCCCCC"
			});
		});
	
	};
	
	
	return {
		login_input: 	login_input
	}
	
})()

// Execute login module below 

loginModule.login_input();
























