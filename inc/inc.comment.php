<?php

include("inc.functions.php");
session_start();
if (!isset($_POST['comment_submit']))
{
    header("Location: ../gallery.php");
    exit();
}
else
{
    $id = ft_clean_input($_GET['id']);
    $id_session = $_SESSION['login']['id'];
    $comment = ft_clean_input($_POST['comment']);
    echo "$id<br>$id_session<br>$comment";
    if (empty($comment))
    {
        $message = "comment cannot be blank";
        $message = ft_urlencode($message);
        header("Location: ../single_image.php?id=$id&response=$message#comment-form");
        exit();
    }
    else if (strlen($comment) > 1000)
    {
        $message = "comment is too long";
        $message = ft_urlencode($message);
        header("Location: ../single_image.php?id=$id&response=$message#comment-form");
        exit();
    }
    else if (!$id)
    {
        header("Location: ../gallery.php");
        exit();
    }
    else if (!$id_session)
    {
        header("Location: ../login.php");
        exit();
    }
    else
    {
        require("inc.connect.php");
        $sql_query = "INSERT INTO comments (user_id, image_id, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_query);
        $stmt->bindParam(1, $id_session);
        $stmt->bindParam(2, $id);
        $stmt->bindParam(3, $comment);
        if ($stmt->execute())
        {
            $stmt = null;
            $conn = null;
            $message = "comment submited";
            $message = ft_urlencode($message);
            header("Location: ../single_image.php?id=$id&response=$message#comment-form");
            exit();
        }
        else
        {
            $stmt = null;
            $conn = null;
            $message = "sql/database error";
            $message = ft_urlencode($message);
            header("Location: ../single_image.php?id=$id&response=$message#comment-form");
            exit();
        }
    }
}

?>