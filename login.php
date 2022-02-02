<?php // Do not put any HTML above this line

session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to autos.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {


    $_SESSION['oldname']=isset($_POST['email'])?$_POST['email']:''; 
    $_SESSION['oldpass']=isset($_POST['pass'])?$_POST['pass']:'';

    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    } else {
        if (strpos($_POST['email'],'@')==FALSE) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        } else {
            $check = hash('md5', $salt.$_POST['pass']);

            if ( $check == $stored_hash ) {
                error_log("Login success ".$_POST['email']);
                $_SESSION['name'] = $_POST['email'];
                header("Location: view.php");
                return;
            } else {
                error_log("Login fail ".$_POST['email'].$check);
                $_SESSION['error'] = "Incorrect password";
                header("Location: login.php");
                return;
            }
        }
    }
error_log("Login fail ".$_POST['email']);
}
?>


<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Ija Saporenkova</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}

if ( isset($_SESSION['oldname']) ) {
    $oldname=$_SESSION['oldname'];
    unset($_SESSION['oldname']);
} else $oldname='';

if ( isset($_SESSION['oldpass']) ) {
    $oldpass=$_SESSION['oldpass'];
    unset($_SESSION['oldpass']);
} else $oldpass='';


?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam" value="<?=htmlentities($oldname)?>"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"value="<?=htmlentities($oldpass)?>"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>
</body>
