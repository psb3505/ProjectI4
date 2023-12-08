<?php

@session_start();

// dbconfig.php 파일
$host = "192.168.1.3";
$user = "dbuser191831";
$pw = "ce1234";
$dbName = "db191831";

$conn = mysqli_connect($host, $user, $pw, $dbName, "3306");

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

        // 여기서 optin이 'true'인 경우를 추가
        if ($row['optin'] == 'true') {
            header('Location: ./Main.html');
            exit();
        }

        if (isset($_SESSION['ID'])) {
            ?>
            <script>
                alert("로그인 되었습니다.");
                location.replace("./Ytest4.php");
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
            alert("아이디가 존재하지 않거나 비밀번호가 잘못되었습니다.");
            history.back();
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert("아이디 혹은 비밀번호가 잘못되었습니다.");
        history.back();
    </script>
    <?php
}

// MySQL 연결 종료
$conn->close();
?>
