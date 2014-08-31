$(document).ready(function(){

	$('#adminregister').click(function(){
		var aregArray = new Array();

		$(this).parent().find('input').each(function(){
			aregArray.push($(this).val());
		});
		aregArray.push($('select').val());
		$.ajax({
			type: "POST",
			url: "http://fitness.desigyn.com/func/requestsHandler.php",
			data: {operation: "createUser", age: aregArray[5] , bio: aregArray[10], email: aregArray[2], experience: aregArray[8], fat_percentage: aregArray[9], height: aregArray[6] , mass: aregArray[7], name: aregArray[0] , password: aregArray[3], picture: aregArray[4], username: aregArray[1],gender: aregArray[11]}, 

			success : function(data){
				alert('Your profile has been created!');
				console.log(data);
					// window.location.href = './register.php';
				},
				
				error : function(xhr, status){
					alert('Error occured. Please try again later. ('+status+')');
				}
			})


	});
});