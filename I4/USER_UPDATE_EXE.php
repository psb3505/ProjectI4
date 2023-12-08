<?php
@session_start();

$host = "192.168.1.3";
$user = "dbuser191831";
$pw = "ce1234";
$dbName = "db191831";

$mysqli = new mysqli($host, $user, $pw, $dbName, "3306");

$name = $_POST['NAME'];
$email = $_POST['EMAIL'];
$call = $_POST['CALL'];

$id = $_SESSION['ID'];

$query = "UPDATE user SET name = ?, email = ?, phone_num = ? WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssss", $name, $email, $call, $id);

$result = $stmt->execute();

if (!$result) {
    ?>
    <script>
        alert("개인정보 수정에 실패했습니다. 관리자에게 문의하세요.");
        location.href="USER_UPDATE.php";
    </script>
    <?php
} else {
    ?>
    <script>
        alert("개인정보가 수정되었습니다.");
        location.href="USER_UPDATE.php";
    </script>
    <?php
}

// MySQL 연결 종료
$stmt->close();
$mysqli->close();
?>
