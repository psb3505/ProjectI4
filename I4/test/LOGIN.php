<html>
<style>
body{
	background-color: #F5DA81;
}
.logo {
    width: 460px;
    height: 270px;
    flex-direction: column;
    border: 1px solid lightgrey;
    border-radius: 5px;
	position:absolute;
	top : 50%;
	left : 50%;
	margin: -50px 0px 0px -200px;
	background-color:white;
}
.mainlogo{
	position:absolute;
	top : 20%;
	left : 52%;
	margin: -50px 0px 0px -200px;
	text-align:center;
	font-size:100px;

}
.container{
	position:absolute;
	top : 50%;
	left : 50%;
	margin: -110px 0px 0px -197px;
}
.Loginbutton{
	width:400px;
	height:45px;
	font-size:25px;
	font-weight:bold;
	color: white;
	background-color:black;
}
</style>
<body>
<h1 class="mainlogo">메인로고<br>I4</h1>
<div class="logo">
<form name="join" method="post">
 <div class="container">
  <input type="text" placeholder="ID"  name="ID" style="width:400px;height:45px;font-size:25px;"><br><br>
  <input type="password" placeholder="PASSWORD" name="PASSWORD" style="width:400px;height:45px;font-size:25px;"><br><br><br>
  <input type="button" class="Loginbutton" value="로그인" onclick="mysubmit(1)">
  <input type="button" value="회원가입" onclick="mysubmit(2)">
</div>
</form>
</div>
  <script = "text/javascript">
        function mysubmit(index){
		if(index == 1){
			document.join.action="idcheck2.php";
		}
		if(index == 2){
			window.open("PLUSACCOUNT.php", "a", "width=500, height=700, left=600, top=50");
		}
		document.join.submit();

	}
  </script>
</body>
</html>