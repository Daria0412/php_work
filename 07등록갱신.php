<?php
include("./01데이터베이스.php");  // DB연결을 위한 같은 경로의 dbconn.php를 인클루드합니다.

$mode = $_POST['mode'];

if($mode != 'insert' && $mode != 'modify') { // 아무런 모드가 없다면 중단
	echo "<script>alert('mode 값이 제대로 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./06등록.php');</script>";
	exit;
}

switch ($mode) {
    case 'insert' :
        $mb_id = trim($_POST['mb_id']);
		$title = "회원가입";
        break;
    case 'modify' :
        $mb_id = trim($_SESSION['ss_mb_id']);
		$title = "회원수정";
        break;
}

$mb_password			= trim($_POST['mb_password']); // 첫번째 입력 패스워드
$mb_password_re		= trim($_POST['mb_password_re']); // 두번째 입력 패스워드
$mb_name				= trim($_POST['mb_name']); // 이름
$mb_email				= trim($_POST['mb_email']); // 이메일
$mb_phone				= trim($_POST['mb_phone']); // 이메일
$mb_gender				= $_POST['mb_gender']; // 성별
$mb_job					= $_POST['mb_job']; // 직업
$mb_hobby			= trim($_POST['mb_hobby']); // 관심언어
$mb_datetime			= date('Y-m-d H:i:s', time()); // 가입일
$mb_modify_datetime	= date('Y-m-d H:i:s', time()); // 수정일


if (!$mb_id) {
	echo "<script>alert('아이디가 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./06등록.php');</script>";
	exit;
}

if (!$mb_password) {
	echo "<script>alert('비밀번호가 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./06등록.php');</script>";
	exit;
}

if ($mb_password != $mb_password_re) {
	echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
	echo "<script>location.replace('./06등록.php');</script>";
	exit;
}

if (!$mb_name) {
	echo "<script>alert('이름이 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./06등록.php');</script>";
	exit;
}

if (!$mb_email) {
	echo "<script>alert('이메일이 넘어오지 않았습니다.');</script>";
	echo "<script>location.replace('./06등록.php');</script>";
	exit;
}



$sql = " SELECT MD5('$mb_password') AS pass; "; // 입력한 비밀번호를 MySQL password() 함수를 이용해 암호화해서 가져옴
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$mb_password = $row['pass'];



if($mode == "insert") { // 신규 등록 상태

	$sql = " SELECT * FROM member WHERE mb_id = '$mb_id'; "; // 회원가입을 시도하는 아이디가 사용중인 아이디인지 체크
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) { // 만약 사용중인 아이디라면 알림창을 띄우고 회원가입 페이지로 이동
		echo "<script>alert('이미 사용중인 회원아이디 입니다.');</script>";
		echo "<script>location.replace('./06등록.php');</script>";
		exit;
	}

	$sql = " INSERT INTO member2
				SET mb_id = '$mb_id',
					 mb_password = '$mb_password',
					 mb_name = '$mb_name',
					 mb_email = '$mb_email',
					 mb_phone = '$mb_phone',
					 mb_gender = '$mb_gender',
					 mb_job = '$mb_job',
					 mb_hobby = '$mb_hobby',
					 mb_datetime = '$mb_datetime',
					 mb_modify_datetime = '$mb_datetime'; ";
	$result = mysqli_query($conn, $sql);
	echo "<script>alert('".$title."이 완료 되었습니다.;</script>";
	echo "<script>location.replace('./03로그인.php');</script>";

} else if ($mode == "modify") { // 회원 수정 상태

	$sql = " UPDATE member2
				SET mb_password = '$mb_password',
					 mb_email = '$mb_email',
					 mb_phone = '$mb_phone',
					 mb_gender = '$mb_gender',
					 mb_job = '$mb_job',
					 mb_hobby = '$mb_hobby',
					 mb_modify_datetime = '$mb_modify_datetime'
			 WHERE mb_id = '$mb_id'; ";
	$result = mysqli_query($conn, $sql);
	echo "<script>alert('".$title."이 완료 되었습니다.;</script>";
	echo "<script>location.replace('./03로그인.php');</script>";
}

exit;
?>