const video = document.getElementById("video");
const capture_image = document.getElementById("capture_image");
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

//stream video
if (navigator.getUserMedia) {
  navigator.getUserMedia({ 
    audio: false,
    video: true 
  }, function(stream) {
    video.srcObject = stream;
    video.play();
  }, function(error) {
    console.log("The following error occurred: "+error.name);
  }
  );
} else {
  alert("getUserMedia not supported");
}

let loadSticker = function(){
  let select_value = document.getElementById("select_sticker").value;
  let sticker = document.getElementById("sticker");
  if (select_value != "")
  {
      sticker.src = "img/stickers/" + select_value;
  }
  else
  {
      sticker.src = "";
  }
}

//capture photo
capture_image.addEventListener("click", function(){
  const canvas = document.getElementById("canvas");
  const context = canvas.getContext("2d");
  let image = document.getElementById("image");
  let sticker = document.getElementById("select_sticker").value;
  const text = document.getElementById("text");

  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  context.drawImage(video, 0, 0);
  let image_url = canvas.toDataURL();

  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
    {
      let message = "my_uploads.php?response=image uploaded";
      let uri = encodeURI(message);
      window.location.replace(uri);
    }
    if (xmlhttp.status === 404)
    {
      console.log("file/resource not found");
    }
  };
  let data = {image: image_url, sticker: sticker};
  let json_data = JSON.stringify(data);
  xmlhttp.open("POST", "inc/inc.capture_image.php", true);
  xmlhttp.setRequestHeader( "Content-type", "application/json" );
  xmlhttp.send(json_data);

});