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

$class = $_GET['class'];

$con = mysqli_connect("localhost", "root", "kyle0908", "shopmall");
$result = mysqli_query($con, "select * from product where class='$class'");
$total = mysqli_num_rows($result);

if (!$total)
{
  echo ("<div class='Div60C'>아직 등록된 상품이 없습니다.</div>");
}
else
{
  if (empty($_GET['cpage'])) $cpage = 1;
  else $cpage = $_GET['cpage'];
  $pagesize = 12;
  $totalpage = (int)($total / $pagesize);
  if (($total % $pagesize) != 0) $totalpage = $totalpage + 1;
  $counter = 0;
  echo ("<div class='listWrap'>");
  while ($counter < $pagesize):
      do {
        $newcounter = ($cpage - 1) * $pagesize + $counter;
        if ($newcounter == $total) break;
        $code = mysqli_result($result, $newcounter, "code");
        $name = mysqli_result($result, $newcounter, "name");
        $price = mysqli_result($result, $newcounter, "price");
        $image = mysqli_result($result, $newcounter, "image");
        echo ("
          <a href=product.html?code=$code>
            <div class='listCol'>
              <div><img src='$image' id='previewC'></div>
              <div>$name</div>
              <div>$price</div>
            </div>
          </a>
        ");
        $counter = $counter + 1;
      } while ($newcounter % 4 != 0);
      if ($newcounter == $total) break;
  endwhile;
  echo ("</div>");
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
}
?>
