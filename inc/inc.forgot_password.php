<?php

include("inc.functions.php");
if (!isset($_POST['forgot_password_submit']))
{
    header("Location: ../forgot_password.php");
}
else
{
    $email = ft_clean_input($_POST['email']);
    if (empty($email))
    {
        $message = "missing input";
        $message = ft_urlencode($message);
        header("Location: ../forgot_password.php?response=$message&email=$email");
        exit();
    }
    else if (!ft_valid_email($email))
    {
        $message = "$email is not a valid email";
        $message = ft_urlencode($message);
        header("Location: ../forgot_password.php?response=$message&email=$email");
        exit();
    }
    else if (ft_unique_email($email))
    {
        $message = "no record of $email on database";
        $message = ft_urlencode($message);
        header("Location: ../forgot_password.php?response=$message&email=$email");
        exit();
    }
    else
    {
        $verify_key = ft_hash($email);
        require("inc.connect.php");
        $sql_query = "UPDATE users SET verify_key = ? WHERE email = ?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $verify_key);
        $stmt->bindParam(2, $email);
        if ($stmt->execute() && ft_reset_password_email($email, $verify_key))
        {
            $stmt = null;
            $conn = null;
            $message = "reset link has been sent to $email";
            $message = ft_urlencode($message);
            header("Location: ../forgot_password.php?response=$message");
            exit();
        }
        else
        {
            $stmt = null;
            $conn = null;
            $message = "sql/database error";
            $message = ft_urlencode($message);
            header("Location: ../forgot_password.php?response=$message");
            exit();
        }
    }
}

?>