let input = document.getElementById("contact_name");
let email = document.getElementById("contact_email");
let regex = "^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$";
let emailInfoError = document.querySelector('.check-email');
let nameInfoError = document.querySelector('.check-name')

input.addEventListener("blur", (e) =>{
    if (e.target.value.length <= 1 ){
        nameInfoError.classList.add("active");
    }else{
        nameInfoError.classList.remove("active");
    }
})

email.addEventListener("blur", (e) =>{
    if (!e.target.value.match(regex)){
        emailInfoError.classList.add("active");
    }else{
        emailInfoError.classList.remove("active");
    }
})