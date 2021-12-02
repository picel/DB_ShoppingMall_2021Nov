<script>
	function   okzip(zip, address) {
		opener.document.signup.zip.value = zip;
		opener.document.signup.addr1.value =   address;
		opener.signup.addr2.value='';
		opener.signup.addr2.focus();
		self.close();
	}
</script>

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
$key = $_POST['key'];
$con = mysqli_connect("localhost","root","kyle0908", "shopmall");
$result = mysqli_query($con, "select * from zipcode where dong like '%$key%'");
$total = mysqli_num_rows($result);

$i = 0;

echo ("
  <link rel='stylesheet' href='main.css' type='text/css'>
  <div class='popUpBanner'>
    검색 결과
  </div>
	<div>
");

while($i <   $total):
	$zip = mysqli_result($result, $i, "zipcode");
	$sido = mysqli_result($result, $i, "sido");
	$gugun = mysqli_result($result, $i, "gugun");
	$dong = mysqli_result($result, $i, "dong");
	$bunji = mysqli_result($result, $i, "bunji");

	$address = $sido . " " . $gugun   . " " .  $dong;

	echo ("<div style='border-bottom: 2px solid black; margin:10px;'><a href=\"javascript: okzip('$zip',   '$address')\">$zip</a>&nbsp;&nbsp;&nbsp;&nbsp;$sido   $gugun $dong $bunji </div>");
	$i++;
endwhile;

echo ("
</div>
<div style='padding-left:20px;'><font style='font-size:15px;'>우편번호를 클릭 해 주세요</div>");
mysqli_close($con);

?>
