var x = jQuery.noConflict();
x(function(){ 
	///////////////////////////////////////////////////////////////////////Save Competitor///////////////////////////////////////////////////////////////
	x('.AddCompetitorReg').bind( 'click', function(e) {}); 
}); 

x(document).ready(function(){
 x("#accept_conditions").click(function(){
	var error =  "";
	var errorFlag = false;
    var comp_fullname=x('#comp_fullname').val();
	var comp_email=x('#comp_email').val();
	var comp_phn=x('#comp_phn').val();
	var comp_div=x('#comp_div').val();
	
    if(comp_fullname.length == 0){
		 error = error+ "Please enter the Fullname of participant<br />";
		 errorFlag = true;
	}
	if(comp_email.length == 0){
		error = error+ "Please enter a valid EmailID<br />";
		errorFlag = true;
    }
	if(comp_phn.length == 0){
		error = error+ "Please enter the Phone Number<br />";
		errorFlag = true;
    }
	if(comp_div.length == 0){
		error = error+ "Please choose the division<br />";
		errorFlag = true;
    }
	if(errorFlag = true){
	    x('#error_block').html(error);
        return true; 
	}else {
		return true;
    }
	return true;
});
});

/////////////Add score  Event LeaderBoard
x("form#addScore").submit(function(){
  	var error =  "";
	var errorFlag = 0;
    var EveScoreEvent=x('#front-EveScoreEvent').val();
	var EveScoreWork=x('#front-EveScoreWork').val();
	var EveScore=x('#front-EveScore').val();
	if(EveScoreEvent.length == 0){
		error = error+ "Please select an Event from the list<br />";
		errorFlag = 1;
    }else{ errorFlag = 0;}
	if(EveScoreWork.length == 0){
		error = error+ "Please select a Workout from the list<br />";
		errorFlag = 1;
    }else{ errorFlag = 0;}
	if(EveScore.length == 0){
		error = error+ "Add a valid score<br />";
		errorFlag = 1;
    }else{ errorFlag = 0;}
	if(errorFlag == 1){
	    x('#error_block').html(error);
        return false; 
	}else {
		return true;
    }
	return true;
});
x('#front-EveScoreWork').on('change', function() {
  var selectedText = x(this).find("option:selected").text();
  x(".divUnit").hide();
  x("#"+selectedText).show();
});
var media_uploader;
x('body').on('click', '#userEveScoreProof', function (event){ 			
    var button = jQuery( this );
    if ( media_uploader ) {
      media_uploader.open();
      return;
    }
    // Create the media uploader.
    media_uploader = wp.media.frames.media_uploader = wp.media({
        title: button.data( 'uploader-title' ),
        library: {
            type: 'image',
            query: false
        },
        button: {
            text: button.data( 'uploader-button-text' ),
        },
        multiple: button.data( 'uploader-allow-multiple' )
    });
    // Create a callback when the uploader is called
    media_uploader.on( 'select', function() {
        var selection = media_uploader.state().get('selection'),
            input_name = button.data( 'input-name' ),
            bucket = x( '#' + input_name + '-thumbnails');
         	selection.map( function( attachment ) {
            attachment = attachment.toJSON();
            bucket.append(function() {
                return '<img src="'+attachment.sizes.thumbnail.url+'" width="'+attachment.sizes.thumbnail.width+'" height="'+attachment.sizes.thumbnail.height+'" class="submission_thumb thumbnail" /><input name="'+input_name+'[]" type="hidden" value="'+attachment.id+'" />'
            });
         });
    });
    // Open the uploader
    media_uploader.open();
  });
