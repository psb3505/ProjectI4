<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="./CSS/plusaccount.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<body>
    <form name="join" method="post" onsubmit="return validateForm()" action="loginp.php">
        <h1 style="text-align:center;">회원가입</h1>
        <table>
            <h3>1.로그인 정보</h3>
            <tr>
                <td class="tdbox">아이디</td>
                <td><input type="text" placeholder="아이디 입력(4~10자)" class="textbox" name="ID" id="ID"></td>
                <td><input type="button" value="중복검사" onclick="checkDuplicateID()"></td>
                <span id="idAvailability"></span>
            </tr>
            <tr>
                <td class="tdbox">비밀번호</td>
                <td><input type="password" placeholder="비밀번호 입력(문자,숫자,특수문자 포함8~20자)" class="textbox" name="PASSWORD" id="PASSWORD"></td>
            </tr>
            <tr>
                <td class="tdbox">비밀번호 확인</td>
                <td><input type="password" placeholder="비밀번호 재입력"class="textbox" name="SecondPASSWORD" id="SecondPASSWORD"></td>
            </tr>
        </table>
        <h3>2.회원 정보</h3>
        <table>
            <tr>
                <td class="tdbox">이름</td>
                <td><input type="text" placeholder="이름을 입력해주세요."class="textbox" maxlength="8" name="NAME" id="NAME"></td>
            </tr>
            <tr>
                <td class="tdbox">이메일</td>
				<td>
					<input type="text" name="email_id" class="form_w200" value="" title="이메일 아이디" placeholder="이메일" maxlength="18" /> @ 
					<input type="text" name="email_input" class="form_w200" value="" title="이메일 도메인" placeholder="이메일 도메인" maxlength="18"/>
					<select name="email_input" class="select" title="이메일 도메인 주소 선택" onchange="updateEmailInput()">
						<option value="">-선택-</option>
						<option value="naver.com">naver.com</option>
						<option value="gmail.com">gmail.com</option>
						<option value="hanmail.net">hanmail.net</option>
						<option value="hotmail.com">hotmail.com</option>
						<option value="korea.com">korea.com</option>
						<option value="nate.com">nate.com</option>
						<option value="yahoo.com">yahoo.com</option>
					</select>
				</td>
            </tr>
            <tr>
                <td class="tdbox">성별</td>
                <td>
                    <div class="gender-box" id="male" onclick="selectGender('male')">남성</div>
                    <div class="gender-box" id="female" onclick="selectGender('female')">여성</div>
                    <input type="hidden" name="GENDER" id="genderInput">
                </td>
            </tr>
			<tr>
			<td class="tdbox">생년월일</td>
			<td><input type="date" class="textbox" name="BIRTH" id="BIRTH"></td>
			</tr>
            <tr>
                <td class="tdbox">전화번호</td>
                <td><input type="text" placeholder="휴대폰 번호 입력('-'제외)"class="textbox" name="phone_num" id="phone_num"></td>
            </tr>
        </table><br><br>
        <input type=reset class="footerbox" style="padding: 0px 10px 0px 10px;background-color:#81DAF5;" value="다시쓰기">
        <input type="submit" class="footerbox" value="완료" style="padding: 0px 20px 0px 20px;background-color:#F5DA81;" id="submitBtn" disabled>
        <div class="error-message" id="errorMessage"></div>
    </form>
<script>
	function updateEmailInput() {
    var emailInput = document.getElementById('email_input');
    var emailSelect = document.getElementById('email_select');

    if (emailSelect.value !== '') {
        emailInput.value = emailSelect.value;
    }
}
    let selectedGender = null;

    function selectGender(gender) {
        if (selectedGender) {
            document.getElementById(selectedGender).classList.remove('selected');
        }

        selectedGender = gender;
        document.getElementById(gender).classList.add('selected');
        document.getElementById('genderInput').value = gender;
    }
	 function validateForm() {
            // 각 필드의 값을 가져오기
            let ID = document.getElementById('ID').value;
            let PASSWORD = document.getElementById('PASSWORD').value;
            let SecondPASSWORD = document.getElementById('SecondPASSWORD').value;
            let NAME = document.getElementById('NAME').value;
            let phone_num = document.getElementById('phone_num').value;
			let BIRTH = document.getElementById('BIRTH').value;
            // 간단한 유효성 검사
            if (!ID || !PASSWORD || !SecondPASSWORD || !NAME || !phone_num || !selectedGender) {
                swal("","모든정보를 입력하세요.", "error");
                return false;
            }

            if (PASSWORD !== SecondPASSWORD) {
                swal("","비밀번호가 일치하지 않습니다.", "error");
                return false;
            }
			   if (!isValidPassword(PASSWORD)) {
				swal("", "새로운 비밀번호는 8자 이상이어야 하며, 특수문자, 숫자, 대문자, 소문자 중 최소 하나 이상을 포함해야 합니다.", "error");
				return false;
			}
			if (PASSWORD.length < 8 || PASSWORD.length > 15) {
                swal("","비밀번호는 8~15자리 이여야 합니다.", "error");
                return false;
            }
			if (phone_num.length != 11) {
                swal("","전화번호를 다시 입력해주세요.", "error");
                return false;
            }
            // 추가적인 유효성 검사를 여기에 추가할 수 있습니다.
			document.getElementById('BIRTH').addEventListener('change', function () {
			let selectedDate = new Date(document.getElementById('BIRTH').value);
			let formattedDate = selectedDate.toISOString().split('T')[0];
			document.getElementById('BIRTH').value = formattedDate;
			});
			document.getElementById('errorMessage').innerText = ''; // 에러 메시지 초기화
			return true;
}
			function isValidPassword(password) {
				// 비밀번호는 8자 이상이어야 하며, 특수문자, 숫자, 대문자, 소문자 중 최소 하나 이상을 포함해야 함
				return /^(?=.*[!@#$%^&*(),.?":{}|<>0-9A-Za-z]).{8,}$/.test(password) &&
					   /[0-9]/.test(password) &&
					   /[A-Z]/.test(password) &&
					   /[a-z]/.test(password);
			}
    function checkDuplicateID() {
        let ID = document.getElementById('ID').value;

        if (!ID) {
            swal("","아이디를 입력하세요.", "error");
            return;
        }

        // 아이디 중복 검사를 수행하는 PHP 파일 경로로 변경
        let url = 'idcheck.php';

        // AJAX를 사용하여 서버에 아이디 중복 검사 요청
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    let response = xhr.responseText;
                    handleDuplicateCheck(response);
                } else {
                    alert('서버 오류가 발생했습니다.');
                }
            }
        };
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('ID=' + encodeURIComponent(ID));
    }

    function handleDuplicateCheck(response) {
        let idAvailability = document.getElementById('idAvailability');
        if (response.includes('이미 존재하는 아이디')) {
            swal("",response, "error");
            document.getElementById('submitBtn').disabled = true;
        } else {
            swal("",response, "success");
            document.getElementById('submitBtn').disabled = false;
        }
    }
</script>

</body>
</html>