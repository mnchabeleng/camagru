<?php include("inc/inc.header.php") ?>
<?php

$response = $username_session = $email_session = null;
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
    $username_session = ft_clean_input($_SESSION['login']['username']);
    $email_session = ft_clean_input($_SESSION['login']['email']);
}

?>
<main>
        <div class="content-header">
            <h1>update info</h1>
        </div>
        <div class="content">
            <div class="form">
            <?php ft_form_response($response); ?>
            </div>
            <div class="form">
                <form action="inc/inc.update_info.php" method="post">
                    <label>username:</label>
                    <input type="text" name="username" placeholder="username" value="<?php echo $username_session; ?>"><br>
                    <input type="submit" name="username_submit" value="update username">
                </form>
            </div>
            <div class="form">
                <form action="inc/inc.update_info.php" method="post">
                    <label>email:</label>
                    <input type="text" name="email" placeholder="email" value="<?php echo $email_session; ?>"><br>
                    <input type="submit" name="email_submit" value="update email">
                </form>
            </div>
            <div class="form">
                <form action="inc/inc.update_info.php" method="post">
                    <label>password:</label>
                    <input type="password" name="old_password" placeholder="old password"><br>
                    <input type="password" name="password" placeholder="new password"><br>
                    <input type="password" name="password_repeat" placeholder="re-enter new password"><br>
                    <input type="submit" name="password_submit" value="update password">
                </form>
            </div>
        </div>
</main>
<?php include("inc/inc.footer.php"); ?>