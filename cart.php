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
if (!isset($UserID)) {
	echo ("<script>
		window.alert('로그인 사용자만 이용하실 수 있어요')
		history.go(-1)
		</script>");
	exit;
}

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");

$result = mysqli_query($con, "select * from cart where session='$Session'");
$total = mysqli_num_rows($result);

if (!$total) {
     echo("<div class='Div60C'>아직 아무도 없나봐요</div>");
} else {

    $counter=0;
    $totalprice=0;

    while ($counter < $total) :
       $pcode = mysqli_result($result, $counter, "pcode");
       $quantity = mysqli_result($result, $counter, "quantity");

       $subresult = mysqli_query($con, "select * from product where code='$pcode'");
       $image = mysqli_result($subresult, 0, "image");
       $pname = mysqli_result($subresult, 0, "name");
       $price = mysqli_result($subresult, 0, "price");

       $subtotalprice = $quantity * $price;
       $totalprice = $totalprice + $subtotalprice;

  		echo ("
        <div class='Div200W' style='margin-top:10px;'>
          <div class='menuNav20-20'>$pname</div>
          <div class='cartImageContainer'><img src='$image' id='cart'></div>
          <div class='menuNav15-20'>$price 원</div>
          <form id='post' method=post action=qmodify.php?code=$pcode>
            <div class='menuNav15-20'>
              <input type=button value='▲' onClick='javascript:this.form.quantity.value++;'>
              <input type=text class='text2' name='quantity' value=$quantity maxlength=2 size=1 style='width:23px;'>
              <input type=button value='▼' onClick='javascript:this.form.quantity.value--;'>
              <div style='margin-top:20px;'><button type=submit>변경</button></div>
            </div>
          </form>
          <div class='menuNav15-20'>$subtotalprice 원</div>
          <a href=cartdel.php?code=$pcode><div class='menuNav11-20'>삭제</div></a>
        </div>
      ");

  		$counter++;
    endwhile;

    echo("
      <div style='padding:20px; text-align:center; font-size:25px; font-weight:bold; border-top:4px solid black;'>
        총 구매 금액 : $totalprice 원
      </div>
      <a href=order.html><div class=submit style='margin: 0 auto; margin-top:20px;'>
        <button id=form type=submit>주문 하기</button>
      </div></a>
    ");

}

mysqli_close($con);


?>
