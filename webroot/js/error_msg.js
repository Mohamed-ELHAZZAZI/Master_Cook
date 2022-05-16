var remobe_msg_btn = document.getElementById("remove_btn");
var message = document.getElementById("message");

remobe_msg_btn.addEventListener("click", () => {
  message.style.display = "none";
});