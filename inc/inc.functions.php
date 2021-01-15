<?php

include "inc.global_variables.php";

function ft_form_response($input)
{
    $str = ft_clean_input($input);
    if ($str)
    {
        echo '<div class="response">';
        echo "<p>$str</p>";
        echo '</div>';
    }
}

function ft_clean_input($input)
{
    $data = trim($input);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function ft_valid_username($username)
{
    if (preg_match('/^[a-zA-Z0-9_]*$/', $username) && strlen($username) < 255)
    {
        return true;
    }
    return false;
}

function ft_valid_email($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 255)
    {
        return true;
    }
    return false;
}

function ft_valid_password($password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $special_chars = preg_match('@[^\w]@', $password);
    if ($uppercase && $lowercase && $number && $special_chars && strlen($password) > 3 && strlen($password) < 255)
    {
        return true;
    }
    return false;
}

function ft_unique_username($username)
{
    require("inc.connect.php");
    $sql_query = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $username);
    if ($stmt->execute())
    {
        $user = $stmt->fetch();
        if (!($stmt->rowCount() > 0))
        {
            $stmt = null;
            $conn = null;
            return true;
        }
    }
    return false;
}

function ft_unique_email($email)
{
    require("inc.connect.php");
    $sql_query = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $email);
    if ($stmt->execute())
    {
        $user = $stmt->fetch();
        if (!($stmt->rowCount() > 0))
        {
            $stmt = null;
            $conn = null;
            return true;
        }
    }
    return false;
}


function ft_unique_key($verify_key)
{
    require("inc.connect.php");
    $sql_query = "SELECT * FROM users WHERE verify_key = ? LIMIT 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $verify_key);
    if ($stmt->execute())
    {
        $user = $stmt->fetch();
        if (!($stmt->rowCount() > 0))
        {
            $stmt = null;
            $conn = null;
            return true;
        }
    }
    return false;
}

function ft_count_likes($id)
{
    require("inc.connect.php");
    $sql_query = "SELECT * FROM likes WHERE image_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    if ($stmt->execute())
    {
        $likes = $stmt->fetchall();
        $num_rows = $stmt->rowCount();
        $stmt = null;
        $conn = null;
        return $num_rows;
    }
    return 0;
}

function ft_count_comments($id)
{
    require("inc.connect.php");
    $sql_query = "SELECT * FROM comments WHERE image_id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    if ($stmt->execute())
    {
        $likes = $stmt->fetchall();
        $num_rows = $stmt->rowCount();
        $stmt = null;
        $conn = null;
        return $num_rows;
    }
    return 0;
}

function ft_dublicate_like($id, $id_session)
{
    require("inc.connect.php");
    $sql_query = "SELECT * FROM likes WHERE image_id = ? AND user_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql_query);
    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $id_session);
    if ($stmt->execute())
    {
        $user = $stmt->fetch();
        if ($stmt->rowCount() > 0)
        {
            $stmt = null;
            $conn = null;
            return true;
        }
    }
    return false;
}

function ft_hash($password)
{
    return (password_hash($password, PASSWORD_DEFAULT));
}

function ft_image_name($extension)
{
    return uniqid('', true).".$extension";
}

function ft_urlencode($input)
{
    $data = ft_clean_input($input);
    return urlencode($data);
}

function ft_confirm_email($email, $verify_key)
{
    $subject = "confirm email address";
    //$body = "<a target='_blank' href='http://localhost:8080/camagru/confirm_email.php?key=$verify_key'>confirm email address</a>";
    $body = "<a target='_blank' href='". SITE_URL ."confirm_email.php?key=$verify_key'>confirm email address</a>";
    $headers = "From: webmaster@camagru.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    if (mail($email, $subject, $body, $headers))
    {
        return true;
    }
    return false;
}

function ft_reset_password_email($email, $verify_key)
{
    $subject = "reset password";
    $body = "<a target='_blank' href='". SITE_URL ."reset_password.php?key=$verify_key'>reset password</a>";
    $headers = "From: webmaster@camagru.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    if (mail($email, $subject, $body, $headers))
    {
        return true;
    }
    return false;
}

function ft_resize_image($image, $dst_width, $dst_height)
{
    $width = imagesx($image);
    $height = imagesy($image);
    $new_img = imagecreatetruecolor($dst_width, $dst_height);
    imagealphablending($new_img, false);
    imagesavealpha($new_img, true);
    $transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
    imagefilledrectangle($new_img, 0, 0, $width, $height, $transparent);
    imagecopyresampled($new_img, $image, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);
    return $new_img;
}

function ft_delete_gallery_image($image)
{
    unlink("../img/gallery/$image");
}

function ft_pagination($query, $per_page = 10,$page = 1, $url = '?')
{
    require("inc.connect.php");
    $sql_query = "SELECT images.* FROM $query";
    $stmt = $conn->prepare($sql_query);
    $stmt->execute();
    $images = $stmt->fetchall();
    $total = $stmt->rowCount();
    $stmt = null;
    $conn = null;
    $adjacents = "2";

    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;								
		
    $prev = $page - 1;							
    $next = $page + 1;
    $lastpage = ceil($total/$per_page);
    $lpm1 = $lastpage - 1;
    	
    $pagination = "";
    if ($lastpage > 1)
    {	
    	$pagination .= "<ul>";
        $pagination .= "<li>Page $page of $lastpage : </li>";
    	if ($lastpage < 7 + ($adjacents * 2))
    	{	
    		for ($counter = 1; $counter <= $lastpage; $counter++)
    		{
                if ($counter == $page)
                {
    				$pagination.= "<li><a class='current'>$counter</a></li>";
                }
                else
                {
                    $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }					
    		}
    	}
    	else if ($lastpage > 5 + ($adjacents * 2))
    	{
    			if ($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
                        if ($counter == $page)
                        {
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        }
                        else
                        {
                            $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                        }					
    				}
    				$pagination.= "<li>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
                        if ($counter == $page)
                        {
                            $pagination.= "<li><a class='current'>$counter</a></li>";
                        }
                        else
                        {
                            $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                        }					
    				}
    			}
    	}
    		
        if ($page < $counter - 1)
        { 
    		$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
            $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
        }
    	$pagination.= "</ul>\n";		
    }

    return $pagination;
}

?>