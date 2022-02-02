<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
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

if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

?>

<h1>Automobiles</h1>

<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo("<ul>");
foreach ( $rows as $row ) {
    echo("<li>");
    echo($row['year']."\n");
    echo($row['make']."\n");
    echo("/");
    echo($row['mileage']."\n");
    echo("</li>");
}
echo("</ul>");
?>

<p>
<a href="add.php">Add New</a> | <a href="logout.php">Logout</a> 
</p>


</div>
</body>
</html>
