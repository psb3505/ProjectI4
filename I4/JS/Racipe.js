function getRacipeVideoAndContent() {
    // 현재 URL에서 쿼리 문자열을 가져오기
    var queryString = window.location.search;

    // URL에서 '?' 이후의 문자열이 쿼리 문자열이므로 이를 제거하고 '&'를 기준으로 파라미터들을 분리
    var params = new URLSearchParams(queryString);

    // foodName 매개변수의 값을 가져오기
    var foodNameValue = params.get('foodName');

    // 가져온 값이 null이 아니라면 사용할 수 있습니다.
    if (foodNameValue !== null) {
        console.log('foodName 매개변수의 값:', foodNameValue);
        // 여기에서 foodNameText를 사용하거나 원하는 작업을 수행하세요.
    } else {
        console.log('foodName 매개변수가 없습니다.');
    }

    return new Promise((resolve, reject) => {
        fetch('RacipeDatabase.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ foodNameValue: foodNameValue })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                resolve(data);
                
            })
            .catch(error => {
                reject(error);
            });
    });
}