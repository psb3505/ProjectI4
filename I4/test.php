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

$sql = "SELECT * FROM user;";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("쿼리 실패: " . mysqli_error($conn));
}

while ($board = mysqli_fetch_array($result)) {
    echo $board[birth]; // column_name은 실제 컬럼 이름으로 대체되어야 합니다.
    echo "<br>";
}

$conn->close();

?>