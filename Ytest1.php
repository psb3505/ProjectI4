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
            <label for="food">음식 선택:</label>
            <select name="food" id="food" required>
                <option value="피자">피자</option>
                <option value="스테이크">스테이크</option>
                <option value="초밥">초밥</option>
                <!-- 다른 음식 옵션 추가 -->
            </select>
            <br>
            <label for="rating">선호도 (1부터 5까지):</label>
            <input type="number" name="rating" id="rating" min="1" max="5" required>
            <br>
            <input type="submit" value="제출">
        </form>
    </section>
</body>

</html>
