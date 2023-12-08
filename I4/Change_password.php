<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/CHANGE_PASSWORD.css">
</head>
<?php
// DB 연결
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

function generateSweetAlertScript($title, $text, $icon, $buttons) {
    echo '<script>';
    echo 'swal({';
    echo 'title: "' . $title . '",';
    echo 'text: "' . $text . '",';
    echo 'icon: "' . $icon . '",';
    echo 'buttons: ' . json_encode($buttons) . ',';
    echo 'dangerMode: true,';
    echo '});';
    echo '</script>';
}

?>
<body>
    <!-- 비밀번호 변경 폼 -->
	<div class="PA_body">
    	<section class="title">
            <div class="titlename">
                비밀번호 변경
            </div>
    </section>
    <form method='POST' action='CHANGE_PASSWORD_EXE.php' onsubmit='return handleFormSubmit()'>
        <hr>
		<div class="Logo">
        <table border="0" class="container">
            <input type="hidden" name="ID" value="<?php echo $row['id']; ?>">
            <tr>
                <td>
				<h4 class="tdbox">기존 비밀번호</h4>
                    <input type="password" class="textbox" name="currentPassword" required><br>
                </td>
            </tr>
            <tr>
                <td>
					<h4 class="tdbox">새로운 비밀번호</h4>
                    <input type="password" class="textbox" name="newPassword" required><br>
                </td>
            </tr>
            <tr>
                <td>
				    <h4 class="tdbox">새로운 비밀번호 확인</h4>
                    <input type="password" class="textbox" name="confirmNewPassword" required><br>
                </td>
            </tr>
        </table>
        <!-- 비밀번호 변경 버튼 -->
        <br><br><button type="button" class="footerbox" onclick="promptForPasswordChange()">변경</button>
		</div>
    </form>
	</div>
        <nav class="nav">
            <ul class="navWrap">
                <li>
                    <a href="./Main.html">
                        <i class="fas fa-burger" style="opacity: 0.2;"></i>
                        <p style="opacity: 0.2;">추천</p>
                    </a>
                </li>
                <!--
                <li>
                    <a href="#">
                        <i class="fas fa-thumbs-up" style="opacity: 0.2;"></i>
                        <p style="opacity: 0.2;">평가</p>
                    </a>
                </li>-->
                <li>
                    <a href="./settings.php">
                        <i class="fas fa-user-gear"></i>
                        <p>설정</p>
                    </a>
                </li>
            </ul>
        </nav>

    <script>
        function handleFormSubmit() {
            // 폼 제출 로직
        }

        function promptForPasswordChange() {
            // SweetAlert로 비밀번호 변경 확인
            swal({
                title: "비밀번호 변경",
                text: "비밀번호를 변경하시겠습니까?",
                icon: "warning",
                buttons: ["취소", "확인"],
                dangerMode: true,
            }).then((willChange) => {
                if (willChange) {
                    // 폼 제출 로직 추가
                    document.forms[0].submit();
                }
            });
        }
    </script>
</body>
</html>
