<?php 

    //function for sanitising form inputs
    function sanitiseForm($data) {
        $sanitisedData = [];
        // sanitise username
        if (isset($data['username'])) {
            $sanitisedData['username'] = htmlspecialchars(trim($data['username']));
        }
        // sanitise email
        if (isset($data['email'])) {
            $sanitisedData['email'] = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
        }
        // sanitise password and password confirmation
        if (isset($data['password']) && isset($data['password_confirmation'])) {
            $sanitisedData['password'] = htmlspecialchars(trim($data['password']));
            $sanitisedData['password_confirmation'] = htmlspecialchars(trim($data['password_confirmation']));
        }
        return $sanitisedData;
    }


?>