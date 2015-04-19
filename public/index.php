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
	<div class="jumbotron text-center">
		<h1>CloudEther Sale!</h1><br />
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem dolor, tincidunt id lacinia eu, lobortis at est. Pellentesque elementum eros quis ultricies ultricies. Cras pretium a quam nec porttitor. Phasellus sed vulputate magna. Morbi ut eros enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.
		</p><br />
		<a href="/contact.php" class="btn btn-default btn-primary">Contact Now</a>
	</div>

	<div class="col-md-12">
		<h2 class="topHeader" style="margin-top: 2%">About CloudEther</h2>
		<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra tincidunt neque, vel porta velit condimentum eu. Sed interdum suscipit felis eu bibendum. Aliquam convallis tellus ut fringilla tincidunt. Nam pellentesque malesuada gravida. In imperdiet fringilla diam. Ut tristique nulla eu finibus lacinia. Suspendisse vestibulum augue eu est consequat maximus. Vivamus lacinia sed felis ut dignissim. Sed bibendum tortor nec sapien laoreet finibus. Cras et dolor porta, tincidunt lectus quis, feugiat arcu. Phasellus malesuada elementum imperdiet. Nam et vehicula diam. Phasellus nisl nunc, aliquam malesuada sodales sodales, mollis sit amet metus.
		</p>
		<p>
		Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam a tortor vel neque ultrices facilisis placerat ut ligula. Vivamus posuere, nunc eget consequat aliquam, neque mauris vestibulum enim, nec cursus lectus est sit amet erat. Sed varius a libero sit amet mollis. Morbi consequat arcu magna, nec lobortis ante lacinia sit amet. Maecenas justo felis, mollis ac nulla at, aliquet viverra felis. Mauris at rhoncus ante, semper consequat est. Integer venenatis diam id elementum porta. Suspendisse potenti. Cras sit amet lobortis turpis, vitae pharetra neque.
		</p>
	</div>
</div>
<!-- Content Ends -->
</body>
</html>