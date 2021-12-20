<?
$result = mysqli_query($con, "select * from receivers where id='$UserID'");
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
    elseif ($status == 100) echo("리뷰 작성 대기중");
    elseif ($status == 200) echo("리뷰 작성 완료");
    echo("
        </div>
      </div>
      <div style='display:inline-block;'>
      ");
      $newcounter = 0;
      $result2 = mysqli_query($con, "select * from orderlist where buydate='$buydate' and id='$rid'");
      $total2 = mysqli_num_rows($result2);
      while ($newcounter < $total2):
        $pcode = mysqli_result($result2, $newcounter, "pcode");
        $quantity = mysqli_result($result2, $newcounter, "quantity");
        $review = mysqli_result($result2, $newcounter, "review");
        $result3 = mysqli_query($con, "select * from product where code='$pcode'");
        $price = mysqli_result($result3, 0, "price");
        $name = mysqli_result($result3, 0, "name");
        $subSum = $price * $quantity;
        echo("
          <div style='font-size: 20px; display:block;'>
            <a href=product.html?code=$pcode><div style='padding:20px; width: 370px; display:inline-block;'>$name</div></a>
            <div style='padding:20px; width: 150px; display:inline-block;'>$price 원</div>
            <div style='padding:20px; width: 100px; display:inline-block;'>$quantity 개</div>
            <div style='padding:20px; width: 160px; display:inline-block;'>소계 : $subSum 원</div>
          </div>
        ");
        if ($status == 100 && $review == 0) {
          echo ("<div style='padding:10px; background-color:black; color:white; width:85px; margin-left:820px; margin-bottom:20px;'>
            <a href=review.html?id=$rid&code=$pcode&name=". htmlentities(urlencode($name)). "&buydate=". htmlentities(urlencode($buydate)).">리뷰 작성하기</a>
          </div>");
        }
        elseif ($status == 100 && $review == 1){
          echo ("<div style='padding:10px; background-color:gray; color:white; width:90px; margin-left:815px; margin-bottom:20px;'>
            리뷰 작성 완료
          </div>");
        }
        $newcounter++;
        $totalSum += $subSum;
      endwhile;
      echo("
        </div>
        <div style='padding: 20px; text-align:center;'>총 결제 금액 : $totalSum 원</div>
        <div style='height:80px; border-top: 2px solid black;'>
          <div style='display:inline-block; float:left; padding:21px; border-right:2px solid black;'>
            $receiver<br>$rphone
          </div>
          <div style='display:inline-block; float:left; padding:21px;'>
            $raddr<br>$memo
          </div>
        ");
        if ($status == 0) {
          echo ("
            <div style='display:inline-block; float:right; padding:31px; border-left:2px solid black;'>
              <div>취소 접수 완료</div>
            </div>
          ");
        }
        elseif ($status == 1 || $status == 2) {
          echo ("
            <div style='display:inline-block; float:right; padding:31px; border-left:2px solid black;'>
              <a href=orderMan.php?id=$rid&buydate=". htmlentities(urlencode($buydate)). "&code=3><div>주문 취소</div></a>
            </div>");
        }
        elseif ($status == 3) {
          echo ("
            <div style='display:inline-block; float:right; padding:31px; border-left:2px solid black;'>
              <a href=orderMan.php?id=$rid&buydate=". htmlentities(urlencode($buydate)). "&code=4><div>수령 확인</div></a>
            </div>");
        }
        elseif ($status == 10) {
          echo ("
            <div style='display:inline-block; float:right; padding:31px; border-left:2px solid black;'>
              <div>취소 완료</div>
            </div>");
        }
      echo("
          </div>
        </div>
      </div>
        ");
    $counter++;
  endwhile;
}
?>
