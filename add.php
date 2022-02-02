<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: view.php");
    return;
}


// Validation
if ( isset($_POST['year']) && isset($_POST['make']) && isset($_POST['mileage']) ) {
    if (( is_numeric($_POST['year']) == FALSE) || ( is_numeric($_POST['mileage']) == FALSE) ) {
            //$failure = "Mileage and year must be numeric";
            $_SESSION['error'] = "Mileage and year must be numeric";
            header("Location: add.php");
            return;
        } else {
            if (strlen($_POST['make']) < 1 ) {
                //$failure = "Make is required";
                $_SESSION['error'] = "Make is required";
                header("Location: add.php");
                return;
                }
            }
}

require_once "first.php"; //require_once "pdo.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Ija Saporenkova</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for</h1>
<?php
echo "<p>";
echo htmlentities($_SESSION['name']);
echo "</p>\n";
?>


<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
} else {
        if ( isset($_POST['year']) && isset($_POST['make']) && isset($_POST['mileage']) ) {
            $stmt = $pdo->prepare('INSERT INTO autos
            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
            $stmt->execute(array(
            ':mk' => htmlentities($_POST['make']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage']))
            );

            $_SESSION['success'] = "Record inserted";
            header("Location: view.php");
            return;
        }
    } 
?>


<form method="post">
<p>Make: <input type ="text" name ="make" size=40></p>
<p>Year: <input type ="text" name ="year"></p>
<p>Mileage: <input type ="text" name ="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>


</div>
</body>
</html>
