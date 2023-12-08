<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/USER_UP.css">
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
<div>
    	<section class="title">
            <div class="titlename">
                개인정보 수정
            </div>
    </section>
    <form method='POST' action='USER_UPDATE_EXE.php' onsubmit='return handleFormSubmit()'>
        <hr>
		<div class="Logo">
        <table border="1" class="container">
            <input type="hidden" name="ID" value="<?php echo $row['id']; ?>">
            <tr>
                <td class="tdbox">이름</label></td>
                <td class="readon">
                    <input type="text" class="textbox" readonly="true" name="NAME" value="<?php echo $row['name']; ?>"><br>
                </td>
            </tr>
            <tr>
                <td class="tdbox">이메일</label></td>
                <td>
                    <input type="text" class="textbox" name="EMAIL"  value="<?php echo $row['email']; ?>"><br>
                </td>
            </tr>
            <tr>
                <td class="tdbox">전화 번호</label></td>
                <td>
                    <input type="text" class="textbox"  name="CALL" value="<?php echo $row['phone_num']; ?>"><br>
                </td>
            </tr>
        </table>
        <!-- 수정 버튼 -->
        <br><br><button type="button" class="footerbox"onclick="promptForPassword()">수정</button>
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

        function promptForPassword() {
            // SweetAlert로 비밀번호 확인
            swal({
                title: "개인정보 수정",
                text: "비밀번호를 입력해주세요:",
                content: "input",
                button: {
                    text: "확인",
                    closeModal: false,
                },
            }).then((enteredPassword) => {
                // 비밀번호 확인
                if (enteredPassword === null || enteredPassword === "") {
                    swal("", "비밀번호를 입력해주세요.", "error");
                    return;
                }

                // 여기에서 입력받은 비밀번호를 서버로 전송하여 확인 로직을 추가해야 합니다.
                // 여기에서는 일단 서버로 전송하지 않고 클라이언트에서 확인하는 것으로 예시를 보여주었습니다.
                if (enteredPassword === "<?php echo $row['password']; ?>") {
                    // SweetAlert로 수정 여부 확인
                    swal({
                        title: "개인정보 수정",
                        text: "정말로 수정하시겠습니까?",
                        icon: "warning",
                        buttons: ["취소", "확인"],
                        dangerMode: true,
                    }).then((willUpdate) => {
                        if (willUpdate) {
                            // 폼 제출 로직 추가
                            document.forms[0].submit();
                        }
                    });
                } else {
                    // SweetAlert를 사용하여 비밀번호 오류 메시지 출력
                    swal("", "비밀번호가 일치하지 않습니다.", "error");
                }
            });
        }
    </script>
</body>
</html>
