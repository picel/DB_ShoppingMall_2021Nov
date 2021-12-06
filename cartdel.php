<?
$Session = $_COOKIE['Session'];
$pcode = $_GET['code'];

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$result = mysqli_query($con, "delete from cart where session='$Session' and pcode='$pcode'");

mysqli_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=cart.html'>");

?>
