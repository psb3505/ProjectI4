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

    $sql = "SELECT * FROM user WHERE ID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // 기존 비밀번호 확인
    if ($currentPassword !== $row['password']) {
        echo '<script>';
        echo 'swal("오류", "기존 비밀번호가 일치하지 않습니다.", "error").then(() => { location.href="Change_password.php"; });';
        echo '</script>';
        exit();
    }

    // 새로운 비밀번호와 확인이 일치하는지 확인
    if ($newPassword !== $confirmNewPassword) {
        echo '<script>';
        echo 'swal("오류", "새로운 비밀번호와 확인이 일치하지 않습니다.", "error").then(() => { location.href="Change_password.php"; });';
        echo '</script>';
        exit();
    }

    // 새 비밀번호의 복잡성 검사
    if (!isValidPassword($newPassword)) {
        echo '<script>';
        echo 'swal("오류", "새로운 비밀번호는 8자 이상이어야 하며, 특수문자, 숫자, 대문자, 소문자 중 최소 하나 이상을 포함해야 합니다.", "error").then(() => { location.href="Change_password.php"; });';
        echo '</script>';
        exit();
    }

    $query = "UPDATE user SET password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $newPassword, $ID);

    $result = $stmt->execute();

    if (!$result) {
        echo '<script>';
        echo 'swal("오류", "비밀번호 변경에 실패했습니다. 관리자에게 문의하세요.", "error").then(() => { location.href="Change_password.php"; });';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'swal("성공", "비밀번호가 성공적으로 변경되었습니다.", "success").then(() => { location.href="settings.php"; });';
        echo '</script>';
    }

    $stmt->close();
    $mysqli->close();

    // 새 비밀번호의 복잡성을 검사하는 함수
    function isValidPassword($password) {
        // 비밀번호는 8자 이상이어야 하며, 특수문자, 숫자, 대문자, 소문자 중 최소 하나 이상을 포함해야 함
        return strlen($password) >= 8 &&
               preg_match('/[!@#$%^&*(),.?":{}|<>0-9A-Za-z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password);
    }
    ?>
</body>
</html>
