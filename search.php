<? require_once("./func.php");
	printHeader("Search");
	?>

<body class="redScheme">
    
   <? printTopbar(); 
	  printNavigationBar("search");
	  
	  $searchTerm = $_GET['search'];
	   
   ?>    
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>SEARCH</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <span>SEARCH</span>
                
            </div>
            
        </div>
        
    </div>
    
    <ul id="reset">
        
  <li><a class="reset" href="#" data-filter=".one-third">reset</a></li>


</ul>
    
      <div class="pageContentWrapper">
        <div class="container">
            <div class = "sixteen coloumns">
                <div class = "pageContent">
                        <h4 style="margin-bottom:2%;">SEARCH</h4>
                        <p>No, I am not Google. I am Goggle. And I can only search in Users. Lame...</p>
                        <hr>
                        <div class="searchlogo">
                            <a href="search.php"><img src="images/goggle.png" alt="Yeah that's me"/></a>
                        </div>
                        <div class="searchInputDiv">
                            
                                 <input type="text" name="searchInput" id="searchInput" placeholder="<? echo $searchTerm; ?>" required="required" maxlength="40" value="<? echo $searchTerm; ?>" />
                                 <p class="button-small-theme rounded3" id="searchSubmit">Search</p>
                            
                        </div>

                        <div class="searchresults">
                            <ul>
                               
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>    
<? printFooter(); ?>