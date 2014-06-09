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
	
	return {
		add_full_width:	add_full_width
	}
	
})()

// execute general module below

generalModule.add_full_width();


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
	
	var add_click = function() {
		
		$add_button.click(function(){
			scroll_to_top();
			
			if($(this).val() != "has_switch_actions") {
				var module = $global_json_path + $(this).val();
				window.history.pushState("Module Location", "Module Location", module); 
			}
			
			// set standard css positions for every slide divs 
			$starting_div.css("left", "0px");
			$first_div.css("left", "800px");
			$second_div.css("left", "800px");
			$third_div.css("left", "800px");
			$fourth_div.css("left", "800px");
			$fifth_div.css("left", "800px");
			$end_div.css("left", "800px");
			
			// fadein popup container
			$popup_container.fadeIn('fast', function(){
				
				// below are the statements if the module are having a slide or has_slide
				
				
				// add current_div class 
				$starting_div.addClass('current_div');
				
				// set current div 
				$current_div = $starting_div;
				
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
			
			return false;
		});
		
		$prev.click(function(event){
			
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
		
		$slideshow_clear.click(function(){
			alert("trying to click the clear");
			return false;
		});
		
	};
	
	var close_click = function() {
		$popup_close.click(function(){
	
			// standard actions for close
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
	
	var $school_id = $("#popup_container #popup_content .student_slideshow_form #school_id");
	var $course_id_select;
	var $subjects;
	
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
				$fifth_div.html(datas.subjects);
				
				$fifth_div.find('div').css({
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
				});
				
				$subjects = $(document).find(".subjects");
				
			});
			
		});
		
	};
	
	var student_slideshow_submit = function() {
	
		$student_slideshow_form.on('submit', function(){
			alert("trying to enroll the student");
			console.log($term_id);
			console.log($first_name);
			console.log($last_name);
			console.log($middle_name);
			console.log($age);
			console.log($gender);
			console.log($birth_date);
			console.log($civil_status);
			console.log($religion);
			console.log($school_id);
			console.log($course_id_select);
			console.log($subjects);
			return false;
		});
	};
	
	return {
		get_courses_by_school_id:	 get_courses_by_school_id,
		get_subjects_by_course_id:	 get_subjects_by_course_id,
		student_slideshow_submit: 	 student_slideshow_submit
	}
	
})()

// execute studentSlideShowModule 

studentSlideShowModule.get_courses_by_school_id();
studentSlideShowModule.get_subjects_by_course_id();
studentSlideShowModule.student_slideshow_submit();



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
























