<?php
session_start();  // 세션을 사용하기 위한 시작 선언
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Ytest1.css">
    <title>음식 선호도 조사</title>
</head>

<body>
    <header>
        <h1 style="margin: 0;">I4</h1>
    </header>

    <section>
        <h2>선호도 조사</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php
            $foodCategories = array("한식", "양식", "중식", "일식");
            $ratings = array("못 먹어요", "싫어요", "보통이에요", "좋아요", "매우 좋아요");

            // 현재 단계 추적을 위한 변수
            $currentStep = isset($_SESSION['currentStep']) ? $_SESSION['currentStep'] : 0;

            if ($currentStep >= count($foodCategories)) {
                // 모든 단계가 끝났을 경우, 결과 페이지로 이동
                header("Location: result.php");
                exit();
            }

            // 현재 단계의 음식 카테고리
            $currentCategory = $foodCategories[$currentStep];

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

            // "한식" 이외의 카테고리에서는 "이전" 버튼 표시
            if ($currentCategory != "한식") {
                echo "<input type='submit' name='prevButton' value='이전'>";
            }

            // "일식"에서는 "완료" 버튼 표시
            if ($currentCategory == "일식") {
                echo "<input type='submit' name='completeButton' value='완료'>";
            } else {
                // "일식"이 아닌 경우에는 "다음" 버튼 표시
                echo "<input type='submit' name='nextButton' value='다음'>";
            }
            ?>
        </form>

        <?php
        // "이전" 버튼이 눌렸을 경우 처리
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prevButton'])) {
            $_SESSION['currentStep']--;  // 이전 단계로 이동
            header("Location: Ytest1.php");  // 현재 페이지를 다시 로드하여 이전 단계를 표시
            exit();
        }

        // "완료" 버튼이 눌렸을 경우 처리
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completeButton'])) {
            $_SESSION['currentStep']++;  // 다음 단계로 이동
            header("Location: result.php");  // 결과 페이지로 이동
            exit();
        }

        // "다음" 버튼이 눌렸을 경우 처리
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nextButton'])) {
            $_SESSION['currentStep']++;  // 다음 단계로 이동
            header("Location: Ytest1.php");  // 현재 페이지를 다시 로드하여 다음 단계를 표시
            exit();
        }
        ?>
    </section>
</body>

</html>

// 1.6