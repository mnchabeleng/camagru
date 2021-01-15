<?php

include("inc/inc.global_variables.php");
include("inc/inc.functions.php");
try
{
    $conn = new PDO("$db_driver:host=$db_host;dbname=$db_name", $db_user, $db_pasword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    try
    {
        $conn = new PDO("$db_driver:host=$db_host", $db_user, $db_pasword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    $sql_query = "CREATE DATABASE IF NOT EXISTS camagru";
    $stmt = $conn->prepare($sql_query);
    if ($stmt->execute())
    {
        echo "camagru database created<br>";
        try
        {
            $conn = new PDO("$db_driver:host=$db_host;dbname=$db_name", $db_user, $db_pasword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "camagru database selected<br>";

            $sql_query = "CREATE TABLE users (
                        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        username tinytext NOT NULL,
                        email tinytext NOT NULL,
                        pass longtext NOT NULL,
                        verify_key longtext,
                        verified tinyint(1) NOT NULL DEFAULT '0',
                        create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        modify_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $stmt = $conn->prepare($sql_query);
            if ($stmt->execute())
            {
                echo "users table created<br>";
            }

            $sql_query = "CREATE TABLE images (
                        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        user_id int(11) NOT NULL,
                        image_name tinytext NOT NULL,
                        create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        modify_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $stmt = $conn->prepare($sql_query);
            if ($stmt->execute())
            {
                echo "images table created<br>";
            }

            $sql_query = "CREATE TABLE likes (
                        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        image_id int(11) NOT NULL,
                        user_id int(11) NOT NULL,
                        create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        modify_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $stmt = $conn->prepare($sql_query);
            if ($stmt->execute())
            {
                echo "likes table created<br>";
            }

            $sql_query = "CREATE TABLE comments (
                        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        user_id int(11) NOT NULL,
                        image_id int(11) NOT NULL,
                        comment longtext NOT NULL,
                        create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        modify_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $stmt = $conn->prepare($sql_query);
            if ($stmt->execute())
            {
                echo "comments table created<br>";
            }
            $stmt = null;
            $conn = null;
            $message = "signup to interact";
            $message = ft_urlencode($message);
            header("Location: signup.php?response=$message");
            exit();

        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    else
    {
        echo "error create camagru database";
    }
}

?>