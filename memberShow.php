<? function mysqli_result($res, $row = 0, $col = 0)
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
$result = mysqli_query($con, "select * from member order by uname");
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
      $uid = mysqli_result($result, $newcounter, "uid");
      $uname = mysqli_result($result, $newcounter, "uname");
      $uphone = mysqli_result($result, $newcounter, "uphone");
      $umail = mysqli_result($result, $newcounter, "umail");
      $zipcode = mysqli_result($result, $newcounter, "zipcode");
      $addr1 = mysqli_result($result, $newcounter, "addr1");
      $addr2 = mysqli_result($result, $newcounter, "addr2");
      $isadmin = mysqli_result($result, $newcounter, "isadmin");
      echo ("
      <div class='Div100W' style='margin-top:10px;'>
        <div class='menuNav11-6'><br>$uid</div>
        <div class='menuNav15-6'><br>$uname</div>
        <div class='menuNav20-6'>$umail<br><br>$uphone</div>
        <div class='menuNav30-6'>$zipcode<br>$addr1<br>$addr2</div>
        <div class='menuNav20-6'>
        ");
      if ($isadmin == 0) echo("<a href=memberMan.php?mode=1>관리자로 승급</a><br><br>");
      else echo("<a href=memberMan.php?mode=2>관리자 권한 박탈</a><br>");
      echo("
          <a href=memberMan.php?mode=3>회원 삭제</a>
        </div>
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
}
echo("</div>")
?>
