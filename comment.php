<?
$content = $_POST['content'];
$id = $_GET['id'];
$admin = $_COOKIE['isadmin'];
$writer = $_COOKIE['UserID'];

if(!$content){
	echo("
		<script>
			window.alert('내용을 입력 해주세요.')
			history.go(-1)
		</script>
	");
	exit;
}

$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

$wdate = date("Y-m-d");

mysqli_query($con, "insert into reply (id, writer, content, wdate, edited, admin) values($id, '$writer', '$content', '$wdate', 0, '$admin')");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=qnaCon.html?id=$id'>");
?>
