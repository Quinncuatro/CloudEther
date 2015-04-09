    <?php
    require_once(__DIR__ . '/../core/init.php');

    // This the local login class was heavily inspired by this source code https://github.com/panique/php-login-minimal
    class AdminLogin {
        private $db_connection = null;

        public function __construct() {
            @session_start();

            // Check the to see if the admin is trying to log in or off
            if (isset($_GET["logout"])) {
                $this->logout();
            }
            // If the login form was submitted, then call the doLoginWithPostData function
            elseif (isset($_POST["admin_login"])) {
                $this->loginWithPOST();
            }
        }

        public function __destruct() {
            $this->db_connection = null;
        }

        private function setLoginErrorAndQuit($message) {
            if (isset($message)) {
                FlashMessage::flash('LoginError', $message);
                header('Location: /admin.php');
                exit();
            }
        }

        private function loginWithPOST() {
            // Verfiy the contents that were submitted by the form
            if (empty($_POST['admin_name'])) {
                $this->setLoginErrorAndQuit('The Username field was empty.');
            }
            elseif (empty($_POST['admin_password'])) {
                $this->setLoginErrorAndQuit('The Password field was empty.');
            }
            elseif (!empty($_POST['admin_name']) && !empty($_POST['admin_password'])) {
                // Start the database connection
                if ($this->db_connection = startPDOConnection()) {
                    // Trimming the whitespace. The input is not sanitized because prepared statements are being used
                    $user_name = trim($_POST['admin_name']);

                    // The database query which allows the admin to login via email address or by username.
                    $stmt = $this->db_connection->prepare('SELECT username, email, password FROM admin WHERE username = ? OR email = ?');
                    $stmt->execute(array($user_name, $user_name));

                    // If the user exists, then verfiy the password
                    if ($stmt->rowCount() == 1) {

                        // Get the user row as an array
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $stmt = null;

                        // Using PHP 5.5's password_verify() function to check if the provided password matches the hash of the password entered
                        if (password_verify($_POST['admin_password'], $user['password'])) {

                            // Write the admin's data into a PHP SESSION
                            $_SESSION['user_name'] = $user['username'];
                            $_SESSION['user_email'] = $user['email'];
                            //The user's privilege is always user from this console
                            $_SESSION['privilege'] = 'admin';
                            $_SESSION['user_login_status'] = 1;

                            //The login is complete, redirect them
                            header('Location: /account.php');
                            exit();

                        }
                        // If the username or password is incorrect, notify the admin trying to log in
                        else {
                            $this->setLoginErrorAndQuit('The Username or Password is incorrect.<br />Please try again.');
                        }
                    }
                    // If the username or password is incorrect, notify the admin trying to log in
                    else {
                        $this->setLoginErrorAndQuit('The Username or Password is incorrect.<br />Please try again.');
                    }
                }
                // If the database connection fails, notify the admin trying to log in
                else {
                    $this->setLoginErrorAndQuit('There was a problem connecting to the database.<br />Please try again.');
                }
            }
        }

        public function logout() {            
            // Delete the admin's session
            $_SESSION = array();
            session_destroy();
            // Redirect them to the login page.
            header('Location: /admin.php');
            exit();
        }
    }
