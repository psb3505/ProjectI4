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
                    echo "<label for='{$category}_{$i}'>{$i}.</label>";
                    echo "<select name='{$category}_{$i}' id='{$category}_{$i}' required>";
                    foreach ($ratings as $rating) {
                        echo "<option value='{$rating}'>{$rating}</option>";
                    }
                    echo "</select><br>";
                }
            }
            ?>
            <br>
            <input type="submit" value="제출">
        </form>
    </section>
</body>

</html>
