// global script function tools below 

var scroll_to_top = function() {
	$('body').animate({scrollTop: 0}, 'slow');
};


// general module below

var generalModule = (function(){
	
	var $content_h1 = $("#content h1");
	
	var add_full_width_2 = function() {
		$content_h1.addClass('full_width_2');
	};
	
	return {
		add_full_width_2:	add_full_width_2
	}
	
})()

// execute general module below

generalModule.add_full_width_2();


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
	var windowWidth = window.innerWidth;
	var windowHeight = window.innerHeight;
	var popup_content_width = $popup_content.width();
	var popup_content_height = $popup_content.height();
	
	var $global_json_path = $("#global_json_path").val();
	var $current_url = $("#current_url").val();
	
	var add_click = function() {
		$add_button.click(function(){
			scroll_to_top();
			var module = $global_json_path + $(this).val();
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
	
	/*var center_popup_option = function() {
		$popup_content.css({
			"top": windowHeight/2-popup_content_height/2,
			"left": windowWidth/2-popup_content_width/2
		});
	}*/
	
	var center_popup = function() {
		$popup_content.css({
			"margin-top": windowHeight/2-popup_content_height/2
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
	
	var $delete_button = $("#delete_form #delete_button");
	var $delete_form = $("#delete_form");
	var $yes_or_no_container = $("#yes_or_no_container");
	
	var $yes = $("#yes_or_no_container #yes_or_no_content div #yes");
	var $no = $("#yes_or_no_container #yes_or_no_content div #no");

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
			
		});
		
	};
	
	var delete_button_click = function() {
		
		$delete_button.click(function(){
			scroll_to_top();
			$yes_or_no_container.fadeIn('fast');
			
			$yes.click(function() {
				$delete_form.trigger('submit');
			});
			
			$no.click(function() {
				$yes_or_no_container.fadeOut('fast');
			});
			
			return false;
		});
		
	};
	
	return {
		execute_checkbox:		execute_checkbox,
		delete_button_click: 	delete_button_click
	}
	
})()

// execute deleteModule below 

deleteModule.execute_checkbox();
deleteModule.delete_button_click();

// dropdown module below 

var dropdownModule = (function() {
	
	var $first_level_li = $(".dropdown li");
	var $second_level_ul = $(".dropdown li ul");
	
	var second_level_actions = function() {
		
		$first_level_li.mouseenter(function(){
			$(this).siblings("li").children("ul").fadeOut("fast");
			$(this).children("ul").slideDown("fast");
		});
		
		$second_level_ul.mouseleave(function(){
			$(this).fadeOut("fast");
		});
	};
	
	var document_click = function() {
		
		$(document).click(function(e){
			if($(e.target).is('.sub_menu, .sub_menu *:not(.sub_menu li a)')) {
				return false;
			} else {
				$second_level_ul.fadeOut("fast");
			}
		});
		
	};
	
	return {
		second_level_actions: 		second_level_actions,
		document_click: 	 	 	document_click
	}
	
})()

// execute dropdown module below 

dropdownModule.second_level_actions();
dropdownModule.document_click();

// prompt module below

var promptModule = (function() {
	
	var $prompt_container = $("#prompt_container");
	var $prompt_content = $("#prompt_container #prompt_content");
	var $prompt_close = $("#prompt_container #prompt_content a.close");
	
	var $yes_or_no_container = $("#yes_or_no_container");
	var $yes_or_no_content = $("#yes_or_no_container #yes_or_no_content");
	var $yes_or_no_close = $("#yes_or_no_container #yes_or_no_content a.close");
	
	// variables for centering the prompt
	var windowHeight = window.innerHeight;
	var prompt_content_height = $prompt_content.height();
	
	var yes_or_no_content_height = $yes_or_no_content.height();
	
	var close_prompt = function() {
		$prompt_close.click(function(){
			$prompt_container.fadeOut('fast');
			return false;
		});
	};
	
	var center_prompt = function() {
		$prompt_content.css({
			"margin-top": windowHeight/2-prompt_content_height/2
		});
	};
	
	var close_yes_or_no = function() {
		$yes_or_no_close.click(function(){
			$yes_or_no_container.fadeOut('fast');
			return false;
		});
	};
	
	var center_yes_or_no = function() {
		$yes_or_no_content.css({
			"margin-top": windowHeight/2-yes_or_no_content_height/2 - 50
		}); 
	};
	
	return {
		close_prompt: 		close_prompt,
		center_prompt: 		center_prompt,
		close_yes_or_no:	close_yes_or_no,
		center_yes_or_no:	center_yes_or_no
	}
	
})()

// execute prompt module below 

promptModule.close_prompt();
promptModule.center_prompt();
promptModule.close_yes_or_no();
promptModule.center_yes_or_no();
























