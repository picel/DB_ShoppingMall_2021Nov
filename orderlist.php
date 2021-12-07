<?
$result = mysqli_query($con, "select * from receivers where id='$UserID'");
$total = mysqli_num_rows($result);


if ($total == 0) echo ("<div style='padding: 20px; text-align:center;'>주문 내역이 존재하지 않습니다.</div>");
else{
  $counter = 0;
  while ($counter < $total) :
    $buydate = mysqli_result($result, $counter, "buydate");

    $totalSum = 0;
    echo("
    <div style='height: auto; width:960px; margin: 0 auto; margin-top:30px; border: 2px solid black;'>
      <div class='Div60W'>
        <div class='menuNav30-6'>주문 일시 : $buydate</div>
      </div>
      <div style='display:inline-block;'>
      ");
      $newcounter = 0;
      $result2 = mysqli_query($con, "select * from orderlist where buydate='$buydate'");
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
      <div style='padding: 20px; text-align:center;'>총 결제 금액 : $totalSum</div>
    </div>
      ");

    $counter++;
  endwhile;
}
?>
