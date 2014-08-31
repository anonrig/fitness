<?php
	require_once("func/include/autoLoader.php");
	session_start();
 	
	
function isImage($url)
{
	$params = array('http' => array(
	          'method' => 'HEAD'
	       ));
	$ctx = stream_context_create($params);
	$fp = @fopen($url, 'rb', false, $ctx);
	if (!$fp) 
	return false;  // Problem with url
	
	$meta = stream_get_meta_data($fp);
	if ($meta === false)
	{
	    fclose($fp);
	    return false;  // Problem reading data from url
	}
	
	$wrapper_data = $meta["wrapper_data"];
	if(is_array($wrapper_data)){
	  foreach(array_keys($wrapper_data) as $hh){
	      if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19 
	      {
	        fclose($fp);
	        return true;
	      }
	  }
	}
	
	fclose($fp);
	return false;
}
	
function printHeader($title)
{
	echo "<!DOCTYPE html>
	<!--[if lt IE 7 ]><html class=\"ie ie6\" lang=\"en\"> <![endif]-->
	<!--[if IE 7 ]><html class=\"ie ie7\" lang=\"en\"> <![endif]-->
	<!--[if IE 8 ]><html class=\"ie ie8\" lang=\"en\"> <![endif]-->
	<!--[if (gte IE 9)|!(IE)]><!--><html lang=\"en\"> <!--<![endif]-->
	<head>
	
		<!-- Basic Page Needs
	  ================================================== -->
		<meta charset=\"utf-8\">
		<title>" . $title . "</title>
		<meta name=\"description\" content=\"\">
		<meta name=\"author\" content=\"\">
        <meta name=\"SKYPE_TOOLBAR\" content=\"SKYPE_TOOLBAR_PARSER_COMPATIBLE\" />
        <meta name=\"format-detection\" content=\"telephone=no\" />
		<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\">
		<!-- Mobile Specific Metas
	  ================================================== -->
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
	    <link rel=\"shortcut icon\" href=\"http://fitness.desigyn.com/stylesheets/logo.ico\">   
	        <!-- CSS
	  ================================================== -->
	        <link rel=\"stylesheet\" href=\"stylesheets/base.min.css\">
	        <link rel=\"stylesheet\" href=\"stylesheets/skeleton.min.css\">
	        <link rel=\"stylesheet\" href=\"stylesheets/colors/red.min.css\">
	        <link rel=\"stylesheet\" href=\"stylesheets/layout.min.css\">
	        <link rel=\"stylesheet\" href=\"stylesheets/btn.min.css\">
	        <link rel=\"stylesheet\" href=\"stylesheets/flexslider.min.css\">
	        <link rel=\"stylesheet\" href=\"stylesheets/superfish.min.css\">
	
	        <!-- Google Fonts -->
	            
	        <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic|Oswald:400,300,700' rel='stylesheet' type='text/css'>
	        
		<!--[if lt IE 9]>
			<script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>
		<![endif]-->
		
		<!-- include jQuery -->
	    <script src=\"javascript/lib/jquery-1.8.0.min.js\"></script>
	    <!-- Include the plug-in -->
	    <script src=\"javascript/plugins/jquery.isotope.min.js\"></script>
	    <script src=\"javascript/plugins/jquery.flexslider-min.js\"></script>
	    <script type=\"text/javascript\" src=\"javascript/plugins/superfish.min.js\"></script>
	    <script type=\"text/javascript\" src=\"javascript/plugins/hoverIntent.min.js\"></script>
	    <script type=\"text/javascript\" src=\"javascript/plugins/form.min.js\"></script>
	    
	    <!-- Include the initializers & flow -->
	    <script type=\"text/javascript\" src=\"javascript/responseHandler.min.js\"></script>
	    <script src=\"javascript/main.js\"></script>
	
		<!-- Favicons
		================================================== -->
		<link rel=\"shortcut icon\" href=\"images/favicon.html\">
		<link rel=\"apple-touch-icon\" href=\"images/apple-touch-icon.html\">
		<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"images/apple-touch-icon-72x72.html\">
		<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"images/apple-touch-icon-114x114.html\">
	
		<!-- Bootstrap modal -->
		<link rel='stylesheet' href='bootstrap/css/bootstrap-modal.css'/>
		<script src='bootstrap/js/bootstrap-modalmanager.js'></script>
		<script src='bootstrap/js/bootstrap-modal.js'></script>
	</head>";
}

function printTopbar()
{
		 
	if (($_SESSION['authenticated'] == true) && (isset($_SESSION['authenticated'])))
	{
	$headerCurrentUser = User::getUserByUserId($_SESSION['userid']);
	 $program = $headerCurrentUser->getFitnessProgram();
	 $currentFitness = FitnessProgram::getFitnessProgramByUser($headerCurrentUser);
     if ($currentFitness != NULL) {
	     $latestNotifications = $currentFitness->getNotification();	
     }
	 
		echo "<div class=\"topBar\">

        <div class=\"container\">
        
            <div class=\"sixteen columns\">
                
                
                <ul class=\"topBarMenu clearfix\">
                    <li class=\"profileModule\">";
                        
                        if ($headerCurrentUser->getGender() == "male"){
	                        echo "<a class=\"profile male\" href=\"#\">" . $_SESSION['name'] . "</a>";
                        } else {
	                        echo "<a class=\"profile female\" href=\"#\">" . $_SESSION['name'] . "</a>";
                        }
                        
                        echo "<div class=\"footerModule clearfix\">
                                
                                <div class=\"profileList clearfix\">
                                         <div class=\"profileListItem\" id=\"profileLinkFirst\"><a href=\"profile.php?id=" . $_SESSION['userid'] . "\">Profile</a></div>";
                                        
                                         if (!isset($program)){
	                                         echo "<div class=\"profileListItem\" id=\"profileLinkThird\"><a href=\"create.php\">Program</a></div>";
                                         }else {
											$headerFitnessId = $program->getProgramId();
	                                         echo "<div class=\"profileListItem\" id=\"profileLinkThird\"><a href=\"program.php?id=" . $headerFitnessId . "\">Program</a></div>";
                                         }
                                        
                                        echo "<div class=\"profileListItem\" id=\"profileLinkSecond\"><a href=\"logout.php\">Logout</a></div>
                                </div>
                        </div>
                    
                    </li>
                    <li class=\"notificationsModule\">
                        <a class=\"notifications\" href=\"#\">Notifications</a>
                        <div class=\"footerModule clearfix\">
                                
                                
                                <div class=\"notificationsList clearfix\">";
                                
                                	
                               if ($latestNotifications == null){
	                               echo "<a class=\"notificationsListItem\" href=\"#\">No comments</a>";
                               } else {
                               /* var_dump($latestNotifications); */
	                               foreach ($latestNotifications as $value) {
			                        	$idInfo = ucwords($value['name']);
			                        	$programId = $value['program_id'];
									    echo "<a class=\"notificationsListItem\" href=\"program.php?id=$programId\">$idInfo commented</a>";
									}
                               }
                                    
                                echo "</div>
                        </div>
                    </li>
                    
                    
                    <li class=\"contactModule\">
                        
                        <a class=\"contact signed_in\" href=\"#\">Contact</a>
                        <div class=\"footerModule clearfix\">
                                <a href=\"#\" class=\"contactClose\">X</a>
                                <div class=\"contactForm clearfix\">
                            
                               
                                    <form id=\"contactForm\"  class=\"clearfix\">
                                      <ul>

                                        <li>
                                          <label for=\"senderName\">Your Name</label>
                                          <input type=\"text\" name=\"senderName\" id=\"senderName\" placeholder=\"\" required=\"required\" maxlength=\"40\" />
                                        </li>

                                        <li>
                                          <label for=\"senderEmail\">Your Email Address</label>
                                          <input type=\"text\" name=\"senderEmail\" id=\"senderEmail\" placeholder=\"\" required=\"required\" maxlength=\"50\" />
                                        </li>

                                        <li>
                                          <label for=\"message\" style=\"padding-top: .5em;\">Your Message</label>
                                          <textarea name=\"message\" id=\"message\" placeholder=\"\" required=\"required\" cols=\"80\" rows=\"10\" maxlength=\"10000\"></textarea>
                                        </li>

                                      </ul>

     
                                        <input type=\"submit\" class=\"button-small rounded3 red\" id=\"sendMessage\" name=\"sendMessage\" value=\"Send Email\" />
                                    </form>

                                    
                                </div>
                        </div>
                         
                    
                    </li>";
		
                   if ($headerCurrentUser->isAdmin()) echo " <li>
                    	<a class=\"adminmodule\" href=\"admin/\">Admin Panel</a>
                    </li>";
                    
                    echo "<li>
                        <div class=\"topBarSearch\">
                                    
                            <form method='get' action='./search.php'>
                            <!-- Search Feature -->
                            <input id=\"search\" type=\"text\" onblur=\"if(this.value=='')this.value='';\" onfocus=\"if(this.value=='')this.value='';\" value=\"" . $_GET['search'] ."\" name=\"search\">
							</form>
                          
                            
                        </div>
                    </li>    
                </ul>
            
             
            
                
            </div>
        
        </div>

    </div>";
	} else {
	
	
		echo " <div class=\"topBar\">
	
	        <div class=\"container\">
	        
	            <div class=\"sixteen columns\">
	                
	                
	                <ul class=\"topBarMenu clearfix\">
	                
	                    <li class=\"openingHoursModule\">
	                        
	                        <a class=\"openingHours\" href=\"#\">Login</a>
	                        <div class=\"footerModule clearfix\">
	                            
	                                <a href=\"#\" class=\"loginClose\">X</a>
	                                
	                                <div class=\"loginForm clearfix\">
	                            
	                               
	                                    <form id=\"loginForm\" class=\"clearfix\" method=\"post\">
	                                      <ul>
	
	                                        <li>
	                                          <label for=\"senderUsername\">Username</label>
	                                          <input type=\"text\" name=\"senderUsername\" id=\"senderUsername\" placeholder=\"\" required=\"required\" maxlength=\"40\" />
	                                        </li>
	
	                                        <li>
	                                          <label for=\"senderPassword\">Password</label>
	                                          <input type=\"password\" name=\"senderPassword\" id=\"senderPassword\" placeholder=\"\" required=\"required\" maxlength=\"50\" />
	                                        </li>
	
	                                         <li>
	                                            <input type=\"button\" class=\"button-small button-new rounded3 red\" id=\"login\" name=\"login\" value=\"Log In\" />
	                                         </li>
	                                        </ul>
	                                    </form>
	
	                                    <div id=\"sendingMessage\" class=\"statusMessage\"><p>Logging in. Please wait...</p></div>
	                                    <div id=\"successMessage\" class=\"statusMessage\"><p>Logged in. Redirecting...</p></div>
	                                    <div id=\"failureMessage\" class=\"statusMessage\"><p>Encountered problem. Please try again later.</p></div>
	                                    <div id=\"incompleteMessage\" class=\"statusMessage\"><p>Please complete all the fields if you want to login.</p></div>
	                                </div>
	                        </div>
	                    
	                    </li>
	                    
	                    
	                    <li class=\"registerModule\">
	                        
	                        <a class=\"register\" href=\"register.php\">Register</a>
	                    </li>
	                    <li class=\"contactModule\">
	                        
	                        <a class=\"contact\" href=\"#\">Contact</a>
	                        <div class=\"footerModule clearfix\">
	                                <a href=\"#\" class=\"contactClose\">X</a>
	                                <div class=\"contactForm clearfix\">
	                            
	                               
	                                    <form id=\"contactForm\"  class=\"clearfix\" method=\"post\">
	                                      <ul>
	
	                                        <li>
	                                          <label for=\"senderName\">Your Name</label>
	                                          <input type=\"text\" name=\"senderName\" id=\"senderName\" placeholder=\"\" required=\"required\" maxlength=\"40\" />
	                                        </li>
	
	                                        <li>
	                                          <label for=\"senderEmail\">Your Email Address</label>
	                                          <input type=\"email\" name=\"senderEmail\" id=\"senderEmail\" placeholder=\"\" required=\"required\" maxlength=\"50\" />
	                                        </li>
	
	                                        <li>
	                                          <label for=\"message\" style=\"padding-top: .5em;\">Your Message</label>
	                                          <textarea name=\"message\" id=\"message\" placeholder=\"\" required=\"required\" cols=\"80\" rows=\"10\" maxlength=\"10000\"></textarea>
	                                        </li>
	
	                                      </ul>
	
	     
	                                        <input type=\"submit\" class=\"button-small rounded3 red\" id=\"sendMessage\" name=\"sendMessage\" value=\"Send Email\" />
	                                    </form>
	
	                                    <div id=\"sendingMessage\" class=\"statusMessage\"><p>Logging in. Please wait...</p></div>
	                                    <div id=\"successMessage\" class=\"statusMessage\"><p>Logged in. Redirecting...</p></div>
	                                    <div id=\"failureMessage\" class=\"statusMessage\"><p>Encountered problem. Please try again later.</p></div>
	                                    <div id=\"incompleteMessage\" class=\"statusMessage\"><p>Please complete all the fields if you want to login.</p></div>
	                                </div>
	                        </div>
	                         
	                    
	                    </li>
	                    <li>
	                        <div class=\"topBarSearch\">
	                                    
	                            <form method='get' action='./search.php'>
	                            <!-- Search Feature -->
	                            <input id=\"search\" type=\"text\" onblur=\"if(this.value=='')this.value='';\" onfocus=\"if(this.value=='')this.value='';\" value=\"" . $_GET['search'] ."\" name=\"search\">
								</form>	                            
	                        </div>
	                    </li>    
	                </ul>
	            
	             
	            
	                
	            </div>
	        
	        </div>
	
	    </div>";
    }
}

function printNavigationBar($currentPage)
{
	
	echo "<header>
        
        <div class=\"container clearfix\">
            
            <div class=\"sixteen columns\">
                
                <div class=\"logo\">
                
                    <a href=\"index.php\">
                        
                         <img src=\"images/logo.png\" alt=\"\" />
                            <span>FITNESS APPLICATION</span>
                         
                    </a>

                </div>
                <nav class=\"mainNav\">
                    <ul class=\"nav clearfix sf-menu sf-js-enabled sf-shadow\">";
                    
	if (($_SESSION['authenticated'] == true) && (isset($_SESSION['authenticated'])))
	{
		                    if ($currentPage == "index")
                    {
	                    echo "<li><a class=\"active\" href=\"index.php\">Home</a></li>
                        <li><a href=\"programs.php\">Programs</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "programs")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a class=\"active\" href=\"programs.php\">Programs</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "users")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"programs.php\">Programs</a></li>
                        <li><a class=\"active\" href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "search")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"programs.php\">Programs</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a class=\"active\" href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "faq")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"programs.php\">Programs</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a class=\"active\" href=\"faq.php\">F.A.Q</a></li>";
                    }
    } else {
     	
                    if ($currentPage == "index")
                    {
	                    echo "<li><a class=\"active\" href=\"index.php\">Home</a></li>
                        <li><a href=\"register.php\">Register</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "register")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a class=\"active\" href=\"register.php\">Register</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "users")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"register.php\">Register</a></li>
                        <li><a class=\"active\" href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "search")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"register.php\">Register</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a class=\"active\" href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "faq")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"register.php\">Register</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a href=\"search.php\">Search</a></li>
                        <li><a class=\"active\" href=\"faq.php\">F.A.Q</a></li>";
                    } else if ($currentPage == "search")
                    {
	                    echo "<li><a href=\"index.php\">Home</a></li>
                        <li><a href=\"register.php\">Register</a></li>
                        <li><a href=\"users.php\">Users</a></li>
                        <li><a class=\"active\" href=\"search.php\">Search</a></li>
                        <li><a href=\"faq.php\">F.A.Q</a></li>";
                    }
               

	}                        
                    
                    echo "</ul>
                
                    <div class=\"container mobileNav\">
                
                        <div class=\"sixteen columns\"></div>
                
                    </div>
                    
                </nav>
                
            </div>
            
        </div>
        
    </header>";
}

function printFooter()
{
$userCount = User::getCount();
	$fitnessCount = FitnessProgram::getCount();

	echo"    <footer>
        <div class=\"container clearfix\">
            <div class=\"one-third column\">
                <img style=\"margin-bottom: 15px;\" src=\"images/footerLogo.png\" alt=\"\" />
                <p>As CS308 project group members we condemn the violence of the police, attitude of the government and fully support our brothers and sisters who are standing up against the ruling.</p>
            </div>

            <div class=\"one-third column\">
                <div class=\"footerModule clearfix\">
                    <h2>ABOUT US</h2>
                    <h3><span class=\"moduleLabel\">FACEBOOK</span><span class=\"moduleDescription\"><a href='http://facebook.com/desigyn'>fb.com/desigyn</a></span></h3>
                    <h3 class=\"odd\"><span class=\"moduleLabel\">EMAIL</span><span class=\"moduleDescription\"><a href=\"#\">info@desigyn.com</a></span></h3>
                </div>
            </div>
            <div class=\"one-third column\">
                 <div class=\"footerModule clearfix\">
                    <h2>STATISTICS</h2>
                    <h3 class=\"odd\"><span class=\"moduleLabel\">USERS</span><span class=\"moduleDescription\">"  . $userCount[0][0] .  " Unique Users</span></h3>
                    <h3><span class=\"moduleLabel\">PROGRAMS</span><span class=\"moduleDescription\">" . $fitnessCount[0][0] . " Fitness Programs</span></h3>
                 </div>
            </div>
        </div>  
    </footer>
    
      
    <div class=\"smallFooter\">
        
        <div class=\"container\">
            
            <div class=\"contentLeft eight columns\">COPYRIGHT ©DESIGYN 2013.</div>
            <div class=\"contentRight eight columns\">DESIGNED WITH LOVE BY <a href=\"http://www.sabanciuniv.edu\">CS308 STUDENTS</a>.</div>
            
        </div>
        
    </div>
    
        
</body>
</html>";
}
?>