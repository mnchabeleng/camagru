let loadImage = function(event){
    let image = document.getElementById("image");
    image.src = URL.createObjectURL(event.target.files[0]);
};

let loadSticker = function(){
    let selectValue = document.getElementById("select_sticker").value;
    let sticker = document.getElementById("sticker");
    if (selectValue != "")
    {
        sticker.src = "img/stickers/" + selectValue;
    }
    else
    {
        sticker.src = "";
    }
}

/*
let upload_image = document.getElementById("upload_image_submit");
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");

upload_image.addEventListener("click", function(){
    let image = document.getElementById("image");
    let sticker = document.getElementById("sticker");
    canvas.width = image.naturalWidth;
    canvas.height = image.naturalHeight;
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
});
*/