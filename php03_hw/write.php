<head>
<meta charset="utf-8">
<title>File書き込み</title>
<link rel="stylesheet" href="write.css">
</head>
<body>
<div class="wrapper">
        <img src="https://i.pinimg.com/564x/7a/6c/03/7a6c0348e4edce9396a37c9f7e680a02.jpg" alt="DONE picture">
</div>
<div class="wrapper">
        <a href="read.php">アンケート結果を確認</a>
</div>
</body>
<?php
// index.phpとかから情報がない場合の処理を書いておく
if(
        !isset($_POST["name"]) || $_POST["name"] == "" || // 左：そもそも変数がない場合、右：変数がNULLの場合 
        !isset($_POST["email"]) || $_POST["email"] == "" ||
        !isset($_POST["age"]) || $_POST["age"] == "" ||
        !isset($_POST["sex"]) || $_POST["sex"] == "" ||
        !isset($_POST["selected1"]) || $_POST["selected1"] == "" ||
        !isset($_POST["selected2"]) || $_POST["selected2"] == "" ||
        !isset($_POST["selected3"]) || $_POST["selected3"] == ""
      ){
        exit("ParamError");
      };
      
      //1. POSTデータ取得
      $name = $_POST["name"];
      $email = $_POST["email"];
      $age = $_POST["age"];
      $sex = $_POST["sex"];
      $selected1 = $_POST["selected1"];
      $selected2 = $_POST["selected2"];
      $selected3 = $_POST["selected3"];
      
      //2. DB接続します
      try {
        $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root',''); //root：ユーザー名、最後：パスワード (localhostの場合)
      } catch (PDOException $e) {
        exit('DbConnectError:'.$e->getMessage()); //DbConnectError:は何でもいい。エラー時の表示
      };
      
      //３．データ登録SQL作成
      $sql = "INSERT INTO picture_table(id, name, email, age, sex, selected1, selected2, selected3, indate)
                VALUES(NULL, :a1, :a2, :a3, :a4, :a5, :a6, :a7, sysdate())";
      
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':a1', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
      $stmt->bindValue(':a2', $email, PDO::PARAM_STR); 
      $stmt->bindValue(':a3', $age, PDO::PARAM_INT); 
      $stmt->bindValue(':a4', $sex, PDO::PARAM_STR); 
      $stmt->bindValue(':a5', $selected1, PDO::PARAM_STR); 
      $stmt->bindValue(':a6', $selected2, PDO::PARAM_STR); 
      $stmt->bindValue(':a7', $selected3, PDO::PARAM_STR); 
      $status = $stmt->execute();
      
      //４．データ登録処理後
      if($status==false){ // status：処理結果が入ってくる
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        $error = $stmt->errorInfo();
        exit("sqlError".$error[2]);
      }
?>
</body>
</html>