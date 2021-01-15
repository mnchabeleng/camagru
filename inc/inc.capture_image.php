<?php

include("inc.functions.php");
session_start();
$id_session = ft_clean_input($_SESSION['login']['id']);
$username_session = ft_clean_input($_SESSION['login']['username']);
$email_session = ft_clean_input($_SESSION['login']['email']);
$data = file_get_contents("php://input");
$data = json_decode($data, true);

$image = explode(',', $data["image"]);
$string = base64_decode($image[1]);
$dest = imagecreatefromstring($string);

if ($string !== false) {
    $new_file_name = ft_image_name("jpg");
    if ($data["sticker"])
    {
        $sticker = "../img/stickers/".$data["sticker"];
        $src = imagecreatefrompng($sticker);
        $src_size = getimagesize($sticker);
        $src_width = $src_size[0];
        $src_height = $src_size[1];
        $src_ratio = $src_height / $src_width;
        $dest_width = 640;
        $dest_height = 480;
        $src = ft_resize_image($src, $dest_height / $src_ratio, $dest_height);
        imagecopy($dest, $src, $dest_width / 5, 0, 0, 0, $dest_height / $src_ratio, $dest_height);
        imagejpeg($dest, "../img/gallery/$new_file_name");
        imagedestroy($dest);
        imagedestroy($src);
    }
    else
    {
        imagejpeg($dest, "../img/gallery/$new_file_name");
        imagedestroy($dest);
    }
    require("inc.connect.php");
    $sql_query = "INSERT INTO images (user_id, image_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id_session);
    $stmt->bindParam(2, $new_file_name);
    $stmt->execute();
    $stmt = null;
    $conn = null;
    echo "image uploaded";
}
else
{
    echo 'An error occurred.';
}
header("../gallery.php");

?>