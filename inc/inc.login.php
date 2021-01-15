<?php

include("inc.functions.php");

if (!isset($_POST['login_submit']))
{
    header("Location: ../login.php");
}
else
{
    $email = ft_clean_input($_POST['email']);
    $password = ft_clean_input($_POST['password']);
    if (empty($email) || empty($password))
    {
        $message = "missing input";
        $message = ft_urlencode($message);
        header("Location: ../login.php?response=$message&email=$email");
        exit();
    }
    else
    {
        require("inc.connect.php");
        $sql_query = "SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $email);
        if ($stmt->execute())
        {
            $user = $stmt->fetch();
            if (password_verify($password, $user['pass']) && $user['verified'] && !$user['verify_key'])
            {
                $stmt = null;
                $conn = null;
                session_start();
                $_SESSION['login']['id'] = $user['id'];
                $_SESSION['login']['username'] = $user['username'];
                $_SESSION['login']['email'] = $user['email'];
                $message = "success";
                $message = ft_urlencode($message);
                header("Location: ../signup.php?response=$message");
                exit();
            }
            else if (!$user['verified'] && $user['verify_key'])
            {
                $stmt = null;
                $conn = null;
                $message = "$email is not verified, please confirm email";
                $message = ft_urlencode($message);
                header("Location: ../login.php?response=$message&email=$email");
                exit();
            }
            else if ($user['verified'] && $user['verify_key'])
            {
                $stmt = null;
                $conn = null;
                $message = "incomplete password reset process";
                $message = ft_urlencode($message);
                header("Location: ../login.php?response=$message&email=$email");
                exit();
            }
            else
            {
                $stmt = null;
                $conn = null;
                $message = "invalid username/password";
                $message = ft_urlencode($message);
                header("Location: ../login.php?response=$message&email=$email");
                exit();
            }
        }
        else
        {
            $stmt = null;
            $conn = null;
            $message = "sql/database error";
            $message = ft_urlencode($message);
            header("Location: ../login.php?response=$message&email=$email");
            exit();
        }
        $stmt = null;
        $conn = null;
    }
}

?>