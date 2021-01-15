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

/*
//const image = document.querySelector("img");
const image = document.getElementById("img");
const filter_controls = document.querySelectorAll("input[type=range]");
function applyFilter() {
    let computed_filters = "";
    filter_controls.forEach(function(item, index){
        computed_filters += item.getAttribute("data-filter") + "(" + item.value + item.getAttribute("data-scale") + ")";
    });
    image.style.filter = computed_filters;
};
*/