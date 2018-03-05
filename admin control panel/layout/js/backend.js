$(function () {

	'use strict';

  //dashboard
    $('.toggle-info').click(function(){
      $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
      if($(this).hasClass('selected'))
      {
        $(this).html('<i class="fa fa-minus fa-lg"></i>')
      }
      else{
        $(this).html('<i class="fa fa-plus fa-lg"></i>')

      }

    });
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
	//convert password
	var passField = $('.password');
	$('.show-pass').hover(function(){
		passField.attr('type','text');

	},function(){

          passField.attr('type','password');
	});
       // confirmation meaage on button
       $('.confirm').click(function(){
       	
       	return confirm('Are you sure?');

       });

      $('.cats h3').click(function(){

      	$(this).next('.full-view').fadeToggle(200);

      });

      $('.ordering span').click(function(){

      	$(this).addClass('active').siblings('span').removeClass('active');

      	if($(this).data('view') === 'full')
      	{
      		$('.cats .full-view').fadeIn(200);
      	} else
      	{
      		$('.cats .full-view').fadeOut(200);

      	}

      });

$('.child-link').hover(function () {

    $(this).find('.show-delete').fadeIn(400);

  }, function () {

    $(this).find('.show-delete').fadeOut(400);

  });


});