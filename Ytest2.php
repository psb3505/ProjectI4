<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>선호도 조사</title>
    <link rel="stylesheet" type="text/css" href="Ytest2.css">
</head>
<body>
    <header>
        <div>
            <h1>I4</h1>
        </div>
    </header>

    <section>
        <h2>선호도 조사</h2>

        <form action="process_Ytest2.php" method="post">
           <h3>한식</h3>
<?php generateFoodOptions("korean"); ?>


            <h3>양식</h3>
            <?php generateFoodOptions("western"); ?>

            <h3>중식</h3>
            <?php generateFoodOptions("chinese"); ?>

            <h3>일식</h3>
            <?php generateFoodOptions("japanese"); ?>

            <input type="submit" value="선호도 제출">
        </form>
    </section>
</body>
</html>
