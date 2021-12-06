<?
$UserID = $_COOKIE['UserID'];
$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");
mysqli_query($con, "delete from shoppingbag where id='$UserID'");
mysqli_close($con);

SetCookie("UserID", "", time());
SetCookie("UserName", "", time());
SetCookie("Session", "", time());

echo ("<meta http-equiv='Refresh' content='0; url=index.html'>");
?>
