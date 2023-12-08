<?php
    $host = "192.168.1.3"; // 호스트 주소
    $user = "dbuser191831"; // MySQL 계정
    $pw = "ce1234"; // MySQL 비밀번호
    $dbName = "db191831"; // 사용할 데이터베이스 이름

    $conn = new mysqli($host, $user, $pw, $dbName);
    
    /* DB 연결 확인 */
    if($conn){ echo "Connection established"."<br>"; }
    else{ die( 'Could not connect: ' . mysqli_error($conn) ); }
    
    mysqli_close($conn);
?>