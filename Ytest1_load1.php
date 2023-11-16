<?php
session_start();  // 세션을 사용하기 위한 시작 선언

$foodCategories = array("한식", "양식", "중식", "일식");
$ratings = array("못 먹어요", "싫어요", "보통이에요", "좋아요", "매우 좋아요");

// 현재 선택된 카테고리를 세션에서 가져옴
$currentCategory = isset($_SESSION['currentCategory']) ? $_SESSION['currentCategory'] : "한식";

echo "<h2>선호도 조사</h2>";
echo "<h3>{$currentCategory}</h3>";
for ($i = 1; $i <= 10; $i++) {
    $imageName = "{$currentCategory}_{$i}.jpg";  // 나중에 추가할 이미지 파일 이름
    echo "<label for='{$currentCategory}_{$i}'>{$i}. <img src='{$imageName}' alt='{$currentCategory} {$i}' width='50'></label>";
    echo "<input type='radio' name='{$currentCategory}_{$i}' id='{$currentCategory}_{$i}' value='못 먹어요' required>못 먹어요";
    echo "<input type='radio' name='{$currentCategory}_{$i}' value='싫어요'>싫어요";
    echo "<input type='radio' name='{$currentCategory}_{$i}' value='보통이에요'>보통이에요";
    echo "<input type='radio' name='{$currentCategory}_{$i}' value='좋아요'>좋아요";
    echo "<input type='radio' name='{$currentCategory}_{$i}' value='매우 좋아요'>매우 좋아요";
    echo "<br>";  // 줄 바꿈을 나타내는 <br> 태그 추가
}


// 현재 선택된 카테고리를 세션에 다음 카테고리로 업데이트
$nextCategoryIndex = array_search($currentCategory, $foodCategories) + 1;
if ($nextCategoryIndex < count($foodCategories)) {
    $_SESSION['currentCategory'] = $foodCategories[$nextCategoryIndex];
}
?>
