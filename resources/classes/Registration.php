<?php
require_once(__DIR__ . '/../core/init.php');
//Function to check if the password conforms to the security policy
require_once(RESOURCE_DIR . 'functions/passwordPolicyMatch.php');

// This class is used to create a new administrative account. This class was heavily inspired by https://github.com/panique/php-login-minimal
class Registration
{
    // The database connection object
    private $db_connection = null;

    public function __construct()
    {
        
    }

    protected function setErrorAndQuit($message) {
        if (isset($message)) {
            FlashMessage::flash('RegisterError', $message);
            header('Location: /admin/newaccount.php');
            exit();
        }
    }

    // This function handles the entire registration process. It checks all error possibilities and creates a new administrator in the database if the input passes
    public function registerNewUser($user_group = 1) {
        if (empty($_POST['user_name'])) {
            $this->setErrorAndQuit('Username cannot be empty.');
        }
        elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->setErrorAndQuit('Password cannot be empty.');
        }
        elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->setErrorAndQuit('RegisterError', 'Passwords do not match.');
        }
        elseif (!passwordPolicyMatch($_POST['user_password_new'])) {
            $this->setErrorAndQuit('Password does not match');
        }
        elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->setErrorAndQuit(('Password does not conform to the password policy.<br />'. passwordPolicyWritten()));
        }
        elseif (!preg_match('/^[a-zA-Z0-9]*[_.-]?[a-zA-Z0-9]*$/', $_POST['user_name'])) {
            $this->setErrorAndQuit('Username does not match the naming scheme. Only letters, numbers, underscores, and periods are allowed');
        }
        elseif (empty($_POST['user_email'])) {
            $this->setErrorAndQuit('Email cannot be empty.');
        }
        elseif (strlen($_POST['user_email']) > 64) {
            $this->setErrorAndQuit('Email cannot be longer than 64 characters.');
        }
        elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->setErrorAndQuit('Your email address is not in a valid email format.');
        }
        elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-zA-Z0-9]*[_.-]?[a-zA-Z0-9]*$/', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            if ($this->db_connection = startPDOConnection()) {

                //Trim the whitespace
                $user_name = trim($_POST['user_name']);
                $user_fullname = trim($_POST['user_fullname']);
                $user_email = trim($_POST['user_email']);
                $user_password = $_POST['user_password_new'];
                $user_created = date('Y-m-d H:i:s');

                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                if (isset($_POST['account_type']) && $_POST['account_type'] == 'admin') {
                    $account_type = 'admin';
                }
                else {
                    $account_type = 'clients';
                }

                // Check if the user/email address is already taken or not
                if ($stmt = $this->db_connection->prepare('SELECT * FROM ' . $account_type . ' WHERE username=? OR email=?')) {
                    if ($stmt->execute(array($user_name, $user_email))) {
                        if ($stmt->rowCount() == 1) {
                            $this->setErrorAndQuit('Sorry, that username or email address is already taken.');
                        }
                        else {
                            $stmt = null;
                            // Prepare and bind the database to insert the administrator account
                            if ($stmt = $this->db_connection->prepare('INSERT INTO ' . $account_type . ' (username, password, email, name, created) VALUES (?, ?, ?, ?, ?)')) {
                                if ($stmt->execute(array($user_name, $user_password_hash, $user_email, $user_fullname, $user_created))) {
                                    FlashMessage::flash('RegisterSuccess', $user_name . ' has been created successfully.');
                                    header('Location: /admin/newaccount.php');
                                    exit();

                                }
                                else {
                                    $this->setErrorAndQuit('Sorry, your registration failed.<br />Please go back and try again.');
                                } 
                            }
                            else {
                                $this->setErrorAndQuit('Sorry, your registration failed.<br />Please go back and try again.');
                            }
                        }
                    }
                    else {
                        $this->setErrorAndQuit('There was a problem connecting to the database.<br />Please try again.');
                    }
                }
                else {
                    $this->setErrorAndQuit('There was a problem connecting to the database.<br />Please try again.');
                }
            } 
            else {
                $this->setErrorAndQuit('There was a problem connecting to the database.<br />Please try again.');
            }
        } 
        else {
            $this->setErrorAndQuit('Sorry, your registration failed.<br />Please go back and try again.');
        }
    }
}
