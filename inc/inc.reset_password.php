<?php

include("inc.functions.php");
if (isset($_POST['reset_password_submit']))
{
    $verify_key = $_GET['key'];
    $password = ft_clean_input($_POST['password']);
    $password_repeat = ft_clean_input($_POST['password_repeat']);
    if (empty($verify_key))
    {
        header("Location: ../reset_password.php");
        exit();        
    }
    else if (empty($password) || empty($password_repeat))
    {
        $message = "missing input";
        $message = ft_urlencode($message);
        header("Location: ../reset_password.php?response=$message&key=$verify_key");
        exit();
    }
    else if ($password !== $password_repeat)
    {
        $message = "password match error";
        $message = ft_urlencode($message);
        header("Location: ../reset_password.php?response=$message&key=$verify_key");
        exit();
    }
    else
    {
        $password = ft_hash($password);
        require("inc.connect.php");
        $sql_query = "UPDATE users SET pass = ?, verify_key = null, modify_date = current_timestamp WHERE verify_key = ?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $password);
        $stmt->bindParam(2, $verify_key);
        if ($stmt->execute())
        {
            $stmt = null;
            $conn = null;
            $message = "password reset you may login";
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
            header("Location: ../reset_password.php?response=$message&key=$verify_key");
            exit();
        }
    }
}
header("Location: ../reset_password.php");
exit();

?>