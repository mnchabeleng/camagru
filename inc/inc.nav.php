<nav class="desktop">
    <ul>
        <?php if (isset($_SESSION['login'])): ?>
        <li><a href="capture_image.php">capture</a></li>
        <li><a href="upload_image.php">upload</a></li>
        <li><a href="update_info.php">update info</a></li>
        <li><a href="logout.php">logout</a></li>
        <?php endif; ?>
        <?php if (!isset($_SESSION['login'])): ?>
        <li><a href="signup.php">signup</a></li>
        <li><a href="login.php">login</a></li>
        <?php endif; ?>
    </ul>
    <div class="title">
        <a href="gallery.php">camagru</a>
    </div>
    <ul>
        <li><a href="gallery.php">gallery</a></li>
        <?php if (isset($_SESSION['login'])): ?>
            <li><a href="my_uploads.php">my uploads</a></li>
        <?php endif; ?>
    </ul>
</nav>