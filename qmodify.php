<?
$Session = $_COOKIE['Session'];
$newnum = $_POST['quantity'];
$pcode = $_GET['code'];

if ($newnum < 1 || $newnum > 100) {
	echo ("<script>
		window.alert('변경하고자 하는 수량이 범위를 초과합니다')
		history.go(-1)
		</script>");
    exit;
}

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$result = mysqli_query($con, "update cart set quantity=$newnum where session='$Session' and pcode='$pcode'");

mysqli_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=cart.html'>");

?>
