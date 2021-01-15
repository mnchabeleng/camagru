<?php

include("inc/inc.functions.php");
if (!isset($_GET['key']))
{
    header("Location: login.php");
}
else
{
    $verify_key = $_GET['key'];
    if (!ft_unique_key($verify_key))
    {
        require("inc/inc.connect.php");
        $sql_query = "UPDATE users SET verified = true, verify_key = null, modify_date=current_timestamp WHERE verify_key = ?";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $verify_key);
        if ($stmt->execute())
        {
            $message = "email verified, you may login";
            $message = ft_urlencode($message);
            header("Location: login.php?response=$message");
            exit(); 
        }
        else
        {
            $message = "sql/database error";
            $message = ft_urlencode($message);
            header("Location: login.php?response=$message");
            exit();
        }
    }
    else
    {
        $message = "invalid key";
        $message = ft_urlencode($message);
        header("Location: login.php?response=$message");
        exit(); 
    }
}

?>