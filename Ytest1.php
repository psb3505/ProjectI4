<?php
session_start();  // 세션을 사용하기 위한 시작 선언 1.8
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Ytest1.css">
    <title>음식 선호도 조사</title>

    <script>
        function loadCategory(category) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("content").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "Ytest1_load1.php?category=" + category, true);
            xhr.send();
        }
    </script>
</head>

<body>
    <header>
        <h1 style="margin: 0;">I4</h1>
    </header>

    <section id="content">
        <?php
        // 초기에는 양식 페이지를 로드
        include 'Ytest1_load1.php?category=양식';
        ?>
    </section>

    <script>
        // 초기에는 이전 버튼을 비활성화
        document.getElementById("prevButton").disabled = true;

        // 다음 버튼 클릭 시 다음 카테고리 로드
        document.getElementById("nextButton").addEventListener("click", function () {
            loadCategory("다음 카테고리");  // TODO: 다음 카테고리를 서버에서 결정하도록 수정
        });

        // 이전 버튼 클릭 시 이전 카테고리 로드
        document.getElementById("prevButton").addEventListener("click", function () {
            loadCategory("이전 카테고리");  // TODO: 이전 카테고리를 서버에서 결정하도록 수정
        });
    </script>
</body>

</html>
