<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="./CSS/setting.css">
</head>
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
?>
<body onload="mainPageLoad()">
	<section class="title">
            <div class="titlename">
                설정
            </div>
    </section>
    <div class="settings-container">
        <ul>
            <li><a href="USER_UPDATE.php" class="settingsButton" onclick="openUserInfoModal()">회원 정보 수정</a></li><br><br>
            <li><a href="Change_password.php" class="settingsButton" onclick="openPasswordChangeModal()">비밀번호 변경</a></li><br><br>
            <li><a href="#" class="settingsButton" onclick="openInquiryModal()">문의하기</a></li><br><br>
			<li><a href="#" class="settingsButton" onclick="promptForPassword()" action="RE_FOOD_INSERT.php">음식 선호도 다시 조사하기</a></li><br><br>
            <li><a href="logout.php" class="settingsButton"onclick="logout()">로그아웃</a></li>
        </ul>
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
                </li>
                -->
                <li>
                    <a href="./settings.php">
                        <i class="fas fa-user-gear"></i>
                        <p>설정</p>
                    </a>
                </li>
            </ul>
        </nav>
<script>
        function promptForPassword() {
            // SweetAlert로 비밀번호 확인
            swal({
                title: "음식 선호도 다시 조사하기",
                text: "비밀번호를 입력해주세요:",
                content: {
                            element: "input",
                            attributes: {
                                type: "password", // 이 부분을 추가하여 입력값을 마스킹합니다.
                            },
                        },
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
                if (enteredPassword === "<?php echo $row['password']; ?>") {
                        // SweetAlert로 수정 여부 확인
                        swal({
                            title: "음식 선호도 다시 조사하기",
                            text: "다시 조사하시겠습니까?",
                            icon: "warning",
                            buttons: {
                                cancel: "취소",
                                confirm: "확인",
                            },
                            dangerMode: true,
                        }).then((confirmed) => {
                            // 사용자가 '확인'을 눌렀을 때만 페이지 이동
                            if (confirmed) {
                                location.href = "RE_FOOD_INSERT.php";
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
