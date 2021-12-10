<?
function mysqli_result($res, $row = 0, $col = 0)
{
    $nums = mysqli_num_rows($res);
    if ($nums && $row <= ($nums - 1) && $row >= 0)
    {
        mysqli_data_seek($res, $row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col]))
        {
            return $resrow[$col];
        }
    }
    return false;
}

$upass = $_POST['pass'];
$uid = $_COOKIE['UserID'];
$mode = $_GET['mode'];

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$result = mysqli_query($con, "select * from member where uid='$uid'");
$total = mysqli_num_rows($result);
$pass = mysqli_result($result, 0, "upass");

if ($pass != $upass) {
	echo("<script>
		window.alert('비밀번호가 맞지 않습니다')
		history.go(-1)
		</script> ");
	exit;
} else {
	if ($mode == 0) echo ("<meta http-equiv='Refresh' content='0; url=userMod.html'>");
  else {
    echo ("
      <script>
        var delcon = confirm('정말로 탈퇴 하시겠습니까? 이 작업은 되돌릴 수 없습니다.');
        if (delcon){
          window.location = 'memberMan.php?mode=4&uid=$uid';
        } else {
          window.location = 'myPage.html';
        }
      </script>
    ");
  }
}
mysqli_close($con);

?>
