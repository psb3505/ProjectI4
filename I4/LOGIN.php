<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="./CSS/Login.css">
</head>
<body>
    <div class="mainbody">
        <img src="./Image/logo.png" class="mainlogo">
		<div class="logo">
        <form name="join" method="post" action="idcheck2.php">
            <div class="container">
                <input type="text" class="logpass" placeholder="ID"  name="ID"><br>
                <input type="password" class="logpass" placeholder="PASSWORD" name="PASSWORD"><br><br>
                <input type="submit" class="Loginbutton" value="로그인">
                <input type="button" class="PAbutton" value="회원가입" onclick="openSignUpPopup()">
            </div>
        </form>
		</div>
	</div>

    <script type="text/javascript">
        function openSignUpPopup() {
            window.open("PLUSACCOUNT.php", "a", "width=500, height=700, left=600, top=50");
        }
    </script>
</body>
</html>
