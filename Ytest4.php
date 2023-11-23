<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>설문조사 페이지</title>
    <link rel="stylesheet" href="Ytest3.css">
</head>

<body>
    <div class="header">
        <h1>I4</h1>
    </div>

    <h2>선호도 조사</h2>

    <div class="step-container">
        <div class="now_step">step1</div>
        <div class="step">step2</div>
        <div class="step">step3</div>
        <div class="step">step4</div>
        <div class="step">step5</div>
        <div class="step">step6</div>
    </div>

    <form class="surveyForm">
    <div class="food-preference">
        <?php
function getRandomImagePath() {
    $servername = "azza.gwangju.ac.kr";
    $username = "dbuser191831";
    $password = "ce1234";
    $dbname = "db191831";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT file_route FROM food_image ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["file_route"];
    } else {
        return "path/to/default_image.jpg";
    }

    $conn->close();
}
        for ($i = 1; $i <= 10; $i++): ?>
            <label for="food<?php echo $i; ?>">음식 <?php echo $i; ?>:</label>
            <!-- 랜덤한 음식 이미지를 표시 -->
            <img src="<?php echo getRandomImagePath(); ?>" alt="음식 이미지" id="foodImage<?php echo $i; ?>">
            <input type="radio" name="food<?php echo $i; ?>" value="1">못 먹어요
            <input type="radio" name="food<?php echo $i; ?>" value="2">싫어요
            <input type="radio" name="food<?php echo $i; ?>" value="3" checked>보통이에요
            <input type="radio" name="food<?php echo $i; ?>" value="4">좋아요
            <input type="radio" name="food<?php echo $i; ?>" value="5">매우 좋아요
            <br>
        <?php endfor; ?>
    </div><br>

    <input type="button" onclick="saveAndNext()" value="다음">
</form>

<script>
    var step_count = 6;
    var step = 0;

    async function saveAndNext() {
        var now = document.querySelector('.now_step');
        if (now) {
            now.classList.remove('now_step');
            now.classList.add('step');
        }

        await updateFoodImages();
        savePreferences(); // 사용자의 응답을 서버에 저장

        step++;
        if (step >= step_count) {
            alert('마지막 단계입니다!');
            return;
        }
        var next = document.querySelectorAll('.step')[step];
        if (next) {
            next.classList.remove('step');
            next.classList.add('now_step');
        }
    }

    async function updateFoodImages() {
        // 이미지 업데이트 로직 (이전 코드 참조)
    }

    function savePreferences() {
        var ratings = {};

        for (let i = 1; i <= 10; i++) {
            var ratingValue = document.querySelector('input[name="food' + i + '"]:checked').value;
            ratings['food' + i] = ratingValue;
        }

        // Fetch API를 사용하여 서버에 응답을 전송
        fetch('savePreferences.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(ratings),
        })
        .then(response => response.json())
        .then(data => console.log('Success:', data))
        .catch(error => console.error('Error:', error));
    }
</script>

</body>

</html>
