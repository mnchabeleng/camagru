<?php include("inc/inc.header.php"); ?>
<?php

$response = $verify_key = null;
if (isset($_GET['response']))
{
    $response = ft_clean_input($_GET['response']);
}
if (isset($_GET['key']) && ft_unique_key($_GET['key']) && isset($_SESSION['login']))
{
    $message = "invalid key";
    $message = ft_urlencode($message);
    header("Location: update_info.php?response=$message");
    exit();
}
else if (isset($_SESSION['login']))
{
    header("Location: update_info.php");
    exit();
}
else if (!isset($_GET['key']))
{
    header("Location: login.php");
    exit();
}
else if (ft_unique_key($_GET['key']))
{
    $message = "invalid key";
    $message = ft_urlencode($message);
    header("Location: login.php?response=$message");
    exit();
}
else
{
    $verify_key = ft_clean_input($_GET['key']);
}

?>
<main>
    <div class="content-header">
        <h1>reset password</h1>
    </div>
    <div class="content">
        <div class="form">
            <?php ft_form_response($response); ?>
            <form action="inc/inc.reset_password.php?key=<?php echo $verify_key; ?>" method="post">
                <input type="password" name="password" placeholder="password"><br>
                <input type="password" name="password_repeat" placeholder="re-enter password"><br>
                <input type="submit" name="reset_password_submit" value="reset password">
            </form>
            <ul>
                <li><a href="signup.php">signup</a></li>
                <li><a href="forgot_password.php">forgot password?</a></li>
            </ul>
        </div>
    </div>
</main>
<?php include("inc/inc.footer.php"); ?>