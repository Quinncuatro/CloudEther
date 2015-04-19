<?php
    $pageTitle = "Current Clients";
    require_once(RESOURCE_DIR . 'templates/header.php');
?>
<body>
<!-- Navigation Menu Starts -->
<?php
    require_once(RESOURCE_DIR . 'templates/admin_navigation.php');
?>
<!-- Navigation Menu Ends -->
<!-- Content Starts -->
<div class="container" id="mainContentBody">
	<div class="col-md-12">
		<h2 class="topHeader">Current Clients</h2>
		<div class="row">
			<div class="col-md-12">
		    	<?php
			        // Show potential feedback from the Clients object
			        if (FlashMessage::flashIsSet('ClientsError')) {
			            FlashMessage::displayFlash('ClientsError', 'error');
			        }
			        elseif (FlashMessage::flashIsSet('ClientsMessage')) {
			            FlashMessage::displayFlash('ClientsMessage', 'message');
			        }
		    	?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
				    <thead>
				    	<tr>
					        <th>Name</th>
					        <th>Email</th>
					        <th>Username</th>
					        <th>Creation Date</th>
					        <th>Action</th>
				      	</tr>
				    </thead>
				    <tbody>
			    	<?php
			    		if (!empty($allClients)) {
			    			foreach ($allClients as $client) {
			    				echo '<tr><td>' . $client['name'] . '</td>';
			    				echo '<td>' . $client['email'] . '</td>';
			    				echo '<td>' . $client['username'] . '</td>';
			    				echo '<td>' . $client['created'] . '</td>';
					?>
								<td><form class="btn-link-form" method="post" action="/admin/currentclients.php">
				    				<input type="hidden" value=<?php echo '"', $client['username'], '"'; ?> name="client_username">
				    				<input type="submit" class="btn btn-link" value="Delete" name="delete_client">
				    			</form></td></tr>
					<?php
			    			}
			    		}
			    	?>
				    </tbody>
				  </table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Content Ends -->
</body>
</html>