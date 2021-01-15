<?php

session_start();
if (!isset($_SESSION['login']))
{
    header("Location: ../login.php");
}
else
{
    $id_session = $_SESSION['login']['id'];
    $username_session = $_SESSION['login']['username'];
    $email_session = $_SESSION['login']['email'];
}
include("inc.functions.php");
if (isset($_POST['username_submit']))
{
    $username = ft_clean_input($_POST['username']);
    if (empty($username))
    {
        $message = "username cannot be blank";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else if(!ft_valid_username($username))
    {
        $message = "$username is not a valid username";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else if (!ft_unique_username($username))
    {
        $message = "$username already in use";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else
    {
        require("inc.connect.php");
        $sql_query = "UPDATE users SET username = ?, modify_date = current_timestamp WHERE id = ?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $id_session);
        if ($stmt->execute())
        {
            $stmt = null;
            $conn = null;
            $_SESSION['login']['username'] = $username;
            $message = "username has been updated";
            $message = ft_urlencode($message);
            header("Location: ../update_info.php?response=$message");
            exit();
        }
        else
        {
            $message = "sql/database error";
            $message = ft_urlencode($message);
            header("Location: ../update_info.php?response=$message");
            exit();
        }
    }
}
if (isset($_POST['email_submit']))
{
    $email = ft_clean_input($_POST['email']);
    if (empty($email))
    {
        $message = "email cannot be blank";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else if(!ft_valid_email($email))
    {
        $message = "$email is not a valid email";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else if (!ft_unique_email($email))
    {
        $message = "$email already in use";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else
    {
        $verify_key = ft_hash($email);
        require("inc.connect.php");
        $sql_query = "UPDATE users SET email = ?, verify_key = ?, verified = false, modify_date = current_timestamp WHERE id = ?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $verify_key);
        $stmt->bindParam(3, $id_session);
        if ($stmt->execute() && ft_confirm_email($email, $verify_key))
        {
            $stmt = null;
            $conn = null;
            unset($_SESSION['login']);
            $message = "email address updated, please confirm new email address";
            $message = ft_urlencode($message);
            header("Location: ../login.php?response=$message");
            exit();
        }
        else
        {
            $stmt = null;
            $conn = null;
            $message = "sql/database error";
            $message = ft_urlencode($message);
            header("Location: ../update_info.php?response=$message");
            exit();
        }
    }

}
if (isset($_POST['password_submit']))
{
    $old_password = ft_clean_input($_POST['old_password']);
    $password = ft_clean_input($_POST['password']);
    $password_repeat = ft_clean_input($_POST['password_repeat']);
    if (empty($old_password) || empty($password) || empty($password_repeat))
    {
        $message = "missing input";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else if ($password !== $password_repeat)
    {
        $message = "password match error";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else if(!ft_valid_password($password))
    {
        $message = "new password should be at least 4 to 255 characters in length and should include at least one upper case letter, one number, and one special character";
        $message = ft_urlencode($message);
        header("Location: ../update_info.php?response=$message");
        exit();
    }
    else
    {
        require("inc.connect.php");
        $sql_query = "SELECT pass FROM users WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $id_session);
        $stmt->execute();
        $data = $stmt->fetch();
        $stmt = null;
        if (password_verify($old_password, $data['pass']))
        {
            $password = ft_hash($password);
            $sql_query = "UPDATE users SET pass = ?, modify_date = current_timestamp WHERE id = ?";
            $stmt = $conn->prepare($sql_query);
            $stmt->bindParam(1, $password);
            $stmt->bindParam(2, $id_session);
            if ($stmt->execute())
            {
                $stmt = null;
                $conn = null;
                unset($_SESSION['login']);
                $message = "password updated, login to verify change";
                $message = ft_urlencode($message);
                header("Location: ../login.php?response=$message");
                exit();
            }
            else
            {
                $stmt = null;
                $conn = null;
                $message = "sql/database error";
                $message = ft_urlencode($message);
                header("Location: ../update_info.php?response=$message");
                exit();
            }
        }
        else
        {
            $stmt = null;
            $conn = null;
            $message = "old password match error";
            $message = ft_urlencode($message);
            header("Location: ../update_info.php?response=$message");
            exit();
        }
    }
}

?>