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
$result = mysqli_query($con, "select * from product order by date desc");
$total = mysqli_num_rows($result);

echo ("<div class='listWrap'>");
$i = 0;
while ($i < 4){
      $code = mysqli_result($result, $i, "code");
      $name = mysqli_result($result, $i, "name");
      $price = mysqli_result($result, $i, "price");
      $image = mysqli_result($result, $i, "image");
      echo ("
        <a href=product.html?code=$code>
          <div class='listCol'>
            <div><img src='$image' id='previewC'></div>
            <div>$name</div>
            <div>$price\</div>
          </div>
        </a>
      ");
      $i = $i + 1;
}
echo ("</div>");
?>
