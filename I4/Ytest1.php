<?php
session_start();  // 세션을 사용하기 위한 시작 선언


/*

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

        document.addEventListener("DOMContentLoaded", function () {
            // 초기에는 이전 버튼을 비활성화
            var prevButton = document.getElementById("prevButton");
            var nextButton = document.getElementById("nextButton");

            if (prevButton && nextButton) {
                prevButton.disabled = true;

                // 다음 버튼 클릭 시 다음 카테고리 로드
                nextButton.addEventListener("click", function () {
                    loadNextCategory();
                });

                // 이전 버튼 클릭 시 이전 카테고리 로드
                prevButton.addEventListener("click", function () {
                    loadPrevCategory();
                });

                // 초기에는 다음 버튼만 활성화
                function loadNextCategory() {
                    loadCategory("양식");
                    prevButton.disabled = false;
                }

                // 한식 페이지에서는 이전 버튼을 비활성화
                function loadPrevCategory() {
                    loadCategory("한식");
                    prevButton.disabled = true;
                }

                // 초기에 한식 페이지 로드
                loadCategory("한식");
            } else {
                console.error("Buttons not found");
            }
        });
    </script>
*/
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

        document.addEventListener("DOMContentLoaded", function () {
            // 초기에는 이전 버튼을 비활성화
            var prevButton = document.getElementById("prevButton");
            var nextButton = document.getElementById("nextButton");

            if (prevButton && nextButton) {
                prevButton.disabled = true;

                // 다음 버튼 클릭 시 다음 카테고리 로드
                nextButton.addEventListener("click", function () {
                    loadNextCategory();
                });

                // 이전 버튼 클릭 시 이전 카테고리 로드
                prevButton.addEventListener("click", function () {
                    loadPrevCategory();
                });

                // 초기에는 다음 버튼만 활성화
                function loadNextCategory() {
                    loadCategory("양식");
                    prevButton.disabled = false;
                }

                // 한식 페이지에서는 이전 버튼을 비활성화
                function loadPrevCategory() {
                    loadCategory("한식");
                    prevButton.disabled = true;
                }

                // 초기에 한식 페이지 로드
                loadCategory("한식");
            }
        });
    </script>
</head>

<body>
    <header>
        <h1 style="margin: 0;">I4</h1>
    </header>

    <section id="content">
        <!-- 초기에는 아무 내용이 없음 -->
    </section>
</body>

</html>


