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
$result = mysqli_query($con, "select * from product order by class");
$total = mysqli_num_rows($result);

if (!$total)
{
  echo ("<div class='Div60C'>아직 등록된 상품이 없습니다.</div>");
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
      $code = mysqli_result($result, $newcounter, "code");
      $class = mysqli_result($result, $newcounter, "class");
      $name = mysqli_result($result, $newcounter, "name");
      $price = mysqli_result($result, $newcounter, "price");
      $quantity = mysqli_result($result, $newcounter, "quantity");
      $image = mysqli_result($result, $newcounter, "image");
      echo ("
      <div class='Div150W' style='margin-top:10px;'>
        <div class='menuNav11-15'>$code</div>
        <div class='menuNav11-15'><a href=category.html?class=$class>$class</a></div>
        <div class='menuNav20-15'><a href=product.html?code=$code>$name</a></div>
        <div class='imageContainer'><img src='$image' id='preview'></div>
        <div class='menuNav15-15'>$price</div>
        <div class='menuNav11-15'>$quantity</div>
        <div class='menuNav15-15'>
          <a href=productMod.php?code=$code>수정</a> /
          <a href=productDel.php?code=$code>삭제</a>
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
  echo("</div>
    <a href='productReg.html'><div style='display:inline-block; padding:10px; float:right; background-color:black; color:white;'>상품 등록</div></a>
    </div>
  ");
}
?>
