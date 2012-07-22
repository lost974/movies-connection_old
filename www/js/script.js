$(document).ready(function()
	{
		var server = 'http://movies-connection.lost974.com/';
		$('#title').autocomplete(server+'movie/autocompletion'); 
		
		$('.content').hide();
		$('.toHide').hide();
		
		$('#search_hide').hide();
		
		$('.toShow').click(function(){ 
			$('.toHide').show();
			$('.toShow').hide();
			$('.content').slideDown('slow');
		});
		
		$('.toHide').click(function(){ 
			$('.toShow').show();
			$('.toHide').hide();
			$('.content').slideUp('slow');
		});	
		
		// Movie/view
		$('.conseil').hide();
		$('.conseil_i').click(function(){ 
			$('.conseil').show();
			$('.conseil_i').hide();
		});
		$('.critique_user').hide();
		$('.critique_user_name_hide').hide();
		$('.critique_user_name_show').click(function(){ 
			$('.critique_user').slideDown('slow');
			$('.critique_user_name_show').hide();
			$('.critique_user_name_hide').show();
		});
		$('.critique_user_name_hide').click(function(){ 
			$('.critique_user').slideUp('slow');
			$('.critique_user_name_hide').hide();
			$('.critique_user_name_show').show();
		});

	});