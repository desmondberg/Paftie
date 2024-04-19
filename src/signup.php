<?php 

    //if the user got onto signup.php through a form, then proceed. else redirect them back to index.php
    if(isset($_POST["submit"])){


    }else{
        header("Location: ./index.php");
    }


?>