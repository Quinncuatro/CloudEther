<?php
	require_once('../resources/core/init.php');
    $pageTitle = "About CloudEther";
    require_once(RESOURCE_DIR . 'templates/header.php');
?>
<body>
<!-- Navigation Menu Starts -->
<?php
	if (LoginCheck::isLoggedInAsAdmin()) {
		require_once(RESOURCE_DIR . 'templates/admin_navigation.php');
	}
	elseif (LoginCheck::isLoggedIn()) {
    	require_once(RESOURCE_DIR . 'templates/logged_in_navigation.php');
    }
    else {
    	require_once(RESOURCE_DIR . 'templates/navigation.php');
    }
?>
<!-- Navigation Menu Ends -->
<!-- Content Starts -->
<div class="container" id="mainContentBody">
	<div class="col-md-12">
		<h2 class="topHeader">Contact Us</h2>
		<div class="col-md-12">
		    <?php
		        // Show potential feedback from the register object
		        if (FlashMessage::flashIsSet('ContactError')) {
		            FlashMessage::displayFlash('ContactError', 'error');
		        }
		        elseif (FlashMessage::flashIsSet('ContactSuccess')) {
		            FlashMessage::displayFlash('ContactSuccess', 'message');
		        }
		    ?>
		</div>
		<form method="post" action="/contact.php" role="form">
			<div class="form-group">
				<label for="InputName">Your Name:</label>
				<input type="text" class="form-control" name="InputName" id="InputName" placeholder="Your name is required" required>
			</div>
			<div class="form-group">
				<label for="InputEmail">Your Email:</label>
				<input type="email" class="form-control" name="InputEmail" id="InputEmail" placeholder="Your email is required" required>
			</div>
			<div class="form-group">
				<label for="InputMessage">Message:</label>
				<textarea class="form-control" name="InputMessage" id="InputMessage" rows="10" placeholder="Please enter your message to us here" required></textarea>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary contact-btn" name="InputSubmit" value="Send" />
			</div>
		</form>
	</div>
</div>
<!-- Content Ends -->
</body>
</html>