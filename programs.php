<? require_once("./func.php");
	printHeader("Fitness Programs");
	
	// Retrieve all the users (as an array)
	?>

<body class="redScheme">
    
   <? printTopbar(); 
   if ($_SESSION['userid'] == null){
	  printNavigationBar("index");
	  } else {
		  printNavigationBar("programs");
	  }
   ?>    
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>PROGRAMS</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <span>PROGRAMS</span>
                
            </div>
            
        </div>
        
    </div>
    
    <ul id="reset">
        
  <li><a class="reset" href="#" data-filter=".one-third">reset</a></li>


</ul>
    
    <div class="pageContentWrapper">
        <div class="page_div">
          <ul class="pagination page_people">
                      <? if (($_GET['page']) == NULL) {
	                      $programs = FitnessProgram::getAllPrograms();
                      } else {
	                      $programs = FitnessProgram::getAllPrograms($_GET['page']);
                      } 
                      
                      $getAllCount = FitnessProgram::getCount();
                      $getAllCount = $getAllCount[0][0];
                      $getAllCount = ($getAllCount / 10) + 1;
                      if ($_GET['page'] > $getAllCount)
                      {
	                      $getAllCount = 1;
                      }
                      for ($counter = 1; $counter <= $getAllCount; $counter++)
                      {
                      	if (($_GET['page'] == 1) || (!isset($_GET['page']))){
	                      	echo "<li class=\"active\"> <a class=\"button-small-theme rounded3\" href=\"programs.php?page=$counter\">$counter</a></li>";
                      	} else if ($_GET['page'] == $counter){
	                      	echo "<li class=\"active\"> <a class=\"button-small-theme rounded3\" href=\"programs.php?page=$counter\">$counter</a></li>";
                      	} else {
	                      	echo "<li> <a class=\"button-small-theme rounded3\" href=\"programs.php?page=$counter\">$counter</a></li>";
                      	}
	                  }
                      ?>
                      
                                  
                      
                      
          </ul>
        </div>
        <div class="container">
        
                    <ul class="trainersPost dd_trainers_widget widget clearfix">
                        <?
 
	                        foreach ($programs as $value) {
	                        	$idInfo = $value['id'];
	                        	$userId = $value['user_id'];
	                        	$createdUser = User::getUserByUserId($userId);
							    $nameInfo = $value['title'];
							    $bioInfo = $value['details'];
							    $url=$createdUser->getPicture(); 
							    $userName = $createdUser->getName();
			                    if (!(isImage($url)))
								{ $url = "http://fitness.desigyn.com/images/default.png"; } else { $url = $createdUser->getPicture(); }
							    echo "<li class=\"one-third column\">
                            
		                              <div class=\"wrapper\">
		                                  
		                                    <div class=\"postThumb\"><a href=\"./program.php?id=" . $idInfo . "\"><img class=\"programimage\" src=\"". $url . "\" alt=\"\" /></a></div>
		                            
		                            <div class=\"postDetails\">
		                                
		                                <a href=\"profile.php?id=\"".$idInfo."\" class=\"postTitle\"><h1>" . $nameInfo . "</h1></a>
		                                <p>View "  . $userName . "'s fitness program</p>
		                                <a class=\"button-small-theme rounded3\" href=\"program.php?id=".$idInfo."\">MORE INFO</a>
		                                
		                            </div>
		                                  
		                              </div>
		                            
		                        </li>";
							    
							}
                        
                        ?>
                                                  
                    </ul>

            </div>
        
    </div>
    
<? printFooter(); ?>
