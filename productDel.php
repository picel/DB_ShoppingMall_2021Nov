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

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");
$result = mysqli_query($con, "delete from product where code='$_GET[code]'");

echo("
	<script>
	window.alert('상품이 삭제 되었습니다.');
	</script>
");

echo("<meta http-equiv='Refresh' content='0; url=productMan.html'>");

mysqli_close($con);

?>
