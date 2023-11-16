<?php
ini_set('memory_limit', '256M');

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
        if ($value['CKG_NM'] == $food_name) {
            return $key;
        }
    }
    return -1; // If not found
}


function get_recommendations($food_name, $foods, $cosine_sim) {
    try {
        $idx = get_idx($food_name, $foods);
        if ($idx === -1) {
                echo "Error: Food '$food_name_to_find' not found.";
                exit(1);
            }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit(1);
    }

    // 코사인 유사도 매트릭스에서 idx에 해당하는 데이터를 (idx, 유사도) 형태
    $sim_scores = [];
       foreach ($cosine_sim as $key => $value) {
            if($key == $idx) {
                var_dump($key);
                var_dump($value[$idx]);
                // $sim_scores[] = [$key, $value[$idx]];
                break;
            }
       }

    return $sim_scores;
}

// 예시 사용법
$food_name_from_php = "현미호두죽";  // PHP에서 전달 받은 음식 이름
// $food_names = get_recommendations($food_name_from_php, $foods, $cosine_sim);

// foreach ($food_names as $name) {
//     echo $name . PHP_EOL;
// }

// var_dump($food_names);

$first_row_values = $cosine_sim[3];
print_r($first_row_values);
?>
