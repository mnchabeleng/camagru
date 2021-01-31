(function (){

    const video = document.getElementById("image");
    const apply = document.getElementById("apply_effects_button");
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    
    //capture image
    apply.addEventListener("click", function(){
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      context.drawImage(video, 0, 0);
    });

})();