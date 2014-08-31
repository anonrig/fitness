<? require_once("./func.php");
	
	if ($_SESSION['userid'] == null)
	{
		header("Location: ./index.php");
	}else 
	{
		$currentUser = User::getUserByUserId($_SESSION['userid']);
	}

	printHeader("Edit Profile");
	?>

<body class="redScheme">

     <? printTopbar(); 
	  printNavigationBar("index");	
	 ?>
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>PROFILE</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.html">HOME</a>
                <a href="profile.html">PROFILE</a>
               <span>EDIT PROFILE</span>

                
            </div>
            
        </div>
        
    </div>
    
    <div class="pageContentWrapper">
        
        <div class="container">
            
            <div class="two-thirds column">
                
                <div class="singleInfo">
                    
                    <div class="singleThumb"><img src="<? echo $currentUser->getPicture(); ?>" alt="" /></div>
                    
                    <div class="singleMeta clearfix">
                        
                         <h1><? echo strtoupper($currentUser->getName());?></h1>
                         <p class="singleContact button-small-theme rounded3" id="saveeditprofile">SAVE PROFILE</p>
                        
                    </div>
                    
                    
                </div>
                
                <div class="pageContent lesspage editprofilepage">
                    
                  <h4 style="margin-bottom: 15px;">MORE ABOUT <? echo strtoupper($currentUser->getName());?></h4>
                            
                          <textarea class="editbio"><? echo $currentUser->getBio() ?></textarea>

                              
                    
                </div>
                
            </div>
            
            <ul class="sidebar one-third column clearfix">
                <li class="widget">
                    <h3>PROFILE INFORMATION</h3>
                            <div class="classesInfo">
                                  
                                <h3>COMPLETENESS LEVEL</h3>           
                               
                                <div class="difficultyBar">
                                    
                                    <div class="difficultyLevel" style="width: 
                                    <? if ($currentUser->getFitnessProgram() == null)
                                     { echo "50%"; } else { echo "100%"; } ?>
                                     "></div>
                                    
                                </div>  
                                
                                <ul class="difficultyText clearfix">
                                    
                                    <? if ($currentUser->getFitnessProgram() == null)
                                    {
	                                    echo "<li><span>LOW</span></li>
                                    <li><span class=\"active\">MEDIUM</span></li>
                                    <li><span>HIGH</span></li>";
                                    } else {
	                                    echo "<li><span>LOW</span></li>
                                    <li><span>MEDIUM</span></li>
                                    <li><span class=\"active\">HIGH</span></li>";
                                    }?>
                                    
                                    
                                </ul>
                                <? if (($currentUser->getFitnessProgram() == null) && ($_SESSION['userid'] != NULL) && ($_SESSION['userid'] == $currentUser->getUserId()))
                                    {
	                                    echo "<h3>FOR COMPLETION TO %100</h3>
                                 
                                 <a class=\"button-small-theme rounded3\" href=\"create.php\">CREATE PROGRAM</a>";
                                    } else if ($currentUser->getFitnessProgram() != null) {
	                                 	echo "<h3>FITNESS PROGRAM</h3>
	                             <a class=\"button-small-theme rounded3\" href=\"profile.php?id=" . $currentUser->getUserId() . "\">VIEW MY PROGRAM</a>"; 
                                    }?>

                            </div>
                    
                        </li>
                <li class="widget">
                    
                    <h3>PERSONAL INFORMATION</h3>
                        
                    <ul class="classesPost clearfix">
                        

                        <li>
                            
                            <div class="wrapper">
                                
                                  
                            
                                <div class="postDetails profleft" id="editprofiledetails">
                                    
                                    <p class="postTitle">Age: <span class="profdet"><input value="<? echo $currentUser->getAge() ?>" type="text" name="age" placeholder="" required="required" maxlength="50" /></span></p>
                                    <p class="postTitle">Height:<span class="profdet"><input value="<? echo $currentUser->getHeight() ?>" type="text" name="height" placeholder="" required="required" maxlength="50" /></span></p>
                                    <p class="postTitle">Mass:<span class="profdet"><input value="<? echo $currentUser->getMass() ?>" type="text" name="mass" placeholder="" required="required" maxlength="50" /></span></p>
                                    <p class="postTitle">Experience: <span class="profdet"><input value="<? echo $currentUser->getExperience() ?>" type="text" name="experience" placeholder="" required="required" maxlength="50" /></span></p>
                                    <p class="postTitle">Fat Percentage:<span class="profdet"><input value="<? echo $currentUser->getFatPercentage() ?>" type="text" name="fat_percentage" placeholder="" required="required" maxlength="50" /></span></p>
                                    <p class="postTitle">Picture URL<span class="profdet"><input value="<? echo $currentUser->getPicture() ?>" type="text" maxlength="500" required="required" placeholder="" name="picture" value="2"></span></p>

                                    
                                </div>
                                
                            </div>
                            
                        </li>
                    </ul>
                    
                </li>
                
                
            </ul>
            
        </div>
        
    </div>
    
<? printFooter(); ?>