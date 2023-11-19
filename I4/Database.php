<?php
    function getFoodName() {
        // MySQL 서버에 연결
        $conn = mysqli_connect('azza.gwangju.ac.kr', 'dbuser191831', 'ce1234', 'db191831');

        // 연결 확인
        if (!$conn) {
            die("연결 실패: " . mysqli_connect_error());
        }

        // $foodName 변수 초기화
        $foodName = '';

        // 쿼리 조건을 배열로 정의
        $conditions = [
            "4 AND 5" => "BETWEEN 4 AND 5",
            "2 AND 3" => "BETWEEN 2 AND 3",
            "1" => "= 1"
        ];

        foreach ($conditions as $rating => $condition) {
            // 해당 등급에 대한 음식 추천 여부 확인
            $checkQueryWithStatus = "SELECT COUNT(*) AS count
                                    FROM preference_rating
                                    WHERE rating $condition
                                    AND user_id = 'sb'
                                    AND recommendationStatus = 'Y'";
            $checkQueryWithoutStatus = "SELECT COUNT(*) AS count
                                        FROM preference_rating
                                        WHERE rating $condition
                                        AND user_id = 'sb'";
            
            $checkResultWithStatus = mysqli_query($conn, $checkQueryWithStatus);
            $checkResultWithoutStatus = mysqli_query($conn, $checkQueryWithoutStatus);

            if ($checkResultWithStatus && $checkResultWithoutStatus) {
                $checkRowWithStatus = mysqli_fetch_assoc($checkResultWithStatus);
                $checkRowWithoutStatus = mysqli_fetch_assoc($checkResultWithoutStatus);

                $countWithStatus = $checkRowWithStatus['count'];
                $countWithoutStatus = $checkRowWithoutStatus['count'];

                // 해당 condition에 검색된 음식이 없으면 건너뛰기
                if(!$countWithoutStatus) {
                    continue;
                }

                // 해당 등급의 음식이 모두 추천 상태일 경우 초기화
                if ($countWithStatus === $countWithoutStatus) {
                    $updateQuery = "UPDATE preference_rating
                                    SET recommendationStatus = 'N'
                                    WHERE rating $condition
                                    AND user_id = 'sb'";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if (!$updateResult) {
                        echo "추천 상태 초기화 실패: " . mysqli_error($conn);
                    }
                }

                // 음식 추천
                $selectQuery = "SELECT food.name as name
                                FROM food
                                JOIN preference_rating ON food.id = preference_rating.food_id
                                WHERE preference_rating.user_id = 'sb'
                                AND preference_rating.recommendationStatus = 'N'
                                AND preference_rating.rating $condition
                                ORDER BY RAND()
                                LIMIT 1";
                $selectResult = mysqli_query($conn, $selectQuery);

                if ($selectResult && mysqli_num_rows($selectResult) > 0) {
                    while ($row = mysqli_fetch_assoc($selectResult)) {
                        echo "음식명 : " . $row['name'] . "<br>";
                        $foodName = $row['name'];
                
                        // $foodName에 해당하는 음식을 추천으로 표시
                        $updateQuery = "UPDATE preference_rating
                                        SET recommendationStatus = 'Y'
                                        WHERE food_id IN (SELECT id FROM food WHERE name = '$foodName')
                                        AND user_id = 'sb'";
                        $updateResult = mysqli_query($conn, $updateQuery);
                
                        if (!$updateResult) {
                            echo "추천 상태 업데이트 실패: " . mysqli_error($conn);
                        }
                    }
                    mysqli_free_result($selectResult);
                    break;  // 조건에 맞는 결과가 있으면 루프 중단
                } else {
                    echo "해당 등급의 음식이 없습니다. " . mysqli_error($conn);
                }
            } else {
                echo "체크 쿼리 실행 실패: " . mysqli_error($conn);
            }
        }

        // 연결 종료
        mysqli_close($conn);

        // $foodName 변수 반환
        return $foodName;
    }
?>
