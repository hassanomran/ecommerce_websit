$(function () {

	'use strict';
       
       //switch between login & signup
       
   
      // fire the selectbox 
       $("select").selectBoxIt({

                // Uses the jQuery 'fadeIn' effect when opening the drop down
                showEffect: "fadeIn",

                // Sets the jQuery 'fadeIn' effect speed to 400 milleseconds
                showEffectSpeed: 400,

                // Uses the jQuery 'fadeOut' effect when closing the drop down
                hideEffect: "fadeOut",

                // Sets the jQuery 'fadeOut' effect speed to 400 milleseconds
                hideEffectSpeed: 400

      });



	$('[placeholder]').focus(function () {

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	}).blur(function () {

		$(this).attr('placeholder', $(this).attr('data-text'));

	});



	$('input').each(function(){
		if ($(this).attr("required") == "required") {
			$(this).after("<span class = asrisk>*</span>");
		}

	});

	
       // confirmation meaage on button
       $('.confirm').click(function(){
       	
       	return confirm('Are you sure?');

       });

      $('.live').keyup(function () {

    $($(this).data('class')).text($(this).val());

  });

      


});