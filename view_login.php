<?php
$submitPressed = filter_input(INPUT_POST, "btnSubmit");
if (isset($submitPressed)) {
    $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $password = filter_input(INPUT_POST, "txtPassword",
                FILTER_SANITIZE_SPECIAL_CHARS);
        $md5Password = md5($password);
        $data = array('api_key' => '123', 'email' => $email, 'password' => $md5Password);
        $result = Utility::curl_post('http://localhost/pw2_w09_ws/service/user/login',
                        $data);
        $decodeResult = json_decode($result);
        if (isset($decodeResult) && !empty($decodeResult->name)) {
            $_SESSION['approved_user'] = TRUE;
            $_SESSION['user_name'] = $decodeResult->name;
            $_SESSION['role'] = $decodeResult->role_name;
            header('location:index.php');
        } else {
            $errString = 'Invalid email or password';
        }
    } else {
        $errString = 'Invalid email format';
    }
}

if (isset($errString)) {
    echo '<div class="err_message">';
    echo $errString;
    echo '</div>';
}
?>

<form method="POST">
    <fieldset>
        <legend>Login Form</legend>
        <label for="txtEmailId">Email</label>
        <input id="txtEmailId" name="txtEmail" type="email" placeholder="Email" autofocus="" required="" >
        <br>
        <label for="txtPasswordId">Password</label>
        <input id="txtPasswordId" name="txtPassword" type="password" placeholder="Password" required="" >
        <br>
        <input name="btnSubmit" value="Login" type="submit" class="button button-primary">
    </fieldset>
</form>