/**
 * Used to check if this is used in program comparison
 */
inIframe = false;

/**
 * Call the API to merge this exercise in the user's program
 * @param {Object} id
 * @param {Object} day
 */
var copyExercise = function(view, id, day, oldBg){
	var modals = $(".copyExerciseModal:not([style*='none'])");
	var sibH = view.find("#"+id);
	if (oldBg){
		sibH.css({
			"background-color" : "#00AAFF"
		})
	}
	
	if (modals.length > 0){
		console.log(modals.last()[0]);
		modals[0].scrollIntoView(false);
		alert("Complete or cancel this copy first!");
		if (oldBg){	
			sibH.css("background", oldBg);
		}
		return;	
	}
	
	var reqUrl = "func/requestsHandler.php";
	
	var reqParams = {
		"operation" : "mergeExercise",
		"day" : day,
		"id" : id
	};
	
	jQuery.ajax({
		url : reqUrl,
		
		data : reqParams,
		
		type : "POST",
		
		success : function(response){
			var exercises = jQuery.parseJSON(response);
						
			var modal = $(".copyExerciseModal").first().clone();
			view.after(modal);
			modal.width(view.width()/2);
			modal.slideDown();
			
			console.log("Length: "+exercises.length);
			if (exercises.length == 0){
				modal.find(".normalMsg").hide();
				modal.find(".noexMsg").show();
			} else {
				// Show exercises' info
				for (var i=0; i<exercises.length; i++){
					var template = $(".exerciseInfo[style*='none']").first().clone();
					var toReplace = template.html();
					toReplace = toReplace.replace("%exerciseName%", exercises[i].name);
					toReplace = toReplace.replace("%repetitions%", exercises[i].repetition);
					template.html(toReplace);
					template.find("h3").width("90%");
					if (i % 2 != 0){
						template.find("h3").attr("class", "odd");
					}
					var firstBtn = modal.find(".btnContainer");
					template.insertBefore(firstBtn);
					template.show();
				}
			}
			
			
			// Set modal listeners
			$(".closeModalBtn").on("click", function(){
				var modal = $(this).parents("div.copyExerciseModal");
				if (oldBg){
					sibH.css("background", oldBg);
				}
				modal.slideUp(400, function(){
					$(this).remove();
				});
			});
			
			$(".confirmModalBtn").on("click", function(){
				// TODO Last ajax call
				var reqUrl = "func/requestsHandler.php";
				var reqParams = {
					"operation": "mergeExerciseStep2",
					"id": id
				}
				
				jQuery.ajax({
					url : reqUrl,
					type : "POST",
					
					data : reqParams,
					
					success : function(response){
						console.log(response);
						if (oldBg){
							sibH.css("background", oldBg);
						}
						modal.slideUp(400, function(){
							$(this).remove();
						});
					},
					
					error : function(xhr){
						alert(xhr.responseText);
					}
				})
			});
		},
		
		error : function(xhr){
			alert(xhr.responseText);
			if (oldBg){
				sibH.css("background", oldBg);
			}
		}
	});
}


var createTable = function(day, exercises){
	var dayMap = {
		1 : "monday",
		2 : "tuesday",
		3 : "wednesday",
		4 : "thursday",
		5 : "friday",
		6 : "saturday",
		7 : "sunday"
	};
	var newId = "exercises"+day;
	var reference = $("#exercises0");
	var newTable = reference.clone();
	newTable.find("tr").remove();
	newTable.attr("id", newId);
	newTable.removeAttr("style");
	// Set the day name
	newTable.html(newTable.html().replace("%day%", dayMap[day].toUpperCase()));
	
	var alternate = true;
	
	jQuery.each(exercises, function(key, value){
		var newCell = $(reference.find("tr")[0]).clone();
		var toReplace = newCell.html();
		var truncatedName = (value.name.length > 15)? value.name.substr(0, 15)+"..." : value.name;
		toReplace = toReplace.replace("%name%", truncatedName);
		toReplace = toReplace.replace("%repetitions%", value.repetition);
		toReplace = toReplace.replace("%exerciseId%", value.id);
		toReplace = toReplace.replace("%day%", value.day);
		newCell.html(toReplace);
		newTable.find("tbody").append(newCell);
		var prevSibling = newCell.prev("tr");
		if (key % 2 != 0 && prevSibling.length != 0){
			var newTd = newCell.find("td").clone();
			if (!inIframe){
				prevSibling.append(newTd);
				newCell.remove();
			}
			if (alternate){
				newTd.find("h3").attr("class", "odd");
				alternate = false;
			} else {
				alternate = true;
			}
		} else {
			if (!alternate){
				newCell.find("h3").attr("class", "odd");
			}
		}
	});
	
	var exercises = newTable.find("td");

	var copyExerciseBtns = exercises.find(".copyExerciseBtn");
	copyExerciseBtns.css({
		"position" : "absolute"
	});
	
	copyExerciseBtns.hide();

	copyExerciseBtns.click(function(){
		var btn = $(this);
		var parentH = btn.parents("h3").first();
		var oldBg = parentH.css("background");
		var exercisesSet = parentH.parents("[id*='exercise']").first();
		copyExercise(exercisesSet, parentH.attr("id"), parentH.attr("day"), oldBg);
	});
	
	exercises.mouseover(function(evt){
		if (window.location.href.indexOf("showFitness") != -1 || $("#isMyProgram").length != 0){
			return;
		}
		var copyExerciseBtn = $(this).find(".copyExerciseBtn");
		copyExerciseBtn.show();
		copyExerciseBtn.attr("style", "position:absolute; display:inline; margin-bottom:100px");
	});
	
	exercises.mouseleave(function(evt){
		var copyExerciseBtn = $(this).find(".copyExerciseBtn");
		copyExerciseBtn.hide();
	});
	
	return newTable;
}

$(document).ready(function(){
	// Check if we need to hide headers
	if (window.location.href.indexOf("showFitness") != -1){
		var body = $("div#exercisesContainer").clone();
		$("body").children().remove();
		$("body").append(body);
		inIframe = true;
	}
	
	var container = $("#programContainer");
	var reqUrl = "func/requestsHandler.php";
	
	var programId = (window.location.href.indexOf("?id") != -1)? window.location.href.split("?")[1].split("=")[1] : null;
	
	var reqParams = {
		operation : "getFitnessProgram"
	};
	
	if (programId != null){
		reqParams.programId = programId;
	}
	
	$.ajax({
		url : reqUrl,
		
		type : "POST",
		
		data : reqParams,
		
		success : function(response){
			var exercises = JSON.parse(response).exercises;
			var tables = new Array();
			jQuery.each(exercises, function(key, value){
				if ($("exercises"+key).length == 0){
					tables.push(createTable(key, value));
				}			
			});
			
			var reference = $("#exercises0");
			
			tables.sort(function(ex1, ex2){
				if (ex1.attr("id") < ex2.attr("id")){
					return -1;
				} else {
					return 1;
				}
			})
			
			reference.after(tables);
			
			if (inIframe){
				for (var i=0; i<tables.length; i++){
					var width = (tables[i]).find("h2").width();
					$(tables[i]).find("h3").attr("style", "width:"+(width-5)+"px !important");
				}
			}
		},
		
		error : function(xhr){
			alert(xhr.responseText);
		}
	});
	
	// Program comparison
	$("#compareProgramBtn").click(function(){
		
	});
	
});




