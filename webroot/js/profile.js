document.getElementById("chng_img").addEventListener("click", () => {
    document.getElementById("file").click();
})

const input_file = document.getElementById("file");
const prof_img = document.querySelector(".profile_img");

input_file.addEventListener("change", function() {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.addEventListener("load", function() {
            console.log(this);
            prof_img.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
    }
});
