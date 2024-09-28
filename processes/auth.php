<?php
class auth{
    public function signup($conn, $ObjGlob){
        if(isset($_POST["signup"])){
            $errors = array();

            $fullname = $_SESSION["fullname"] = $conn->escape_values(ucwords(strtolower($_POST["fullname"])));
            $email_address = $_SESSION["email_address"] = $conn->escape_values(strtolower($_POST["email_address"]));
            $username = $_SESSION["username"] = $conn->escape_values(strtolower($_POST["username"]));
            $password = $_SESSION["password"] = $conn->escape_values($_POST["password"]);
            $repeat_password = $_SESSION["repeat_password"] = $conn->escape_values($_POST["repeat_password"]);


            // Sanitize all inputs

            // verify that the fullname has only letters, space, dash, quotation
            if(ctype_alpha(str_replace(" ", "", str_replace("\'", "", $fullname))) === FALSE){
                $errors['nameLetters_err'] = "Invalid name format: Full name must contain letters and spaces only etc " . $fullname;
            }

            // verify that the email has got the correct format
            if(!filter_var($email_address, FILTER_VALIDATE_EMAIL)){
                $errors['email_format_err'] = 'Wrong email format';
            }

            // verify that the email domain is authorized (@strathmore.edu, @gmail.com, @yahoo.com, @mada.co.ke) and not (@yanky.net)
            $conf['valid_domains'] = ["strathmore.edu", "gmail.com", "yahoo.com", "mada.co.ke", "outlook.com", "STRATHMORE.EDU", "GMAIL.COM", "YAHOO.COM", "MADA.CO.KE", "OUTLOOK.COM"];

            $arr_email_address = explode("@", $email_address);
            $spot_dom = end($arr_email_address);
            $spot_user = reset($arr_email_address);

            if(!in_array($spot_dom, $conf['valid_domains'])){
                $errors['mailDomain_err'] = "Invalid email address domain. Use only: " . implode(", ", $conf['valid_domains']);
            }
            $exist_count = 0;
            // Verify Email Already Exists
            $spot_email_address_res = $conn->count_results(sprintf("SELECT email FROM users WHERE email = '%s' LIMIT 1", $email_address));
            if ($spot_email_address_res > $exist_count){
                $errors['mailExists_err'] = "Email Already Exists";
            }

            // Verify Username Already Exists
            $spot_username_res = $conn->count_results(sprintf("SELECT username FROM users WHERE username = '%s' LIMIT 1", $username));
            if ($spot_username_res > $exist_count){
                $errors['usernameExists_err'] = "Username Already Exists";
            }

            // Verify if username contain letters only
            if (!ctype_alpha($username)) {
                $errors['usernameLetters_err'] = "Invalid username format. Username must contain letters only";
                $ObjGlob->setMsg('errors', $errors, 'invalid');
            }

            if ($password !== $repeat_password) {
                $errors['passwordMismatch_err'] = "Passwords do not match";
                
            }

            // Verify password length
            if (strlen($password) < 8 || strlen($password) > 32) {
                $errors['passwordLength_err'] = "Password must be between 8 and 32 characters long";
                
            }

            // Verify password strength
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,32}$/", $password)) {
                $errors['passwordStrength_err'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character";
                
            }

            // Implement 2FA (email => PHP-Mailer)
            // Send email verification with an OTP (OTC)
            // Verify that the password is identical to the repeat passsword
            // verify that the password length is between 4 and 8 characters
            // Generate a random OTP
            $otp = rand(100000, 999999);
            // Send email verification with the OTP
            require_once 'PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'marlynwairimu4@gmail.com';
            $mail->Password = 'Mals4@Nimo';
            $mail->setFrom('marlynwairimu4@gmail.com', 'Marlyn');
            $mail->addAddress($email_address, $fullname);
            $mail->Subject = 'Email Verification';
            $mail->Body = 'Your OTP is: ' . $otp;
            if (!$mail->send()) {
                $errors['emailVerification_err'] = 'Failed to send email verification';
            } else {
                // Store the OTP in the database
                $conn->query("UPDATE users SET otp = '$otp' WHERE email = '$email_address'");
            }

            if (!count($errors)) {
                $cols = ['fullname', 'email', 'username', 'password'];
                $vals = [$fullname, $email_address, $username, password_hash($password, PASSWORD_DEFAULT)];
                $data = array_combine($cols, $vals);
                $insert = $conn->insert('users', $data);
                if ($insert === TRUE) {
                    header('Location: signup.php');
                    unset($_SESSION["fullname"], $_SESSION["email_address"], $_SESSION["username"], $_SESSION["password"], $_SESSION["repeat_password"]);
                    exit();
                } else {
                    die($insert);
                }
            }else{
                $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
                $ObjGlob->setMsg('errors', $errors, 'invalid');
            }
        }
    }
}
