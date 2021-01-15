<?php include('inc/inc.header.php') ?>
<?php

$response = $email = null;
if (isset($_SESSION['login']))
{
    header("Location: signup.php");
}
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
    <div class="content-header"><h1>login</h1></div>
    <div class="content">
        <div class="form">
            <?php ft_form_response($response); ?>
            <form action="inc/inc.login.php" method="post">
                <input type="text" name="email" placeholder="email/username" value="<?php echo $email; ?>"><br>
                <input type="password" name="password" placeholder="password"><br>
                <input type="submit" name="login_submit" value="login">
            </form>
            <ul>
                <li><a href="signup.php">signup</a></li>
                <li><a href="forgot_password.php">forgot password?</a></li>
            </ul>
        </div>
    </div>
</main>
<?php include('inc/inc.footer.php') ?>