<?
$code = $_GET['code'];
$id = $_GET['id'];
$buydate = $_GET['buydate'];

$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

if ($code == 0){
  mysqli_query($con, "update receivers set status=10 where id='$id' and buydate='$buydate'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('주문 취소 처리가 완료되었습니다.')
    </script>
  ");
}
elseif ($code == 1){
  mysqli_query($con, "update receivers set status=2 where id='$id' and buydate='$buydate'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('발송 준비 단계로 전환이 완료되었습니다.')
    </script>
  ");
}
elseif ($code == 2){
  mysqli_query($con, "update receivers set status=3 where id='$id' and buydate='$buydate'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('발송 완료 단계로 전환이 완료되었습니다.')
    </script>
  ");
}
if ($code == 3){
  mysqli_query($con, "update receivers set status=0 where id='$id' and buydate='$buydate'");

  mysqli_close($con);

  echo("
    <script>
      window.alert('주문 취소 신청이 완료되었습니다.')
    </script>
    <meta http-equiv='Refresh' content='0; url=myPage.html'>
  ");
}
echo ("<meta http-equiv='Refresh' content='0; url=adminOrder.html'>");
?>