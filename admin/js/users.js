function enableUser(userId, disabled){
	var operation = (disabled)? "enableUser" : "disableUser";
	
	var reqParams = {
		operation : operation,
		userId : userId
	};
	
	console.log(reqParams);
	
	$.ajax({
		url: "../../func/requestsHandler.php",
		type: "POST",
		data: reqParams,
		
		success : function(data){
			alert(data);
		},
		
		error : function(xhr, status, msg){
			alert(msg+" - "+xhr.responseText);
		}
	})
}

$(document).ready(function(){
	$(".disableUserBtn").click(function(el){
		var userId = $($(this).parent().parent().children()[0]).html();
		enableUser(userId);
	});
	
	$(".enableUserBtn").click(function(el){
		var userId = $($(this).parent().parent().children()[0]).html();
		enableUser(userId, true);
	});
});
