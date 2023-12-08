<html>
<style>
.textbox {
    width: 300px;
    height: 40px;
    border-left-width: 0;
    border-right-width: 0;
    border-top-width: 0;
    border-bottom-width: 1;
}

/* 추가된 스타일 */
.gender-box {
    width: 140px;
    height: 40px;
    border: 1px solid #333;
    display: inline-block;
    margin-right: 10px;
    cursor: pointer;
    text-align: center;
    font-size: 20px;
    color: black;
	border-radius: 15px;
}

.selected {
    background-color: #A9E2F3 !important;
    color: white;
}

.footerbox {
    width: 230px;
    height: 40px;
	border:none;
	border-radius: 15px;
}

.tdbox {
    width: 110px;
	border:none;
}

.error-message {
    color: red;
    font-size: 14px;
}
</style>

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
                <td><input type="text" placeholder="이메일을 입력해주세요." class="textbox" name="EMAIL" id="EMAIL"></td>
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
            let EMAIL = document.getElementById('EMAIL').value;
            let phone_num = document.getElementById('phone_num').value;
			let BIRTH = document.getElementById('BIRTH').value;
            // 간단한 유효성 검사
            if (!ID || !PASSWORD || !SecondPASSWORD || !NAME || !EMAIL || !phone_num || !selectedGender) {
                document.getElementById('errorMessage').innerText = '모든 필드를 입력하세요.';
                return false;
            }

            if (PASSWORD !== SecondPASSWORD) {
                document.getElementById('errorMessage').innerText = '비밀번호와 확인 비밀번호가 일치하지 않습니다.';
                return false;
            }
			
			if (PASSWORD.length < 8 || PASSWORD.length > 15) {
                document.getElementById('errorMessage').innerText = '비밀번호는 8자에서 15자 이하여야 합니다.';
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
    function checkDuplicateID() {
        let ID = document.getElementById('ID').value;

        if (!ID) {
            alert('아이디를 입력하세요.');
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
            idAvailability.innerHTML = '<span style="color: red;">' + response + '</span>';
            document.getElementById('submitBtn').disabled = true;
        } else {
            idAvailability.innerHTML = '<span style="color: green;">' + response + '</span>';
            document.getElementById('submitBtn').disabled = false;
        }
    }
</script>
</body>
</html>