<?php

session_start();
include("inc.functions.php");
$id_session = $id = $action = $page = null;
if (!isset($_SESSION['login']))
{
    header("Location: ../gallery.php");
}
else
{
    $id_session = ft_clean_input($_SESSION['login']['id']);
}
if (isset($_GET['id']))
{
    $id = ft_clean_input($_GET['id']);
}
if (isset($_GET['action']))
{
    $action = ft_clean_input($_GET['action']);
}
if (isset($_GET['page']))
{
    $page = $_GET['page'];
}
if ($id && $action == "like" && !ft_dublicate_like($id, $id_session))
{
    require("inc.connect.php");
    $sql_query = "INSERT INTO likes (image_id, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $id_session);
    if ($stmt->execute())
    {
        header("Location: ../gallery.php?page=$page");
        exit();
    }
    else
    {
        header("Location: ../gallery.php?page=$page");
        exit();
    }
}

?>