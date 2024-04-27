<?php 
    
    

    //function for sanitising form inputs
    function sanitiseForm($data) {
        $sanitisedData = [];
        // sanitise username
        if (isset($data['user'])) {
            $sanitisedData['username'] = htmlspecialchars(trim($data['user']));
        }
        // sanitise email
        if (isset($data['email'])) {
            $sanitisedData['email'] = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
        }
        // sanitise password and password confirmation
        if (isset($data['password']) && isset($data['password_confirm'])) {
            $sanitisedData['password'] = htmlspecialchars(trim($data['password']));
            $sanitisedData['password_confirm'] = htmlspecialchars(trim($data['password_confirm']));
        }
        if(isset($data["address"])){
            $sanitisedData['address'] = htmlspecialchars(trim($data['address']));
        }
        return $sanitisedData;
    }

    //function to retrieve hashed password from database
    function getHashedPassword($username) {
        $hash = 0;
        require("../../../../mysql_connect.php");
        $query = "SELECT password FROM users WHERE username = '$username'";
        $stmt = $db_connection->prepare($query);
        if($stmt->execute()){
            $stmt->store_result();
            $stmt->bind_result($hash);
            if($stmt->fetch()){
                return $hash;
            } 
            
        }
        
    }
