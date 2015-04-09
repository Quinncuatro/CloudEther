<?php
    $pageTitle = "New Account";
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

<!-- Start of form inspired from http://bootswatch.com/flatly/ -->
<div class="col-md-12">
      <form class="form-horizontal" method="post" action="newaccount.php" name="registerform">
      <fieldset>
        <h2 class="topHeader">New Account</h2>
<div class="col-md-12">
    <?php
        // Show potential feedback from the register object
        if (flashMessage::flashIsSet('RegisterError')) {
            FlashMessage::displayFlash('RegisterError', 'error');
        }
        elseif (flashMessage::flashIsSet('RegisterSuccess')) {
            FlashMessage::displayFlash('RegisterSuccess', 'message');
        }
    ?>
</div>
        <div class="form-group">
            <label for="register_input_username" class="col-lg-2 control-label">Username:</label>
            <div class="col-lg-10">
                <input id="register_input_username" class="form-control" type="text" pattern="^[a-zA-Z0-9]*[_.-]?[a-zA-Z0-9]*$" name="user_name" required /><br />
            </div>
        </div>

        <div class="form-group">
            <label for="register_input_fullname" class="col-lg-2 control-label">Name:</label>
            <div class="col-lg-10">
                <input id="register_input_fullname" class="form-control" type="text" name="user_fullname" required /><br />
            </div>
        </div>

        <div class="form-group">
            <label for="register_input_email" class="col-lg-2 control-label">Email:</label>
            <div class="col-lg-10">
                <input id="register_input_email" class="form-control" type="email" name="user_email" required /><br />
            </div>
        </div>

        <div class="form-group">
            <label for="register_input_password_new" class="col-lg-2 control-label">Password (<?php echo Config::get('security/passwordLength') ?>+ Characters):</label>
            <div class="col-lg-10">
                <input id="register_input_password_new" class="form-control" type="password" name="user_password_new" pattern=<?php echo '".{', Config::get('security/passwordLength'), ',}"' ?> placeholder=<?php echo '"Password with ', Config::get('security/passwordLength'), ' or more characters"' ?> required autocomplete="off" /><br />
            </div>
        </div>

        <div class="form-group">
            <label for="register_input_password_repeat" class="col-lg-2 control-label">Repeat Password:</label>
            <div class="col-lg-10">
                <input id="register_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=<?php echo '".{', Config::get('security/passwordLength'), ',}"' ?> placeholder=<?php echo '"Password with ', Config::get('security/passwordLength'), ' or more characters"' ?> required autocomplete="off" /><br />
            </div>
        </div>

        <div class="form-group">
            <label for="register_input_account_type" class="col-lg-2 control-label">Account Type:</label>
            <div class="col-lg-10">
                <select name="account_type" class="form-control">
                    <option value="client">Client</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div><br />

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <input type="submit" class="btn btn-primary" name="register" value="Create" />
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