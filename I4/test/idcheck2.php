<?php

@session_start();

// dbconfig.php 파일
$host = "192.168.1.3";
$user = "dbuser191831";
$pw = "ce1234";
$dbName = "db191831";

$conn = mysqli_connect($host, $user, $pw, $dbName, "3306");

// 연결 오류 체크
if (!$conn) {
    die("connect: 실패 - " . mysqli_connect_error());
} else {
    echo "connect: 성공<br>";
}
mysqli_select_db($conn, $dbName);

$ID = $_POST['ID'];
$PASSWORD = $_POST['PASSWORD'];

$query = "SELECT * FROM user WHERE ID='{$ID}'";
$count = "SELECT count(*) AS total FROM user WHERE ID = '{$ID}'";

$result = $conn->query($query);
$countResult = $conn->query($count);

$rowcount = $countResult->fetch_assoc();
$totalrows = $rowcount['total'];

if ($totalrows >= 1) {
    $row = $result->fetch_assoc();
    $NAME = $row['name'];
    $_SESSION['NAME'] = $NAME;
    if ($row['password'] == $PASSWORD) {
        $_SESSION['ID'] = $ID;
        if (isset($_SESSION['ID'])) {
?>
       <script>
       alert("로그인 되었습니다.");
       location.replace("./Main_page.php");
       </script>
<?php
		} else {
?>
        <script>
            alert("아이디 혹은 비밀번호가 잘못되었습니다.");
            history.back();
        </script>
<?php
        }
    } else {
?>
    <script>
        alert("아이디가 존재하지 않습니다.");//아이디가 존재하지 않음 
        history.back();
    </script>
<?php
    }
}  // Add this closing brace

// MySQL 연결 종료
$conn->close();
?>
