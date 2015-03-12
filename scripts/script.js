// declare variables for every inputs of the slideshow 
var $term_id = $("#popup_container #popup_content .student_slideshow_form #term_id");
var $first_name = $("#popup_container #popup_content .student_slideshow_form #first_name");
var $last_name = $("#popup_container #popup_content .student_slideshow_form #last_name");
var $middle_name = $("#popup_container #popup_content .student_slideshow_form #middle_name");
var $age = $("#popup_container #popup_content .student_slideshow_form #age");
var $gender = $("#popup_container #popup_content .student_slideshow_form #gender");
var $birth_date = $("#popup_container #popup_content .student_slideshow_form #birth_date");
var $civil_status = $("#popup_container #popup_content .student_slideshow_form #civil_status");
var $religion = $("#popup_container #popup_content .student_slideshow_form #religion");
var $address = $("#popup_container #popup_content .student_slideshow_form #address");
var $school_id = $("#popup_container #popup_content .student_slideshow_form #school_id");
var $course_id_select;
var $subjects;
	
	
// general loading container variable below
var $loading_container = $("#loading_container");

// general loading module below 

var loadingModule = (function() {
	
	// below are the variables for centering the popup content 

	var $loading_content = $("#loading_container #loading_content");
	var windowWidth = window.innerWidth;
	var windowHeight = window.innerHeight;
	var loading_content_width = $loading_content.width();
	var loading_content_height = $loading_content.height();
	
	
	var center_general_loading = function() {
		$loading_content.css({
			"margin-top": windowHeight/2-loading_content_height/2 - 40
		});
	};
	
	return {
		center_general_loading: 	center_general_loading
	}
	
})()

// execute loading module below
loadingModule.center_general_loading();

// jquery ui module below 

var jqueryUi = (function() {
	
	var $popup_content = $("#popup_container #popup_content");
	var $link_add_content = $("#link_add_container #link_add_content");
	
	
	var drag_popup_content = function() {	
		
	
		$popup_content.draggable();
		$link_add_content.draggable();

	};
	
	return {
		drag_popup_content: drag_popup_content
	}
	
})()

// execute jquery ui module below 

jqueryUi.drag_popup_content();


// global script function tools below 

var scroll_to_top = function() {
	$('body').animate({scrollTop: 0}, 'slow');
};

// general module below

var generalModule = (function(){
	
	var $content_h1 = $("#content h1");
	var $content_delete_form = $("#content #delete_form");
	
	var add_full_width = function() {
		$content_h1.addClass('full_width_2');
		$content_delete_form.addClass('full_width_3');
	};
	
	// turn off auto completes below in all of the forms
	
	var autocomple_form_off = function(){
		$(document).ready(function(){
			$(this).find('form').attr("autocomplete", "off");
		});
	};
	
	// add border to every submit button in a page 
	
	var add_border_button = function(){
		$(document).ready(function(){
			var submit_button = "input[type='submit']";
			var buttons = "button";
			
			$(this).find(submit_button).css({
				"border": "1px solid #D7D7D7",
				"cursor": "pointer"
			});
			
			$(this).find(buttons).css({
				"border": "1px solid #D7D7D7",
				"cursor": "pointer"
			});
			
		});
	};
	
	return {
		add_full_width:			add_full_width,
		autocomple_form_off: 	autocomple_form_off,
		add_border_button: 		add_border_button
	}
	
})()

// execute general module below

generalModule.add_full_width();
generalModule.autocomple_form_off();
generalModule.add_border_button();

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
// in this module slideshow of divs for enrolling students exists

var popupModule = (function() {
	
	var $add_button = $("#add_button");
	var $popup_container = $("#popup_container");
	var $popup_close = $("#popup_container #popup_content a.close");
	var $clear_button = $("#popup_container #popup_content .clear");
	
	// option for final actions if there is a slide 
	var $final_actions = $("#popup_container #popup_content form .final_actions");
	
	// below are the variables for centering the popup content 
	var $popup_content = $("#popup_container #popup_content");
	var windowWidth = window.innerWidth;
	var windowHeight = window.innerHeight;
	var popup_content_width = $popup_content.width();
	var popup_content_height = $popup_content.height();
	
	var $global_json_path = $("#global_json_path").val();
	var $current_url = $("#current_url").val();
	
	// variable for has_slide if there is has_slide 
	var $has_slide = $("#popup_container #popup_content .has_slide");
	var $slide_div = $("#popup_container #popup_content form .slide_div");
	var $next = $("#popup_container #popup_content form .switch_actions #next");
	var $prev = $("#popup_container #popup_content form .switch_actions #prev");
	
	var $starting_div = $("#popup_container #popup_content form #starting_div");
	var $first_div = $("#popup_container #popup_content form #first_div");
	var $second_div = $("#popup_container #popup_content form #second_div");
	var $third_div = $("#popup_container #popup_content form #third_div");
	var $fourth_div = $("#popup_container #popup_content form #fourth_div");
	var $fifth_div = $("#popup_container #popup_content form #fifth_div");
	var $end_div = $("#popup_container #popup_content form #end_div");
	
	var $current_div;
	
	// below are for variables having switch actions next and prev
	
	var $slideshow_clear = $("#popup_container #popup_content form .final_actions td #slideshow_clear");
	var slide_number = 1;
	var do_slide;
	
	var add_click = function() {
		
		$add_button.click(function(){
			
			// set date picker 
			
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
				dd='0'+dd
			} 

			if(mm<10) {
				mm='0'+mm
			} 

			date_today = yyyy+'-'+mm+'-'+dd;
	
			var $birth_date = $("#popup_container #popup_content .student_slideshow_form #birth_date");
			
			$birth_date.val(date_today);
			
			$birth_date.datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat:	"yy-mm-dd"
			});
			
			scroll_to_top();
			
			if($(this).val() != "has_switch_actions") {
				var module = $global_json_path + $(this).val();
				window.history.pushState("Module Location", "Module Location", module); 
			}
			
			// set standard css positions for every slide divs 
			/*$starting_div.css("left", "0px");
			$first_div.css("left", "800px");
			$second_div.css("left", "800px");
			$third_div.css("left", "800px");
			$fourth_div.css("left", "800px");
			$fifth_div.css("left", "800px");
			$end_div.css("left", "800px");*/
			
			
			$starting_div.css("display", "none");
			$first_div.css("left", "0px");
			$second_div.css("left", "800px");
			$third_div.css("left", "800px");
			$fourth_div.css("left", "800px");
			$fifth_div.css("left", "800px");
			$end_div.css("left", "800px");
			
			// fadein popup container
			$popup_container.fadeIn('fast', function(){
				
				// below are the statements if the module are having a slide or has_slide
				
				// add current_div class 
				//$starting_div.addClass('current_div');
				$("#popup_container #popup_content form #first_div").addClass('current_div');
				
				// set current div 
				//$current_div = $starting_div;
				$current_div = $("#popup_container #popup_content form #first_div");
				
				// set height to current div
				$has_slide.css({
					"height": $current_div.height() + 80
				});
				
				$prev.hide();
				$next.show();
				
				//----------------------------------------------------------------------------------
				// center the popup, this is for all of the modules 
				$popup_content.css({
					"margin-top": windowHeight/2-$popup_content.height()/2
				});
				
				
			});
		
			return false;
		}); 
		
		// below are the functions for clicking the next and prev button
		$next.click(function(event){
			
			switch (slide_number) {
				/*case 1:
					if($term_id.val() == "") {
						alert("Select Term");
						do_slide = false;
					} else {
						do_slide = true;
					}
					execute_slide(do_slide);
					break;*/
				case 1:
					if($first_name.val() == "" || $last_name.val == "" || $middle_name.val() == "") {
						alert("First name, Last name or Middle name must not be empty");
						do_slide = false;
					} else {
						do_slide = true;
					}
					execute_slide(do_slide);
					break;
				case 2:
					if($age.val() == "" || $gender.val == "" || $birth_date.val() == "" || $civil_status.val() == "" || $religion.val() == "" || $address.val() == "") {
						alert("Age, Gender, Birthdate, Civil Status, Religion, Address  must not be empty");
						do_slide = false;
					} else {
						do_slide = true;
					}
					execute_slide(do_slide);
					
					break;
				case 3:
					if($school_id.val() == "") {
						alert("Select School");
						do_slide = false;
					} else {
						do_slide = true;
					}
					execute_slide(do_slide);
				
					break;
				case 4:
					
					if($course_id_select.val() == "") {
						alert("Select Course");
						do_slide = false;
					} else {
						do_slide = true;
					}
					
					execute_slide(do_slide);
					break;
				case 5:
					var subjects_length = $(document).find(".subjects:checked").length;
					if(subjects_length == 0) {
						alert("Select Subject");
						do_slide = false;
					} else {
						do_slide = true;
					}
					
					execute_slide(do_slide);
					break;
				default:
					execute_slide(true);
			}
			
			return false;
		});
		
		$prev.click(function(event){
			
			slide_number -= 1;
			
			$current_div.animate({"left": "+=800px"}, "slow", function(){
				
				$(this).removeClass('current_div');
				
				$has_slide.css({
					"height": $(this).prev().height() + 80
				});
				
				$(this).prev().animate({"left": "+=800px"}, "slow", function(){
					
					var has_next = $(this).next().hasClass('slide_div');
					var has_prev = $(this).prev().hasClass('slide_div');
					$current_div = $(this);
					check_next_and_prev(has_next, has_prev);
					
				}).addClass('current_div');
			
			});
			
			return false;
		});
		
		function check_next_and_prev(has_next, has_prev) {
			
			if(!has_next && has_prev) {	
				$prev.show();
				$next.hide();
			}
			
			if(has_next && !has_prev) {
				$prev.hide();
				$next.show();
			}
			
			if(has_next && has_prev) {
				$prev.show();
				$next.show();
			}	
			
		}
		
		function execute_slide(do_slide) {
			if(do_slide == true) {
			
				slide_number += 1;
				
				$current_div.animate({"left": "-=800px"}, "slow", function(){
				
					$(this).removeClass('current_div');
					
					$has_slide.css({
						"height": $(this).next().height() + 80
					});
					
					$(this).next().animate({"left": "-=800px"}, "slow", function(){
						
						var has_next = $(this).next().hasClass('slide_div');
						var has_prev = $(this).prev().hasClass('slide_div');
						$current_div = $(this);
						check_next_and_prev(has_next, has_prev);
						
						
					}).addClass('current_div');
				
				});
			
			} 
		}
		
		$slideshow_clear.click(function(){
			alert("trying to click the clear");
			return false;
		});
		
	};
	
	var close_click = function() {
		$popup_close.click(function(){
		
			slide_number = 1;
			// standard actions for close
			$clear_button.trigger('click');
			window.history.pushState("Standard Location", "Standard Location", $current_url); 
			$popup_container.fadeOut('fast');
			
			return false;
		});
	};
	
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
//popupModule.center_popup();

// students slideshow module below 

var studentSlideShowModule = (function() {
	
	// option for final actions if there is a slide 
	var $final_actions = $("#popup_container #popup_content form .final_actions");
	
	var $third_div = $("#popup_container #popup_content form #third_div");
	var $fourth_div = $("#popup_container #popup_content form #fourth_div");
	var $fifth_div = $("#popup_container #popup_content form #fifth_div");
	
	var $course_source = $("#popup_container #popup_content form #third_div #course_source");
	var $school_id = $("#popup_container #popup_content form #third_div #school_id");
	// below will get its value on a ajax generated content 
	var $subject_source;
	var $course_id;
	
	// below is the variable for student slide show for submission
	var $student_slideshow_form = $("#popup_container #popup_content .student_slideshow_form");
	
	var get_courses_by_school_id = function() {
	
		$third_div.on('change', function(){
			
			$.get($course_source.val() + "?id=" + $school_id.val(), function(data){
				var datas = eval('msg=' + data);
				$fourth_div.html(datas.courses);
				
				$course_id_select = $(document).find("#course_id");
			});

		});
		
	};
	
	var get_subjects_by_course_id = function() {
		
		$fourth_div.change(function(){
			
			$subject_source = $(this).find("#subject_source").val();
			$course_id = $(this).find("#course_id").val();
		
			$.get($subject_source + "?id=" + $course_id, function(data){
				
			
				var datas = eval('msg=' + data);
				
				$fifth_div.children("div").html(datas.subjects);
				
				// set the css design
				
				/*$fifth_div.find('div').css({
					"padding": "10px"
				});
				
				$fifth_div.find('h2').css({
					"text-align": "center",
					"font-weight": "bold"
				});
				
				$fifth_div.find('p').css({
					"display": "inline-block",
					"margin-top": "20px"
				});
				
				$fifth_div.find('.center').css({
					"display": "block",
					"text-align": "center"
				});
				
				$fifth_div.find('input').css({
					"margin": "0px 10px 0px 20px"
				});*/
				
				
				
				// set the subjects value 
				//$subjects = $(document).find(".subjects");
				
			});
			
		});
		
	};
	
	return {
		get_courses_by_school_id:	 get_courses_by_school_id,
		get_subjects_by_course_id:	 get_subjects_by_course_id
	}
	
})()

// execute studentSlideShowModule 

studentSlideShowModule.get_courses_by_school_id();
studentSlideShowModule.get_subjects_by_course_id();


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
			
			/*$yes.click(function() {
				$delete_form.trigger('submit');
			});*/
			
			$(document).on('click', '#yes_or_no_container #yes_or_no_content div #yes', function(){
				$delete_form.trigger('submit');
			});
			
			/*$no.click(function() {
				$yes_or_no_container.fadeOut('fast');
			});*/
			
			$(document).on('click', '#yes_or_no_container #yes_or_no_content div #no', function(){
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
	
	// prompt below 
	var $prompt_container = $("#prompt_container");
	var $prompt_content = $("#prompt_container #prompt_content");
	var $prompt_close = $("#prompt_container #prompt_content a.close");
	
	// yes or no below 
	var $yes_or_no_container = $("#yes_or_no_container");
	var $yes_or_no_content = $("#yes_or_no_container #yes_or_no_content");
	var $yes_or_no_close = $('#yes_or_no_container #yes_or_no_content a.close');
	
	// variables for centering
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
		$(document).on('click', '#yes_or_no_container #yes_or_no_content a.close', function(){
			
			$yes_or_no_container.fadeOut('fast', function(){
				$(this).children().html("<a class='close' href='#'>&#215;</a><h1>Are you sure?</h1><div><button id='yes'>Yes</button><button id='no'>No</button></div>");
			});
		
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

// link add module below 

var linkAddModule = (function() {

	var windowHeight = window.innerHeight;

	var $link_add = $("a.link_add");
	
	var $link_add_container = $("#link_add_container");
	var $link_add_content = $("#link_add_container #link_add_content");
	var $link_add_close = $("#link_add_container #link_add_content a.close");
	var $link_add_form = $("#link_add_container #link_add_content div form");
	
	var link_add_click = function() {
		$link_add.click(function(event){
			//alert(event.target.id);
			scroll_to_top();
			$link_add_container.fadeIn('fast', function(){
				// center the popup
				$link_add_content.css({
					"margin-top": windowHeight/2-$link_add_content.height()/2
				});
			});
			
			$link_add_form.append("<input type='hidden' name='sub_id' value='" + event.target.id + "' />");               
			return false;
		});
	};
	
	var link_add_close = function() {
		$link_add_close.click(function(){
			$link_add_container.fadeOut('fast');
			return false;
		});
	};
	
	return {
		link_add_click: 	link_add_click,
		link_add_close:		link_add_close
	}
	
})()


// execute link add module below 

linkAddModule.link_add_click();
linkAddModule.link_add_close();
 
// manage module below 

var manageModule = (function() {
	
	var $manage_link = $("#delete_form .manage_link");
	var $yes_or_no_container = $("#yes_or_no_container");
	
	var manage_link_click = function() {
		$manage_link.click(function(){
		
			var has_link_add = $(this).parent().prev().children().hasClass('link_add');
			
			if(has_link_add) {
				scroll_to_top();
				$yes_or_no_container.children().html("<a class='close' href='#'>&#215;</a><h1>Reminder</h1><div><p>Update necessary updates first.</p></div>");
				$yes_or_no_container.fadeIn('fast');
				
				return false;
				
			} else {
				return true;
			}
			
		});
	};
	
	return {
		manage_link_click: manage_link_click
	}
	
})()

// execute manage module below 

manageModule.manage_link_click();

// below is for manage students module

var manageStudents = (function() {
	
	// below are the variables for the adding subject popup
	var $popup_container = $("#popup_container");
	$add_subject = $("#add_subject");
	var $popup_content = $("#popup_container #popup_content");
	var windowHeight = window.innerHeight;
	var $subject_source;
	var $course_id;
	
	
	// below are variables for main_data_form 
	var $main_data_form = $("#content #main_data_form");
	var $main_data_form_submit_button = $("#content #main_data_form input[type='submit']");
	var $main_data_form_reset_button = $("#content #main_data_form input[type='reset']");
	var $main_data_form_cancel_button = $("#content #main_data_form button.cancel");
	var $main_data_form_input = $("#content #main_data_form tr td:nth-child(even) input");
	var $main_data_form_edit = $("#content #main_data_form img.edit");
	
	// below are for variables of academic_data_form
	
	var $academic_data_form = $("#content #academic_data_form");
	var $academic_data_form_submit_button = $("#content #academic_data_form input[type='submit']");

	var $academic_data_form_reset_button = $("#content #academic_data_form input[type='reset']");
	var $academic_data_form_cancel_button = $("#content #academic_data_form .academic_cancel");
	var $academic_data_form_input = $("#content #academic_data_form input");
	
	var $academic_data_form_edit = $("#content #academic_data_form img.edit");
	
	// below is for the delete features 
	
	// extend check and uncheck function below 
	
	jQuery.fn.extend({
		check: function() {
			return this.each(function() { this.checked = true; });
		},
		uncheck: function() {
			return this.each(function() { this.checked = false; });
		}
	});
	
	// below are the variables for the checkboxes
	
	var $main_check = $("#content #academic_data_form .main_check");
	var $sub_check = $("#content #academic_data_form .subcheck");
	
	var execute_delete_checkbox = function() {
		
		$(document).on('click', '#content #academic_data_form .main_check', function(){
			if($(this).is(":checked")) {
				$(document).find("#content #academic_data_form .subcheck").check();
			} else {
				$(document).find("#content #academic_data_form .subcheck").uncheck();
			}
		});
		
		$(document).on('click', '#content #academic_data_form .subcheck', function(){
			if($("#content #academic_data_form .subcheck:checked").length === $("#content #academic_data_form .subcheck").length) {
				$main_check.check();
			} else {
				$main_check.uncheck();
			}
		});
		
	};
	
	var disable_submit_and_cancel_button = function(){
		// below hide for the main data form
		$main_data_form_submit_button.css("display", "none");
		$main_data_form_cancel_button.css("display", "none");
		$main_data_form_reset_button.css("display", "none");
		
		// below hide for the academic data form
		$academic_data_form_submit_button.css("display", "none");
		$academic_data_form_reset_button.css("display", "none");
		$academic_data_form_cancel_button.css("display", "none");
		
	};
	
	// below are for functions of main data form
	
	function main_data_cancel() {
		$main_data_form_submit_button.hide("fast");
		$main_data_form_cancel_button.hide("fast");
		$main_data_form_input.attr("disabled", "disabled");
		
		$main_data_form_input.css({
			"border": "1px solid #A9A9A9",
			"-webkit-border-radius": "0px",
			"moz-border-radius": "0px",
			"border-radius": "0px"
		});
		
		$main_data_form_edit.show("fast");
	}
	
	var main_data_form_edit_click = function() {
		$main_data_form_edit.click(function(){
			$main_data_form_submit_button.show("fast");
			$main_data_form_cancel_button.show("fast");
			$main_data_form_input.removeAttr("disabled");
			
			$main_data_form_input.css({
				"border": "1px solid #51A5E4",
				"-webkit-border-radius": "2px",
				"moz-border-radius": "2px",
				"border-radius": "2px"
			});
			
			$(this).hide("fast");
		});
	};
	
	var main_data_form_cancel_click = function() {
		$main_data_form_cancel_button.click(function(){
			$main_data_form_reset_button.trigger('click');
			main_data_cancel();
			return false;
		});
	};
	
	var main_data_form_submit = function() {
		
		$("#main_data_form").ajaxForm({
			dataType: 'json',
			forceSync: true,
			beforeSubmit: loading,
			success: success_status
		});
		
		function loading() {
			$loading_container.fadeIn('fast');
		}
		
		function success_status(data) {
			$(".student_angular_trigger").trigger('click');
			main_data_cancel();
			$loading_container.fadeOut('fast');
		}
		
	};
	
	// below are for functions of academic data form
	
	function academic_cancel() {
		$academic_data_form_submit_button.hide('fast');
		$academic_data_form_cancel_button.hide('fast');
		$(document).find("#content #academic_data_form input").attr('disabled', 'disabled').css("border", "1px solid #C3C3C3");
		$academic_data_form_edit.show('fast');
	}
	
	var academic_data_form_edit_click = function() {
		
		$academic_data_form_edit.click(function(){
		
			$academic_data_form_submit_button.show('fast');
			$academic_data_form_cancel_button.show('fast');
			$(document).find("#content #academic_data_form input").removeAttr('disabled').css("border", "1px solid #51A5E4");
			
			// exception for enabling the school and course
			$(document).find("#content #academic_data_form #school").attr('disabled', 'disabled').css("border", "1px solid #C3C3C3");
			$(document).find("#content #academic_data_form #course").attr('disabled', 'disabled').css("border", "1px solid #C3C3C3");
			
			
			$(this).hide('fast');
			
		});
	
	};
	
	var academic_data_form_cancel_click = function() {
		$academic_data_form_cancel_button.click(function(){
			
			$academic_data_form_reset_button.trigger('click');
			academic_cancel();
			return false;
			
		});
	};
	
	var academic_data_form_submit = function() {
		
		$("#academic_data_form").ajaxForm({
			dataType: 'json',
			forceSync: true,
			beforeSubmit: loading,
			success: success_status
		});
		
		function loading() {
			$loading_container.fadeIn('fast');
		}
		
		function success_status(data) {
			
			if(data.update_status == true) {
				$(".student_angular_trigger").trigger('click');
				academic_cancel();
				$loading_container.fadeOut('fast');
			}
		
			if(data.delete_status == true) {
				$(".student_angular_trigger").trigger('click');
				academic_cancel();
				$loading_container.fadeOut('fast');
			}
			
			if(data.add_status) {
				alert("Let's execute addition of subjects");
				
				
				$loading_container.fadeOut('fast');
			}
		
		}
	
	};		
	
	
	var add_subject_click = function() {
	
		$add_subject.click(function(){
			
			$popup_container.fadeIn("fast", function(){
				
				$popup_content.css({
					"margin-top": windowHeight/2-$popup_content.height()/2
				});
				
				// now get all the subjects from the course
				$subject_source = $(this).find("#subject_source").val();
                $course_id = $(this).find("#course_id").val();
				
				$.get($subject_source + "?id=" + $course_id, function(data){
					var datas = eval('msg=' + data);
					console.log(datas);
					//$popup_container.children("#subject_popup_form").html(datas);
					
					$(document).find("#subjects_container").html(datas.subjects);
					$(document).find("#subjects_container").append("<input type='submit' value='Add Subject' />");
				});
			
			});
		
			return false;
		});
	
	};
	
	return {
		disable_submit_and_cancel_button: 		disable_submit_and_cancel_button,
		main_data_form_edit_click: 				main_data_form_edit_click,
		main_data_form_cancel_click:			main_data_form_cancel_click,
		main_data_form_submit:					main_data_form_submit,
		academic_data_form_edit_click:			academic_data_form_edit_click,
		academic_data_form_cancel_click:		academic_data_form_cancel_click,
		execute_delete_checkbox:				execute_delete_checkbox,
		academic_data_form_submit:				academic_data_form_submit,
		add_subject_click:						add_subject_click
	}

})()

// execute manage students module below 

manageStudents.disable_submit_and_cancel_button();
manageStudents.main_data_form_edit_click();
manageStudents.main_data_form_cancel_click();
manageStudents.main_data_form_submit();

manageStudents.academic_data_form_edit_click();
manageStudents.academic_data_form_cancel_click();
manageStudents.execute_delete_checkbox();
manageStudents.academic_data_form_submit();

manageStudents.add_subject_click();























