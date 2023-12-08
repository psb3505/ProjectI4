<?php
@session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

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
		<p><?php echo $_SESSION['NAME']; ?></p>
    </div>

    <h2>선호도 조사</h2>


	<form class="surveyForm" id="preferencesForm" action="savePreferences.php" method="post">
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

    $sql = "SELECT f.id, f.name, f.file_route
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

            for ($i = 1; $i <= 30; $i++):
                $randomImage = getRandomImagePath();
            ?>
                <!-- 랜덤한 음식 이미지를 표시 -->
                <img src="<?php echo $randomImage['file_route']; ?>" alt="음식 이미지" id="foodImage<?php echo $i; ?>">
				<br>

                <?php echo $randomImage['name']; ?><br>
				<div class="form_toggle row-vh d-flex flex-row justify-content-between">
                    <div class="form_radio_btn">
				    	<input id="radio-1<?php echo $i; ?>" type="radio" name="preference<?php echo $i; ?>" value="<?php echo $randomImage['id']; ?>_1"><label for="radio-1<?php echo $i; ?>">못 먹어요</label>
                    </div>
                    <div class="form_radio_btn">
                        <input id="radio-2<?php echo $i; ?>" type="radio" name="preference<?php echo $i; ?>" value="<?php echo $randomImage['id']; ?>_2"><label for="radio-2<?php echo $i; ?>">싫어요</label>
                    </div>
                    <div class="form_radio_btn">
                        <input id="radio-3<?php echo $i; ?>" type="radio" name="preference<?php echo $i; ?>" value="<?php echo $randomImage['id']; ?>_3" checked><label for="radio-3<?php echo $i; ?>">보통이에요</label>
                    </div>
                    <div class="form_radio_btn">
                        <input id="radio-4<?php echo $i; ?>" type="radio" name="preference<?php echo $i; ?>" value="<?php echo $randomImage['id']; ?>_4"><label for="radio-4<?php echo $i; ?>">좋아요</label>
                    </div>
                    <div class="form_radio_btn">
                        <input id="radio-5<?php echo $i; ?>" type="radio" name="preference<?php echo $i; ?>" value="<?php echo $randomImage['id']; ?>_5"><label for="radio-5<?php echo $i; ?>">매우 좋아요</label>
                    </div>
                </div>

                <br>
            <?php endfor; ?>
        </div><br>

        <input class="ok" type="submit" onclick="submitForm()" value="확인">


    </form>

    <script>
	function submitForm() {
    var preferencesForm = document.getElementById('preferencesForm');
    preferencesForm.submit();
	return false; // 폼이 실제로 서버로 제출되지 않도록 함
}

    </script>
</body>
</html>