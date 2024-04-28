//script to make the password field in the login and signup forms visible
const showPassword = document.querySelector(".show-password");
const passwordInput = document.getElementById("password");
const passwordConfirmInput = document.getElementById("password_confirm");
showPassword.addEventListener('change',()=>{
    if (showPassword.checked) {
        console.log('checked');
        passwordInput.type="text";
        passwordConfirmInput.type="text";
    } else {
        console.log('unchecked');
        passwordInput.type="password";
        passwordConfirmInput.type="password";
    }
})