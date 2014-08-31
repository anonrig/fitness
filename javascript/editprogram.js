$(document).ready(function() {
	

	// The first screen that tells the user to enter data, after that opens Tabs
	function editStepOne(){
		$('#editstepOneButton').click(function(){
			$(this).parent().fadeOut();
			$('#editstepTwo').delay(400).fadeIn();
		});
	}

	function saveFirst(){

		$("#saveStepOne").click(function(){
			var title = $('#exerciseName').val();
			var area = $('#editarea').val();

			$.ajax({
				type: "POST",
				url: "./func/requestsHandler.php",
				data: { operation: 'editFitnessProgram', title: title, details: area},
				
				success : function(data){
					console.log(data);
				},
				
				error : function(xhr, status){
					console.log(xhr.responseText);
					alert('Error happened please try again later.');
				}
			});
			
		});
			
	}

	function loadExercises(){
		$('#editstepOneButton').click(function(){
			for(var c = 1; c < 8; c++){
			
				$.ajax({
					type: "POST",
					url: "./func/requestsHandler.php",
					data: { operation: 'getSpecificDay', day:c},

					beforeSend : function(xhr){
						xhr.myCounter = c		

					}

				}).done(function(msg, status, xhr){
						var dayobj = $.parseJSON(msg);
						for(var i=0 ; i < dayobj.length; i++){
							var obj = $('#' + xhr.myCounter);
							obj.find('hr').after('<li id="' + dayobj[i].id +'"><div class="createinputs open"><div><label for="exerciseName">Exercise Name</label><input type="text" name="exerciseSets" id="exerciseSets" placeholder="' + dayobj[i].name + '" required="required" maxlength="40" disabled="disabled"/></div><div><label for="exerciseSets">Sets / Periods</label><input type="text" name="exerciseSets" id="exerciseSets" placeholder="' + dayobj[i].repetition + '" required="required" maxlength="40" disabled="disabled"/></div><div ><p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p></div><div></div></div></li>');
						}
					});
			}
		});	
		
	}
	// The function that helps to create exercise tabs
	

	function openTabs(){
		var eArray = new Array();
		eArray = [
			'Romanian Deadlift',
			'Seated Leg Cur',
			'Smith Machine Stiff-Legged Deadlift',
			'Standing Leg Curl',
			'Stiff-Legged Barbell Deadlift',
			'Stiff-Legged Dumbbell Deadlift',
			'Leaning Leg Curl',

			'Barbell Curl',
			'Cable Hammer Curl',
			'Close Grip Ez Bar Curl',
			'Concentration Curl',
			'Dumbell Alternate Biceps Curl',
			'Dumbell Curl',
			'Ez Bar Curl',
			'Hammer Curl',
			'Incline Dumbell Curl',
			'Over Head Cable Curl',
			'Preacher Dumbell Curl',
			'Reverse Barbell Curl',
			'Spider Curl',
			'Zottman Curl',

			'Bar Wrist Curl Over A Bench (Up Down)',
			'Dumbell Wrist Curl Over A Bench (Up Down)',
			'Reversed Wrist Curl',
			'Sating Palms-Up Barbell Behind The Back Wrist Curl',

			'Dumbell Flyes',
			'Barbell Bench Press',
			'Butterfly',
			'Cable Cross-Over',
			'Decline Bar Bench Press',
			'Decline Dumbell Bench Press',
			'Dips',
			'Dumbell Bench Press',
			'Dumbell Pullover',
			'Incline Bar Bench Press',
			'Incline Dumbell Bench Press',

			'Butt Lift',
			'Flutter Kicks',
			'Glute Kickback',
			'Total Hip',

			'Calf Press On Leg Press Machine',
			'Rocking Standing Caf Raise',
			'Seated Calf Raise',

			'Ab Crunch Machine',
			'Air Bike',
			'Bent Knee Hip Raise',
			'Cable Crunch',
			'Cable Seated Crunch',
			'Cross Body Crunch',
			'Crunches',
			'Decline Crunch',
			'Decline Reverse Crunch',
			'Dumbell Side Bend',
			'Flat Bench Leg Pull In',
			'Hanging Leg Raise',
			'Jackknife Sit Up',
			'Russian Twist',
			'Sit Up',

			'Arnold Dumbell Press',
			'Barbell Shoulder Press',
			'Bend Over Dumbell Rear Delt Rise',
			'Bend Over Low Pulley Side Lateral',
			'Cable Rope Rear Delt Rows',
			'Dumbell Shoulder Press',
			'Front Barbell Rise',
			'Front Cable Rise',
			'Front Dumbell Rise',
			'Front Plate Rise',
			'Seated Bent Over Rear Delt Raise',
			'Seated Side Lateral Raise',
			'Standing Low-Pulley Side Lateral Raise',
			'Standing Side Lateral Raise',
			'Upright Barbell Row',

			'Barbell Hack Squat',
			'Barbell Lunge',
			'Barbell Side Squat',
			'Barbell Squat',
			'Dumbell Lunges',
			'Dumbell Squat',
			'Front Barbell Squat',
			'Leg Extension',
			'Leg Press',
			'Lying Machine Squat',

			'Barbell Deadlift',
			'Bentover Barbell Row',
			'Bentover Dumbell Row',
			'Chin Up',
			'Elevated Cable Rows',
			'Grip Front Lat Pull Down',
			'Hyperextensions',
			'Incline Bench Pull',
			'One Arm Dumbell Row',
			'Pull Up',
			'Seated Cable Row',
			'Seated Good Morning',
			'Stiff Leg Barbell Good Morning',
			'V-Bar Pull Down',

			'Barbell Shrug',
			'Barbell Shrug Behind The Back',
			'Cable Shrugs',
			'Dumbell Shrug',
			'Standing Dumbell Upright Row',

			'Bench Dips',
			'Cable One Arm Triceps Extension',
			'Cable Rope Overhead Triceps Extensions',
			'Close Grip Barbell Bench Press',
			'Close Push Ups',
			'Dips',
			'Kickback',
			'Kneeling Cable Triceps Extension',
			'Lying Barbell Triceps Extension',
			'Lying Dumbell Triceps Extension',
			'Lying Z-Bar Triceps Extension',
			'Reverse Grip Triceps Pushdown',
			'Seated Barbell Triceps Press',
			'Seated Dumbell Triceps Press',
			'Standing Bent-Over Two-Arm Dumbbell Triceps Extension',
			'Triceps Push Down',
			'Triceps Pushdown (Rope)',
			'Triceps Pushdown (V-Bar)',
		];

		var aString = '<select>';
		for(var i = 0; i < eArray.length; i = i + 1){
			aString = aString + '<option value="' + eArray[i] + '">' + eArray[i] + '</option>';
		};
		aString = aString + '</select>';
		$('.weekday .addExercise').live("click", function(){
			$(this).fadeOut();
			$(this).parent().children('div').fadeIn();
			$(this).parent().parent().append('<li><p class="button-small red rounded3 addExercise">Add another exercise</p><div class="createinputs"><div><label for="exerciseName">Exercise Name</label>' + aString + '</div><div><label for="exerciseSets">Sets / Periods</label><input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" /></div><div ><p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p></div><div> <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p></div></div></li>');
		});
	}
	// Gets a button object that inside the .createinputs and returns an array that collects inputs
	function getInfo(obj){

		var weekday = $(obj).parent().parent().parent().parent().attr('id');

		var parent = $(obj).parent().parent();

		var exercisename = $(parent).find('select').val();
		
		var sets = $(parent).find('input').val();


		return arr = {weekday: weekday, exercise: exercisename, sets: sets};

	}
	// After press delete button, button fades out and tells to back-end that which row should be deleted
	function closeTabs(){
		$('.deleteExercise').live("click",function(){
			
			//Tell database to delete the data
			var thisobj = $(this);
			var delarray = getInfo(thisobj);	// Get the array that contains key,value pairs
			var eid = $(this).parent().parent().parent().attr('id');

			//Extract the values
			var day = delarray.weekday;
			var exercise = delarray.exercise;
			var sets = delarray.sets;

			// Post the values that wanted to delete
			$.ajax({
				type: "POST",
				url: "./func/requestsHandler.php",
				data: { operation: 'deleteExercise', day: day, exercise: exercise, sets: sets, exerciseid: eid}
			});

			$(this).parent().parent().parent().fadeOut();
		});
	}

	// After press save button, tells to back-end that which row should be added
	function saveExercise(){
		$('.saveExercise').live('click',function(){
			//Tell database to delete the data
			var thisobj = $(this);
			var subarray = getInfo(thisobj);	// Get the array that contains key,value pairs
			console.log(subarray);
			//Extract the values
			var day = subarray.weekday;
			var exercise = subarray.exercise;
			var sets = subarray.sets;

			// Post the values that wanted to delete
			$.ajax({
				type: "POST",
				url: "./func/requestsHandler.php",
				data: { operation: 'addExercise', day: day, name: exercise, repetition: sets}
			});
			$(this).fadeOut();
		});
	}

	function finishCreation(){
		$('#submitExercise').click(function(){
			window.location.href = '/program.php';
		});
	}
	function editInit(){
		loadExercises();
		finishCreation();
		editStepOne();
		closeTabs();
		openTabs();
		saveExercise();
		saveFirst();
	}

	editInit();
	
	
});