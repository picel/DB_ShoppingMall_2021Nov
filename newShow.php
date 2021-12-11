<?
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
      $quantity = mysqli_result($result, $i, "quantity");
      echo ("
        <a href=product.html?code=$code>
          <div class='listCol'>
            <div><img src='$image' id='previewC'");
            if ($quantity == 0) echo ("class='brightness'");
            echo("></div>
            <div>$name
          ");
      if ($quantity == 0) echo ("<b>(품절)</b>");
      echo ("
            </div>
            <div>$price\</div>
          </div>
        </a>
      ");
      $i = $i + 1;
}
echo ("</div>");
?>
