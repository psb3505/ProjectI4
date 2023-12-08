<html>
<body>
<?php
$host = "192.168.1.3";
$user = "dbuser191831";
$pw = "ce1234";
$dbName = "db191831";

$mysqli = new mysqli($host, $user, $pw, $dbName, "3306");

// 연결 오류 체크
if ($mysqli->connect_error) {
    die("MySQL 연결 실패: " . $mysqli->connect_error);
}

$sql = "INSERT INTO user(ID, PASSWORD, NAME, EMAIL, GENDER, phone_num, BIRTH) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

function check_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$ID = check_input($_POST['ID']);
$PASSWORD = check_input($_POST['PASSWORD']);
$NAME = check_input($_POST['NAME']);
$EMAIL = check_input($_POST['EMAIL']);
$GENDER = check_input($_POST['GENDER']);
$BIRTH = check_input($_POST['BIRTH']);
$phone_num = check_input($_POST['phone_num']);


$stmt->bind_param("sssssss", $ID, $PASSWORD, $NAME, $EMAIL, $GENDER, $phone_num, $BIRTH);

$result = $stmt->execute();

if (!$result) {
?>
    <script>
        alert("회원가입에 실패하였습니다.");
        location.href = "PLUSACCOUNT.php";
    </script>
<?php
} else {
    ?>
    <script>
        alert("회원가입이 완료되었습니다.");
        location.href = "LOGIN.php";
    </script>
<?php
    $stmt->close();
    $mysqli->close();
}
?>

</body>
</html>
