<?php
include("./01데이터베이스.php");
//trim() : php 문자열에서 양 끝의 공백을 제거
$mb_id = trim($_POST['mb_id']);
$mb_password = trim($_POST['mb_password']);

if(!$mb_id || !$mb_password)
{
   // alert() : JavaScript에서 메세지창을 띄움
   // replace() : JavaScript에서 현재 페이지를 새 페이지로 대체
    echo "<script>alert('회원아이디나 비밀번호가 공백이면 안됩니다.');</script>";
    echo "<script>location.replace('./03로그인.php')</script>";
    exit;
}
// 회원 테이블에서 해당 아이디가 존재하는지 체크
$sql = "SELECT * FROM member2 WHERE mb_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);

// PASSWORD : mysql에서 데이터를 암호화함(SHA-1)   **그런데 뒤에 FROM member는 안들어가나?
$sql = "SELECT MD5('$mb_password') AS pass;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
// pass 속성의 값을 가져옴(별칭으로 pass를 설정)
$password = $row['pass'];


// 존재하는 아이디인지 입력한 비밀번호가 맞는지 확인
if(!$mb['mb_id'] || !($password === $mb['mb_password']))
{
   // alert() : JavaScript에서 메세지창을 띄움
   // replace() : JavaScript에서 현재 페이지를 새 페이지로 대체
    echo "<script>alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.');</script>";
    echo "<script>location.replace('./03로그인.php')</script>";
    exit;
}


if($mb['mb_email_certify'] == '1970-01-01 00:00:00')
{
    include_once('./02라이브러리.php');
    
    // 어떠한 회원정보도 포함되지 않은 일회성 난수를 
    //   생성하여 인증에 사용
    // md5 : PHP에서 md5방식의 해시값을 도출함
    // pack : PHP에서 각각의 arguement들을 이진 String으로 묶음, 첫 번째 aruguement는 format(형식)을 결정
    //        V	unsigned long (always 32 bit, little endian byte order)
    $mb_md5 = md5(pack('V*', rand(), rand(), rand(), rand()));
    
    // 로그인을 시도하는 아이디가 메일 인증을 해야한다면 일회용 난수를 업데이트
    $sql = "UPDATE member2 SET mb_email_certify2 = '$mb_md5'
     WHERE mb_id = '$mb_id' ";
    $result = mysqli_query($conn, $sql);
    // &amp; : &을 표현
    $certify_href = 'http://localhost/새/09메일인증.php?&amp;mb_id='
         . $mb_id . '&amp;mb_md5=' . $mb_md5;
    
    //메일 제목
    $subject = '인증확인 메일입니다.';
    
    //출력 버퍼에 담음
    ob_start();
    include_once('./08회원인증메일.php');
    $content = ob_get_contents();
    ob_end_clean();
    
    $mail_from = "chuclass@naver.com";
    $mail_to = $mb['mb_email'];
    
    // 메일전송
    mailer('관리자', $mail_from, $mail_to
    , $subject, $content);
    
    echo "<script>alert('" . $mb['mb_email'] 
        . " 메일로 인증메일을 전송하였습니다.\\n" 
        . $mb['mb_email'] 
        . " 메일로 메일인증을 받으셔야 로그인 가능합니다.');
        </script>";
echo "<script>location.replace('./03로그인.php');</script>";
    exit;
}
// id, 비번 확인 후 세션생성
$_SESSION['ss_mb_id'] = $mb_id;

mysqli_close($conn);

// 세션에 있다면 로그인 확인 페이지로 이동
if(isset($_SESSION['ss_mb_id']))
{
    echo "<script>alert('로그인 되었습니다.');</script>";
echo "<script>location.replace('./03로그인.php');</script>";    
}

?>