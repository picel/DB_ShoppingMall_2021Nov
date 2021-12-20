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
$result = mysqli_query($con, "select * from qna order by id desc");
$total = mysqli_num_rows($result);

if (!$total)
{
  echo ("<div class='Div60C'>아직 등록된 글이 없습니다.</div><a href='qnaIn.html'>");
  if (isset($_COOKIE['UserID'])){
    echo ("
    <a href=qnaIn.html>
    <div style='display:inline-block; padding:10px; float:right; background-color:black; color:white;'>글쓰기</div></a><br>
    ");
  }

}
else
{
  if (empty($_GET['cpage'])) $cpage = 1;
  else $cpage = $_GET['cpage'];
  $pagesize = 5;
  $totalpage = (int)($total / $pagesize);
  if (($total % $pagesize) != 0) $totalpage = $totalpage + 1;
  $counter = 0;
  while ($counter < $pagesize):
      $newcounter = ($cpage - 1) * $pagesize + $counter;
      if ($newcounter == $total) break;
      $id = mysqli_result($result, $newcounter, "id");
      $topic = mysqli_result($result, $newcounter, "topic");
      $writer = mysqli_result($result, $newcounter, "writer");
      $wdate = mysqli_result($result, $newcounter, "wdate");
      $hit = mysqli_result($result, $newcounter, "hit");
      $islocked = mysqli_result($result, $newcounter, "islocked");
      $result2 = mysqli_query($con, "select * from reply where id=$id");
      $total2 = mysqli_num_rows($result2);
      echo ("
      <div class='Div60W' style='margin-top:10px;'>
        <div class='menuNav11-6'>$id</div>
        <a href=qnaCon.html?id=$id><div class='menuNav40-6'>$topic
      ");
      if ($islocked == 1) echo("<i class='fas fa-lock'></i>");
      if ($total2 != 0) echo(" [$total2]");
      echo("</div></a>
        <div class='menuNav15-6'>$writer</div>
        <div class='menuNav15-6'>$wdate</div>
        <div class='menuNav15-6'>$hit</div>
      </div>
      ");
      $counter = $counter + 1;
  endwhile;
  echo ("<div class='Div60C' style='padding-top:30px; border-top: 4px solid black;'><div style='text-align:center; display:inline-block; padding:10px;'>");
  if (empty($_GET['cblock'])) $cblock = 1;
  else $cblock = $_GET['cblock'];
  $blocksize = 5;
  $pblock = $cblock - 1;
  $nblock = $cblock + 1;
  $startpage = ($cblock - 1) * $blocksize + 1;
  $pstartpage = $startpage - 1;
  $nstartpage = $startpage + $blocksize;
  if ($pblock > 0) echo ("[<a href=productMan.html?cblock=$pblock&cpage=$pstartpage>이전블록</a>] ");
  $i = $startpage;
  while ($i < $nstartpage):
      if ($i > $totalpage) break;
      echo ("[<a href=productMan.html?cblock=$cblock&cpage=$i>$i</a>]");
      $i = $i + 1;
  endwhile;
  if ($nstartpage <= $totalpage) echo ("[<a href=productMan.html?cblock=$nblock&cpage=$nstartpage>다음블록</a>] ");
  echo("</div>");
  if (isset($_COOKIE['UserID'])){
    echo ("
      <a href=qnaIn.html>
      <div style='display:inline-block; padding:10px; float:right; background-color:black; color:white;'>글쓰기</div></a><br>
    ");
  }
  echo("</div>");
}
?>
