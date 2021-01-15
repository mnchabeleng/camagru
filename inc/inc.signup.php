<?php

include("inc.functions.php");
session_start();
if (isset($_SESSION['login']))
{
    header("Location: ../update_info.php");
}
if (!isset($_POST['signup_submit']))
{
    header("Location: ../signup.php");
}
else
{
    $username = ft_clean_input($_POST['username']);
    $email = ft_clean_input($_POST['email']);
    $password = ft_clean_input($_POST['password']);
    $password_repeat = ft_clean_input($_POST['password_repeat']);
    if (empty($username) || empty($email) || empty($password) || empty($password_repeat))
    {
        $message = "missing input";
        $message = ft_urlencode($message);
        header("Location: ../signup.php?response=$message&username=$username&email=$email");
        exit();
    }
    else
    {
        if (!ft_valid_username($username))
        {
            $message = "$username is not a valid username";
            $message = ft_urlencode($message);
            header("Location: ../signup.php?response=$message&username=$username&email=$email");
            exit();
        }
        else if (!ft_valid_email($email))
        {
            $message = "$email is not a valid email";
            $message = ft_urlencode($message);
            header("Location: ../signup.php?response=$message&username=$username&email=$email");
            exit();
        }
        else if ($password !== $password_repeat)
        {
            $message = "password match error";
            $message = ft_urlencode($message);
            header("Location: ../signup.php?response=$message&username=$username&email=$email");
            exit();          
        }
        else
        {
            if (!ft_unique_username($username))
            {
                $message = "$username already in use";
                $message = ft_urlencode($message);
                header("Location: ../signup.php?response=$message&username=$username&email=$email");
                exit();    
            }
            else if (!ft_unique_email($email))
            {
                $message = "$email already in use";
                $message = ft_urlencode($message);
                header("Location: ../signup.php?response=$message&username=$username&email=$email");
                exit();
            }
            else if (!ft_valid_password($password))
            {
                $message = "password should be at least 4 to 255 characters in length and should include at least one upper case letter, one number, and one special character";
                $message = ft_urlencode($message);
                header("Location: ../signup.php?response=$message&username=$username&email=$email");
                exit();
            }
            else
            {
                $password = ft_hash($password);
                $verify_key = ft_hash($email);
                require("inc.connect.php");
                $sql_query = "INSERT INTO users (username, email, pass, verify_key) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql_query);
                $stmt->bindParam(1, $username);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $password);
                $stmt->bindParam(4, $verify_key);
                if ($stmt->execute() && ft_confirm_email($email, $verify_key))
                {
                    $stmt = null;
                    $conn = null;
                    $message = "signup complete, please confirm email";
                    $message = ft_urlencode($message);
                    header("Location: ../signup.php?response=$message");
                    exit();
                }
                else
                {
                    $stmt = null;
                    $conn = null;
                    $message = "Unable to send verification email";
                    $message = ft_urlencode($message);
                    header("Location: ../signup.php?response=$message");
                    exit();
                }
            }
        }
    }
}

?>