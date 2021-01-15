<?php include("inc/inc.header.php"); ?>
<?php

$id = $response = $image = null;
if (isset($_GET['id']))
{
    $id = ft_clean_input($_GET['id']);
}
else
{
    header("Location: gallery.php");
    exit();
}
if (isset($_GET['response']))
{
    $response = ft_clean_input($_GET['response']);
}
require("inc/inc.connect.php");
$sql_query = "SELECT * FROM images WHERE id = ?";
$stmt = $conn->prepare($sql_query);
$stmt->bindParam(1, $id);
if ($stmt->execute())
{
    $image = $stmt->fetch();
}
$sql_query = "SELECT comments.comment, users.username AS user_id FROM comments, users WHERE comments.image_id = ? AND comments.user_id = users.id ORDER BY comments.modify_date DESC";
$stmt = $conn->prepare($sql_query);
$stmt->bindParam(1, $id);
if ($stmt->execute())
{
    $comments = $stmt->fetchall();
}
$stmt = null;
$conn = null;

?>
<main>
<div class="content-header">
    <h2><?php echo ft_count_likes($id)." like, ".ft_count_comments($id)." comment"; ?></h2>
</div><!-- ./content-header -->
<div class="content">
<div class="single">
    <div class="img">
        <img src="img/gallery/<?php echo $image['image_name']; ?>" alt="">
    </div>
    <div class="comments">
        <?php if (isset($_SESSION['login'])): ?>
        <div class="form-container">
            <div class="form">
                <?php ft_form_response($response); ?>
            </div>
            <div class="form" id="comment-form">
                <form action="inc/inc.comment.php?id=<?php echo $id; ?>" method="post">
                    <textarea name="comment" rows="4"></textarea>
                    <input type="submit" name="comment_submit" value="submit comment">
                </form>
            </div>
        </div><!-- ./form-container -->
        <?php endif; ?>
        <?php if (ft_count_comments($id) > 0): ?>
        <h2>comments</h2>
        <ul>
            <?php foreach($comments as $comment): ?>
            <li>
                <h4><?php echo $comment['user_id']; ?></h4>
                <p><?php echo $comment['comment']; ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div><!-- ./comments -->
</div><!-- ./single -->
</div><!-- ./content -->
</main>
<?php include("inc/inc.footer.php"); ?>