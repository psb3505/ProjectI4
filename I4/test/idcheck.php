<?php
// dbconfig.php 파일
$host = "192.168.1.3";
$user = "dbuser191831";
$pw = "ce1234";
$dbName = "db191831";

$conn = mysqli_connect($host, $user, $pw, $dbName, "3306");

if (!$conn) {
    die("connect: 실패 - " . mysqli_connect_error());
} else {
    echo "connect: 성공<br>";
}

mysqli_select_db($conn, $dbName);

// 사용자가 POST로 전송한 데이터를 안전하게 가져옴
$ID = isset($_POST['ID']) ? $_POST['ID'] : '';

if ($ID == '') {
    echo '아이디를 입력하세요.';
    exit;
}

if (mb_strlen($ID) < 4 || mb_strlen($ID) > 15) {
    echo '아이디는 4~15자 이내로 가능합니다.';
    exit;
}

// 데이터베이스에 존재하는 아이디 확인
$sql = "SELECT count(*) AS total FROM user WHERE ID = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("쿼리 준비 실패: " . $conn->error);
}

$stmt->bind_param('s', $ID);
$stmt->execute();
$stmt->bind_result($totalrows);
$stmt->fetch();
$stmt->close();

$conn->close();

// 결과에 따라 메시지 출력
if ($totalrows >= 1) {
    echo '이미 존재하는 아이디가 있습니다.';
} else {
    echo '사용 가능한 아이디 입니다.';
}
?>
