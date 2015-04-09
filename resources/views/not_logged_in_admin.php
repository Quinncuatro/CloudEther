<?php
    $pageTitle = "Admin Login";
    require_once(RESOURCE_DIR . 'templates/header.php');
?>
<body>
<!-- Navigation Menu Starts -->
<?php
    require_once(RESOURCE_DIR . 'templates/navigation.php');
?>
<!-- Navigation Menu Ends -->
<!-- Content Starts -->
<div class="container" id="mainContentBody">

<!-- Start of form inspired from http://bootswatch.com/flatly/ -->
<div class="col-md-12">
      <form class="form-horizontal" method="post" action="admin.php" name="loginform">
      <fieldset>
        <h2 class="topHeader">Administrator Login</h2>
<div class="col-md-12">
    <?php
        // Show potential feedback from the login object
        if (FlashMessage::flashIsSet('LoginError')) {
            FlashMessage::displayFlash('LoginError', 'error');
        }
        elseif (FlashMessage::flashIsSet('LoginMessage')) {
            FlashMessage::displayFlash('LoginMessage', 'message');
        }
    ?>
</div>
        <div class="form-group">
          <label for="inputUsername" class="col-lg-2 control-label"><a href="#" class="tool-tip" data-toggle="tooltip" data-placement="top" data-original-title="This username will be provided to you from CloudEther when a payment plan has been agreed upon.">Username:</a>
</label>
          <div class="col-lg-10">
            <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="admin_name">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-lg-2 control-label">Password:</label>
          <div class="col-lg-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="admin_password" autocomplete="off">
          </div>
        </div>
        <br />
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <button type="submit" class="btn btn-primary" name="admin_login" value="Log in">Submit</button>
            <button class="btn btn-default" type="reset">Reset</button>
          </div>
        </div>
      </fieldset>
    </form>
</div>
<!-- End of Form -->

</div>
<!-- Content Ends -->
</body>
</html>