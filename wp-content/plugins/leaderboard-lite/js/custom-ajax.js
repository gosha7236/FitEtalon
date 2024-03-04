jQuery.noConflict();
var ajaxUrl = customAjaxHandle.myPermalink;
(function( $ ) {
$(function(){ 
	///////////////////////////////////////////////////////////////Add Competition///////////////////////////////////////////////////////////////
	$('.addCompetition').bind( 'click', function(e) { 
	   var competitionName = $('#competition_name').val();		
	   var competitionStartDate = $('#competition_start_date').val();	
	   var competitionEndDate = $('#competition_end_date').val();	
	    var competitionDesc = $('#competition_desc').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competition_name': competitionName,
				'competition_start_date': competitionStartDate,
				'competition_end_date': competitionEndDate,
				'competition_desc': competitionDesc,
                'action': 'lbd_add_competition',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.ResultArea').html("<span class='greenmsg'>"+response+"</span>" );
					$("#competitionForm")[0].reset();
				}else{
					$('.ResultArea').html("<span class='redmsg'>Please fill all the fields</span>");
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 2000); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Delete Competition////////////////////////////////////////////////////////////////
		$('.deleteCompetition').bind( 'click', function(e) { 
	   var competition_id = $(this).find('#competition_id').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competition_id': competition_id,
                'action': 'lbd_delete_competition',
				'security':ajax_object.ajax_nonce
            },
			beforeSend:function(){
				 return confirm("Are you sure?");
			},
			success : function( response ) {
				if(response != 0){
					$('.competitionTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Competition////////////////////////////////////////////////////////////////
	$('.editCompetition').bind( 'click', function(e) { 
	   var competition_id = $(this).find('#competition_id').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competition_id': competition_id,
                'action': 'lbd_edit_competition',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.competitionTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Save Competition////////////////////////////////////////////////////////////////
	$('body').on('click', '.editCompSave', function (){
	   var competitionID = $('#edit_competition_id').val();		
	   var competitionName = $('#edit_competition_name').val();		
	   var competitionStartDate = $('#edit_competition_start_date').val();	
	   var competitionEndDate = $('#edit_competition_end_date').val();	
	    var competitionDesc = $('#edit_competition_desc').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competition_id': competitionID,
				'competition_name': competitionName,
				'competition_start_date': competitionStartDate,
				'competition_end_date': competitionEndDate,
				'competition_desc': competitionDesc,
                'action': 'lbd_editsave_competition',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.competitionTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	//////////////////////////*************************************/////////////////////// Division ////////////////////////////**************************************/////////////////////////////
	/////////////////////////////////////////////Add Division//////////////////////////////////////////////////////
	$('.addDivision').bind( 'click', function(e) { 
	   var divisionName = $('#division_name').val();		
	   var divisionEvent = $('#division_event').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'division_name': divisionName,
				'division_event': divisionEvent,
                'action': 'lbd_add_division',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.ResultArea').html("<span class='greenmsg'>"+response+"</span>" );
					$("#divisionForm")[0].reset();
				}else{
					$('.ResultArea').html("<span class='redmsg'>Please fill all the fields</span>");
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 2000); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Delete Division////////////////////////////////////////////////////////////////
		$('.deleteDivision').bind( 'click', function(e) { 
	   var division_id = $(this).find('#division_id').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'division_id': division_id,
                'action': 'lbd_delete_division',
				'security':ajax_object.ajax_nonce
            },
			beforeSend:function(){
				 return confirm("Are you sure?");
			},
			success : function( response ) {
				if(response != 0){
					$('.divisionTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Division////////////////////////////////////////////////////////////////
	$('.editDivision').bind( 'click', function(e) { 
	   var division_id = $(this).find('#division_id').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'division_id': division_id,
                'action': 'lbd_edit_division',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.divisionTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Save Division////////////////////////////////////////////////////////////////
	$('body').on('click', '.editDivSave', function (){
	   var divisionID = $('#edit_division_id').val();		
	   var divisionName = $('#edit_division_name').val();		
	   var divisionEvent = $('#edit_division_event').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'division_id': divisionID,
				'division_name': divisionName,
				'division_event': divisionEvent,
                'action': 'lbd_editsave_division',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.divisionTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	/////////////////////////////////////////////////  Event Workout -Divisioin seletor////////////////////////////////////////////////////////
	$('body').on('click', '#event_workout_event', function (){ 
	   var event_id = $(this).val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
                'action': 'lbd_event_workout_div',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#available_divisions').html(response);
				}
			}
        });
	return false;
	}); 
	$('body').on('click', '#edit_event_workout_event', function (){ 
	   var event_id = $(this).val();
	   var old_event_workout_division 	= $('#old_event_workout_division').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
				'old_event_workout_division': old_event_workout_division,
                'action': 'lbd_event_workout_edit_div',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#edit_available_divisions').html(response);
				}
			}
        });
	return false;
	}); 
	/////////////////////////////////////////////////  Add Event  ////////////////////////////////////////////////////////
	$('body').on('click', '.addEvent', function (){
	   var event_organizer_email 		= $('#event_organizer_email').val();	
		var event_name 							= $('#event_name').val();	
		var event_competition 				= $('#event_competition').val();	
		var event_type 								= $('#event_type').val();	
		var event_from 								= $('#event_from').val();	
		var event_time_from 					= $('#event_time_from').val();	
		var event_to 									= $('#event_to').val();	
		var event_time_to 						= $('#event_time_to').val();	
		var event_time_fullday 				= $('#event_time_fullday').val();	
		var event_location 						= $('#event_location').val();	
		var event_region 							= $('#event_region').val();	
		var event_address 						= $('#event_address').val();	
		var event_country 						= $('#event_country').val();	
		var event_city 								= $('#event_city').val();	
		var event_po 								= $('#event_po').val();	
		var event_latitude 						= $('#event_latitude').val();	
		var event_longitude 					= $('#event_longitude').val();	
		var event_desc 							= $('#event_desc').val();	
		var event_image 							= $('#upload_image').val();	
		var event_website 						= $('#event_website').val();	
		var event_enable_booking 		= $('#event_enable_booking').val();	
		var event_endof_reg_date 		= $('#event_endof_reg_date').val();	
		var event_endof_reg_time 			= $('#event_endof_reg_time').val();	
		var event_fee 								= $('#event_fee').val();	
		var event_fee_currency 				= $('#event_fee_currency').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_organizer_email': event_organizer_email,
				'event_name':event_name,
				'event_competition':event_competition,
				'event_type':event_type,
				'event_from':event_from,
				'event_time_from':event_time_from,
				'event_to':event_to,
				'event_time_to':event_time_to,
				'event_time_fullday':event_time_fullday,
				'event_location':event_location,
				'event_region':event_region,
				'event_address':event_address,
				'event_country':event_country,
				'event_city':event_city,
				'event_po':event_po,
				'event_latitude':event_latitude,
				'event_longitude':event_longitude,
				'event_desc':event_desc,
				'event_image':event_image,
				'event_website':event_website,
				'event_enable_booking':event_enable_booking,
				'event_endof_reg_date':event_endof_reg_date,
				'event_endof_reg_time':event_endof_reg_time,
				'event_fee':event_fee,
				'event_fee_currency':event_fee_currency,				
                'action': 'lbd_add_event',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.ResultArea').html("<span class='greenmsg'>"+response+"</span>" );
					$("#eventForm")[0].reset();
				}else{
					$('.ResultArea').html("<span class='redmsg'>Please fill all the fields</span>");
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 2000); 
				});
			}
        });
	return false;
	}); 
	///////////////////////////////////////////////////////////////////////Delete Event////////////////////////////////////////////////////////////////
	$('.deleteEvent').bind( 'click', function(e) { 
	   var event_id = $(this).find('#event_id').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
                'action': 'lbd_delete_event',
				'security':ajax_object.ajax_nonce
            },
			beforeSend:function(){
				 return confirm("Are you sure?");
			},
			success : function( response ) {
				if(response != 0){
					$('.eventTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Event////////////////////////////////////////////////////////////////
	$('.editEvent').bind( 'click', function(e) { 
	   var event_id = $(this).find('#event_id').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
                'action': 'lbd_edit_event',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.eventTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Save Event////////////////////////////////////////////////////////////////
	$('body').on('click', '.editEventSave', function (){
	  	var event_id 									= $('#edit_event_id').val();	
		var event_organizer_email 		= $('#edit_event_organizer_email').val();	
		var event_name 							= $('#edit_event_name').val();	
		var event_competition 				= $('#edit_event_competition').val();	
		var event_type 								= $('#edit_event_type').val();	
		var event_from 								= $('#edit_event_from').val();	
		var event_time_from 					= $('#edit_event_time_from').val();	
		var event_to 									= $('#edit_event_to').val();	
		var event_time_to 						= $('#edit_event_time_to').val();	
		var event_time_fullday 				= $('#edit_event_time_fullday').val();	
		var event_location 						= $('#edit_event_location').val();	
		var event_region 							= $('#edit_event_region').val();	
		var event_address 						= $('#edit_event_address').val();	
		var event_country 						= $('#edit_event_country').val();	
		var event_city 								= $('#edit_event_city').val();	
		var event_po 								= $('#edit_event_po').val();	
		var event_latitude 						= $('#edit_event_latitude').val();	
		var event_longitude 					= $('#edit_event_longitude').val();	
		var event_desc 							= $('#edit_event_desc').val();	
		var event_image 							= $('#upload_image').val();	
		var event_website 						= $('#edit_event_website').val();	
		var event_enable_booking 		= $('#edit_event_enable_booking').val();	
		var event_endof_reg_date 		= $('#edit_event_endof_reg_date').val();	
		var event_endof_reg_time 			= $('#edit_event_endof_reg_time').val();	
		var event_fee 								= $('#edit_event_fee').val();	
		var event_fee_currency 				= $('#edit_event_fee_currency').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
				'event_organizer_email': event_organizer_email,
				'event_name':event_name,
				'event_competition':event_competition,
				'event_type':event_type,
				'event_from':event_from,
				'event_time_from':event_time_from,
				'event_to':event_to,
				'event_time_to':event_time_to,
				'event_time_fullday':event_time_fullday,
				'event_location':event_location,
				'event_region':event_region,
				'event_address':event_address,
				'event_country':event_country,
				'event_city':event_city,
				'event_po':event_po,
				'event_latitude':event_latitude,
				'event_longitude':event_longitude,
				'event_desc':event_desc,
				'event_image':event_image,
				'event_website':event_website,
				'event_enable_booking':event_enable_booking,
				'event_endof_reg_date':event_endof_reg_date,
				'event_endof_reg_time':event_endof_reg_time,
				'event_fee':event_fee,
				'event_fee_currency':event_fee_currency,	
                'action': 'lbd_editsave_event',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) { 
				if(response != 0){
					$('.eventTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	/////////////////////////////////////////////////  Add Competitor  ////////////////////////////////////////////////////////
	$('body').on('click', '.addCompetitor', function (){
	   var competitor_name 						= $('#competitor_name').val();	
		var competitor_gender					= $('#competitor_gender').val();	
		var competitor_dob 							= $('#competitor_dob').val();	
		var competitor_age 							= $('#competitor_age').val();	
		var competitor_email 						= $('#competitor_email').val();	
		var competitor_phone 					= $('#competitor_phone').val();
		var competitor_division 					= $('#competitor_division').val();
		var competitor_reg_date 				= $('#competitor_reg_date').val();	
		var competitor_reg_fee 					= $('#competitor_reg_fee').val();	
		var competitor_payment_status 	= $('#competitor_payment_status').val();	
		var competitor_status 						= $('#competitor_status').val();	
		
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competitor_name': competitor_name,
				'competitor_gender':competitor_gender,
				'competitor_dob':competitor_dob,
				'competitor_age':competitor_age,
				'competitor_email':competitor_email,
				'competitor_phone':competitor_phone,
				'competitor_division':competitor_division,
				'competitor_reg_date':competitor_reg_date,
				'competitor_reg_fee':competitor_reg_fee,
				'competitor_payment_status':competitor_payment_status,
				'competitor_status':competitor_status,
                'action': 'lbd_add_competitor',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) { //alert(response);
				if(response != 0){
					$('.ResultArea').html("<span class='greenmsg'>"+response+"</span>" );
					$("#competitorForm")[0].reset();
				}else{
					$('.ResultArea').html("<span class='redmsg'>Please fill all the fields</span>");
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 2000); 
				});
			}
        });
	return false;
	}); 
	///////////////////////////////////////////////////////////////////////Delete Competitor////////////////////////////////////////////////////////////////
	$('.deleteCompetitor').bind( 'click', function(e) { 
	   var competitor_id = $(this).find('#competitor_id').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competitor_id': competitor_id,
                'action': 'lbd_delete_competitor',
				'security':ajax_object.ajax_nonce
            },
			beforeSend:function(){
				 return confirm("Are you sure?");
			},
			success : function( response ) {
				if(response != 0){
					$('.competitorTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Competitor////////////////////////////////////////////////////////////////
	$('.editCompetitor').bind( 'click', function(e) { 
	   var competitor_id = $(this).find('#competitor_id').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competitor_id': competitor_id,
                'action': 'lbd_edit_competitor',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.competitorTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Save Competitor////////////////////////////////////////////////////////////////
	$('body').on('click', '.editCompetitorSave', function (){
	  	var competitor_id 			= $('#edit_competitor_id').val();	
		var competitor_name 		= $('#edit_competitor_name').val();	
		var competitor_gender 	= $('#edit_competitor_gender').val();	
		var competitor_dob 			= $('#edit_competitor_dob').val();	
		var competitor_age 			= $('#edit_competitor_age').val();	
		var competitor_email 		= $('#edit_competitor_email').val();	
		var competitor_phone 	= $('#edit_competitor_phone').val();	
		var competitor_division 	= $('#edit_competitor_division').val();	
		var competitor_reg_date = $('#edit_competitor_reg_date').val();	
		var competitor_reg_fee 	= $('#edit_competitor_reg_fee').val();	
		var competitor_payment_status 	= $('#edit_competitor_payment_status').val();	
		var competitor_status 						= $('#edit_competitor_status').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'competitor_id': competitor_id,
				'competitor_name': competitor_name,
				'competitor_gender':competitor_gender,
				'competitor_dob':competitor_dob,
				'competitor_age':competitor_age,
				'competitor_email':competitor_email,
				'competitor_phone':competitor_phone,
				'competitor_division':competitor_division,
				'competitor_reg_date':competitor_reg_date,
				'competitor_reg_fee':competitor_reg_fee,
				'competitor_payment_status':competitor_payment_status,
				'competitor_status':competitor_status,
                'action': 'lbd_editsave_competitor',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {  
				if(response != 0){
					$('.competitorTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Add Workout////////////////////////////////////////////////////////////////
	$('.addWorkout').bind( 'click', function(e) { 
	   var event_workout_name = $('#event_workout_name').val();		
	   var event_workout_event = $('#event_workout_event').val();	
	   var event_workout_divisions = $('#event_workout_divisions').val();	
	   var event_workout_desc = $('#event_workout_desc').val();
	   var event_workout_unit = $('#event_workout_unit').val();
	   var event_workout_enable = $('#event_workout_enable').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_workout_name': event_workout_name,
				'event_workout_event': event_workout_event,
				'event_workout_divisions': event_workout_divisions,
				'event_workout_desc': event_workout_desc,
				'event_workout_unit':event_workout_unit,
				'event_workout_enable':event_workout_enable,
                'action': 'lbd_add_workout',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.ResultArea').html("<span class='greenmsg'>"+response+"</span>" );
					$("#workoutForm")[0].reset();
				}else{
					$('.ResultArea').html("<span class='redmsg'>Please fill all the fields</span>");
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 2 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 2000); 
				});
			}
        });
	return false;
	}); 
	///////////////////////////////////////////////////////////////////////Delete Workout////////////////////////////////////////////////////////////////
	$('.deleteWorkout').bind( 'click', function(e) { 
	   var workout_id = $(this).find('#workout_id').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'workout_id': workout_id,
                'action': 'lbd_delete_workout',
				'security':ajax_object.ajax_nonce
            },
			beforeSend:function(){
				 return confirm("Are you sure?");
			},
			success : function( response ) {
				if(response != 0){
					$('.workoutTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Workout////////////////////////////////////////////////////////////////
	$('.editWorkout').bind( 'click', function(e) { 
	   var workout_id = $(this).find('#workout_id').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'workout_id': workout_id,
                'action': 'lbd_edit_workout',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.workoutTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Save Workout////////////////////////////////////////////////////////////////
	$('body').on('click', '.editWorkoutSave', function (){
	   var event_workout_id = $('#edit_event_workout_id').val();
	   var event_workout_name = $('#edit_event_workout_name').val();		
	   var event_workout_event = $('#edit_event_workout_event').val();	
	   var event_workout_divisions = $('#edit_event_workout_divisions').val();	
	   var event_workout_desc = $('#edit_event_workout_desc').val();
	   var event_workout_unit = $('#edit_event_workout_unit').val();
	   var event_workout_enable = $('#edit_event_workout_enable').val();
	   
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_workout_id': event_workout_id,
				'event_workout_name': event_workout_name,
				'event_workout_event':event_workout_event,
				'event_workout_divisions':event_workout_divisions,
				'event_workout_desc':event_workout_desc,
				'event_workout_unit':event_workout_unit,
				'event_workout_enable':event_workout_enable,
                'action': 'lbd_editsave_workout',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {  
				if(response != 0){
					$('.workoutTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	/////////////////////////////////////////////////  Score Event || Workout -Divisioin-Competitor seletor ////////////////////////////////////////////////////////
	$('body').on('click', '#event_score_event', function (){ 
	   var event_id = $(this).val();
	   $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
                'action': 'lbd_event_score_division',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#event_score_division_selector').html(response);
				}
			}
        });
	return false;
	}); 
	$('body').on('click', '#event_score_division', function (){ 
	   var division = $(this).val(); 
	   var event_id 	= $('#event_score_event').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
				'division':division,
                'action': 'lbd_event_score_workout',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#event_score_workout_selector').html(response);
				}
			}
        });
	   $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'division': division,
                'action': 'lbd_event_score_competitor',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#event_score_competitor_selector').html(response);
				}
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Add Score////////////////////////////////////////////////////////////////
	$('.addScore').bind( 'click', function(e) { 
	   var event_score_event = $('#event_score_event').val();		
	   var event_score_division = $('#event_score_division').val();	
	   var event_score_workout = $('#event_score_workout').val();	
	   var event_score_competitor = $('#event_score_competitor').val();
	   var event_score = $('#event_score').val();
	   var event_score_proof = $('#event_score_proof').val();
		
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_score_event': event_score_event,
				'event_score_division': event_score_division,
				'event_score_workout': event_score_workout,
				'event_score_competitor': event_score_competitor,
				'event_score':event_score,
				'event_score_proof':event_score_proof,
                'action': 'lbd_add_score',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.ResultArea').html("<span class='greenmsg'>"+response+"</span>" );
					$("#scoreForm")[0].reset();
				}else{
					$('.ResultArea').html("<span class='redmsg'>Please fill all the fields</span>");
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 2 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 2000); 
				});
			}
        });
	return false;
	}); 
	///////////////////////////////////////////////////////////////////////Delete Score////////////////////////////////////////////////////////////////
	$('.deleteScore').bind( 'click', function(e) { 
	   var score_id = $(this).find('#score_id').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'score_id': score_id,
                'action': 'lbd_delete_score',
				'security':ajax_object.ajax_nonce
            },
			beforeSend:function(){
				 return confirm("Are you sure?");
			},
			success : function( response ) {
				if(response != 0){
					$('.scoreTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Score////////////////////////////////////////////////////////////////
	$('.editScore').bind( 'click', function(e) { 
	   var score_id = $(this).find('#score_id').val();
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'score_id': score_id,
                'action': 'lbd_edit_score',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.scoreTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
			}
        });
	return false;
	}); 
	////////////////////////////////////////////////////////////////Edit Save Score////////////////////////////////////////////////////////////////
	$('body').on('click', '.editScoreSave', function (){
	   var event_score_id = $('#edit_event_score_id').val();		
	   var event_score_event = $('#edit_event_score_event').val();	
	   if(!event_score_event){
		   event_score_event = $('#event_score_event').val();	
	   }
	   var event_score_division = $('#edit_event_score_division').val();	
	   if(!event_score_division){
		   event_score_division = $('#event_score_division').val();	
	   }
	   var event_score_workout = $('#edit_event_score_workout').val();	
	   if(!event_score_workout){
		   event_score_workout = $('#event_score_workout').val();	
	   }
	   var event_score_competitor = $('#edit_event_score_competitor').val();
	    if(!event_score_competitor){
		   event_score_competitor = $('#event_score_competitor').val();	
	   }
	   var event_score = $('#edit_event_score').val();
	   var event_score_proof = $('#event_score_proof').val();
	   var old_event_score_proof = $('#old_event_score_proof').val();
	   
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_score_id': event_score_id,
				'event_score_event': event_score_event,
				'event_score_division':event_score_division,
				'event_score_workout':event_score_workout,
				'event_score_competitor':event_score_competitor,
				'event_score':event_score,
				'event_score_proof':event_score_proof,
				'old_event_score_proof':old_event_score_proof,
                'action': 'lbd_editsave_score',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('.scoreTable').html(response);
				}
				$('html, body').animate({
                  scrollTop: ($('.head_lbAdmin').offset().top )-100
                  }, 500); 
				$(document).ajaxStop(function(){
					setTimeout(function(){// wait for 5 secs(2)
						   location.reload(); // then reload the page.(3)
					  }, 500); 
				});
			}
        });
	return false;
	}); 
	/////////////////////////////////////////////////  Score Event || Workout -Divisioin-Competitor seletor  - Edit screen ////////////////////////////////////////////////////////
	$('body').on('click', '#edit_event_score_event', function (){ 
	   var event_id = $(this).val();
	   $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
                'action': 'lbd_event_score_division',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#edit_event_score_division_selector').html(response);
				}
			}
        });
	return false;
	}); 
	$('body').on('click', '#edit_event_score_division', function (){ 
	   var division = $(this).val(); 
	   var event_id 	= $('#edit_event_score_event').val();	
       $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'event_id': event_id,
				'division':division,
                'action': 'lbd_event_score_workout',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#edit_event_score_workout_selector').html(response);
				}
			}
        });
	   $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                'division': division,
                'action': 'lbd_event_score_competitor',
				'security':ajax_object.ajax_nonce
            },
			success : function( response ) {
				if(response != 0){
					$('#edit_event_score_competitor_selector').html(response);
				}
			}
        });
	return false;
	}); 
	///////////////////////////////////////////////////////////////////////Upload score proof files////////////////////////////////////////////////////////////////
	jQuery(document).ready( function( $ ) {

    var myplugin_media_upload;

    $('#event_score_proof_upload').click(function(e) {
        e.preventDefault();
        // If the uploader object has already been created, reopen the dialog
        if( myplugin_media_upload ) {
            myplugin_media_upload.open();
            return;
        }
        // Extend the wp.media object
        myplugin_media_upload = wp.media.frames.file_frame = wp.media({
            title: "title",
            button: { text: "Add as Proof" },
            multiple: true //allowing for multiple image selection
        });
        myplugin_media_upload.on( 'select', function(){
            var attachments = myplugin_media_upload.state().get('selection').map( 
                function( attachment ) {
                    attachment.toJSON();
                    return attachment;
            });
            //loop through the array and do things with each attachment
           var i;
		   var ImageList="";
           for (i = 0; i < attachments.length; ++i) {
				var j = i+1;
				var Icon;
				if( attachments[i].attributes.type=="text"){
					Icon = "textBg";
				}else if( attachments[i].attributes.type == "image"){
					Icon = "imageBg";
				}else if( attachments[i].attributes.type == "video"){
					Icon = "videoBg";
				}else if( attachments[i].attributes.type == "application"){
					Icon = "applicationBg";
				}else{
					Icon = "defaultBg";
				}
                ImageList =ImageList+'<div class="listBlck"><a href ="'+attachments[i].attributes.url+'" target="_blank" class="'+Icon+'"></a><h5>'+attachments[i].attributes.url+'</h5><span id="proof' + attachments[i].id+'">X<input id="save_proof' + attachments[i].id+'" type="hidden" value="' + attachments[i].id + '"></span></div>';
            }
			ImageList = ImageList+'<select name="event_score_proof" id="event_score_proof" class="eve_drop" style="display:none;" multiple>';
			for (i = 0; i < attachments.length; ++i) {
				var j = i+1;
                ImageList = ImageList+'<option value="'+attachments[i].id+'" selected>' + attachments[i].id + '</option>';
            }
			ImageList = ImageList+'</select>';
			$('#myplugin-placeholder').before(ImageList );
        });
    	myplugin_media_upload.open();
    });
});		
	//Upload proof on Edit screen
jQuery(document).ready( function( $ ) {
   var myplugin_media_upload;
	$('body').on('click', '#edit_event_score_proof_upload', function (){ 												
        if( myplugin_media_upload ) {
            myplugin_media_upload.open();
            return;
        }
        // Extend the wp.media object
        myplugin_media_upload = wp.media.frames.file_frame = wp.media({
            //button_text set by wp_localize_script()
            title: "title",
            button: { text: "Add as Proof" },
            multiple: true //allowing for multiple image selection
        });
        myplugin_media_upload.on( 'select', function(){
            var attachments = myplugin_media_upload.state().get('selection').map( 
                function( attachment ) {
                    attachment.toJSON();
                    return attachment;
            });
            //loop through the array and do things with each attachment
           var i;
		   var ImageList="";
           for (i = 0; i < attachments.length; ++i) {
				var j = i+1;
				var Icon;
				if( attachments[i].attributes.type=="text"){
					Icon = "textBg";
				}else if( attachments[i].attributes.type == "image"){
					Icon = "imageBg";
				}else if( attachments[i].attributes.type == "video"){
					Icon = "videoBg";
				}else if( attachments[i].attributes.type == "application"){
					Icon = "applicationBg";
				}else{
					Icon = "defaultBg";
				}
                ImageList =ImageList+'<div class="listBlck"><a href ="'+attachments[i].attributes.url+'" target="_blank" class="'+Icon+'"></a><h5>'+attachments[i].attributes.url+'</h5><span id="proof' + attachments[i].id+'">X<input id="save_proof' + attachments[i].id+'" type="hidden" value="' + attachments[i].id + '"></span></div>';
            }
			ImageList = ImageList+'<select name="event_score_proof" id="event_score_proof" class="eve_drop" style="display:none;" multiple>';
			for (i = 0; i < attachments.length; ++i) {
				var j = i+1;
                ImageList = ImageList+'<option value="'+attachments[i].id+'" selected>' + attachments[i].id + '</option>';
            }
			ImageList = ImageList+'</select>';
			$('#myplugin-placeholder').before(ImageList );
        });
    	myplugin_media_upload.open();
    });
});	
}); 
})(jQuery);