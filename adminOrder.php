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
$result = mysqli_query($con, "select * from receivers");
$total = mysqli_num_rows($result);


if ($total == 0) echo ("<div style='padding: 20px; text-align:center;'>주문 내역이 존재하지 않습니다.</div>");
else{
  $counter = 0;
  while ($counter < $total) :
    $buydate = mysqli_result($result, $counter, "buydate");
    $rname = mysqli_result($result, $counter, "sender");
    $rid = mysqli_result($result, $counter, "id");
    $receiver = mysqli_result($result, $counter, "receiver");
    $rphone = mysqli_result($result, $counter, "phone");
    $raddr = mysqli_result($result, $counter, "address");
    $status = mysqli_result($result, $counter, "status");
    $memo = mysqli_result($result, $counter, "message");
    $totalSum = 0;
    echo("
    <div style='height: auto; width:960px; margin: 0 auto; margin-top:30px; border: 2px solid black;'>
      <div class='Div60W'>
        <div class='menuNav30-6'>주문 일시 : $buydate</div>
        <div class='menuNav30-6' style='float:right; color:red;'>
    ");
    if ($status == 0) echo("취소 요청됨");
    elseif ($status == 1) echo("주문 접수");
    elseif ($status == 2) echo("발송 준비중");
    elseif ($status == 3) echo("발송 완료");
    elseif ($status == 10) echo("취소 완료");
    elseif ($status == 100) echo("수령 확인");
    elseif ($status == 200) echo("수령 확인");
    echo("
        </div>
      </div>
      <div style='display:inline-block;'>
      ");
      $newcounter = 0;
      $result2 = mysqli_query($con, "select * from orderlist where buydate='$buydate' and id='$rid' order by '$buydate' desc");
      $total2 = mysqli_num_rows($result2);
      while ($newcounter < $total2):
        $pcode = mysqli_result($result2, $newcounter, "pcode");
        $quantity = mysqli_result($result2, $newcounter, "quantity");
        $result3 = mysqli_query($con, "select * from product where code='$pcode'");
        $price = mysqli_result($result3, 0, "price");
        $name = mysqli_result($result3, 0, "name");
        $subSum = $price * $quantity;
        echo("
          <div style='font-size: 20px;'>
            <a href=product.html?code=$pcode><div style='padding:20px; width: 370px; display:inline-block;'>$name</div></a>
            <div style='padding:20px; width: 150px; display:inline-block;'>$price 원</div>
            <div style='padding:20px; width: 100px; display:inline-block;'>$quantity 개</div>
            <div style='padding:20px; width: 160px; display:inline-block;'>소계 : $subSum 원</div>
          </div>
        ");
        $newcounter++;
        $totalSum += $subSum;
      endwhile;
    echo("
      </div>
      <div style='padding: 20px; text-align:center;'>총 결제 금액 : $totalSum 원</div>
      <div style='height:80px; border-top: 2px solid black;'>
        <div style='display:inline-block; float:left; padding:21px; border-right:2px solid black;'>
          $receiver ($rid)<br>$rphone
        </div>
        <div style='display:inline-block; float:left; padding:21px;'>
          $raddr<br>$memo
        </div>
      ");
      if ($status == 0) {
        echo ("
        <div style='display:inline-block; float:right; padding:20px; height: 40px; border-left:2px solid black;'>
          <a href=orderMan.php?id=$rid&buydate=". htmlentities(urlencode($buydate)). "&code=0><div>반품 처리하기</div></a>
          <a href=orderMan.php?id=$rid&buydate=". htmlentities(urlencode($buydate)). "&code=1><div>발송 준비로 변경</div></a>
        </div>");
      }
      elseif ($status == 1) {
        echo ("
        <div style='display:inline-block; float:right; padding:20px; height: 40px; border-left:2px solid black;'>
          <a href=orderMan.php?id=$rid&buydate=". htmlentities(urlencode($buydate)). "&code=1><div>발송 준비로 변경</div></a>
        </div>");
      }
      elseif ($status == 2) {
        echo ("
        <div style='display:inline-block; float:right; padding:20px; height: 40px; border-left:2px solid black;'>
          <a href=orderMan.php?id=$rid&buydate=". htmlentities(urlencode($buydate)). "&code=2><div>발송 완료로 변경</div></a>
        </div>");
      }
    echo("
      </div>
    </div>
      ");

    $counter++;
  endwhile;
}
?>
