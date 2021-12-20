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


echo("
  <script>
    window.alert('리뷰 등록이 완료되었습니다')
  </script>
");

$result = mysqli_query($con, "select * from orderlist where id='$writer' and buydate='$buydate'");
$total = mysqli_num_rows($result);
$counter = 0;
$counter2 = 0;
while($counter < $total){
	$review = mysqli_result($result, $counter, "review");
	if ($review == 0) break;
	if ($review == 1) $counter2++;
	$counter++;
}
if($counter2 == $total) mysqli_query($con, "update receivers set status=200 where id='$writer' and buydate='$buydate'");

mysqli_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=myPage.html'>");
?>
