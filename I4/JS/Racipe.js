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
    console.log('Player is ready!');
    event.target.playVideo();
}

// 5. API는 플레이어의 상태가 변화될 때 아래의 function을 불러올 것이다.
//    이 function은 비디오가 재생되고 있을 때를 가르킨다.(state=1),
//    플레이어는 6초 이상 재생되고 정지되어야 한다.
var done = false;
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
        console.log('Player state changed:', event.data);
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

                tag = document.createElement('script');

                tag.src = "https://www.youtube.com/iframe_api";
                firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                onYouTubeIframeAPIReady(); // 여기서 YouTube API 함수 호출
                resolve(data);
                
            })
            .catch(error => {
                reject(error);
            });
    });
}

// function createIngredientAndRacipeContent() {

// }