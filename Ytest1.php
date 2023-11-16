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

            foreach ($foodCategories as $category) {
                echo "<h3>{$category}</h3>";
                for ($i = 1; $i <= 10; $i++) {
                    $imageName = "{$category}_{$i}.jpg";  // 나중에 추가할 이미지 파일 이름
                    echo "<label for='{$category}_{$i}'>{$i}. <img src='{$imageName}' alt='{$category} {$i}' width='50'></label>";
                    echo "<input type='radio' name='{$category}_{$i}' id='{$category}_{$i}' value='못 먹어요' required>못 먹어요";
                    echo "<input type='radio' name='{$category}_{$i}' value='싫어요'>싫어요";
                    echo "<input type='radio' name='{$category}_{$i}' value='보통이에요'>보통이에요";
                    echo "<input type='radio' name='{$category}_{$i}' value='좋아요'>좋아요";
                    echo "<input type='radio' name='{$category}_{$i}' value='매우 좋아요'>매우 좋아요";
                    echo "<br>";
                }
            }
            ?>
            <br>
            <input type="submit" value="제출">
        </form>
    </section>
</body>

</html>
