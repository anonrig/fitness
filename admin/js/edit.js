$(document).ready(function(){

	$('#editadminuser').live('click',function(){

		var aregeditArray = new Array();

		$(this).parent().find('input.input-medium').each(function(){
			aregeditArray.push($(this).val());
		});

		aregeditArray.push($('select').val());
		$.ajax({
			type: "POST",
			url: "http://fitness.desigyn.com/func/requestsHandler.php",
			data: {operation: "adminEditUser", adminedituserid: $('.adminedituserid').attr('id'), age: aregeditArray[4] , bio: $('.input-large').val(), email: aregeditArray[2], experience: aregeditArray[7], fat_percentage: aregeditArray[8], height: aregeditArray[5] , mass: aregeditArray[6], name: aregeditArray[0] , picture: aregeditArray[3], username: aregeditArray[1], gender: $('select').val()}, 

			success : function(data){
				alert('The profile has been edited!');
				console.log(data);
				location.reload();
					// window.location.href = './register.php';
				},
				
				error : function(xhr, status){
					alert('Error occured. Please try again later. ('+status+')');
					location.reload();
				}
			})
	});

	$('#editadmincomment').live('click',function(){
		var ctitle = $(this).parent().find('.input-medium').val();

		$.ajax({
			type: "POST",
			url: "http://fitness.desigyn.com/func/requestsHandler.php",
			data: {operation: "adminEditComment", comment_text: ctitle, id: $('.admincommentid').val()}, 

			success : function(data){
				alert('The comment has been edited!');
				console.log(data);
				location.reload();
					// window.location.href = './register.php';
				},
				
				error : function(xhr, status){
					alert('Error occured. Please try again later. ('+status+')');
					location.reload();
				}
			})

	});

	$('#editadminprogram').live('click',function(){
		var adminProgramArray = new Array();

		$(this).parent().find('input.input-medium').each(function(){
			adminProgramArray.push($(this).val());
		});

		$.ajax({
			type: "POST",
			url: "http://fitness.desigyn.com/func/requestsHandler.php",
			data: {operation: "adminEditProgram", id: $('.adminprogramid').val(), title: adminProgramArray[0], detail: adminProgramArray[1]}, 

			success : function(data){
				alert('The program has been edited!');
				console.log(data);
				location.reload();
					// window.location.href = './register.php';
				},
				
				error : function(xhr, status){
					alert('Error occured. Please try again later. ('+status+')');
					location.reload();
				}
			})
	});
});