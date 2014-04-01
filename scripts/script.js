//header module below 

var headerModule = (function() {
	
	var $search_form = $("#search_form");
	var $search_button = $("#search_form #search_button");
	var $search_input = $("#search_form #keyword");
	
	var search_input = function(){
	
		$search_input.focus(function(){
			$(this).css({
				"border": "1px solid #4285F4"
			});
		}).blur(function(){
			$(this).css({
				"border": "1px solid #CCCCCC"
			});
		});
		
	};
	
	var search_submit = function() {	
		$search_button.click(function(){
			$search_form.trigger("submit");
		});
	};
	
	return {
		search_input: 	search_input,
		search_submit:	search_submit
	}
	
})()

// execute header module below 

headerModule.search_input();
headerModule.search_submit();

// popup module below 

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
	
	var $global_json_path = $("#global_json_path").val();
	var $current_url = $("#current_url").val();
	
	var add_click = function() {
		$add_button.click(function(){
			var module = $global_json_path + $(this).val();
			console.log(module);
			//window.location = module;
			window.history.pushState("Module Location", "Module Location", module); 
			$popup_container.fadeIn('fast');
			return false;
		}); 
	};
	
	var close_click = function() {
		$popup_close.click(function(){
			$clear_button.trigger('click');
			window.history.pushState("Standard Location", "Standard Location", $current_url); 
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

// login module below 

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

// delete module below 

var deleteModule = (function() {
	
	// extend check and uncheck function below 
	
	jQuery.fn.extend({
		check: function() {
			return this.each(function() { this.checked = true; });
		},
		uncheck: function() {
			return this.each(function() { this.checked = false; });
		}
	});
	
	var $main_check = $("#delete_form .main_check");
	var $sub_check = $("#delete_form .sub_check");

	var execute_checkbox = function() {
		
		$main_check.click(function() {
			if($(this).is(":checked")) {
				$sub_check.check();
			} else {
				$sub_check.uncheck();
			}
		});
		
		$sub_check.click(function(){
			
			if($("#delete_form .sub_check:checked").length === $("#delete_form .sub_check").length) {
				$main_check.check();
			} else {
				$main_check.uncheck();
			}
			
			console.log('click sub');
			
			
		});
		
	};
	
	return {
		execute_checkbox:	execute_checkbox
	}
	
})()

// execute deleteModule below 

deleteModule.execute_checkbox();

// dropdown module below 

var dropdownModule = (function() {
	
	var $first_level_li = $(".dropdown li");
	var $second_level_ul = $(".dropdown li ul");
	
	var second_level_actions = function() {
		
		$first_level_li.mouseenter(function(){
			$(this).children("ul").slideDown("fast");
		});
		
		$second_level_ul.mouseleave(function(){
			$(this).fadeOut("fast");
		});
		
	
	};
	
	return {
		second_level_actions: second_level_actions
	}
	
})()

// execute dropdown module below 

dropdownModule.second_level_actions();






















