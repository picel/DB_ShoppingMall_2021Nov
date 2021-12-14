<?
$title = $_POST['title'];
$content = $_POST['content'];
$score = $_POST['score'];
$code = $_GET['code'];
$writer = $_GET['writer'];
$buydate = $_GET['buydate'];

if (!$title){
	echo("
		<script>
		window.alert('제목을 입력 해 주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if (!$content){
	echo("
		<script>
		window.alert('내용을 입력 해 주세요.')
		history.go(-1)
		</script>
	");
	exit;
}
$date = date("Y-m-d");

$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

mysqli_query($con, "insert into review(code, writer, title, content, score, date) values ('$code', '$writer', '$title', '$content', $score, '$date')");
mysqli_query($con, "update orderlist set review=1 where id='$writer' and buydate='$buydate' and pcode='$code'");

mysqli_close($con);

echo("
  <script>
    window.alert('리뷰 등록이 완료되었습니다')
  </script>
");

echo ("<meta http-equiv='Refresh' content='0; url=myPage.html'>");
?>
