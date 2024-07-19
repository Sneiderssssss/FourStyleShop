const btnSignIn = document.getElementById("sign-up");
const btnSignUp = document.getElementById("sign-in");
const formRegister = document.querySelector(".login");
const formLogin = document.querySelector(".register");

btnSignIn.addEventListener("click", () => {
    formRegister.classList.add("hide");
    formLogin.classList.remove("hide");
});

btnSignUp.addEventListener("click", () => {
    formLogin.classList.add("hide");
    formRegister.classList.remove("hide");
});