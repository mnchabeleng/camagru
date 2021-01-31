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