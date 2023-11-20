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
                resolve(data);
                
            })
            .catch(error => {
                reject(error);
            });
    });
}

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