<?php
// 회원가입과 회원수정을 위한 페이지
include("./01데이터베이스.php");


// 세션이 있고, 회원수정 mode이면 회원 정보를 가져옴
if(isset($_SESSION['ss_mb_id']) && $_GET['mode'] == 'modify')
{
    $mb_id = $_SESSION['ss_mb_id'];
    $sql = "SELECT * FROM member2 where mb_id = TRIM('$mb_id');";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    $mode = "modify";
    $title = "회원수정";
    $modify_mb_info = "readonly";
}
else
{
    $mode = "insert";
    $title = "회원가입";
    $modify_mb_info = '';
}
?>

<html>
    <head><link rel="stylesheet" href="./style2.css"><meta charset='utf-8'>
</head>
    <body>
        <div id= wrap>
            <div id = header role=header>
                <h1>
                    <a href = ./03로그인.php></a><span id="blind"></span></a>
                </h1>
            </div>
            <form action="./07등록갱신.php" onsubmit = "return fregisterform_submit(this);" method="post" id = form_st>
            <input type="hidden" name="mode" value="<?php echo $mode ?>" >
                 <h3>아이디</h3> <br>
                <span id = st>
                    <input type="text" name="mb_id" 
                        value="<?php echo $mb_id ?>" 
                        <?php echo $modify_mb_info ?> id = form_sty>
                </span>
                <h3>비밀번호</h3><br>
                <span id = st>
                    <input type="password" name="mb_password" id = form_sty>
                </span>
                <h3>비밀번호 확인</h3><br>
                <span id = st>
                    <input type="password" name="mb_password_re" id = form_sty>
                </span> 
                <h3>이름</h3><br>
                <span id = st>
                    <input type="text" name="mb_name" 
                        value="<?php echo $mb['mb_name'] ?>" 
                        <?php echo $modify_mb_info ?> id = form_sty>
                </span> 
                <h3>이메일</h3><br>
                <span id = st> 
                    <input type="text" name="mb_email" 
                        value="<?php echo $mb['mb_email'] ?>" id = form_sty >
                </span>
                <h3>전화번호</h3><br>
                <span id = st> 
                    <input type="text" name="mb_phone" 
                        value="<?php echo $mb['mb_phone'] ?>" id = form_sty >
                </span>
                <h3>성별</h3><br>
                <span id = st>
                    <br>
                    <label>
                        <input type="radio" name="mb_gender" value="남자" 
                            <?php echo ($mb['mb_gender'] =="남자") ? "checked" : ""; ?> >남자
                    </label>
                    <label>
                        <input type="radio" name="mb_gender" value="여자" 
                            <?php echo ($mb['mb_gender'] =="여자") ? "checked" : ""; ?> >여자
                    </label>        
                </span>
                <h3>직업</h3><br>
                <span id = st>
                    <input type="text" name="mb_job" 
                        value="<?php echo $mb['mb_job'] ?>" id = form_sty >
                </span>
                <h3>취미</h3><br>
                <span id = st>
                    <input type="text" name="mb_hobby" 
                        value="<?php echo $mb['mb_hobby'] ?>" id = form_sty >
                </span>
                <input type="submit" value="<?php echo $title ?>" id = "sub">
        </form>
        </div>
        <script>
        function fregisterform_submit(f)
        {
            // id검사
            if(f.mb_id.value.lengh <1)
            {
                alert("id를 입력하세요");
                f.mb_id.focus();
                return false;
            }
            // 이름검사
            if(f.mb_name.value.lengh <1)
            {
                alert("이름을 입력하세요");
                f.mb_name.focus();
                return false;
            }
            // 비밀번호
            if(f.mb_password.value.lengh <3)
            {
                alert("비밀번호를 3글자 이상 입력하세요");
                f.mb_password.focus();
                return false;
            }
            // 두 번 입력한 내용이 다른 경우
            if(f.mb_password.value != f.mb_password_re.value)
            {
                alert("비밀번호가 같지 않습니다.");
                f.mb_password_re.focus();
                return false;
            }
            // 이메일 검사
            if(f.mb_email.value.length<1)
            {
                alert("이메일을 입력하세요");
                f.mb_email.focus();
                return false;
            }
            return true;
        }
    </script>
    </body>
</html>

