<?php
// savePreferences.php

$servername = "azza.gwangju.ac.kr";
$username = "dbuser191831";
$password = "ce1234";
$dbname = "db191831";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 클라이언트에서 전송된 JSON 데이터 가져오기
$data = json_decode(file_get_contents("php://input"), true);

// 사용자 ID (예시로 1로 설정)
$user_id = 1;

// 데이터베이스에 응답 저장
foreach ($data as $food_id => $rating) {
    $query = "INSERT INTO preference_rating (user_id, food_id, rating) VALUES ('$user_id', '$food_id', '$rating')";
    $result = $conn->query($query);

    if (!$result) {
        echo "Error: " . $conn->error;
    }
}

$conn->close();

echo json_encode(['message' => 'Preferences saved successfully']);
?>
