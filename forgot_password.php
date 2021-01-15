<?php include("inc/inc.header.php"); ?>
<?php

$response = $email = null;
if (isset($_GET['response']))
{
    $response = ft_clean_input($_GET['response']);
}
if (isset($_GET['email']))
{
    $email = ft_clean_input($_GET['email']);
}

?>
<main>
    <div class="content-header">
        <h1>forgot password</h1>
        <p>provide an email to get a password reset link</p>
    </div>
    <div class="content">
        <div class="form">
            <?php ft_form_response($response); ?>
            <form action="inc/inc.forgot_password.php" method="post">
                <input type="text" name="email" placeholder="email" value="<?php echo $email; ?>"><br>
                <input type="submit" name="forgot_password_submit" value="send link">
            </form>
            <ul>
                <li><a href="login.php">login</a></li>
                <li><a href="signup.php">signup</a></li>
            </ul>
        </div>
    </div>
</main>
<?php include("inc/inc.footer.php"); ?>