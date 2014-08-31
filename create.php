<? require_once("./func.php");

	if ($_SESSION['userid'] == null){
		header("Location: ./index.php");
	} else {
		$currentUser = User::getUserByUserId($_SESSION['userid']);
		$currentFitness = FitnessProgram::getFitnessProgramByUser($currentUser);
		if ($currentFitness != null){
			header("Location: ./program.php");
		}
	}
	printHeader("Create a fitness program");
	
		$exercisesArray = array(
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
	);
	sort($exercisesArray);
	?>

<body class="redScheme">
    
   <? printTopbar(); 
	  printNavigationBar("users");
	   
   ?>

    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>CREATE A FITNESS PROGRAM</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.html">HOME</a>
               <a href="profile.html">PROFILE</a>
               <span>CREATE A FITNESS PROGRAM</span>
                
            </div>
            
        </div>
        
    </div>
    
    <div class="pageContentWrapper">
        
        <div class="container">
            
            <div class="sixteen columns">
                
                <div class="pageContent">
                    
                        <h4 style="margin-bottom: 15px;">CREATING A FITNESS PROGRAM</h4>
                            
                        <p>To add a program, you need to create an exercise day and then, create an exercise according to your pleasure.</p>
                        <br>
                        <br>
                        <div id="stepOne">
                          <div>
                            <label for="exerciseName">Title For Your Program</label>
                            <input type="text" name="exerciseName" id="exerciseName" placeholder="" required="required" maxlength="40" />
                          </div>
                          <div>
                            <label for="exerciseName">Detailed Info For Your Program</label>
                            <textarea></textarea>
                          </div>
                           <p class="exbuttons button-small red rounded3" id="stepOneButton">Next Step</p>
                        </div>
                
                    
                    <div id="stepTwo">
                      <ul class="weekday" id="1">
                          <h4>Monday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                     <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul>
                      <ul class="weekday" id="2">
                          <h4>Tuesday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                     
                                     <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                   
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul>  
                      <ul class="weekday" id="3">
                          <h4>Wednesday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                     <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul>
                      <ul class="weekday" id="4">
                          <h4>Thursday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                    <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul> 
                      <ul class="weekday" id="5">
                          <h4>Friday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                     <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul>  
                      <ul class="weekday" id="6">
                          <h4>Saturday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                     <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul>   
                      <ul class="weekday" id="7">
                          <h4>Sunday</h4>
                          <hr>
                          <li>
                              <p class="button-small red rounded3 addExercise">Add another exercise</p>
                              <div class="createinputs">
                                  <div>
                                     <label for="exerciseName">Exercise Name</label>
                                     <select>
                                     <? 
	                                     foreach ($exercisesArray as $exercise)
	                                     {
		                                     echo "<option value=\"$exercise\">$exercise</option>";
	                                     }
                                     ?>
                                     </select>
                                  </div>
                                  <div>
                                     <label for="exerciseSets">Sets / Periods</label>
                                     <input type="text" name="exerciseSets" id="exerciseSets" placeholder="" required="required" maxlength="40" />
                                  </div>
                                  <div >
                                     <p class="deleteExercise exbuttons button-small red rounded3">Delete Exercise</p>
                                  </div>
                                  <div>
                                     <p class="saveExercise exbuttons button-small red rounded3">Save Exercise</p>
                                  </div>
                              </div>
                          </li>
                      </ul>     
                      <p class="button-big red rounded3" id="submitExercise">Finish Your Program</p>
                    </div>

                </div>
                
            </div>
            
            
            
        </div>
        
    </div>
    
   <? printFooter(); ?>
    <script type="text/javascript" src="javascript/createprogram.min.js"></script>   
