<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./CSS/Main.css">
        <title>음식추천</title>
    </head>
    <body>

    </body>
</html>


<?php
    ini_set('memory_limit', '256M');
    include './Database.php';
    include './CBFiltering.php';

    // 예시 사용법
    $food_name_from_php = getFoodName();  // Database.php에서 전달 받은 음식 이름

    $food_names = get_recommendations($food_name_from_php, $foods, $cosine_sim);

    foreach ($food_names as $name) {
        echo $name . "<br>";
    }
?>