<?
$name = $_POST['name'];
$price = $_POST['price'];

if (!$name){
	echo("
		<script>
		window.alert('상품명이 없습니다. 다시 입력하세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if(!$price){
	echo("
		<script>
		window.alert('가격이 없습니다. 다시 입력하세요.')
		history.go(-1)
		</script>
	");
	exit;
}

$class = $_POST['class'];
$quantity = $_POST['quantity'];
$userfile = $_FILES['userfile'];
$file_path = $userfile['tmp_name'];
$file_name = $userfile['name'];
$ftp_host = "storage.bunnycdn.com";
$ftp_id = "shopmall-2021nov";
$ftp_pw = "8fcd400b-ba89-47e1-83f646b77f8c-6d9e-4c07";

$conn_id = ftp_connect($ftp_host);
ftp_pasv($conn_id, true);
$login_result = ftp_login($conn_id, $ftp_id, $ftp_pw);
$uploaddir = '/shopmall-2021nov/';
$server_file = $uploaddir . $file_name;

ftp_put($conn_id, $server_file, $file_path, FTP_BINARY);
ftp_close($conn_id);

$fileLink = "https://ShopMall2021NOV.b-cdn.net/$file_name";


$con = mysqli_connect("localhost","root","kyle0908", "shopmall");

$result = mysqli_query($con, "insert into product(class, name, price, image, hit) values ($class, '$name', '$price', '$fileLink', 0)");

mysqli_close($con);

echo("
  <script>
    window.alert('상품 등록이 완료되었습니다')
  </script>
");

echo ("<meta http-equiv='Refresh' content='0; url=productReg.html'>");
?>
