let hamb = document.querySelector(".hamburger")
let list = document.getElementById("menu")

if (hamb.style.display ="block"){
    hamb.addEventListener("click", () =>{
        hamb.classList.toggle("active");
        list.classList.toggle("active");
    })
}