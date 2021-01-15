<?php

include("inc.functions.php");
session_start();
$id_session = $username_session = $email_session = null;
if (!isset($_SESSION['login']) || !isset($_POST['upload_image_submit']))
{
    header("Location: ../upload_image.php");
    exit();
}
else
{
    $sticker = $_POST['select_sticker'];
    $id_session = ft_clean_input($_SESSION['login']['id']);
    $username_session = ft_clean_input($_SESSION['login']['username']);
    $email_session = ft_clean_input($_SESSION['login']['email']);
    $image = $_FILES['image'];
    if (!empty($image))
    {
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_error = $_FILES['image']['error'];
        $temp = explode('.',$_FILES['image']['name']);
        $file_ext = strtolower(end($temp));
        $max_file_size = 2097152;
        $extensions = array('jpeg', 'jpg', 'png', 'gif');
        if ($file_size > $max_file_size)
        {
            $message = "max file size is 2mb";
            $message = ft_urlencode($message);
            header("Location: ../upload_image.php?response=$message");
            exit();
        }
        else if ($file_error === 0 && $id_session !== null)
        {
            $new_file_name = ft_image_name($file_ext);
            require("inc.connect.php");
            $sql_query = "INSERT INTO images (user_id, image_name) VALUES (?, ?)";
            $stmt = $conn->prepare($sql_query);
            $stmt->bindParam(1, $id_session);
            $stmt->bindParam(2, $new_file_name);
            if ($stmt->execute() && move_uploaded_file($file_tmp,"../img/gallery/".$new_file_name))
            {
                $stmt = null;
                $conn = null;
                if ($sticker)
                {
                    $dest_path = "../img/gallery/$new_file_name";
                    $src_path = "../img/stickers/$sticker";
                    if ($file_ext == "jpeg" || $file_ext == "jpg")
                    {
                        $dest = imagecreatefromjpeg($dest_path);
                    }
                    else if ($file_ext == "png")
                    {
                        $dest = imagecreatefrompng($dest_path);
                    }
                    else if ($file_ext == "gif")
                    {
                        $dest = imagecreatefromgif($dest_path);
                    }
                    $src = imagecreatefrompng($src_path);

                    $dest_image_size = getimagesize($dest_path);
                    $dest_width = $dest_image_size[0];
                    $dest_height = $dest_image_size[1];

                    $src_image_size = getimagesize($src_path);
                    $src_width = $src_image_size[0];
                    $src_height = $src_image_size[1];

                    $src_ratio = $src_height / $src_width;
                    $src = ft_resize_image($src, $dest_height / $src_ratio, $dest_height);

                    imagecopy($dest, $src, $dest_width / 5, 0, 0, 0, $dest_height / $src_ratio, $dest_height);
                    if ($file_ext == "jpeg" || $file_ext == "jpg")
                    {
                        imagejpeg($dest, $dest_path);
                    }
                    else if ($file_ext == "png")
                    {
                        imagepng($dest, $dest_path);
                    }
                    else if ($file_ext == "gif")
                    {
                        imagegif($dest, $dest_path);
                    }

                    imagedestroy($dest);
                    imagedestroy($src);
                }
                $message = "image uploaded";
                $message = ft_urlencode($message);
                header("Location: ../my_uploads.php?response=$message");
                exit();
            }
            else
            {
                $stmt = null;
                $conn = null;
                $message = "sql/database error";
                $message = ft_urlencode($message);
                header("Location: ../upload_image.php?response=$message");
                exit();
            }
        }
        else
        {
            $message = "error uploading image";
            $message = ft_urlencode($message);
            header("Location: ../upload_image.php?response=$message");
            exit();
        }
    }
}

?>