<?php
include("./01데이터베이스.php");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>로그인</title>
    <link rel="stylesheet" href="./style2.css">
</head>
<body>
    <div id= wrap>
    <?php 
    if(!isset( $_SESSION['ss_mb_id'])) 
    { ?>
    <div id = header role=header>
                <h1>
                    <a href = ./03로그인.php></a><span id="blind"></span></a>
                </h1>
            </div>
    <h5><br></h5>
    <form action="./04로그인검사.php" method="post">
        <input type="text" name="mb_id" placeholder="     아이디" style="width:100%;height:55px;font-size:15px; margin:0px 0px 30px; border: 1px solid #d5d5d5;">
        <input type="password" name="mb_password" placeholder="     비밀번호" style="width:100%;height:55px;font-size:15px;  border: 1px solid #d5d5d5;">
        <input type="submit" value="로그인" id = sub>
        <a href="./06등록.php">회원가입</a>
    </form>
    </div>
    <?php 
    }  
    else { ?>

    

    <?php
    $mb_id = $_SESSION['ss_mb_id'];

    // TRIM() mysql에서 양 끝쪽의 공백 제거
    $sql = "SELECT * FROM member2 where mb_id = TRIM('$mb_id');";

    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);

    mysqli_close($conn);
    ?>
    <center><p style = "font-size: 25px;"><b>로그인을 환영합니다</b></p>
    <table style ='border-collapse: separate;border-spacing: 1px;text-align: left;line-height: 1.5;border-top: 1px solid #ccc;margin: 20px 10px'>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">아이디</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_id'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">이름</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_name'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">이메일</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_email'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">전화번호</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_phone'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">성별</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_gender'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">직업</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_job'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">취미</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_hobby'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">회원가입일</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_datetime'] ?></td>
        </tr>
        <tr>
            <th style = "width: 150px;padding: 10px;font-weight: bold;vertical-align: top;border-bottom: 1px solid #ccc;background: #efefef;">회원정보 수정일</th>
            <td style = "width: 350px;padding: 10px;vertical-align: top;border-bottom: 1px solid #ccc;"><?php echo $mb['mb_modify_datetime'] ?></td>
        </tr>
        <tr>
            <td colspan="2" class="td_center">
                <a href="./06등록.php?mode=modify">회원정보수정</a>
                <a href="./05로그아웃.php">로그아웃</a>
            </td>   
        </tr>
    </table></center>
<?php } ?>
</body>
</html>