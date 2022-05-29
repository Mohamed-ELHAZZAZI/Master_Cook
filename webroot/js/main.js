let show_ver_nav = document.getElementById("show_ver_nav");

if (show_ver_nav != null) {
  show_ver_nav.addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("ver_nav").classList.toggle("show");
  });
}

//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------
//--------------------------------------------------------create post---------------------------------------

var stop_a_bnt = document.getElementsByClassName("cate_btn");
var caty_bnt = document.getElementsByClassName("category_btn");

var myFunction = function (event) {
  event.preventDefault();
};

if (stop_a_bnt != null) {
  Array.from(stop_a_bnt).forEach(function (element) {
    element.addEventListener("click", myFunction);
  });
}

if (caty_bnt != null) {
  Array.from(caty_bnt).forEach(function (element) {
    element.addEventListener("click", myFunction);
  });
}
//------------------------------------------------------------------------------------------------------------
//clicko on radio btn
var dairy_a = document.getElementById("dairy_a");
var vegetable_a = document.getElementById("vegetable_a");
var fruit_a = document.getElementById("fruit_a");
var meat_a = document.getElementById("meat_a");
var pastry_a = document.getElementById("pastry_a");
var seafood_a = document.getElementById("seafood_a");

if (dairy_a != null) {
  dairy_a.addEventListener("click", () => {
    document.getElementById("dairy").click();
  });
}
if (vegetable_a != null) {
  vegetable_a.addEventListener("click", () => {
    document.getElementById("vegetable").click();
  });
}

if (meat_a != null) {
  meat_a.addEventListener("click", () => {
    document.getElementById("meat").click();
  });
}
if (fruit_a != null) {
  fruit_a.addEventListener("click", () => {
    document.getElementById("fruit").click();
  });
}

if (pastry_a != null) {
  pastry_a.addEventListener("click", () => {
    document.getElementById("pastry").click();
  });
}
if (seafood_a != null) {
  seafood_a.addEventListener("click", () => {
    document.getElementById("seafood").click();
  });
}

//------------------------------------------------------------------------------------------------------------
//execute file input (for post img)
var show_post_img = document.getElementById("show_post_img");
if (show_post_img) {
  show_post_img.addEventListener("click", () => {
    document.getElementById("post_img").click();
  });
}

//------------------------------------------------------------------------------------------------------------
//show img after insering it

const input_file = document.getElementById("post_img");
const post_img = document.querySelector(".img_icon");

if (input_file != null) {
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
}

//-------------------------------------------------------------------------------------------------------------
//execute file input (for post video)
var upload_vdo = document.getElementById("upload_vdo");
if (upload_vdo != null) {
  upload_vdo.addEventListener("click", (event) => {
    event.preventDefault();
    document.getElementById("input-tag").click();
  });
}

//------------------------------------------------------------------------------------------------------------
//show img after insering it

const videoSrc = document.querySelector("#video-source");
const videoTag = document.querySelector("#video-tag");
const inputTag = document.querySelector("#input-tag");

if (inputTag != null) {
  inputTag.addEventListener("change", readVideo);
}

function readVideo(event) {
  console.log(event.target.files);
  if (event.target.files && event.target.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      videoTag.classList.add("show");
      console.log("loaded");
      videoSrc.src = e.target.result;
      videoTag.load();
    }.bind(this);

    reader.readAsDataURL(event.target.files[0]);
  }
}
//------------------------------------------------------------------------------------------------------------
//error message

var remove_msg_btn = document.getElementById("remove_btn");
var message = document.getElementById("message");
if (remove_msg_btn != null) {
  remove_msg_btn.addEventListener("click", () => {
    message.style.display = "none";
  });
}

//------------------------------------------------------------------------------------------------------------
//open input file

var chng_img = document.getElementById("chng_img");
if (chng_img != null) {
  chng_img.addEventListener("click", () => {
    document.getElementById("file").click();
  });
}

//------------------------------------------------------------------------------------------------------------
//error message

const profile_input_file = document.getElementById("file");
const profile_img = document.querySelector(".profile_img");

if (profile_input_file != null) {
  profile_input_file.addEventListener("change", function () {
    const file = this.files[0];

    if (file) {
      const reader = new FileReader();

      reader.addEventListener("load", function () {
        console.log(this);
        profile_img.setAttribute("src", this.result);
      });
      reader.readAsDataURL(file);
    }
  });
}

//------------------------------------------------------------------------------------------------------------
//confirmation functions

function delete_post_confirm() {
  if (confirm("Delete the post?")) {
    return true;
  } else {
    return false;
  }
}

function delete_user_confirm() {
  if (confirm("Delete this user?")) {
    return true;
  } else {
    return false;
  }
}


function set_admin_user_confirm() {
  if (confirm("Change The statue of this user?")) {
    return true;
  } else {
    return false;
  }
}

function show_confirm() {
  if(confirm("Confirm this post?")) {
      return true;
  } else {
      return false;
  }
}
function show_unconfirm() {
  if(confirm("Unconfirm this post?")) {
      return true;
  } else {
      return false;
  }
}