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
        return $sanitisedData;
    }


?>