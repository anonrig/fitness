<?
	require_once("../func.php");
	if (($_SESSION['authenticated'] != true) && !(isset($_SESSION['authenticated'])))
	{
		header("Location: ../index.php");
	}
	
	$adminUser = User::getUserByUserId($_SESSION['userid']);
	
	if (!$adminUser->isAdmin())
		header("Location: ../index.php?msg=fail");
	
?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Add User | Admin Page</title>
		<meta name="description" content="">
		<meta name="author" content="Walking Pixels | www.walkingpixels.com">
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- jQuery TagsInput Styles -->
		<link rel='stylesheet' type='text/css' href='css/plugins/jquery.tagsinput.css'>
		
		<!-- jQuery jWYSIWYG Styles -->
		<link rel='stylesheet' type='text/css' href='css/plugins/jquery.jwysiwyg.css'>
		
		<!-- Bootstrap wysihtml5 Styles -->
		<link rel='stylesheet' type='text/css' href='css/plugins/bootstrap-wysihtml5.css'>
		
		<!-- CSS styles -->
		<link rel='stylesheet' type='text/css' href='css/huraga-green.css'>
		
		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="img/icons/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/icons/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/icons/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="img/icons/apple-touch-icon-57-precomposed.png">
		
		<!-- JS Libs -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/libs/jquery.js"><\/script>')</script>
		<script src="js/libs/modernizr.js"></script>
		<script src="js/libs/selectivizr.js"></script>
		<script type="text/javascript" src="js/admin.js"></script>
		
		<script>
			$(document).ready(function(){
				
				// Tooltips
				$('[title]').tooltip({
					placement: 'top'
				});
				
				// Dropdowns
				$('.dropdown-toggle').dropdown();
				
				// Tabs
				$('.demoTabs a').click(function (e) {
					e.preventDefault();
					$(this).tab('show');
				})
				
			});
		</script>

	<!-- Shared on MafiaShare.net  --><!-- Shared on MafiaShare.net  --></head>
	<body>
		
		<!-- Main page header -->
		<header class="container">
		
			<!-- Main page logo -->
			<h1><a href="index.php" class="brand">fitnessApp</a></h1>
			
			<!-- Main page headline -->
			<p>Fitness App Admin Panel</p>
			
			<!-- Alternative navigation -->
			<nav>
				<ul>
					
					<li><a href="../logout.php">Logout</a></li>
				</ul>
			</nav>
			<!-- /Alternative navigation -->
			
		</header>
		<!-- /Main page header -->
		
		<!-- Main page container -->
		<section class="container" role="main">
		
			<!-- Left (navigation) side -->
			<div class="navigation-block">

				
				<!-- Main navigation -->
				<nav class="main-navigation" role="navigation">
					<ul>
						<li><a href="index.php" class="no-submenu"><span class="awe-home"></span>MainPage</a></li>
						<li class="current"><a href="add.php" class="no-submenu"><span class="awe-tasks"></span>Add</a></li>

						<li><a href="users.php" class="no-submenu"><span class="awe-table"></span>All Users</a></li>
						<li><a href="programs.php" class="no-submenu"><span class="awe-table"></span>All Programs </a></li>
						<li><a href="comments.php" class="no-submenu"><span class="awe-table"></span>All Comments</a></li>


							
					</ul>
				</nav>
				<!-- /Main navigation -->
				

				
			</div>
			<!-- Left (navigation) side -->
			
			<!-- Right (content) side -->
			<div class="content-block" role="main">
			

				
				<!-- Grid row -->
				
				<div class="row">
				
					<!-- Example form sizing -->
					<!-- Data block -->
					<article class="span12 data-block decent">
						<div class="data-container">
							<header>
								<h2>Add New User</h2>
							</header>
							<section>
								<form class="form-inline">
									<fieldset>
										<div class="control-group">
											
											<div class="form-controls demo">

												<label data-icon="u" for="namesignup">Name</label>
												<input class="input-medium" type="text">
												
												<label data-icon="u" for="namesignup">Username</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">E-mail</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Password</label>
												<input class="input-medium" type="text">


												<label data-icon="u" for="namesignup">Image Url</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Age</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Height</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Mass</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Experience</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Fat Percentage</label>
												<input class="input-medium" type="text">

												<label data-icon="u" for="namesignup">Gender</label>
												<select class="span2">
													<option>male</option>
													<option>female</option>
												</select>


												<label data-icon="u" for="namesignup">Bio</label>
												<input class="input-large" type="text">

												<a href="#" id="adminregister" class="btn btn-primary btn-flat pull-left" style="margin-bottom:2%;">Submit</a>
												
											</div>
										</div>
									</fieldset>
								</form>
							</section>
						</div>
					</article>
					<!-- /Data block -->
				
				</div>
				<!-- /Grid row -->
				
			</div>
			<!-- /Right (content) side -->
			
		</section>
		<!-- /Main page container -->
		
		<!-- Main page footer -->
		<footer class="container">
			<a href="#top" class="btn btn-primary btn-flat pull-right">Top &uarr;</a>
		</footer>
		<!-- /Main page footer -->
		
		<!-- Scripts -->
		<script src="js/navigation.js"></script>
		<script src="js/bootstrap/bootstrap-affix.js"></script>
		<script src="js/bootstrap/bootstrap-alert.js"></script>
		<script src="js/bootstrap/bootstrap-tooltip.js"></script>
		<script src="js/bootstrap/bootstrap-dropdown.js"></script>
		<script src="js/bootstrap/bootstrap-tab.js"></script>
		<script src="js/bootstrap/bootstrap-collapse.js"></script>
		<script src="js/bootstrap/bootstrap-fileupload.js"></script>
		<script src="js/bootstrap/bootstrap-inputmask.js"></script>

		<!-- jQuery TagsInput -->
		<script src="js/plugins/tagsInput/jquery.tagsinput.min.js"></script>
		
		<script>
			$(document).ready(function() {
			
				$('.tagsinput').tagsInput();
			
			});
		</script>
		
		<!-- jQuery jWYSIWYG -->
		<script src="js/plugins/jWYSIWYG/jquery.wysiwyg.js"></script>
		
		<script>
			$(document).ready(function() {
				
				$('.wysiwyg').wysiwyg({
					controls: {
						bold          : { visible : true },
						italic        : { visible : true },
						underline     : { visible : true },
						strikeThrough : { visible : true },
						
						justifyLeft   : { visible : true },
						justifyCenter : { visible : true },
						justifyRight  : { visible : true },
						justifyFull   : { visible : true },
			
						indent  : { visible : true },
						outdent : { visible : true },
			
						subscript   : { visible : true },
						superscript : { visible : true },
						
						undo : { visible : true },
						redo : { visible : true },
						
						insertOrderedList    : { visible : true },
						insertUnorderedList  : { visible : true },
						insertHorizontalRule : { visible : true },
						
						cut   : { visible : true },
						copy  : { visible : true },
						paste : { visible : true }
					},
					events: {
						click: function(event) {
							if ($("#click-inform:checked").length > 0) {
								event.preventDefault();
								alert("You have clicked jWysiwyg content!");
							}
						}
					}
				});
				
			});
		</script>
		
		<!-- Wysihtml5 -->
		<script src="js/plugins/wysihtml5/wysihtml5-0.3.0.js"></script>
		<script src="js/plugins/wysihtml5/bootstrap-wysihtml5.js"></script>
		
		<script>
			$(document).ready(function() {
				
				$('.wysihtml5').wysihtml5();
				
			});
		</script>
		
		<!-- Colorpicker -->
		<script src="js/plugins/colorpicker/bootstrap-colorpicker.js"></script>
		
		<script>
			$(document).ready(function() {
				
				var preview = $('.colorpicker-preview')[0].style;
				$('.colorpicker').colorpicker().on('changeColor', function(ev){
					preview.backgroundColor = ev.color.toHex();
				});
				
			});
		</script>
		
		<!-- Colorpicker -->
		<script src="js/plugins/datepicker/bootstrap-datepicker.js"></script>
		
		<script>
			$(document).ready(function() {
				
				$('.datepicker').datepicker();
				
			});
		</script>


		
	</body>
</html>
