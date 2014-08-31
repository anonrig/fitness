<? require_once("./func.php");
	
	$currentUser = User::getUserByUserId($_SESSION['userid']);
	$referringSite = $_SERVER['HTTP_REFERER'];
	
	if (!isset($_SESSION['userid'])){
		header("Location: ./index.php");
	}
	if (isset($_GET['user'])){
		$secondUser = $_GET['user'];
		$secondUser = User::getUserByUserId($secondUser);
	} else if (!isset($_GET['user'])) {
		$message = "You should select a user to compare with your program.";
	} 
	
	if ($currentUser->getFitnessProgram() == NULL){
		$message = ucwords($currentUser->getName()) . " you don't have any fitness program. Can not compare. <br><a href=\"$referringSite\" >Go back >></a>";
	} else if ($secondUser->getFitnessProgram() == NULL){
		$message = ucwords($secondUser->getName()) . " doesn't have any fitness program. Can not compare. <br><a href=\"$referringSite\" >Go back >></a>";
	}
	
	if (($secondUser->getUserId() == $currentUser->getUserId())){
		header("Location: ./index.php");
	}
	
	printHeader("Compare Programs");
	?>

<body class="redScheme">
    
    <? printTopbar(); 
	  printNavigationBar("programs");	
	    
   ?>       
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>COMPARISON</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <span>COMPARISON</span>
                
            </div>
            
        </div>
        
    </div>

    <div class="pageContentWrapper">
        <div class="container">
            <div class = "sixteen coloumns">
            <? if (isset($message)){ echo "<h3>$message</h3>";} else { ?>
                <div class = "pageContent" style="width: 44%; float: left;">
                                <? echo "<h3>" . ucwords($currentUser->getName()) .  "</h3>"; ?>
                                <hr>
                                <iframe style="width: 100%; height: 500px;" src="./program.php?id=<? echo $currentUser->getFitnessProgram()->getProgramId(); ?>&showFitness=true" ></iframe>
                </div>
				<div class = "pageContent" style="width: 44%; float: left;">
                                <? echo "<h3>" . ucwords($secondUser->getName()) .  "</h3>"; ?>
                                <hr>
                                <iframe style="width: 100%; height: 500px;" src="./program.php?id=<? echo $secondUser->getFitnessProgram()->getProgramId(); ?>&showFitness=true" ></iframe>
                </div>
                <? } ?>
             </div>
        </div>
    </div>
    
   <?php printFooter(); ?>