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
$num = $_GET['num'];
$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

mysqli_query($con, "delete from reply where num=$num");
echo("
  <script>
  window.alert('댓글이 삭제 되었습니다.');
  </script>
");
echo("<meta http-equiv='Refresh' content='0; url=qnaCon.html?id=$id'>");

mysqli_close($con);

?>
