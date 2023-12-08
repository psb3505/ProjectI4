<!-- Main_page.php -->
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
    <title>Main Page</title>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION['NAME']; ?>!</h1>

<!-- 여기에 메인 페이지의 내용을 추가하세요 -->

</body>
</html>
