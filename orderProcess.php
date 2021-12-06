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

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$Session = $_COOKIE['Session'];
$UserID = $_COOKIE['UserID'];
$UserName = $_COOKIE['UserName'];
$mode = $_POST['addressSel'];

if($mode == 'newone') {
  $receiver = $_POST['name'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];
  $zip = $_POST['zip'];
  $addr1 = $_POST['addr1'];
  $addr2 = $_POST['addr2'];
  if(!$addr1){
  	echo("
  		<script>
  		window.alert('배송 주소가 없습니다. 다시 입력하세요.')
  		history.go(-1)
  		</script>
  	");
  	exit;
  }
} else {
  $result = mysqli_query($con, "select * from member where uid='$UserID'");
  $receiver = $_POST['name1'];
  $phone = $_POST['phone1'];
  $message = $_POST['message1'];
  $zip = mysqli_result($result, 0, "zipcode");
  $addr1 = mysqli_result($result, 0, "addr1");
  $addr2 = mysqli_result($result, 0, "addr2");
}

if (!$receiver){
	echo("
		<script>
		window.alert('수신자 이름이 없습니다. 다시 입력하세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if(!$phone){
	echo("
		<script>
		window.alert('수신자의 전화번호가 없습니다. 다시 입력하세요.')
		history.go(-1)
		</script>
	");
	exit;
}


$buydate = date("Y-m-d H:i:s");

$ordernum = strtoupper(substr($UserID, 0, 3)) . "-" . substr($buydate, 0, 10);

$address = "(" . $zip .  ")" . "&nbsp;" . $addr1 . "&nbsp;" . $addr2;

mysqli_query($con, "insert into receivers(id, session, sender, receiver, phone, address, message, buydate,   ordernum, status) values ('$UserID', '$Session', '$UserName',   '$receiver','$phone', '$address', '$message', '$buydate', '$ordernum', 1)");

$result = mysqli_query($con, "select * from cart where session='$Session'");
$total = mysqli_num_rows($result);

$counter=0;

while ($counter < $total) :
	$pcode = mysqli_result($result, $counter, "pcode");
    $quantity = mysqli_result($result, $counter, "quantity");

    mysqli_query($con, "insert into orderlist(id, session, pcode, quantity)   values ('$UserID', '$Session', '$pcode','$quantity')");

    $counter++;
endwhile;

mysqli_query($con, "delete from cart where session='$Session'");

mysqli_close($con);

echo ("<script>
 	window.alert('구매가 정상적으로 처리되었습니다. \\n주문 번호는 $ordernum 이며 My Page에서 주문 조회가 가능합니다')
    history.go(1)
    </script>
    <meta http-equiv='Refresh' content='0; url=index.html'>
");

?>
