<?php

include("inc.functions.php");
session_start();
$id_session = $page = null;
if (isset($_SESSION['login']))
{
    $id_session = $_SESSION['login']['id'];
}
if (isset($_GET['page']))
{
    $page = $_GET['page'];
}
if (isset($_GET['id']) && isset($_GET['user_id']) && isset($_GET['image']) && isset($_SESSION['login']))
{
    $id = $_GET['id'];
    $user_id = $_GET['user_id'];
    $image = $_GET['image'];
    echo "$id<br>$user_id<br>$image";
    require("inc.connect.php");
    $sql_query = "DELETE FROM images WHERE id = ? AND user_id = ? AND user_id = ? AND image_name = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $user_id);
    $stmt->bindParam(3, $id_session);
    $stmt->bindParam(4, $image);
    $stmt->execute();
    $sql_query = "DELETE FROM likes WHERE image_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $sql_query = "DELETE FROM comments WHERE image_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $stmt = null;
    $conn = null;
    ft_delete_gallery_image($image);
    $message = "image deleted";
    $message = ft_urlencode($message);
    if ($page)
    {
        header("Location: ../my_uploads.php?response=$message&page=$page");
    }
    else
    {
        header("Location: ../my_uploads.php?response=$message");
    }
    exit();
}
else
{
    header("Location: ../gallery.php");
}

?>