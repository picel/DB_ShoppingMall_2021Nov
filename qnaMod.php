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
$con = mysqli_connect("localhost","root","kyle0908", "shopmall");
$result = mysqli_query($con, "select * from qna");
$total=mysqli_num_rows($result);

$id = $_GET['id'];
$writer = $_COOKIE['UserID'];
$topic = $_POST['topic'];
$content = $_POST['content'];
$islocked = $_POST['islocked'];
$date = date("Y-m-d");

if (!$topic){
	echo("
		<script>
		window.alert('제목을 입력 해 주세요.')
		history.go(-1)
		</script>
	");
	exit;
}

if(!$content){
	echo("
		<script>
		window.alert('내용을 입력 해 주세요.')
		history.go(-1)
		</script>
	");
	exit;
}
if(empty($_FILES['userfile']['name'])){
	$fileLink = "";
}
else{
  $userfile = $_FILES['userfile'];
  $file_path = $userfile['tmp_name'];
  $file_name = $userfile['name'];
  $ftp_host = "storage.bunnycdn.com";
  $ftp_id = "shopmall-2021nov";
  $ftp_pw = "8fcd400b-ba89-47e1-83f646b77f8c-6d9e-4c07";

  $conn_id = ftp_connect($ftp_host);
  ftp_pasv($conn_id, true);
  $login_result = ftp_login($conn_id, $ftp_id, $ftp_pw);
  $uploaddir = '/shopmall-2021nov/qna/';
  $server_file = $uploaddir . $file_name;

  ftp_put($conn_id, $server_file, $file_path, FTP_BINARY);
  ftp_close($conn_id);

  $fileLink = "https://ShopMall2021NOV.b-cdn.net/qna/$file_name";
}

$result = mysqli_query($con, "update qna set topic='$topic', content='$content', file='$filelink', wdate='$date' where id=$id");

mysqli_close($con);

echo("
  <script>
    window.alert('질문 등록이 완료되었습니다')
  </script>
");

echo ("<meta http-equiv='Refresh' content='0; url=qna.html'>");
?>
