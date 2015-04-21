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
			Freedom discount! Are you full of patriotism? Do you love America? Do you care about Justice? Other America themed buzzwords? SIGN UP NOW!
		</p>
		<p>
			If you sign up before July 4th, 2015, you get a free two months of VPN support and an ASCII Picture of an American Flag! You know… for freedom.
		</p><br />
		<a href="/contact.php" class="btn btn-default btn-primary">Contact Now</a>
	</div>

	<div class="col-md-12" style="font-size:120%">
		<h2 class="topHeader" style="margin-top: 2%">About CloudEther</h2>
		<p>
			Welcome to CloudEther! We are the leading innovators of high availability VPN clusters for the Skiff network at Champlain College. With very humble and modest beginnings, five very attractive and talented developers set out with a goal in mind: create and support the finest high availability cloud VPN cluster service in the entire Skiff Annex area. That’s is our mission. 
		</p><br />
		<p>
			While currently a start-up based in the Chittenden County area, we will soon be expanding to much larger and demanding markets. It is an exciting time to be a client of CloudEther! If you have specific questions about our product, click on the “Contact” tab. Thanks for visiting us, and remember, “Freedom. Justice. America.” 
		</p>
	</div>
</div>
<!-- Content Ends -->
</body>
</html>