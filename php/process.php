<?php
    session_start();
    require ("new-connection.php");

    //reset AJAX request
    if(isset($_POST['request']) && isset($_POST['request']) == 1){
        resetPass($_POST);
    }
    //Review
    if(isset($_POST['reviewAction']) == "write"){
        reviewAction($_POST);
    }
    //Reply
    if(isset($_POST['replyAction']) == "send"){
        replyAction($_POST);
    }
    function replyAction($p){
        if(isset($_SESSION['userData']) && (!empty(trim($p['composedReply'])))){
            $d = $_SESSION['userData'];
            $d['postId'] = escape_this_string($p['replyId']);
            $reply = escape_this_string($p['composedReply']);
            $id = escape_this_string($d['id']);
            $revId = escape_this_string($p['replyId']);
            $query = "INSERT INTO `replies`
                        (`review_id`, `user_id`, `content`, `update_time`)
                      VALUES
                     ('{$revId}', '{$id}', '{$reply}', now())";
            run_mysql_query($query);
            header("Location: ../index.php");
            die();
        }
        else if(isset($_SESSION['userData']) && (empty(trim($p['composedReply'])))){
            header("Location: ../index.php");
            die();
        }
        else{
            //triggers if user not logged in
            header("Location: signIn.php");
            die();
        }
    }

    function displayReview(){
        // var_dump($_SESSION);
        $query = "SELECT CONCAT(`first_name`,' ', `last_name`) AS name,
        DATE_FORMAT(`reviews`.`create_time`, '%M %D %Y %I:%i%p') AS date,
        `reviews`.`content` AS review,
        `reviews`.`review_id` AS rId
        FROM `reviews`
        INNER JOIN `users`
        ON `reviews`.`user_id` = `users`.`user_id`
        ORDER BY `reviews`.`create_time` DESC";
        $rawData = fetch_all($query);
        foreach($rawData as $key){
            $n = $key['name'];
            $d = $key['date'];
            $r = $key['review'];
            $rId =  $key['rId'];
            echo "        <div class='review'>"."\r\n";
            echo "          <p class='userWhoReview'>".$n." (".$d.")</p>"."\r\n";
            echo "          <p class='content'>".$r."</p>"."\r\n";
            echo "        </div>"."\r\n";
            if(isset($_SESSION['userData'])){
                include('reply.php');
            }
        }

    }
    function getAllReplies($revId){
        $query = "SELECT CONCAT(`first_name`,' ', `last_name`) AS name,
            DATE_FORMAT(`replies`.`create_time`, '%M %D %Y %I:%i%p') AS date,
                `replies`.`content`
            FROM `replies`
            INNER JOIN `users`
            ON `replies`.`user_id` = `users`.`user_id`
            WHERE `review_id` = '{$revId}';";
        $rawData = fetch_all($query);
        foreach($rawData as $key){
            $n = $key['name'];
            $d = $key['date'];
            $c = $key['content'];
           echo "        <p class='userWhoReview'>".$n." (".$d.")</p>"."\r\n";
           echo "          <p class='reply content'>".$c."</p>"."\r\n";
        }
    }
    //Write a review function
    function reviewAction($p){
        if(isset($_SESSION['userData']) && (!empty(trim($p['latestReview'])))){
            $d = $_SESSION['userData'];
            $review = escape_this_string($p['latestReview']);
            $id = escape_this_string($d['id']);
            $query = "INSERT INTO `reviews`
                    (`user_id`, `content`, `update_time`)
                    VALUES
                    ({$id}, '{$review}', now())";
            run_mysql_query($query);
            header("Location: ../index.php");
            die();
        }
        else if(isset($_SESSION['userData']) && (empty(trim($p['latestReview'])))){
            header("Location: ../index.php");
            die();
        }
        else{
            //triggers if user not logged in
            header("Location: signIn.php");
            die();
        }
    }
    // LOGOUT
    if(isset($_POST['logoutAction']) == "logout"){
        logout();
    }
    if(isset($_POST['signEin']) == "signIn"){
        signInValidation($_POST);
    }
    // SIGN IN validation
    function signInValidation($post){
        $_SESSION['inputs']= array();
        foreach($post as $key => $value){
            $_SESSION['inputs'][$key] = $value;
        };
        $_SESSION['errors'] = array();
        //Contact Number Validation
        if(trim($post['fcEmail'] == "")){
            $_SESSION['errors'][] =  "Email cannot be empty!.";
        }
        //password Validation
        if(trim($post['pw'] == "")){
            $_SESSION['errors'][] =  "Password cannot be empty!";
        }
        //BEGIN CHECKING DATA FROM DATABASE
        $email = escape_this_string($post['fcEmail']);
        $password = escape_this_string($post['pw']);
        $query ="SELECT `users`.`user_id` AS id,
                        `users`.`email`,
                        `users`.`password`,
                        CONCAT(`first_name`,' ', `last_name`) AS name,
                        `users`.`salt`
                FROM    `users`
                WHERE   `email` = '{$email}'";
        $user = fetch_record($query);
        if(!empty($user)){
            $encryptedUserInput = md5($password . '' . $user['salt']);
            if($user['password'] == $encryptedUserInput){
                $_SESSION['userData'] = array();
                $_SESSION['userData']['id'] =  $user['id'];
                $_SESSION['userData']['name'] =  $user['name'];
                $_SESSION['userData']['postId'] = 0;
                header("Location: ../index.php");
                die();
            }
            else{
                $_SESSION['errors'][] =  "Please provide registered password.";
            }
        }else{
            $_SESSION['errors'][] =  "Please provide registered email address.";
        }
        header("Location: signIn.php");
        die();
    }

    if(isset($_POST['action']) == "register"){
        registerValidation($_POST);
    }
    //signup validation
    function registerValidation($post){
        $_SESSION['inputs']= array();
        foreach($post as $key => $value){
            $_SESSION['inputs'][$key] = $value;
        };
        $_SESSION['errors'] = array();
        //Name Validation
        if(trim($post['firstName'] == "") || (checkNUm($post['firstName']))){
            $_SESSION['errors'][] =  "First name cannot be empty or contain numbers.";
        }
        if(strlen($post['firstName']) < 2){
            $_SESSION['errors'][] =  "First name must have at least 2 characters.";
        }
        //Name Validation
        if(trim($post['lastName'] == "") || (checkNUm($post['lastName']))){
            $_SESSION['errors'][] =  "Last name cannot be empty or contain numbers.";
        }
        if(strlen($post['lastName']) < 2){
            $_SESSION['errors'][] =  "First name must have at least 2 characters.";
        }
        //Email Validation
        if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['errors'][] =  "Invalid email";
        }
        if(trim($post['email']) == ""){
            $_SESSION['errors'][] =  "Email is required.";
        }
        //Contact Number Validation
        if(trim($post['contactNumber'] == "") || (validateNum($post['contactNumber']) == false)){
            $_SESSION['errors'][] =  "Invalid contact number! eg.09123456789";
        }
        //password Validation
        if(trim($post['password'] == "") || (strlen($post['password']) < 8)){
            $_SESSION['errors'][] =  "Password cannot be empty && must be least 8 characters long";
        }
        //Confirm password Validation
        if($post['password'] != $post['confirmPassword']){
            $_SESSION['errors'][] =  "Password mismatch!";
        }
        if(count($_SESSION['errors']) <= 0){
            $fname = escape_this_string($post['firstName']);
            $lname = escape_this_string($post['lastName']);
            $email = escape_this_string($post['email']);
            $number = escape_this_string($post['contactNumber']);
            $password = escape_this_string($post['password']);
            $salt = bin2hex(openssl_random_pseudo_bytes(22));
            $encrypted_password = md5($password . '' . $salt);

            $query = "INSERT INTO `users`
            (`first_name`,`last_name`,`email`,`contact_number`,`password`,`salt`,`update_time`)
            VALUES
            ('{$fname}','{$lname}','{$email}','{$number}','{$encrypted_password}','{$salt}',now())";
            run_mysql_query($query);
            $_SESSION['successMsg'] = $post['firstName'];
        }
        header("Location: signup.php");
        die();
    }
    //All about message box
    function validationMsg(){
        if(isset($_SESSION['inputs'])){
            //repopulating the input based on user input
            foreach($_SESSION['inputs'] as $key => $value){
                $_POST[$key] = $value;
            }
            unset($_SESSION['inputs']);
        }
        if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0){
            // $prevInputs  = $_SESSION['inputs'];
            $errors = $_SESSION['errors'];
            //creating error message
            $msgBox = "    <div class='errorField'>"."\r\n";
            //Appending all catch errors
            foreach($errors as $key ){
                $msgBox .= "      <p>"."* ".$key."</p>"."\r\n";
            }
            $msgBox .= '    </div>'."\r\n";
            echo $msgBox;
            unset($_SESSION['errors']);
        }
        if(isset($_SESSION['successMsg'])){
            $msgBox = "    <div class='successMsg'>"."\r\n";
            $msgBox .= "      <p>Thanks! " .$_SESSION['successMsg']. " you are successfully signed up!</p>"."\r\n";
            $msgBox .= '    </div>'."\r\n";
            echo $msgBox;
            unset($_SESSION['successMsg']);
            unset($_POST);
        }
    }
    //reset password and set to "village88"
    function resetPass($post){
        $defaultPass = "village88";
        $email = escape_this_string($post['emailAddress']);
        $password = escape_this_string($defaultPass);
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $encrypted_password = md5($password . '' . $salt);

        $query ="UPDATE `users`
                SET
                `password` = '{$encrypted_password}',
                `salt` = '{$salt}',
                `update_time` = now()
                WHERE `email` = '{$email}'";
        $dataState = run_mysql_query($query);
        echo json_encode($dataState);
        exit;
    }
    // destroy session and redirect to the signup page
    function logout(){
        unset($_SESSION);
        session_destroy();
        header("location: index.php");
    }
    //name validator
    function checkNUm($x){
        for($c=0;$c<strlen($x);$c++){
            if(is_numeric($x[$c])){
                return true;
            }
        }
    }
    //phone number validation
    function validateNum($num){
    if((strlen($num) == 11) && is_numeric($num)){
        $prefix = '';
        for($c=0;$c<strlen($num)-9;$c++){
            $prefix .= $num[$c];
        }
        return($prefix == '09')? true : false;
        }
        else{
            return false;
        }
    }
?>