<?php include("inc/inc.header.php") ?>
<?php

$response = $username = $email = null;
if (isset($_SESSION['login']))
{
    header("Location: update_info.php");
}
if (isset($_GET['response']))
{
    $response = ft_clean_input($_GET['response']);
}
if (isset($_GET['username']))
{
    $username = ft_clean_input($_GET['username']);
}
if (isset($_GET['email']))
{
    $email = ft_clean_input($_GET['email']);
}

?>
<main>
    <div class="content-header">
        <h1>sign up</h1>
    </div>
    <div class="content">
        <div class="form">
            <?php ft_form_response($response); ?>
            <form action="inc/inc.signup.php" method="post">
                <input type="text" name="username" placeholder="username" value="<?php echo $username; ?>"><br>
                <input type="text" name="email" placeholder="email" value="<?php echo $email; ?>"><br>
                <input type="password" name="password" placeholder="password"><br>
                <input type="password" name="password_repeat" placeholder="re-enter password"><br>
                <input type="submit" name="signup_submit" value="signup">
            </form>
            <ul>
                <li><a href="login.php">login</a></li>
                <li><a href="forgot_password.php">forgot password?</a></li>
            </ul>
        </div>
    </div>
</main>
<?php include("inc/inc.footer.php") ?>