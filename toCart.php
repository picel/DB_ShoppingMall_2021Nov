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

$UserID = $_COOKIE['UserID'];
$UserName = $_COOKIE['UserName'];
$Session = $_COOKIE['Session'];
if (!$UserID) {
	echo ("<script>
		window.alert('로그인 사용자만 구매 가능합니다')
		history.go(-1)
		</script>");
      exit;
}

$code = $_GET['code'];
$quantity = $_POST['quantity'];

if (!isset($quantity)) $quantity = 1;

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");
$result = mysqli_query($con, "select * from cart where session='$Session' and pcode='$code'");
$total = mysqli_num_rows($result);

$result2 = mysqli_query($con, "select * from product where code='$code'");
$oldquant = mysqli_result($result2, 0, "quantity");

if ($oldquant - $quantity < 0) {
	echo ("<script>
		window.alert('재고보다 많은 수량을 구매 하실 수 없습니다.')
		history.go(-1)
		</script>");
      exit;
}

if (isset($total)) $oldnum = mysqli_result($result, 0, "quantity");

if ($oldnum != 0) {
     $quantity = $oldnum + $quantity;
     mysqli_query($con, "update cart set quantity=$quantity where   session='$Session' and pcode='$code'");
} else {
     mysqli_query($con, "insert into cart(id, session, pcode, quantity) values ('$UserID','$Session', '$code', $quantity)");
}

mysqli_close($con);

echo ("<meta http-equiv='Refresh' content='0; url=cart.html'>");

?>
