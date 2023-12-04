<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@session_start();

// 로그인 세션이 없으면 에러 응답
if (!isset($_SESSION['ID'])) {
    http_response_code(401);
    exit("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // savePreferences.php
        $servername = "192.168.1.3";
        $username = "dbuser191831";
        $password = "ce1234";
        $dbname = "db191831";
        $user_id = $_SESSION['ID'];

        // 데이터베이스 연결
        $conn = new mysqli($servername, $username, $password, $dbname, "3306");

        // 데이터베이스 연결 실패 시 에러 응답
        if ($conn->connect_error) {
			http_response_code(500);
			exit("Connection failed: " . $conn->connect_error);
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO preference_rating (user_id, food_id, rating) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // 전송된 데이터 디코딩
        $requestData = json_decode(file_get_contents("php://input"), true);

        // JSON 디코딩 실패 시 에러 응답
        if ($requestData === null) {
            throw new Exception("Bad Request: JSON data could not be decoded.");
        }

        // 각 라디오 버튼의 값 처리
        foreach ($requestData as $data) {
            $food_id = $data['food_id'];
            $rating = $data['rating'];

            // SQL 쿼리 실행 (preference_rating 테이블에 데이터 삽입)
            $stmt->bind_param("iss", $user_id, $food_id, $rating);

            // execute 메서드의 결과 확인
            if (!$stmt->execute()) {
                throw new Exception("Error: " . $stmt->error);
            }
        }

        // 클라이언트에 응답을 보내줍니다.
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Preferences saved successfully']);

        // 리다이렉트
        header("Location: ./Main.html");
        exit();
    } catch (Exception $e) {
        http_response_code(500);
        exit("Error saving preferences: " . $e->getMessage());
    }
} else {
    http_response_code(405);
    exit("Method Not Allowed");
}

// 여기까지 코드가 실행되면 $conn->close();가 실행됩니다.
$conn->close();
?>
