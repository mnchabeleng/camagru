
<?php include("inc/inc.header.php"); ?>
<?php

$response = null;
if (isset($_GET['response']))
{
    $response = ft_clean_input($_GET['response']);
}
if (!isset($_SESSION['login']))
{
    header("Location: login.php");
}

?>
<main>
    <div class="content-header">
            <h1>upload image</h1>
            <p>upload image from storage</p>
    </div>
    <div class="content">
        <div class="upload-img-preview">
            <img id="image">
            <div class="overlay">
                <img id="sticker">
            </div>
        </div>
        <div class="form">
            <?php ft_form_response($response); ?>
            <form action="inc/inc.upload_image.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image" onchange="loadImage(event)"><br>
                <label>stickers:</label>
                <select name="select_sticker" id="select_sticker" onchange="loadSticker()">
                    <option value="">none</option>
                    <option value="angry_bird.png">angry bird</option>
                    <option value="super_mario.png">super mario</option>
                    <option value="minecraft.png">minecraft</option>
                    <option value="pikachu.png">pikachu</option>
                    <option value="smile.png">smile</option>
                    <option value="dice.png">dice</option>
                    <option value="mickey_mouse.png">micky mouse</option>
                    <option value="boss_baby.png">boss baby</option>
                    <option value="bart_simpson.png">bart simpson</option>
                    <option value="sonic.png">sonic</option>
                </select><br>
                <input type="submit" name="upload_image_submit" value="upload image">
            </form>
        </div>
    </div>
</main>
<script src="js/upload_image.js"></script>
<?php include("inc/inc.footer.php"); ?>