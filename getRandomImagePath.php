<?php
$servername = "azza.gwangju.ac.kr";
$username = "dbuser191831";
$password = "ce1234";
$dbname = "db191831";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT file_route FROM food_image ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["file_route"];
} else {
    echo "path/to/default_image.jpg";
}

$conn->close();
?>
