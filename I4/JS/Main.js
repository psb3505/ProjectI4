let foodNameText;

// 음식 추천 select
function foodNameFiltering() {
    return new Promise((resolve, reject) => {
        fetch('CBFiltering.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
			.then(response => response.json())
            .then(data => {
                console.log(data);
                foodNameWriteText(data);
                // 받아온 데이터를 로컬 스토리지에 저장
                localStorage.setItem('foodData', JSON.stringify(data));
                resolve(data);
                
            })
            .catch(error => {
                reject(error);
            });
    });
}

// 음식 추천 이미지 및 이름 화면 반영
function foodNameWriteText(name) {
    const foodName = document.querySelectorAll('.foodName');
    const foodImageElements = document.querySelectorAll('.foodImage');
    let idx = 0;

    name.forEach(element => {
        foodName[idx].textContent = element.food_name;
        foodImageElements[idx].src = element.file_route ? element.file_route : "./Image/none.png";
        idx++;
    });
}

// 모달 팝업 열기
const images = document.querySelectorAll('.foodImage');
images.forEach((image) => {
    image.addEventListener('click', function () {
        // 클릭된 이미지의 부모 요소를 찾습니다.
        const parentDiv = this.closest('.slideitem');

        // 부모 요소에서 h2를 찾습니다.
        const foodNameElement = parentDiv.querySelector('.foodName');

        // h2의 텍스트를 가져와서 출력하거나 다른 작업을 수행합니다.
        foodNameText = foodNameElement.textContent;
        console.log(foodNameText);

        document.querySelector('.modal').style.display = 'block';
    });
});

// 모달 팝업 닫기
document.querySelector('.close-modal-btn').addEventListener('click', function () {
    document.querySelector('.modal').style.display = 'none';
});

// 배경 클릭 시 모달 닫기
window.onclick = function(event) {
    var commentModal = document.getElementById('commentModal');

    if (event.target == commentModal) {
        commentModal.style.display = 'none';
    }
}

var naverMapLink1 = document.getElementById('naverMapLink1');

naverMapLink1.addEventListener('click', function () {
    openNaverMap();
});

function openNaverMap() {
    // 네이버 지도 앱을 열기 위한 URL Scheme
    var naverMapScheme = 'nmap://search?query=';

    // 앱 실행 시도
    window.location.href = naverMapScheme + encodeURIComponent(foodNameText);

    // 일정 시간(예: 3초)이 지난 후에 네이버 지도 앱이 실행되지 않으면 네이버 지도 웹 버전으로 이동
    setTimeout(function () {
        // 웹 버전으로 이동하며 검색 키워드를 추가
        window.location.href = 'https://map.naver.com/v5/search/' + encodeURIComponent(foodNameText);
    }, 3000);
}
