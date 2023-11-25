// 2. 이 코드는 Iframe Player API를 비동기적으로 로드한다. !!필수!!
var tag;
var firstScriptTag;
var videoIdLink;

// 3. API 코드를 다운로드 받은 다음에 <iframe>을 생성하는 기능 (youtube player도 더불어)
var player;
function onYouTubeIframeAPIReady() {
    console.log('onYouTubeIframeAPIReady():', videoIdLink);
    player = new YT.Player('player', {
        height: '250',  //변경가능-영상 높이
        width: '360',  //변경가능-영상 너비
        videoId: `${videoIdLink}`,  //변경-영상ID
        playerVars: {
            'rel': 0,    //연관동영상 표시여부(0:표시안함)
            'controls': 1,    //플레이어 컨트롤러 표시여부(0:표시안함)
            'autoplay' : 0,   //자동재생 여부(1:자동재생 함, mute와 함께 설정)
            'mute' : 1,   //음소거여부(1:음소거 함)
            'loop' : 0,    //반복재생여부(1:반복재생 함)
            'playsinline' : 1,    //iOS환경에서 전체화면으로 재생하지 않게
            'playlist' : `${videoIdLink}`   //재생할 영상 리스트
            },
            events: {
            'onReady': onPlayerReady, //onReady 상태일 때 작동하는 function이름
            'onStateChange': onPlayerStateChange //onStateChange 상태일 때 작동하는 function이름
        }
    });
}

// 4. API는 비디오 플레이어가 준비되면 아래의 function을 불러올 것이다.
function onPlayerReady(event) {
    // console.log('Player is ready!');
    event.target.playVideo();
}

// 5. API는 플레이어의 상태가 변화될 때 아래의 function을 불러올 것이다.
//    이 function은 비디오가 재생되고 있을 때를 가르킨다.(state=1),
//    플레이어는 6초 이상 재생되고 정지되어야 한다.
var done = false;
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
        // console.log('Player state changed:', event.data);
        var duration = player.getDuration();
        
        // 전체 영상 시간만큼 재생 후 정지
        setTimeout(function () {
            done = true;
            stopVideo();
        }, duration * 1000); // setTimeout은 밀리초 단위이므로 초로 변환
    }
}
function stopVideo() {
    player.stopVideo();
}

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
                videoIdLink = data[0].url;
                console.log('videoIdLink:', videoIdLink);

                createIngredientAndRacipeContent(data);

                if(videoIdLink != 'X') {
                    tag = document.createElement('script');
                    tag.src = "https://www.youtube.com/iframe_api";
                    firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                    onYouTubeIframeAPIReady(); // 여기서 YouTube API 함수 호출
                }
                resolve(data);
                
            })
            .catch(error => {
                reject(error);
            });
    });
}

function createIngredientAndRacipeContent(data) {
    var racipeTitle = document.getElementById('racipeTitle');
    var inbun = document.getElementById('inbun');
    var cookTime = document.getElementById('cookTime');
    var difficulty = document.getElementById('difficulty');
    var ingredientArea = document.getElementById('ingredientArea');
    var racipeContentArea = document.getElementById('racipeContentArea');

    // 레시피 타이틀 및 레시피 세부 정보 출력
    racipeTitle.textContent = data[0].title;

    inbun.textContent = data[0].ckg_inbun_nm;
    cookTime.textContent = data[0].ckg_timg_nm;
    difficulty.textContent = data[0].ckg_dodf_nm;

    // 레시피 재료 정보들 출력
    // 정규식을 사용하여 '[ ]'로 묶인 그룹과 그 외의 내용을 추출
    var matches = data[0].ckg_mtrl_cn.match(/\[([^\]]+)\]\s*([^[]+)/g);

    matches.forEach(match => {
        // '['와 ']' 사이의 내용을 추출하여 그룹으로 사용
        var groupMatches = match.match(/\[([^\]]+)\]/g);

        if (groupMatches) {
            // 중복된 그룹명 제거
            var uniqueGroups = Array.from(new Set(groupMatches));

            uniqueGroups.forEach(group => {
                var groupName = group.trim();

                // div 태그 생성
                var ingredientPart = document.createElement('div');
                ingredientPart.className = 'ingredientPart';

                // p 태그 생성
                var paragraph = document.createElement('p');
                paragraph.textContent = groupName;

                // div에 p 태그 추가
                ingredientPart.appendChild(paragraph);

                // '|'로 이어진 문자열을 각각의 행으로 구분하여 table 생성
                var ingredients = match.split(group)[1].trim().split('|');

                // table 생성
                var table = document.createElement('table');

                ingredients.forEach(ingredient => {
                    // 각 값의 앞뒤 공백 제거
                    var trimmedIngredient = ingredient.trim();

                    // 공백으로 분리
                    var subIngredients = trimmedIngredient.split(' ');

                    // tr 생성
                    var tr = table.insertRow();

                    subIngredients.forEach(subIngredient => {
                        // 각 값의 앞뒤 공백 제거
                        var trimmedSubIngredient = subIngredient.trim();

                        // td 생성
                        var td = tr.insertCell();
                        td.textContent = trimmedSubIngredient;
                    });
                });

                // table을 ingredientPart에 추가
                ingredientPart.appendChild(table);

                // ingredientPart을 ingredientArea에 추가
                ingredientArea.appendChild(ingredientPart);
            });
        }
    });

    // 레시피 보여주기
    // 각 값의 앞뒤 공백 제거
    var trimmedRacipeContent = data[0].recipe_description.trim();
    // 마지막 '/' 제거
    if (trimmedRacipeContent.endsWith('/')) {
        trimmedRacipeContent = trimmedRacipeContent.slice(0, -1);
    }

    // 공백으로 분리
    var subRacipeContent = trimmedRacipeContent.split('/');

    // ul 생성
    var ul = document.createElement('ul');

    subRacipeContent.forEach((content, index) => {
        var li = document.createElement('li');
        var span = document.createElement('span');
        span.textContent = (index + 1).toString() + '. '; // 1.부터 시작하는 숫자 값을 span에 넣음
        li.appendChild(span);
        
        var trimmedContent = content.trim();
        li.textContent += trimmedContent; // 기존 li의 textContent에 새로운 내용 추가
        ul.appendChild(li);
    });

    racipeContentArea.appendChild(ul);
}