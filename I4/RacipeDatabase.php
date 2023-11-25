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
        
        // 각 항목에 LIKE를 추가
        $food_names_string = "f.name LIKE " . $food_names_string;  

        $sql = "SELECT f.id AS id,
                f.file_route AS file_route,
                r.title AS title,
                r.ckg_dodf_nm AS ckg_dodf_nm,
                r.ckg_timg_nm AS ckg_timg_nm,
                r.ckg_inbun_nm AS ckg_inbun_nm,
                r.ckg_mtrl_cn AS ckg_mtrl_cn,
                r.recipe_description as recipe_description,
                v.url AS url
        FROM food AS f
        JOIN racipe AS r ON f.id = r.food_id
        JOIN video AS v ON r.id = v.racipe_id
        WHERE ($food_names_string)";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $food_data[] = array(
                    'id' => $row['id'],
                    'file_route' => $row['file_route'],
                    'title' => $row['title'],
                    'ckg_dodf_nm' => $row['ckg_dodf_nm'],
                    'ckg_timg_nm' => $row['ckg_timg_nm'],
                    'ckg_inbun_nm' => $row['ckg_inbun_nm'],
                    'ckg_mtrl_cn' => $row['ckg_mtrl_cn'],
                    'recipe_description' => $row['recipe_description'],
                    'url' => $row['url']
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
