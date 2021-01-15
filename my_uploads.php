<?php include("inc/inc.header.php"); ?>
<?php

$response = $id_session = null;
if (isset($_GET['response']))
{
    $response = ft_clean_input($_GET['response']);
}
if (!isset($_SESSION['login']))
{
    header("Location: login.php");
}
else
{
    $id_session = $_SESSION['login']['id'];
}

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page < 0)
{
    $page = 1;
}
$limit = 9;
$startpoint = ($page * $limit) - $limit;
$statement = "images WHERE user_id = $id_session  ORDER BY modify_date DESC";

require("inc/inc.connect.php");
$sql_query = "SELECT * FROM $statement LIMIT $startpoint, $limit";
$stmt = $conn->prepare($sql_query);
$stmt->execute();
$images = $stmt->fetchall();
$num_rows = $stmt->rowCount();
$stmt = null;
$conn = null;


?>
<main>
<div class="content-header">
    <h1>my uploads</h1>
</div>
<div class="content">
<div class="form">
    <?php ft_form_response($response); ?>
</div>
<?php if (!($num_rows > 0)): ?>
<div class="form">
    <div class="response">
        <p>you have no uploads</p>
    </div>
</div>
<?php endif; ?>
<div class="gallery">
    <?php foreach($images as $image): ?>
    <div class="img" style="background-image: url(img/gallery/<?php echo $image['image_name']; ?>">
        <div class="overlay">
            <div class="header"></div>
            <div class="main">
                <ul>
                    <li><?php echo ft_count_likes($image['id']); ?> like</li>
                    <li><?php echo ft_count_comments($image['id']); ?> comment</li>
                    <li><a href="single_image.php?id=<?php echo $image['id']; ?>">view</a></li>
                    <li><a href="inc/inc.delete_image.php?<?php echo 'id='.$image['id'].'&user_id='.$id_session.'&image='.$image['image_name'].'&page='.$page; ?>" onclick="return confirm('delete image?')">delete</a></li>
                </ul>
            </div>
            <div class="footer"></div>
        </div><!-- ./overlay -->
    </div><!-- ./img -->
<?php endforeach; ?>
</div><!-- ./gallery -->
<div class="pagination">
    <?php echo ft_pagination($statement, $limit, $page); ?>
</div><!-- ./pagination -->    
</div>
</main>
<script src="js/my_uploads.js"></script>
<?php include("inc/inc.footer.php"); ?>