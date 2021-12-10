<?
$id = $_COOKIE['UserID'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$zip = $_POST['zip'];
$addr1 = $_POST['addr1'];
$addr2 = $_POST['addr2'];


$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

mysqli_query($con, "update member set upass='$password', uphone='$phone', umail='$email', zipcode='$zip', addr1='$addr1', addr2='$addr2' where uid='$id'");

mysqli_close($con);

echo("
  <script>
  window.alert('회원 수정이 정상적으로 처리되었습니다.')
  </script>
");

echo("<meta http-equiv='Refresh' content='0; url=myPage.html'>");
?>
