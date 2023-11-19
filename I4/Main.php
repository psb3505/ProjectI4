<?php
    ini_set('memory_limit', '256M');
    include './Database.php';

    // JSON 파일 읽기
    $json_data = file_get_contents('cosine_sim.json');
    // JSON 데이터를 PHP 배열로 변환
    $data = json_decode($json_data, true);
    // cosine_sim에 접근
    $cosine_sim = $data['cosine_sim'];

    // JSON 파일 읽기
    $foods_json_data = file_get_contents('foods.json');
    // 각 줄을 배열로 파싱
    $foods_lines = explode("\n", $foods_json_data);
    $foods = array();

    foreach ($foods_lines as $line) {
        if (!empty($line)) {
            $foods[] = json_decode($line, true);
        }
    }

    function get_idx($food_name, $foods) {
        foreach ($foods as $key => $value) {
            // trim 함수를 사용하여 앞뒤의 공백을 제거하고 비교
            if (trim($value['CKG_NM']) == trim($food_name)) {
                return $key;
            }
        }
        return -1; // If not found
    }    


    function get_recommendations($food_name, $foods, $cosine_sim) {
        try {
            $idx = get_idx($food_name, $foods);
            if ($idx === -1) {
                    echo "Error: Food '$food_name' not found.";
                    exit(1);
                }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit(1);
        }

        // 코사인 유사도 매트릭스에서 idx에 해당하는 데이터를 (idx, 유사도) 형태
        $sim_scores = $cosine_sim[$idx];
        $result = array_map(function($value, $index) {
            return array($index, $value);
        }, $sim_scores, range(0, count($sim_scores) - 1));

        //코사인 유사도 기준으로 내림차순 정렬
        usort($result, function($a, $b) {
            // $a[1]과 $b[1]은 각각 원소의 값입니다.
            if ($a[1] == $b[1]) {
                // 두 번째 요소가 같을 때, 첫 번째 요소를 기준으로 오름차순 정렬
                return $a[0] - $b[0];
            }
            
            // 두 번째 요소가 다를 때, 내림차순 정렬
            return ($a[1] < $b[1]) ? 1 : -1;
        });
        

        // 자기 자신을 제외한 10개의 추천 영화를 슬라이싱
        $selected_result = array_slice($result, 1, 10);

        // 추천 음식 목록 10개의 인덱스 정보 추출
        $food_indices = array();
        foreach ($selected_result as $result) {
            $food_indices[] = $result[0];
        }

        // 인덱스 정보를 통해 영화 제목 추출
        $ckg_values = array();
        foreach ($foods as $food) {
            $ckg_values[] = $food['CKG_NM'];
        }

        $food_names = array();
        foreach ($food_indices as $i) {
            $food_names[] = $ckg_values[$i];
        }

        return $food_names;
    }

    // 예시 사용법
    $food_name_from_php = getFoodName();  // Database.php에서 전달 받은 음식 이름

    $food_names = get_recommendations($food_name_from_php, $foods, $cosine_sim);

    foreach ($food_names as $name) {
        echo $name . "<br>";
    }
?>
