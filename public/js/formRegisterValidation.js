let input = document.getElementById("registration_username");
let password = document.getElementById("registration_plainPassword_first");
let nameInfoError = document.querySelector('.check-name');
let passwordInfoError = document.querySelector('.check-password')

input.addEventListener("blur", (e) =>{
    if (e.target.value.length <= 2 ){
        nameInfoError.classList.add("active");
    }else{
        nameInfoError.classList.remove("active");
    }
})

password.addEventListener("blur", (e) =>{
    if (!e.target.value.length <= 2){
        passwordInfoError.classList.add("active");
    }else{
        passwordInfoError.classList.remove("active");
    }
})