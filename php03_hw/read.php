<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アンケート結果</title>
    <link rel="stylesheet" href="read.css">
</head>
<body>  
<table>
    <tr>
        <th>名前</th>
        <th>メールアドレス</th>
        <th>年齢</th>
        <th>性別</th>
        <th>好みの画像1</th>
        <th>好みの画像2</th>
        <th>好みの画像3</th>
    </tr>

<?php
//1.  DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT*FROM picture_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .=
        "<tr>".
            "<td>".$result["name"]."</td>".
            "<td>".$result["email"]."</td>".
            "<td>".$result["age"]."</td>".
            "<td>".$result["sex"]."</td>".
            '<td><img src="'.$result['selected1'].'"></td>'.
            '<td><img src="'.$result['selected2'].'"></td>'.
            '<td><img src="'.$result['selected3'].'"></td>'.
        "</tr>"; 
    }
}
?>

<tr><?= $view ?></tr>
</table>
</body>
</html>