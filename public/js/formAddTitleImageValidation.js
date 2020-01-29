let input = document.getElementById("image_title");
let titleInfoError = document.querySelector('.check-title');

input.addEventListener("blur", (e) =>{
    if (e.target.value.length == 0 ){
        titleInfoError.classList.add("active");
    }else{
        titleInfoError.classList.remove("active");
    }
})
