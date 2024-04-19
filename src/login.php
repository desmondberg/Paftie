<?php 
    require './functions.php';
    $error = '';

    //if the user got onto login.php through a form, then proceed. else redirect them back to index.php
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

        $user = sanitiseForm(trim($_POST["user"]));
        $password = sanitiseForm(trim($_POST['password']));
        $password_confirm = sanitiseForm(trim($_POST['password_confirm']));
    
        // validate if email is empty
        if (empty($user)) {
            $error .= '<p class="error">Please enter email or username.</p>';
        }
    
        if(empty($password)){
            $error .= '<p class="error">Please enter password.</p>';
        }

        if($password!==$password_confirm){
            $error .= '<p class="error">The password and the password confirmation don\'t match.</p>';
        }



    }else{
        header("Location: ./index.php");
    }


?>