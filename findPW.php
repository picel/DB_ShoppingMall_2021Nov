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

$uid = $_POST['id'];
$uname = $_POST['name'];
$email = $_POST['email'];

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$result = mysqli_query($con, "select * from member where uname='$uname' and uid='$uid' and umail='$email'");
$total = mysqli_num_rows($result);

if (!$total)   {
   echo("
      <script>
      window.alert('입력하신 아이디와 이름과 이메일 주소를 동시에 만족하는 사용자 아이디가 없습니다')
      history.go(-1)
      </script>
   ");
   exit;
} else {
	$upass = mysqli_result($result, 0, "upass");
   echo("
      <script>
      window.alert('귀하의 비밀번호는 $upass 입니다')
      </script>
   ");
}

mysqli_close($con);
echo   ("<meta http-equiv='Refresh' content='0; url=index.html'>");
?>
