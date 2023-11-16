<?php
//1.9
$foodCategories = array("한식", "양식", "중식", "일식");
$ratings = array("못 먹어요", "싫어요", "보통이에요", "좋아요", "매우 좋아요");

// 현재 단계 추적을 위한 변수
$currentStep = isset($_SESSION['currentStep']) ? $_SESSION['currentStep'] : 0;

if ($currentStep >= count($foodCategories)) {
    // 모든 단계가 끝났을 경우, 결과 페이지로 이동
    include 'result.php';
    exit();
}

// 현재 단계의 음식 카테고리
$currentCategory = $foodCategories[$currentStep];

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
    echo "<br>";
}
?>

<button id="prevButton">이전</button>
<button id="nextButton">다음</button>
