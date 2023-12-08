<!-- PHP 파일 (savePreferences.php) -->

<?php
@session_start();

// 로그인 세션이 없으면 에러 응답
if (!isset($_SESSION['ID'])) {
    http_response_code(401);
    exit("Unauthorized");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "azza.gwangju.ac.kr";
    $username = "dbuser191831";
    $password = "ce1234";
    $dbname = "db191831";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        http_response_code(500);
        exit("Connection failed: " . $conn->connect_error);
    }

    // 사용자 ID
    $user_id = $_SESSION['ID'];

    // 전송된 데이터 디코딩
    $requestData = json_decode(file_get_contents("php://input"), true);

    // 각 라디오 버튼의 값 처리
    foreach ($requestData as $data) {
        $food_id = $data['food_id'];
        $rating = $data['rating'];

        // SQL 쿼리 실행 (preference_rating 테이블에 데이터 삽입)
        $sql = "INSERT INTO preference_rating (user_id, food_id, rating, recommendationStatus) VALUES ('$user_id', '$food_id', '$rating', 'N')";

        if ($conn->query($sql) !== TRUE) {
            http_response_code(500);
            exit("Error: " . $sql . "<br>" . $conn->error);
        }
    }

    $conn->close();
} else {
    http_response_code(405);
    exit("Method Not Allowed");
}
?>
