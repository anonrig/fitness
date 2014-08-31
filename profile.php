<? require_once("./func.php");
	
	
	if (isset($_GET['id']))
	{
		$currentUserId = (int) $_GET['id'];
		$currentUser = User::getUserByUserId($currentUserId);
	}
	else {
		if ($_SESSION['userid'] == null)
		{
			header("Location: ./index.php");
		}else 
		{
			$currentUser = User::getUserByUserId($_SESSION['userid']);
		}
	}
	printHeader("Users");
	?>

<body class="redScheme">

   <? printTopbar(); 
	  printNavigationBar("users");	
	    
   ?>   
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>PROFILE</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <a href="users.php">USERS</a>
               <span><? echo strtoupper($currentUser->getName()); ?></span>
                
            </div>
            
        </div>
        
    </div>
    
    <div class="pageContentWrapper">
        
        <div class="container">
            
            <div class="two-thirds column">
                
                <div class="singleInfo">
                    <? $url = $currentUser->getPicture();
                    if (!(isImage($url)))
					{ $url = "http://fitness.desigyn.com/images/default.png"; } else { $url = $currentUser->getPicture(); }  ?>
                    <div class="singleThumb"><img src="<? echo $url;  ?>" alt="" /></div>
                    
                    <div class="singleMeta clearfix">
                        
                         <h1><? echo $currentUser->getName();  ?></h1>
                         <?
                         if (($_SESSION['userid'] != NULL) && ($_SESSION['userid'] == $currentUser->getUserId()))
                         {
	                      echo "<a class=\"singleContact button-small-theme rounded3\" href=\"editprofile.php\">EDIT</a>   ";
                         } else if ($currentUser->getFitnessProgram() != NULL) {
	                       echo "<a class=\"singleContact button-small-theme rounded3\" href=\"program.php?id=" . $currentUser->getFitnessProgram()->getProgramId() . "\">VIEW PROGRAM</a> ";                         
	                       }
                         
                         ?>
                        
                    </div>
                    
                    
                </div>
                
                <div class="pageContent lesspage">
                    
                  <h4 style="margin-bottom: 15px;">MORE ABOUT <? echo strtoupper($currentUser->getName());  ?></h4>
                            
                          <p><? echo $currentUser->getBio();  ?></p>

                              
                    
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
	                             <a class=\"button-small-theme rounded3\" href=\"program.php?id=" . $currentUser->getFitnessProgram()->getProgramId() . "\">VIEW MY PROGRAM</a>"; 
                                    }?>
                                 
                                
                            </div>
                    
                        </li>
                <li class="widget">
                    
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
        
    </div>
    
<? printFooter(); ?>