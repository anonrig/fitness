$(document).ready(function(){
	$('.trashComment').click(function(){

		var cid = $(this).attr('id');

		$(this).parent().parent().fadeOut();
		
			$.ajax({
				type: "POST",
				url: "http://fitness.desigyn.com/func/requestsHandler.php",
				data: {operation: 'deleteComment' , comment_id: cid},
				
				success : function(data){
					alert('Comment deleted!');
					console.log(data);
					// window.location.href = './register.php';
				},
				
				error : function(xhr, status){
					alert('Error occured. Please try again later. ('+status+')');
				}
			})
		
	});
});