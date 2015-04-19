<?php
    $pageTitle = "Change Password";
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

<!-- Start of form inspired from http://bootswatch.com/flatly/ -->
<div class="col-md-12">
      <form class="form-horizontal" method="post" action="/changepw.php">
      <fieldset>
        <h2 class="topHeader">Change Password</h2>
        <div class="col-md-12">
            <?php
                // Show potential feedback from the login object
                if (FlashMessage::flashIsSet('ChangePWError')) {
                    FlashMessage::displayFlash('ChangePWError', 'error');
                }
                elseif (FlashMessage::flashIsSet('ChangePWSuccess')) {
                    FlashMessage::displayFlash('ChangePWSuccess', 'message');
                }
            ?>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-lg-2 control-label">Current Password:</label>
          <div class="col-lg-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Current Password" name="user_currentpassword" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label for="inputNewPassword" class="col-lg-2 control-label">New Password:</label>
          <div class="col-lg-10">
            <input type="password" class="form-control" id="inputNewPassword" placeholder="New Password" name="user_newpassword" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label for="inputRepeatPassword" class="col-lg-2 control-label">Repeat Password:</label>
          <div class="col-lg-10">
            <input type="password" class="form-control" id="inputRepeatPassword" placeholder="New Password" name="user_repeatpassword" autocomplete="off">
          </div>
        </div>
        <br />
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <button type="submit" class="btn btn-primary" name="change_password" value="Change Password">Submit</button>
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