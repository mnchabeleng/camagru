<?php include("inc/inc.header.php"); ?>
<?php

$page = (!isset($_GET["page"]) ? 1 : ft_clean_input($_GET["page"]));
if ($page < 0 || !is_numeric($page))
{
    $page = 1;
}
$limit = 9;
$startpoint = ($page * $limit) - $limit;
$statement = "images, users WHERE images.user_id = users.id ORDER BY modify_date DESC";

require("inc/inc.connect.php");
$sql_query = "SELECT images.*, users.username as username FROM $statement LIMIT $startpoint, $limit";
$stmt = $conn->prepare($sql_query);
$stmt->execute();
$images = $stmt->fetchall();
$num_rows = $stmt->rowCount();
$stmt = null;
$conn = null;
$id_session = null;
if (isset($_SESSION['login']))
{
    $id_session = ft_clean_input($_SESSION['login']['id']);
}


?>
<main>
<div class="content-header">
    <h1>gallery</h1>
</div>
<div class="content">
<?php if (!($num_rows > 0)): ?>
<div class="form">
    <div class="response">
        <p>gallery is empty, be the first to upload</p>
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
                    <li>uploaded by ~ <?php echo $image['username']; ?></li>
                    <li>
                        <?php echo ft_count_likes($image['id']); ?> like&nbsp;
                        <?php if (isset($_SESSION['login']) && !ft_dublicate_like($image['id'], $id_session)): ?>
                        &rarr; <a href="inc/inc.gallery.php?id=<?php echo $image['id']; ?>&action=like&page=<?php echo $page; ?>">like here</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php echo ft_count_comments($image['id']); ?> comment&nbsp; 
                        <?php if (isset($_SESSION['login'])): ?>
                        &rarr; <a href="single_image.php?id=<?php echo $image['id']; ?>#comment-form">comment here</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <a href="single_image.php?id=<?php echo $image['id']; ?>">view</a>
                    </li>
                </ul>
            </div>
            <div class="footer">
                share:
                <ul>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost:8080/camagru/single_image.php?id=<?php echo $image['id']; ?>" target="_blank" rel="noopener">facebook</a></li>
                    <li><a href="http://twitter.com/share?text=camagru&url=http://localhost:8080/camagru/single_image.php?id=<?php echo $image['id']; ?>" target="_blank" rel="noopener">twitter</a></li>
                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http://localhost:8080/camagru/single_image.php?id=<?php echo $image['id']; ?>" target="_blank" rel="noopener">linkedin</a></li>
                </ul>
            </div>
        </div><!-- ./overlay -->
    </div><!-- ./img -->
<?php endforeach; ?>
</div><!-- ./gallery -->
<div class="pagination">
    <?php echo ft_pagination($statement, $limit, $page); ?>
</div><!-- ./pagination -->    
</div>
</main>
<?php include("inc/inc.footer.php"); ?>