<?
function mysqli_result($res,$row=0,$col=0)
{
	$nums=mysqli_num_rows($res);
	if($nums && $row<=($nums-1) && $row>=0)
	{
		mysqli_data_seek($res,$row);
		$resrow=(is_numeric($col))?mysqli_fetch_row($res):mysqli_fetch_assoc($res);
		if(isset($resrow[$col]))
		{
			return $resrow[$col];
		}
	}
	return false;
}

$id = $_GET['id'];

$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

mysqli_query($con, "delete from qna where id=$id");
echo("
  <script>
  window.alert('게시글이 삭제 되었습니다.');
  </script>
");

$tmp = mysqli_query($con, "select id from qna order by id desc");
$last = mysqli_result($tmp, 0, "id");

$i = $id + 1;
while($i <= $last):
	mysqli_query($con, "update qna set id=id-1 where id=$i");
	$i++;
endwhile;

echo("<meta http-equiv='Refresh' content='0; url=qna.html'>");

mysqli_close($con);

?>
