<?
require_once("./func.php");
printHeader("Homepage");
?>
<body class="redScheme">
    
 <? printTopbar(); 
 printNavigationBar("index");
 $programs = FitnessProgram::getAllPrograms();
 
 if (isset($_GET['msg']) && ($_GET['msg'] == "fail")){
	 echo "<div id=\"mustLoginMessage\" class=\"statusMessage\"><p>You must login to view that page.</p></div>
";
 }

 ?>    
 
 <div class="sliderWrapper">
    
  <div id="slider" class="flexslider">

      <div class="whiteTop"></div>
      <div class="whiteTop2"></div>
      
      <ul class="slides">
        
        <li>
            <a href="./create.php"><img alt="" src="images/slider/slide1.jpg" /></a>
            
            <div class="slidesDescription">
                
                <h2>FITNESS PROGRAM</h2>
                <span>Create your fitness program no more than 90 seconds!</span>
                <a class="button-big rounded3 grey" href="./create.php">LEARN MORE</a>
                
            </div>
            
        </li>
        
        <li>
            <a href="./register.php"><img alt="" src="images/slider/slide3.jpg" /></a>
            <div class="slidesDescription">
                
                <h2>REGISTER NOW</h2>
                <span>It's really easy to register to fitnessApp!</span>
                <a class="button-big rounded3 grey" href="./register.php">LEARN MORE</a>
                
            </div>
            
        </li>
        <li>
            <a href="./users.php"><img alt="" src="images/slider/slide2.jpg" /></a>
            <div class="slidesDescription">
                
                <h2>MEET OUR FAMILY</h2>
                <span>Want to see our users?</span>
                <a class="button-big rounded3 grey" href="./users.php">LEARN MORE</a>
                
            </div>	 
        </li>
        <li>
            <a href="./search.php"><img alt="" src="images/slider/slide4.jpg" /></a>
            
            <div class="slidesDescription">
                
                <h2>CURIOUS? SEARCH IT</h2>
                <span>Are you curious about our users? Just search it.</span>
                <a class="button-big rounded3 grey" href="./search.php">LEARN MORE</a>
                
            </div>	 
        </li>
        <!-- items mirrored twice, total of 12 -->
    </ul>
    
</div>

<div id="carousel">

    <ul class="slides container">
        
        <li class="four columns">
            
            <img alt="" src="images/slider/slideThumb1.jpg" />
            <div class="navDescription">
                
              <h3>FITNESS PROGRAM</h3>
              <p>Create your fitness program no more than 90 seconds!</p>
              
          </div>
          
      </li>
      
      <li class="four columns">
        
          <img alt="" src="images/slider/slideThumb2.jpg" />
          <div class="navDescription">
              
             <h3>REGISTER NOW</h3>
             <p>It's really easy to register to fitnessApp!</p>
             
         </div>
         
     </li>
     <li class="four columns">
        
        <img alt="" src="images/slider/slideThumb3.jpg" />
        
        <div class="navDescription">
            
           <h3>MEET OUR FAMILY</h3>
           <p>Want to see our users?</p>
           
       </div>
       
   </li>
   
   <li class="four columns">
       <img alt="" src="images/slider/slideThumb4.jpg" />
       <div class="navDescription">
           
         <h3>CURIOUS? SEARCH IT</h3>
         <p>Are you curious about our users? Just search it</p>
         
     </div>
     
 </li>
 <!-- items mirrored twice, total of 12 -->
</ul>

</div>

</div>

<div class="container"><div class="sixteen columns horizontalAd"><a href="./users.php"><img src="images/ads/horizontal.jpg" alt="" /></a></div></div>

<div class="homeWidgetModule">
    
    <ul class="widgetModule container clearfix ">
        <h3 class="indexwidget">VIEW ALL PROGRAMS<span><a href="programs.php">view all</a></span></h3>
        <li class="one-third column widget upper" style="margin-left:0px;">
            
            <div class="container">
                

                
                <ul class="trainersPost dd_trainers_widget widget clearfix newprogramcss ">

                        <?
 
	                        foreach ($programs as $value) {
	                        	$idInfo = $value['id'];
	                        	$userId = $value['user_id'];
	                        	$createdUser = User::getUserByUserId($userId);
							    $nameInfo = $value['title'];
							    $bioInfo = $value['details'];
							    $userPicture = $createdUser->getPicture();
							    if (!(isImage($userPicture))) { $userPicture = "http://fitness.desigyn.com/images/default.png"; }
							    echo "<li class=\"one-third column\">
                            
		                              <div class=\"wrapper\">
		                                  
		                                    <div class=\"postThumb\"><a href=\"./program.php?id=" . $idInfo . "\"><img class=\"programimage\" src=\"". $userPicture . "\" alt=\"\" /></a></div>
		                            
		                            <div class=\"postDetails\">
		                                
		                                <a href=\"program.php?id=" .$idInfo."\" class=\"postTitle\"><h1>" . $nameInfo . "</h1></a>
		                                <p>" . $bioInfo . "</p>
		                                <a class=\"button-small-theme rounded3\" href=\"program.php?id=".$idInfo."\">MORE INFO</a>
		                                
		                            </div>
		                                  
		                              </div>
		                            
		                        </li>";
							    
							}?>
            </ul>
          </div>
        </ul>
      </div>
                        
                        <? printFooter(); ?>
              