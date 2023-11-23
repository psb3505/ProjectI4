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
            // 랜덤한 음식 이미지를 표시하기 위해 PHP로 이미지 경로를 생성
            function getRandomImagePath() {
                $servername = "azza.gwangju.ac.kr";
                $username = "dbuser191831";
                $password = "ce1234";
                $dbname = "db191831";

                // 데이터베이스 연결
                $conn = new mysqli($servername, $username, $password, $dbname);

                // 연결 확인
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // 랜덤한 음식 이미지 경로 조회
                $sql = "SELECT file_route FROM food_image ORDER BY RAND() LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row["file_route"];
                } else {
                    return "path/to/default_image.jpg"; // 디폴트 이미지 경로 또는 다른 처리를 할 수 있습니다.
                }

                // 데이터베이스 연결 종료
                $conn->close();
            }

            for ($i = 1; $i <= 10; $i++): ?>
                <label for="food<?php echo $i; ?>">음식 <?php echo $i; ?>:</label>
                <!-- 랜덤한 음식 이미지를 표시 -->
                <img src="<?php echo getRandomImagePath(); ?>" alt="음식 이미지">
                <input type="radio" name="food<?php echo $i; ?>" value="못 먹어요">못 먹어요
                <input type="radio" name="food<?php echo $i; ?>" value="싫어요">싫어요
                <input type="radio" name="food<?php echo $i; ?>" value="보통이에요" checked>보통이에요
                <input type="radio" name="food<?php echo $i; ?>" value="좋아요">좋아요
                <input type="radio" name="food<?php echo $i; ?>" value="매우 좋아요">매우 좋아요
                <br>
            <?php endfor; ?>
        </div><br>

        <input type="button" onclick="saveAndNext()" value="다음">
    </form>

    <script>
        var step_count = 6;
        var step = 0;

        function saveAndNext() {
            // 현재 단계의 class를 "step"으로 변경
            var now = document.querySelector('.now_step');
            if (now) {
                now.classList.remove('now_step');
                now.classList.add('step');
            }

            step++;
            if (step >= step_count) {
                // 마지막 단계에서는 추가적인 처리를 할 수 있습니다.
                alert('마지막 단계입니다!');
                return;
            }
            var next = document.querySelectorAll('.step')[step];
            if (next) {
                next.classList.remove('step');
                next.classList.add('now_step');
            }
        }
    </script>
</body>
</html>
