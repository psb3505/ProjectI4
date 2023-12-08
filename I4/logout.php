<?php
 
        @session_start();
        $result = session_destroy();
 
        if($result) { 
?>
        <script>
                alert("로그아웃 되었습니다.");
                location.replace("./LOGIN.php"); //다시 처음 페이지로 돌아간다
        </script>
<?php   }
?>