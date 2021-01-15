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
        <div class="edit-image">
            <div class="img" id="image" style="background-image: url(img/gallery/dirt-bike-171156_640.jpg)">
                <div class="overlay">
                    <img src="img/stickers/flower.png" alt="">
                </div>
            </div>
            <canvas id="canvas"></canvas>
        </div>
        <div class="form">
            <label>stickers:</label>
            <select>
                <option value="">none</option>
                <option value="angry_bird.png">angry bird</option>
                <option value="super_mario.png">super mario</option>
                <option value="minecraft.png">minecraft</option>
                <option value="pikachu.png">pikachu</option>
                <option value="smile.png">smile</option>
                <option value="flower.png">flower</option>
            </select>
            <input type="submit" value="apply effects" id="apply_effects_button">
        </div>
    </div>
</main>
<script src="js/image_filter.js"></script>
<?php include("inc/inc.footer.php"); ?>