<?php include("inc/inc.header.php"); ?>
<?php

if (!isset($_SESSION['login']))
{
    header("Location: login.php");
    exit();
}

?>
<main>
    <div class="content-header">
        <h1>capture image</h1>
        <p>upload image using webcam</p>
    </div>
    <div class="content">
        <div class="image-capture">
            <video id="video">video</video>
            <div class="overlay">
                <img id="sticker">
            </div>
        </div>
        <div class="image-capture" hidden>
            <canvas id="canvas" poster="img/icons/image.svg">canvas</canvas>
        </div>
        <div class="form">
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
            <input type="submit" value="capture image" id="capture_image">
        </div>
    </div>
</main>
<script src="js/capture_image.js"></script>
<?php include("inc/inc.footer.php"); ?>