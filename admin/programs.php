<?
	require_once("../func.php");
	if (($_SESSION['authenticated'] != true) && !(isset($_SESSION['authenticated'])))
	{
		header("Location: ../index.php");
	}
	
	$adminUser = User::getUserByUserId($_SESSION['userid']);
	
	if (!$adminUser->isAdmin())
		header("Location: ../index.php?msg=fail");
		
	$programs = FitnessProgram::getAllPrograms();
?>
<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Programs | Admin Page</title>
		<meta name="description" content="">
		<meta name="author" content="Walking Pixels | www.walkingpixels.com">
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
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
						<li><a href="index.php" class="no-submenu"><span class="awe-home"></span>Main Page</a></li>
						<li><a href="add.php" class="no-submenu"><span class="awe-tasks"></span>Add</a></li>
						<li><a href="users.php" class="no-submenu"><span class="awe-table"></span>All Users</a></li>
						<li class="current"><a href="programs.php" class="no-submenu"><span class="awe-table"></span>All Programs</a></li>
						<li><a href="comments.php" class="no-submenu"><span class="awe-table"></span>All Comments</a></li>
					</ul>
				</nav>
				<!-- /Main navigation -->
				
			</div>
			<!-- Left (navigation) side -->
			
			<!-- Right (content) side -->
			<div class="content-block" role="main">
			
				<!-- Page header -->
				<article class="page-header">
					<h1>Statistics</h1>
				</article>
				<!-- /Page header -->
				
				<!-- Grid row -->
				<div class="row">
				
					<!-- Data block -->
					<article class="span12 data-block">
						<div class="data-container">

							<section class="tab-content">
							
								
								
<!-- Tab #dynamic -->
								<div class="tab-pane active" id="dynamic">
									<h3>All Users</h3>
									<table class="datatable table table-striped table-bordered table-hover" id="showUsers">
										<thead>
											<tr>
												<th>ID</th>
												<th>Title</th>
												<th>Username</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											
											<?
				 
					                        foreach ($programs as $value) {
					                        	$idInfo = $value['id'];
					                        	$userId = $value['user_id'];
					                        	$createdUser = User::getUserByUserId($userId);
											    $titleInfo = $value['title'];
											    $nameInfo = $createdUser->getName();
											    echo "<tr class=\"odd gradeX\">
												<td>$idInfo</td>
												<td>$titleInfo</td>
												<td>$nameInfo</td>
												<td><a href=\"edit.php?type=program&id=$idInfo\">Edit</a>
											</tr>";
											    
											}
				                        
				                        ?>
				                        </tbody>
									</table>
								</div>
								<!-- /Tab #dynamic -->
								
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
		<script src="js/bootstrap/bootstrap-tooltip.js"></script>
		<script src="js/bootstrap/bootstrap-dropdown.js"></script>
		<script src="js/bootstrap/bootstrap-tab.js"></script>
		
		<!-- jQuery DataTable -->
		<script src="js/plugins/dataTables/jquery.datatables.min.js"></script>
		<script>
			/* Default class modification */
			$.extend( $.fn.dataTableExt.oStdClasses, {
				"sWrapper": "dataTables_wrapper form-inline"
			} );
			
			/* API method to get paging information */
			$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
			{
				return {
					"iStart":         oSettings._iDisplayStart,
					"iEnd":           oSettings.fnDisplayEnd(),
					"iLength":        oSettings._iDisplayLength,
					"iTotal":         oSettings.fnRecordsTotal(),
					"iFilteredTotal": oSettings.fnRecordsDisplay(),
					"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
					"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
				};
			}
			
			/* Bootstrap style pagination control */
			$.extend( $.fn.dataTableExt.oPagination, {
				"bootstrap": {
					"fnInit": function( oSettings, nPaging, fnDraw ) {
						var oLang = oSettings.oLanguage.oPaginate;
						var fnClickHandler = function ( e ) {
							e.preventDefault();
							if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
								fnDraw( oSettings );
							}
						};
						
						$(nPaging).addClass('pagination').append(
							'<ul>'+
								'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
								'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
							'</ul>'
						);
						var els = $('a', nPaging);
						$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
						$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
					},
					
					"fnUpdate": function ( oSettings, fnDraw ) {
						var iListLength = 5;
						var oPaging = oSettings.oInstance.fnPagingInfo();
						var an = oSettings.aanFeatures.p;
						var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);
						
						if ( oPaging.iTotalPages < iListLength) {
							iStart = 1;
							iEnd = oPaging.iTotalPages;
						}
						else if ( oPaging.iPage <= iHalf ) {
							iStart = 1;
							iEnd = iListLength;
						} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
							iStart = oPaging.iTotalPages - iListLength + 1;
							iEnd = oPaging.iTotalPages;
						} else {
							iStart = oPaging.iPage - iHalf + 1;
							iEnd = iStart + iListLength - 1;
						}
						
						for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
							// Remove the middle elements
							$('li:gt(0)', an[i]).filter(':not(:last)').remove();
							
							// Add the new list items and their event handlers
							for ( j=iStart ; j<=iEnd ; j++ ) {
								sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
								$('<li '+sClass+'><a href="#">'+j+'</a></li>')
									.insertBefore( $('li:last', an[i])[0] )
									.bind('click', function (e) {
										e.preventDefault();
										oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
										fnDraw( oSettings );
									} );
							}
							
							// Add / remove disabled classes from the static elements
							if ( oPaging.iPage === 0 ) {
								$('li:first', an[i]).addClass('disabled');
							} else {
								$('li:first', an[i]).removeClass('disabled');
							}
							
							if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
								$('li:last', an[i]).addClass('disabled');
							} else {
								$('li:last', an[i]).removeClass('disabled');
							}
						}
					}
				}
			});
			
			/* Show/hide table column */
			function dtShowHideCol( iCol ) {
				var oTable = $('#example-2').dataTable();
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol, bVis ? false : true );
			};
			
			/* Table #example */
			$(document).ready(function() {
				$('.datatable').dataTable( {
					"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_ records per page"
					}
				});
				$('.datatable-controls').on('click','li input',function(){
					dtShowHideCol( $(this).val() );
				})
			});
		</script>
		
	</body>
</html>
