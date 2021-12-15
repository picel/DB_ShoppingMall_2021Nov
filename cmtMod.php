<?
$content = $_POST['content'];
$id = $_GET['id'];
$num = $_GET['num'];

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

mysqli_query($con, "update reply set content='$content', edited=1 where num=$num");

mysqli_close($con);

echo("<meta http-equiv='Refresh' content='0; url=qnaCon.html?id=$id'>");
?>
