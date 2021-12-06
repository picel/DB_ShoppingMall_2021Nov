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
$upass = $_POST['pass'];

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$result = mysqli_query($con, "select * from member where uid='$uid'");
$total = mysqli_num_rows($result);

if (!$total){
	echo("<script>
		window.alert('아이디가 존재하지 않습니다')
		history.go(-1)
		</script> ");
	 exit;
}
else {
	$pass = mysqli_result($result, 0, "upass");
	$uname = mysqli_result($result, 0, "uname");
	$isadmin = mysqli_result($result, 0, "isadmin");

	if ($pass != $upass) {
		echo("<script>
			window.alert('비밀번호가 맞지 않습니다')
			history.go(-1)
			</script> ");
		exit;
	} else {
		SetCookie("UserID", "$uid", 0);
		SetCookie("UserName", "$uname", 0);
    SetCookie("isadmin", $isadmin, 0);

		$session = md5(uniqid(rand()));
		SetCookie("Session", $session, 0);

		mysqli_query($con, "delete from cart where id='$uid'");

		echo ("<meta http-equiv='Refresh' content='0; url=index.html'>");
	}
}
mysqli_close($con);

?>
