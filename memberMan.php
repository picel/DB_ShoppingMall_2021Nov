<?
$mode = $_GET['mode'];
$uid = $_GET['uid'];

$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

if ($mode == 1){
  mysqli_query($con, "update member set isadmin=1 where uid='$uid'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('관리자 권한 부여가 완료되었습니다')
    </script>
  ");
}
elseif ($mode == 2){
  mysqli_query($con, "update member set isadmin=0 where uid='$uid'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('관리자 권한 박탈이 완료되었습니다')
    </script>
  ");
}
else {
  mysqli_query($con, "delete from member where uid='$uid'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('회원 삭제가 완료되었습니다')
    </script>
  ");
}

if ($mode == 4) {
  SetCookie("UserID", "", time());
  SetCookie("UserName", "", time());
  SetCookie("Session", "", time());
  echo ("<meta http-equiv='Refresh' content='0; url=index.html'>");
}
else {
  echo ("<meta http-equiv='Refresh' content='0; url=memberShow.html'>");
}
?>
