<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");


$servername = "azza.gwangju.ac.kr";
$username = "dbuser191831";
$password = "ce1234";
$dbname = "db191831";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['ID'];

$sql = "SELECT f.id, f.file_route 
            FROM food f
            LEFT JOIN preference_rating pr ON f.id = pr.food_id AND pr.user_id = '$user_id'
            WHERE pr.user_id IS NULL
            ORDER BY RAND()
            LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);  // 반환값을 JSON 형식으로 변경하여 출력
} else {
    echo json_encode(["file_route" => "path/to/default_image.jpg", "id" => null]);
}

$conn->close();
?>
