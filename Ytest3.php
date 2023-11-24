<?php
@session_start();

// 로그인 세션이 없으면 로그인 페이지로 리다이렉트
if (!isset($_SESSION['ID'])) {
    header("Location: 로그인 페이지 URL"); // 로그인 페이지의 URL로 수정해야 합니다.
    exit();
}
?>

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
		<p><?php echo $_SESSION['NAME']; ?>
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

                $sql = "SELECT food_id, file_route FROM food_image ORDER BY RAND() LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row;
                } else {
                    return null;
                }

                $conn->close();
            }

            for ($i = 1; $i <= 10; $i++):
                $randomImage = getRandomImagePath();
            ?>
                <!-- 랜덤한 음식 이미지를 표시 -->
                <img src="<?php echo $randomImage['file_route']; ?>" alt="음식 이미지" id="foodImage<?php echo $i; ?>">
                <input type="radio" name="<?php echo $randomImage['food_id']; ?>" value="1"><?php echo $randomImage['food_id']; ?>
                <input type="radio" name="<?php echo $randomImage['food_id']; ?>" value="2">싫어요
                <input type="radio" name="<?php echo $randomImage['food_id']; ?>" value="3" checked>보통이에요
                <input type="radio" name="<?php echo $randomImage['food_id']; ?>" value="4">좋아요
                <input type="radio" name="<?php echo $randomImage['food_id']; ?>" value="5">매우 좋아요
                <br>
            <?php endfor; ?>
        </div><br>

        <input type="button" onclick="saveAndNextWrapper()" value="다음">


    </form>

    <script>
	var step_count = 6;
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
        var selectedRadio = document.querySelector('input[name="food' + i + '"]:checked');
        if (selectedRadio) {
            selectedValues.push({
                food_id: selectedRadio.name,
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

    // 여기서 서버 응답에 대한 추가 처리를 할 수 있습니다.
    const responseData = await response.json();
    console.log('Server Response:', responseData);

    // 이후에 필요한 작업 수행
} catch (error) {
    console.error('Error saving preferences:', error);
}

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
    } catch (error) {
        console.error('Error saving preferences:', error);
    }
}


async function updateFoodImages() {
    for (let i = 1; i <= 10; i++) {
        try {
            // Fetch API를 사용하여 서버에서 새로운 이미지 경로 가져오기
            const response = await fetch("getRandomImagePath.php");
            const newImagePath = await response.text();

            // 이미지의 ID를 동적으로 생성하여 이미지 속성 변경
            document.getElementById('foodImage' + i).src = newImagePath;
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }
}
    </script>
</body>

</html>
