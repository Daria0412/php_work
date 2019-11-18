<?php
session_start();    // 세션의 시작
session_unset();    // 모든 세션변수를 해제함
session_destroy();  // 세션 해제함

// 세션이 삭제되었으면 로그인 페이지로 이동
if(!isset($_SESSION['ss_mb_id']))
{
    echo "<script>alert('로그아웃 되었습니다.');</script>";
    echo "<script>location.replace('./03로그인.php')</script>";     
}
?>