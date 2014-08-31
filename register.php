<? require_once("./func.php");
	printHeader("Register"); ?>

<body class="redScheme">
    
   <? printTopbar(); 
	  printNavigationBar("register");
	   
   ?>  
        
    <div class="pageInfo">
        
        <div class="container">
            
            <div class="eight columns pageTitle">
                
                <h1>REGISTER</h1>
                
            </div>
            
            <div class="eight columns breadcrumb">
                
               <a href="index.php">HOME</a>
               <span>REGISTER</span>
                
            </div>
            
        </div>
        
    </div>

    <div class="pageContentWrapper">
        <div class="container">
            <div class = "sixteen coloumns">
                <div class = "pageContent">
                    
                        <h3>Register</h3>
                        <hr>
                        <form id="regform"> 
                            <div class="regParentCol">
                                <div class="regCol">
                                    <div> 
                                        <label for="namesignup" data-icon="u">Name</label>
                                        <input id="namesignup" name="name" required="required" type="text"  />
                                    </div>
                                    <div> 
                                        <label for="usernamesignup">Username</label>
                                        <input id="usernamesignup" name="username" required="required" type="text" />
                                    </div>
                                    <div> 
                                        <label for="emailsignup"> E-mail</label>
                                        <input id="emailsignup" name="email" required="required" type="email" /> 
                                    </div>
                                    <div> 
                                        <label for="passwordsignup">Password </label>
                                        <input id="passwordsignup" name="password" required="required" type="password"/>
                                    </div>
                                    <div> 
                                        <label for="passwordsignup_confirm">Password Confirmation </label>
                                        <input id="passwordsignup_confirm" name="password_confirm" required="required" type="password"/>
                                    </div>
                                    <div> 
                                        <label for="imagesignup">Image URL</label>
                                        <input id="imagesignup" name="picture" required="required" type="text"  />
                                    </div>
                                </div>
                                <div class="regCol">
                                    <div> 
                                        <label for="ageregister">Age </label>
                                        <input id="ageregister" name="age" required="required" type="text"/>
                                    </div>
                                    <div> 
                                        <label for="heightregister">Height </label>
                                        <input id="heightregister" name="height" required="required" type="text"/>
                                    </div>
                                    <div> 
                                        <label for="massregister">Mass </label>
                                        <input id="massregister" name="mass" required="required" type="text"/>
                                    </div>
                                    <div> 
                                        <label for="exregister">Experience</label>
                                        <select id="exregister">
                                          <option value="0">+0 Years</option>
                                          <option value="1">+1 Years</option>
                                          <option value="2">+2 Years</option>
                                          <option value="3">+3 Years</option>
                                          <option value="4">+4 Years</option>
                                          <option value="5">+5 Years</option>
                                          <option value="6">+6 Years</option>
                                          <option value="7">+7 Years</option>
                                          <option value="8">+8 Years</option>
                                          <option value="9">+9 Years</option>
                                          <option value="10">+10 Years</option>
                                        </select>
                                    </div>
                                    <div> 
                                        <label for="fatpregister">Fat Percentage </label>
                                        <input id="fatpregister" name="fat_percentage" required="required" type="text"/>
                                    </div>

                                    <div>
                                         <label for="genderregister">Gender </label>
                                        <select id="genderregister">
                                          <option value="male">Male</option>
                                          <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="regTextBox">
                                <label for="biosignup">Bio: </label>
                                <textarea id="bioText"></textarea>
                            </div>
                             <p class="button-small button-new rounded3 red" id="registerButton">Submit </p>
                        </form>  
            
                    
                </div>
             </div>
        </div>
    </div>
    
<? printFooter(); ?>