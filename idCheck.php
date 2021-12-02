<?
if (isset($_POST['newid'])) $newid = $_POST['newid'];
if (isset($_POST['id'])) $id = $_POST['id'];
else $id = $_GET['id'];

echo("
<script language='Javascript'>
    function a() {
      var id = document.idcheck.newid.value;
      if (id == '') {
        window.alert('아이디를 입력해 주세요!')
      }
      else {
      if (id.length < 5)
        window.alert('아이디를 5글자 이상 입력해 주세요!')
      else
        document.idcheck.submit();
      }
    }

    function b() {
      opener.signup.id.value = document.idcheck.id.value;
      this.close();
    }
</script>
<link rel='stylesheet' href='main.css' type='text/css'>
<form method=post action=idCheck.php name=idcheck>
<div style='width:100%; padding:20px; background-color:black; color:white;font-size:20px;'>ID 중복확인</div>
<div style='text-align:center;'>
");

if (isset($newid)) $id = $newid;

$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

$result = mysqli_query($con, "select * from member where uid='$id'");
$total = mysqli_num_rows($result);

if ($total == 0) {
  echo ("
  <div style='padding:30px;'>
  <b>$id</b> 은(는) 사용 가능한 아이디입니다.<br>
  사용하시겠습니까?
  </div>
  <div>
    <a href='javascript:b()'><input type=hidden name='id' value='$id'>[예]</a>
  </div>
  <div style='padding:20px;'>
  * <b>아이디</b>
  <input type=text name=newid   size=20>
  &nbsp;&nbsp;
  <a href='javascript:a()'>ID중복검사</a></div>");
} else {
  echo ("
  <div style='padding:30px;'>
  <b>$id</b> 은(는) 이미 사용중인 아이디입니다.<br>
  다른 아이디를 입력해 주세요.
  <div style='padding:20px;'>
  * <b>아이디 </b> <input type=text id=newid size=20>&nbsp;&nbsp;
  <a href='javascript:a()'>ID중복검사</a></div>");
}

mysqli_close($con);

echo("
</div>
</form>
");

?>
