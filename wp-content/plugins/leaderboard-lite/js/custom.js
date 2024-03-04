jQuery.noConflict();
(function( $ ) {
$(function(){
	//Date picker
	$('#competition_start_date').datepicker({
		dateFormat : 'yy-mm-dd'
	});
	$('#competition_end_date').datepicker({
		dateFormat : 'yy-mm-dd'
	});
	$('#event_endof_reg_date').datepicker({
		dateFormat : 'yy-mm-dd'
	});
	$('#event_from').datepicker({
		dateFormat : 'yy-mm-dd'
	});
	$('#event_to').datepicker({
		dateFormat : 'yy-mm-dd'
	});
	
	$('#competitor_dob').datepicker({
		dateFormat : 'yy-mm-dd',
		changeMonth : true,
		changeYear : true,
		yearRange: '-100y:c+nn',
		maxDate: '-1d'
	});
	$('#competitor_reg_date').datepicker({
		dateFormat : 'yy-mm-dd',
		maxDate: '0d'
	});
	//Event Image uploader
	$('#upload_image_button').click(function() {
        formfield = $('#upload_image').attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        window.send_to_editor = function(html) {
           imgurl = $(html).attr('src');
           $('#upload_image').val(imgurl);
           tb_remove();
        }
        return false;
    });
	//Event fee 
	$('#event_enable_booking').change(function() {
		if(this.checked) {
			$("#eventFee").show();
		}else{
			$("#eventFee").hide();
		}
	});
	
	$('#event_competition').change(function() {
		$('#available_divisions').show();
	});
	/**************START*************/
	$('body').on('click','.resp-tab-content-active',function(){
		$('#edit_competition_start_date').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		$('#edit_competition_end_date').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		$('#edit_event_from').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		$('#edit_event_to').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		$('#edit_event_endof_reg_date').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		//Competitor
		$('#edit_competitor_dob').datepicker({
			dateFormat : 'yy-mm-dd',
			changeMonth : true,
			changeYear : true,
			yearRange: '-100y:c+nn',
			maxDate: '-1d'
		});
		$('#edit_competitor_reg_date').datepicker({
			dateFormat : 'yy-mm-dd',
			maxDate: '0d'
		});
	});

$('body').on('click','#edit_event_from',function(){
		$('#edit_event_enable_booking').change(function() {
			if(this.checked) {
				$("#eventFee").show();
			}else{
				$("#eventFee").hide();
			}
		});
		//Event Image uploader
		$('#upload_image_button').click(function() {
			formfield = $('#upload_image').attr('name');
			tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
			window.send_to_editor = function(html) {
			   imgurl = $(html).attr('src');
			   $('#upload_image').val(imgurl);
			   tb_remove();
			}
			return false;
		});
	});   
	//
	$('body').on('click','#edit_competitor_from',function(){
		$('#competitor_dob').datepicker({
			dateFormat : 'yy-mm-dd'
		});
		$('#competitor_reg_date').datepicker({
			dateFormat : 'yy-mm-dd'
		});
	});  
	//
	$('body').on('change','#edit_event_enable_booking',function(){
		if(this.checked) {
			$("#edit_eventFee").show();
		}else{
			$("#edit_eventFee").hide();
		}											 
	});   		
	$('body').on('change','#edit_event_competition',function(){
		$('#available_divisions').toggle();
	});
	/**************END************/
	////////////////// Event LeaderBoard ///////////////////
	//Remove Proof - Add score
	$('body').on('click','.listBlck > span',function(){
		v = $(this).find("input").val(); 
		$(this).parent().remove();
		$('.eve_drop option[value="'+v+'"]').remove();
	});
	//Remove Proof - Edit score
	$('body').on('click','.listBlck > span.old_eve_score_proof',function(){
		v = $(this).find("input").val(); 
		$(this).parent().remove();
		$('.old_eve_drop option[value="'+v+'"]').remove();
	});
	
	
	$("#enable_stripeTestMode").click(function () {
		if ($(this).is(":checked")) {
			$("#stripe_data").css("opacity","0.3");
		} else {
			$("#stripe_data").css("opacity","1");
		}
	});

});
})(jQuery);