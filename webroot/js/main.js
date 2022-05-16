

  
document
  .getElementById("show_ver_nav")
  .addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("ver_nav").classList.toggle("show");
  });



//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------



var stop_a_bnt = document.getElementsByClassName("cate_btn");

var myFunction = function (event) {
  event.preventDefault();
};

Array.from(stop_a_bnt).forEach(function (element) {
  element.addEventListener("click", myFunction);
});

document.getElementById("upload_vdo").addEventListener("click",(event=>{
  event.preventDefault();
}));


//------------------------------------------------------------------------------------------------------------
//clicko on radio btn
document.getElementById("dairy_a").addEventListener("click", () => {
  document.getElementById("dairy").click();
});
document.getElementById("vegetable_a").addEventListener("click", () => {
  document.getElementById("vegetable").click();
});
document.getElementById("meat_a").addEventListener("click", () => {
  document.getElementById("meat").click();
});
document.getElementById("fruit_a").addEventListener("click", () => {
  document.getElementById("fruit").click();
});
document.getElementById("pastry_a").addEventListener("click", () => {
  document.getElementById("pastry").click();
});
document.getElementById("seafood_a").addEventListener("click", () => {
  document.getElementById("seafood").click();
});

//------------------------------------------------------------------------------------------------------------
//execute file input (for post img)
document.getElementById("show_post_img").addEventListener("click", () => {
  document.getElementById("post_img").click();
});

//------------------------------------------------------------------------------------------------------------
//show img after insering it

const input_file = document.getElementById("post_img");
const post_img = document.querySelector(".img_icon");

input_file.addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function () {
      console.log(this);
      post_img.setAttribute("src", this.result);
    });
    reader.readAsDataURL(file);
    post_img.style.width = "auto";
    post_img.style.maxWidth = "100%";
  }
});

//-------------------------------------------------------------------------------------------------------------
//execute file input (for post video)
document.getElementById("upload_vdo").addEventListener("click", () => {
  document.getElementById("input-tag").click();
});

//------------------------------------------------------------------------------------------------------------
//show img after insering it

const videoSrc = document.querySelector("#video-source");
const videoTag = document.querySelector("#video-tag");
const inputTag = document.querySelector("#input-tag");

inputTag.addEventListener('change',  readVideo)

function readVideo(event) {
  console.log(event.target.files)
  if (event.target.files && event.target.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      videoTag.classList.add("show");
      console.log('loaded');
      videoSrc.src = e.target.result;
      videoTag.load();
    }.bind(this);

    reader.readAsDataURL(event.target.files[0]);
  }
}