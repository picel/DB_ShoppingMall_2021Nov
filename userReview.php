<?
$writer = $_COOKIE['UserID'];

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");
$result = mysqli_query($con, "select * from review where writer='$writer'");
$total = mysqli_num_rows($result);

if (!$total)
{
  echo ("<div class='Div60C'>아직 아무도 없나봐요.</div>");
}
else
{
  if (empty($_GET['cpage'])) $cpage = 1;
  else $cpage = $_GET['cpage'];
  $pagesize = 10;
  $totalpage = (int)($total / $pagesize);
  if (($total % $pagesize) != 0) $totalpage = $totalpage + 1;
  $counter = 0;
  while ($counter < $pagesize):
      $newcounter = ($cpage - 1) * $pagesize + $counter;
      if ($newcounter == $total) break;
      $code = mysqli_result($result, $newcounter, "code");
      $result2 = mysqli_query($con, "select * from product where code='$code'");
      $name = mysqli_result($result2, 0, "name");
      $title = mysqli_result($result, $newcounter, "title");
      $date = mysqli_result($result, $newcounter, "date");
      $score = mysqli_result($result, $newcounter, "score");
      echo ("
      <div class='Div60W' style='margin-top:10px;margin:0 auto;'>
        <div class='menuNav20-6'>$name</div>
        <a href='javascript:content()'><div class='menuNav40-6'>$title</div></a>
        <div class='menuNav18-6'>");
        $tempA = 0;
        while($tempA < $score){
          echo("★");
          $tempA++;
        }
        $tempB = 0;
        while($tempB < (5 - $tempA)){
          echo ("☆");
          $tempB++;
        }
      echo ("
        </div>
        <div class='menuNav20-6'>$date</div>
      </div>
      <script>
        function content() {
          window.open('reviewCon.html?code=$code&date=$date', 'review_content', 'width=600, height=550, scrollbars=yes');
        }
      </script>
      ");
      $counter = $counter + 1;
  endwhile;
  echo ("<div class='Div60C' style='padding-top:30px; border-top: 4px solid black; margin:0 auto;'><div style='text-align:center; display:inline-block; padding:10px;'>");
  if (empty($_GET['cblock'])) $cblock = 1;
  else $cblock = $_GET['cblock'];
  $blocksize = 5;
  $pblock = $cblock - 1;
  $nblock = $cblock + 1;
  $startpage = ($cblock - 1) * $blocksize + 1;
  $pstartpage = $startpage - 1;
  $nstartpage = $startpage + $blocksize;
  if ($pblock > 0) echo ("[<a href=userReview.php?cblock=$pblock&cpage=$pstartpage>이전블록</a>] ");
  $i = $startpage;
  while ($i < $nstartpage):
      if ($i > $totalpage) break;
      echo ("[<a href=userReview.php.html?cblock=$cblock&cpage=$i>$i</a>]");
      $i = $i + 1;
  endwhile;
  if ($nstartpage <= $totalpage) echo ("[<a href=userReview.php.html?cblock=$nblock&cpage=$nstartpage>다음블록</a>] ");
}
echo("</div>")
?>
