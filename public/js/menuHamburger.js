let hamb = document.querySelector(".hamburger")
let list = document.getElementById("menu")
let forms = document.querySelector("form")

if (hamb.style.display ="block"){
    hamb.addEventListener("click", () =>{
        hamb.classList.toggle("active");
        list.classList.toggle("active");
    })
}

if (list.className ==="active"){
    console.log("coucou")
}