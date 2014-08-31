<? require_once("./func.php");
	printHeader("Users");
	
	// Retrieve all the users (as an array)
	
	?>

<body class="redScheme">
    
   <? printTopbar(); 
	  printNavigationBar("users");
	   
   ?>    
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>USERS</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <span>USERS</span>
                
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
	                      $users = User::getAllUsers();
                      } else {
	                      $users = User::getAllUsers($_GET['page']);
                      } 
                      
                      $getAllCount = User::getCount();
                      $getAllCount = $getAllCount[0][0];
                      $getAllCount = ($getAllCount / 10) + 1;
                      if ($_GET['page'] > $getAllCount)
                      {
	                      $getAllCount = 1;
                      }
                      for ($counter = 1; $counter <= $getAllCount; $counter++)
                      {
                      	if (($_GET['page'] == 1) || (!isset($_GET['page']))){
	                      	echo "<li class=\"active\"> <a class=\"button-small-theme rounded3\" href=\"users.php?page=$counter\">$counter</a></li>";
                      	} else if ($_GET['page'] == $counter){
	                      	echo "<li class=\"active\"> <a class=\"button-small-theme rounded3\" href=\"users.php?page=$counter\">$counter</a></li>";
                      	} else {
	                      	echo "<li> <a class=\"button-small-theme rounded3\" href=\"users.php?page=$counter\">$counter</a></li>";
                      	}
	                  }
                      ?>
                      
                      
                      
          </ul>
        </div>
        <div class="container">
        
                    <ul class="trainersPost dd_trainers_widget widget clearfix">
                        <?
 
	                        foreach ($users as $value) {
	                        	$idInfo = $value['id'];
							    $nameInfo = $value['name'];
							    $bioInfo = $value['bio'];
							    $pictureInfo = $value['picture'];
							    
							    if (!isImage($pictureInfo)) {$pictureInfo = "http://fitness.desigyn.com/images/default.png"; }
							    echo "<li class=\"one-third column\">
                            
		                              <div class=\"wrapper\">
		                                  
		                                    <div class=\"postThumb\"><a href=\"$pictureInfo\"><img class=\"programimage\" src=\"". $pictureInfo . "\" alt=\"\" /></a></div>
		                            
		                            <div class=\"postDetails\">
		                                
		                                <a href=\"profile.php?id=" . $idInfo . "\" class=\"postTitle\"><h1>" . $nameInfo . "</h1></a>
		                                <p>" . $bioInfo . "</p>
		                                <a class=\"button-small-theme rounded3\" href=\"profile.php?id=".$idInfo."\">MORE INFO</a>
		                                
		                            </div>
		                                  
		                              </div>
		                            
		                        </li>";
							    
							}
                        
                        ?>
                                                  
                    </ul>

            </div>
        
    </div>
    
<? printFooter(); ?>
