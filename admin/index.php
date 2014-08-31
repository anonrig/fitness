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
		<title>Dashboard | Huraga Bootstrap Admin Template</title>
		<meta name="description" content="">
		<meta name="author" content="Walking Pixels | www.walkingpixels.com">
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- jQuery Visualize Styles -->
		<link rel='stylesheet' type='text/css' href='css/plugins/jquery.visualize.css'>
		
		<!-- jQuery jGrowl Styles -->
		<link rel='stylesheet' type='text/css' href='css/plugins/jquery.jgrowl.css'>
		
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
		
		<script>
			$(document).ready(function(){
				
				// Tooltips
				$('[title]').tooltip({
					placement: 'top'
				});
				
			});
		</script>
	<!-- Shared on MafiaShare.net  --><!-- Shared on MafiaShare.net  --></head>
	<body>
		
		<!-- Main page header -->
		<header class="container">
		<div id="top">
		</div>
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
						<li class="current"><a href="index.php" class="no-submenu"><span class="awe-home"></span>Main Page</a></li>
						<li><a href="add.php" class="no-submenu"><span class="awe-tasks"></span>Add</a></li>
						<li><a href="users.php" class="no-submenu"><span class="awe-table"></span>All User</a></li>
						<li><a href="programs.php" class="no-submenu"><span class="awe-table"></span>All Program</a></li>
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
					
					<!-- Data block -->
					
						<h1 style="text-align:center;">Welcome to the Admin Page</h1>
					
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
		<script src="js/bootstrap/bootstrap-tooltip.js"></script>
		<script src="js/bootstrap/bootstrap-collapse.js"></script>
		<script src="js/bootstrap/bootstrap-dropdown.js"></script>
		
		<!-- Block TODO list -->
		<script>
			$(document).ready(function() {
				
				$('.todo-block input[type="checkbox"]').click(function(){
					$(this).closest('tr').toggleClass('done');
				});
				$('.todo-block input[type="checkbox"]:checked').closest('tr').addClass('done');
				
			});
		</script>
		
		<!-- jQuery Visualize -->
		<!--[if lte IE 8]>
			<script language="javascript" type="text/javascript" src="js/plugins/visualize/excanvas.js"></script>
		<![endif]-->
		<script src="js/plugins/visualize/jquery.visualize.min.js"></script>
		
		<script>
			$(document).ready(function() {
			
				var chartWidth = $(('.chart')).parent().width()*0.9;
				
				$('.chart').hide().visualize({
					type: 'pie',
					width: chartWidth,
					height: chartWidth,
					colors: ['#389abe','#fa9300','#6b9b20','#d43f3f','#8960a7','#33363b','#b29559','#6bd5b1','#66c9ee'],
					lineDots: 'double',
					interaction: false
				});
			
			});
		</script>
		
		<!-- jQuery Flot Charts -->
		<!--[if lte IE 8]>
			<script language="javascript" type="text/javascript" src="js/plugins/flot/excanvas.min.js"></script>
		<![endif]-->
		<script src="js/plugins/flot/jquery.flot.js"></script>
		
		<script>
			$(document).ready(function() {
			
				// Demo #1
				// we use an inline data source in the example, usually data would be fetched from a server
				var data = [], totalPoints = 300;
				function getRandomData() {
					if (data.length > 0)
						data = data.slice(1);
				
					// do a random walk
					while (data.length < totalPoints) {
						var prev = data.length > 0 ? data[data.length - 1] : 50;
						var y = prev + Math.random() * 10 - 5;
						if (y < 0)
							y = 0;
						if (y > 100)
							y = 100;
						data.push(y);
					}
				
					// zip the generated y values with the x values
					var res = [];
					for (var i = 0; i < data.length; ++i)
						res.push([i, data[i]])
					return res;
				}
				
				// setup control widget
				var updateInterval = 30;
				$("#updateInterval").val(updateInterval).change(function () {
					var v = $(this).val();
					if (v && !isNaN(+v)) {
						updateInterval = +v;
					if (updateInterval < 1)
						updateInterval = 1;
					if (updateInterval > 2000)
						updateInterval = 2000;
					$(this).val("" + updateInterval);
					}
				});
				
				// setup plot
				var options = {
					series: { shadowSize: 0, color: '#389abe' }, // drawing is faster without shadows
					yaxis: { min: 0, max: 100 },
					xaxis: { show: false },
					grid: { backgroundColor: '#ffffff' }
				};
				var plot = $.plot($("#demo-1"), [ getRandomData() ], options);
				
				function update() {
					plot.setData([ getRandomData() ]);
					// since the axes don't change, we don't need to call plot.setupGrid()
					plot.draw();
					setTimeout(update, updateInterval);
				}
				
				update();
			
			});
		</script>
		
			
		</script>
		
	</body>
</html>
