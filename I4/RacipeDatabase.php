<?php
header('Content-Type: application/json');

// JSON 형식으로 전송된 데이터를 디코딩하여 $data에 저장
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    echo json_encode(selectRacipeVideoAndContent($data));
} else {
    // JSON 데이터 디코딩 실패
    echo json_encode(['message' => 'Error: Invalid JSON data']);
}

function DBConnect() {
    // MySQL 서버에 연결
    $conn = mysqli_connect('azza.gwangju.ac.kr', 'dbuser191831', 'ce1234', 'db191831');

    // 연결 확인
    if (!$conn) {
        die("연결 실패: " . mysqli_connect_error());
    }

    return $conn;
}

function selectRacipeVideoAndContent($data) {
    $conn = DBConnect();

    // $data에서 필요한 값을 가져와서 사용
    $food_names = $data['foodNameValue']; // 예시로 'foodNameValue'라고 가정

    $food_names_string = "'" . mysqli_real_escape_string($conn, $food_names) . "%'";
    
    // LIKE를 추가
    $food_names_string = "name LIKE " . $food_names_string;  

    $sql = "SELECT name
            FROM food
            WHERE $food_names_string";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $food_data[] = array(
                'food_name' => $row['name']
            );
        }
        mysqli_free_result($result);
    } else {
        // Handle query error
        die("Query failed: " . mysqli_error($conn));
    }

    // Close the connection
    mysqli_close($conn);

    return $food_data;
}
?>
