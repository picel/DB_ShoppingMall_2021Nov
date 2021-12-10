<?
$id = $_POST['id'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$zip = $_POST['zip'];
$addr1 = $_POST['addr1'];
$addr2 = $_POST['addr2'];


$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

mysqli_query($con, "insert into member (uid, upass, uname, uphone, umail, zipcode, addr1, addr2, isadmin) values('$id', '$password', '$name', '$phone', '$email', '$zip', '$addr1', '$addr2', 0)");

mysqli_close($con);

echo("
  <script>
  window.alert('회원 등록이 정상적으로 처리되었습니다. 로그인 해 주세요.')
  </script>
");

echo("<meta http-equiv='Refresh' content='0; url=signIn.html'>");
?>
