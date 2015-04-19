<?php
    $pageTitle = "Manage Hubs";
    require_once(RESOURCE_DIR . 'templates/header.php');
?>
<body>
<!-- Navigation Menu Starts -->
<?php
    require_once(RESOURCE_DIR . 'templates/logged_in_navigation.php');
?>
<!-- Navigation Menu Ends -->
<!-- Content Starts -->

<div class="container" id="mainContentBody">
	<div class="col-md-12">
      	<fieldset>
	      	<h2 class="topHeader">Manage Hubs</h2>
	      	<br />
	      	<div class="col-md-12">
			    <?php
			        // Show potential feedback from the register object
			        if (FlashMessage::flashIsSet('ManageHubError')) {
			            FlashMessage::displayFlash('ManageHubError', 'error');
			        }
			        elseif (FlashMessage::flashIsSet('ManageHubMessage')) {
			            FlashMessage::displayFlash('ManageHubMessage', 'message');
			        }
			    ?>
			</div>
			<div class="col-md-12">
		    	<div class="panel-group" id="accordion">
		    		<div class="panel panel-default">
		        		<div class="panel-heading">
			            	<h4 class="panel-title">
			            		What would you like to do?
			            	</h4>
		          		</div>
			        	<div id="collapse4" class="panel-collapse ">
				            <div class="panel-body">
				            	<br />
				            	<p style="font-weight:normal; max-width:780px">
			            			Explain how the hubs work and how to connect here
			            		</p><br />
			            		<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>Name</th>
													<th>Password</th>
													<th>Creation Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
									    	<?php
									    		if (!empty($allHubs)) {
									    			foreach ($allHubs as $hub) {
									    				echo '<tr><td>' . $hub['name'] . '</td>';
									    				echo '<td>' . $hub['password'] . '</td>';
									    				echo '<td>' . $hub['created'] . '</td>';
											?>
														<td><form class="btn-link-form" method="post" action="/client/manage.php">
										    				<input type="hidden" value=<?php echo '"', $hub['name'], '"'; ?> name="hub_name">
										    				<input type="submit" class="btn btn-link" value="Delete" name="delete_hub">
										    			</form></td></tr>
											<?php
									    			}
									    		}
									    	?>
									    		<tr>
									    			<form class="btn-link-form" method="post" action="/client/manage.php">
											    		<td>
											    			<input type="text" class="form-control" name="hub_name" placeholder="Enter a New Hub Name">
							    						</td>
							    						<td></td>
							    						<td></td>
							    						<td style="vertical-align: middle">
							    							<input type="submit" class="btn btn-link" name="create_hub" value="Add">
										    			</td>
									    			</form>
									    		</tr>
										    </tbody>
										  </table>
										</div>
									</div>
								</div>
								<br /><br />
				        	</div>
			          	</div>
		        	</div>
		    	</div> 
			</div>
		</fieldset>
	</div>
</div>
<!-- Content Ends -->
</body>
</html>