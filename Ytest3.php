<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@session_start();

// 로그인 세션이 없으면 로그인 페이지로 리다이렉트
if (!isset($_SESSION['ID'])) {
    header("Location: 로그인 페이지 URL"); // 로그인 페이지의 URL로 수정해야 합니다.
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head profile="http://www.w3.org/2005/10/profile"> <link rel="icon" type="image/png" href="http://example.com/myicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>설문조사 페이지</title>
    <link rel="stylesheet" href="Ytest3.css">
</head>

<body>
    <div class="header">
        <h1>I4</h1>
		<p><?php echo $_SESSION['NAME']; ?>
    </div>

    <h2>선호도 조사</h2>

    <div class="step-container">
        <div class="now_step">step1</div>
        <div class="step">step2</div>
        <div class="step">step3</div>
        <div class="step">step4</div>
        <div class="step">step5</div>
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

    // 사용자 ID
    $user_id = $_SESSION['ID'];

    $sql = "SELECT f.id, f.file_route 
            FROM food f
            LEFT JOIN preference_rating pr ON f.id = pr.food_id AND pr.user_id = '$user_id'
            WHERE pr.user_id IS NULL
            ORDER BY RAND()
            LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
		$conn->close();
        return $row;
    } else {
		$conn->close();
        return null;
    }
}

            for ($i = 1; $i <= 10; $i++):
                $randomImage = getRandomImagePath();
            ?>
                <!-- 랜덤한 음식 이미지를 표시 -->
                <img src="<?php echo $randomImage['file_route']; ?>" alt="음식 이미지" id="foodImage<?php echo $i; ?>"><?php echo $randomImage['name']; ?>
                <input type="radio" name="preference<?php echo $i; ?>" id="<?php echo $randomImage['id']; ?>" value="1">못 먹어요
                <input type="radio" name="preference<?php echo $i; ?>" id="<?php echo $randomImage['id']; ?>" value="2">싫어요
                <input type="radio" name="preference<?php echo $i; ?>" id="<?php echo $randomImage['id']; ?>" value="3" checked>보통이에요
                <input type="radio" name="preference<?php echo $i; ?>" id="<?php echo $randomImage['id']; ?>" value="4">좋아요
                <input type="radio" name="preference<?php echo $i; ?>" id="<?php echo $randomImage['id']; ?>" value="5">매우 좋아요
                <br>
            <?php endfor; ?>
        </div><br>

        <input type="button" onclick="saveAndNextWrapper()" value="다음">


    </form>

    <script>
	var step_count = 5;
    var step = 0;

    async function saveAndNextWrapper() {
        try {
            await saveAndNext();
        } catch (error) {
            console.error('Error in saveAndNextWrapper:', error);
        }
    }

    async function saveAndNext() {
    var selectedValues = [];
    for (let i = 1; i <= 10; i++) {
        var selectedRadio = document.querySelector('input[name="preference' + i + '"]:checked');
        if (selectedRadio) {
            selectedValues.push({
                food_id: selectedRadio.id,
                rating: selectedRadio.value
            });
        }
    }

    try {
        const response = await fetch("savePreferences.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(selectedValues),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // 서버 응답에 대한 추가 처리
        const responseData = await response.json();
        console.log('Server Response:', responseData);

        if (responseData.status === 'success') {
            // 성공적으로 저장된 경우
            alert(responseData.message);

            var now = document.querySelector('.now_step');
            if (now) {
                now.classList.remove('now_step');
                now.classList.add('step');
            }

            await updateFoodImages();

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
        } else {
            // 저장 실패 또는 다른 상태인 경우
            console.error('Error saving preferences:', responseData.message);
            alert('Preferences could not be saved. Please try again.');
        }
    } catch (error) {
        console.error('Error saving preferences:', error);
    }
}

async function updateFoodImages() {
    for (let i = 1; i <= 10; i++) {
        try {
            // Fetch API를 사용하여 서버에서 새로운 이미지 경로와 food_id 가져오기
            const response = await fetch("getRandomImagePath.php");
            const data = await response.json();  // JSON 형식으로 파싱

            // 이미지의 ID를 동적으로 생성하여 이미지 속성 변경
            document.getElementById('foodImage' + i).src = data.file_route;
            document.getElementById('foodImage' + i).alt = '음식 이미지 ' + data.id;

            // 라디오 버튼의 ID도 업데이트
            document.querySelector('input[name="preference' + i + '"]').id = data.id;
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }
}

    </script>
</body>

</html>
