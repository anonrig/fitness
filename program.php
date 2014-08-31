<? require_once("./func.php");
	
	$isMyProgram = false;
	if (!isset($_SESSION['userid'])){
		header("Location: ./index.php?msg=fail");
	}
	$mainUser = User::getUserByUserId($_SESSION['userid']);
	$currentPageId = $_GET['id'];
	if (isset($_GET['id']))
	{
		$currentFP = (int) $_GET['id'];
		$currentFitness = FitnessProgram::getFitnessProgramById($currentFP);
		$currentUser = User::getUserByUserId($currentFitness->getUserId());
		
		if ($currentUser->getUserId() == $_SESSION["userid"]){
			$isMyProgram = true;
		}
	}
	else {
		if ($_SESSION['userid'] == NULL) {
			header("Location: ./index.php");
		} else {
			$currentUser = User::getUserByUserId($_SESSION['userid']);
			$myUserInfo = $currentUser;
			$isMyProgram = true;
			$currentFitness = FitnessProgram::getFitnessProgramByUser($currentUser);
			if ($currentFitness == NULL){
				header("Location: ./create.php");
			}
		}
		
	}
	
	printHeader("Fitness Program");
	?>

<body class="redScheme">

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=301184223311811";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
   <? printTopbar(); 
	  printNavigationBar("users");
	   
   ?>   
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>FITNESS PROGRAM</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <a href="users.php">USERS</a>
               <span>FITNESS PROGRAM</span>
                
            </div>
            
        </div>
        
    </div>
    
    <div class="pageContentWrapper">
        
        <div class="container">
            
            <div class="two-thirds column">
                
                <div class="singleInfo">
                    <? $url=$currentUser->getPicture(); 
                    if (!(isImage($url)))
					{ $url = "http://fitness.desigyn.com/images/default.png"; } else { $url = $currentUser->getPicture(); } ?>
                    <div class="singleThumb"><img style="width: 100%;" src="<? echo $url; ?>" alt="" /></div>
                    
                    <div class="singleMeta clearfix">
                        
                         <h1><? echo strtoupper($currentUser->getName()); ?></h1>
                        <? 
                        	if (!$isMyProgram && $currentUser->getFitnessProgram() != NULL){
                        		$urlCompare = $currentUser->getUserId();
                        		echo '<a style="margin-left: 10px; margin-right: 10px;" class="singleContact button-small-theme rounded3" href="./compare.php?user=' . $urlCompare . '">COMPARE PROGRAMS</a>';
                        		}
                        ?>
                        
                         <a class="singleContact button-small-theme rounded3" href="./profile.php?id=<? echo $currentUser->getUserId(); ?>">VIEW <? echo strtoupper($currentUser->getName()); ?></a>
                         <?
                         	if ($isMyProgram)
                         	echo '<a style="margin-left: 10px; margin-right: 10px;" class="singleContact button-small-theme rounded3" href="./editprogram.php">EDIT PROGRAM</a>'
                         ?>
                    </div>
                    
                    
                </div>
                
                <div class="pageContent lesspage">
                   <div style="margin-bottom:5%;" class="fb-like" data-href="http://fitness.desigyn.com/program.php?id=<? echo $currentPageId; ?>" data-send="false" data-width="450" data-show-faces="false" data-font="segoe ui"></div> 
                  <h4 style="margin-bottom: 15px;">MORE ABOUT <? echo strtoupper($currentUser->getName()); ?>'S FITNESS PROGRAM</h4>
                            
                          <p><? echo $currentFitness->getDetails(); ?></p>

                </div>
                
            </div>
            
            <ul class="sidebar one-third column clearfix">
                
                <li class="widget">
                    <? if ($isMyProgram) { ?>
                    <input type="hidden" id="isMyProgram" value="true" />
                    <? } ?>
                    <h3>PERSONAL INFORMATION</h3>
                        
                    <ul class="classesPost clearfix">
                        

                        <li>
                            
                            <div class="wrapper">
                                
                                  
                            
                                <div class="postDetails profleft">
                                    
                                    <p class="postTitle">Age: <span class="profdet"><? echo $currentUser->getAge();  ?></span></p>
                                    <p class="postTitle">Height:<span class="profdet"><? echo $currentUser->getHeight();  ?></span></p>
                                    <p class="postTitle">Mass:<span class="profdet"><? echo $currentUser->getMass();  ?></span></p>
                                    <p class="postTitle">Experience: <span class="profdet">+<? echo $currentUser->getExperience();  ?> Years</span></p>
                                    <p class="postTitle">Fat Percentage:<span class="profdet">%<? echo $currentUser->getFatPercentage();  ?></span></p>

                                    
                                </div>

                                
                            </div>
                            
                        </li>
                                                
                    </ul>
                    
                </li>
                
                
            </ul>
            
        </div>
        <div class="container">
            <div class="two-thirds column">
            	<!-- Exercises -->
				<div id="exercisesContainer">
	                <div style="display:none" id="exercises0" class="pageContent full">
							<div class="footerModule clearfix extable">
								<h2>%day%</h2>
								<table>
									<tr>
										<td><h3 day="%day%" id="%exerciseId%"><span class="moduleLabel">%name%</span><span class="copyExerciseBtn button-small-theme rounded3">Copy exercise</span></span><span style="text-align:right" class="moduleDescription">%repetitions%</span></h3></td>
									</tr>
								</table>
							</div>
	                </div>
                </div>
                
                <!-- EXERCISE COPY MODAL WINDOW -->
                <div class="copyExerciseModal pageContent full" style="display:none">
                	<h3>Warning</h3>
                	<p class="normalMsg">The following exercises are already in your program, on the same day. Are you sure you want to add a new one?</p>
					<p style="display:none" class="noexMsg">Are you sure you want to add this exercise to your program?</p>
					<div class="exerciseInfo footerModule clearfix" style="display:none">
						<h3>
							<span class="moduleLabel">%exerciseName%</span>
							<span class="moduleDescription">%repetitions%</span>
						</h3>
	
					</div>
					<br/>
					<div class="btnContainer" style="margin-left:auto; margin-right:auto;">
						<a class="confirmModalBtn button-small-theme rounded3" type="button">Confirm</a>
						<a class="closeModalBtn button-small-theme rounded3" type="button">Cancel</a>
					</div>
				</div>
                
                <div class="pageContent full">
                    <li id="comments">
                        <h4>Who commented to my fitness program?</h4>
                        <? 
                        $allcomments = $currentFitness->getAllComments();
                        	foreach ($allcomments as $value) {
							    $nameInfo = $value['name'];
							    $commentInfo = $value['comment_text'];
							    $pictureInfo = $value['picture'];
							    $submitInfo = $value['created_at'];
							     
							     if (!(isImage($pictureInfo))) { $pictureInfo = "http://fitness.desigyn.com/images/default.png"; }
 							    echo "<div class=\"comment last nochildren\">
                            <div class=\"avatar\">
                                <img src=\"". $pictureInfo ."\" alt=\"Avatar\" />
                            </div>
                            <div class=\"text\">
                                <h5>" . $nameInfo . " says:</h5>
                                <p class=\"meta\">" . $submitInfo . "</p>
                                <p>" . $commentInfo ."</p>
                            </div>
                        </div>";
							    
							}
                        ?>

                    </li><!-- //comments -->
                    
                    <li id="leave-comment">
                        <h4>Got something to say? Leave a comment!</h4>
                        <form class="comment-form">
                            <p><label for="name">Name <span>*</span></label>
                                <input type="text" name="name" id="commentname" placeholder="<? echo $mainUser->getName(); ?>" disabled/></p>
                            <p><label for="email">Email <span>*</span></label>
                                <input type="text" name="email" id="commentemail" placeholder="<? echo $mainUser->getEmail(); ?>" disabled/></p>
                                <input type="hidden" id="fitness_id" value="<? echo $currentFitness->getProgramId(); ?>" name="<? echo $currentFitness->getProgramId(); ?>"/>
                            <p><label for="comment">Message <span>*</span></label>
                                <textarea name="comment" id="commentarea"></textarea></p>
                                                        <p style="padding-top: 15px; padding-bottom: 12px;" class="button-big button-small-theme rounded3 red" id="submitComment">SUBMIT YOUR COMMENT</p>
                        </form>
                    </li><!-- //leave-comment -->  
                </div>
            </div>
        </div>
        <div id="scripts">
        	
        	<script src="javascript/showprogram.js"></script>
        </div>
    </div>
    
<? printFooter(); ?>