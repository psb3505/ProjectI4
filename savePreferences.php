<?php
@session_start();

$host = "192.168.1.3";
$user = "dbuser191831";
$pw = "ce1234";
$dbName = "db191831";

$mysqli = new mysqli($host, $user, $pw, $dbName, "3306");

// 연결 오류 체크
if ($mysqli->connect_error) {
    die("MySQL 연결 실패: " . $mysqli->connect_error);
}

// POST로 전송된 음식 선호도 데이터 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 사용자 ID
        $user_id = $_SESSION['ID'];

        // SQL 쿼리 준비
        $sql = "INSERT INTO preference_rating (user_id, food_id, rating) VALUES (?, ?, ?)
				ON DUPLICATE KEY UPDATE rating = VALUES(rating)";
        $stmt = $mysqli->prepare($sql);

        // 음식 선호도 데이터 처리
        for ($i = 1; $i <= 30; $i++) {
            $preference = isset($_POST['preference' . $i]) ? $_POST['preference' . $i] : null;

            // 값과 음식 ID 분리
            list($food_id, $rating) = explode('_', $preference);

            // 데이터베이스에 저장
            $stmt->bind_param("iss", $user_id, $food_id, $rating);
            $result = $stmt->execute();

            if (!$result) {
                if ($mysqli->errno == 1062) {
                    // 중복된 키 에러 (1062) 처리
                    // 여기에서 중복된 키 에러에 대한 추가 처리를 할 수 있습니다.
                    // 예를 들어, 업데이트 쿼리를 따로 수행하거나 다른 조치를 취할 수 있습니다.
                    // 현재는 에러를 던지고 있습니다.
                    echo json_encode(array("error" => "Duplicate key error: " . $stmt->error));
                } else {
                    // 다른 에러 처리
                    echo json_encode(array("error" => "Error saving preference: " . $stmt->error));
                }
				exit();
            }
        }

        // 선호도 저장이 완료되면 리다이렉트 또는 응답을 보낼 수 있음
        header("Location: ./Main.html");
        exit();
    } catch (Exception $e) {
        echo '<script>';
        echo 'alert("선호도 저장에 실패하였습니다. 에러 메시지: ' . $e->getMessage() . '");';
        echo 'location.href = "Ytest4.php";';
        echo '</script>';
    }

    // 리소스 해제
    $stmt->close();
    $mysqli->close();
}
else {
    // POST 요청이 아닌 경우에 대한 처리
    http_response_code(405);
    exit("Method Not Allowed");
}
?>
