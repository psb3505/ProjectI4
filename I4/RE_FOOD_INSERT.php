<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php
    @session_start();

    $host = "192.168.1.3";
    $user = "dbuser191831";
    $pw = "ce1234";
    $dbName = "db191831";

    $mysqli = new mysqli($host, $user, $pw, $dbName, "3306");

    $ID = $_SESSION['ID'];
	
	$query = "UPDATE user SET optin = 'false' WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $ID);

    $result = $stmt->execute();

	if (!$result) {
        echo '<script>';
        echo 'swal("오류", "실패했습니다. 관리자에게 문의하세요.", "error").then(() => { location.href="settings.php"; });';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'swal("성공", "선호도 정보가 초기화되었습니다.", "success").then(() => { location.href="Ytest4.php"; });';
        echo '</script>';
    }
	
	$stmt->close();
    $mysqli->close();
?>
</body>
</html>
