<!-- login.phpからユーザー情報を取得 -->
<?php
$name = $_POST["name"];
$email = $_POST["email"];
$age = $_POST["age"];
$sex = $_POST["sex"];
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>画像セレクト</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="selects.css" type="text/css">
</head>
<body>
    
    <div id="navi">
        <!-- <form action="自分のサイトURL" method="get"> -->
        <input id="sbox1" name="s" type="text" placeholder="スライドを検索 …" />
        <!-- </form> -->
        <!-- <input id="dl_btn" type="button" value="選択したスライドをダウンロード"> -->
        <a href="#" id="dl_btn" class="download">選択したスライドをダウンロード</a>
        <span id="username"><?php echo $name; ?></span>
    </div>

    <div id="content-wrapper">
        <!-- <a href="#" class="download">ImageDownload</a> -->
        <?php

        // ディレクトリハンドルの取得
        $dir_h = opendir( "picture/" ) ;
        // ファイル・ディレクトリの一覧を $file_list に
        while (false !== ($file_list[] = readdir($dir_h))) ;
        // ディレクトリハンドルを閉じる
        closedir( $dir_h ) ;

        //ディレクトリ内のファイル名を１つずつを取得
        foreach ( $file_list as $file_name )
            {if( is_file( "picture/" . $file_name) )
                {$p = pathinfo("picture/" . $file_name);
                    if ( $p["extension"] == "jpg" )
                    {print('<img class="pictures" src="picture/'.$file_name.'" width="23.7%">' . "\n");}
                }
            }

        ?>

        <div class="send-wrapper">
            <input class="send" type="submit" value="Send">
        </div>
    </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/FileSaver.js"></script>
<script type="text/javascript" src="js/jszip.min.js"></script> -->
<script>
    var clicked_picture = [];
    $(".pictures").click(function(){
        $(this).toggleClass("clicked");
        if($.inArray(this.src, clicked_picture) >= 0){
            var delete_obj = clicked_picture.indexOf(this.src);
            clicked_picture.splice(delete_obj, 1);
            return;
        };
        clicked_picture.push(this.src);
    });
</script>
<script>
    $(function(){
        $("#dl_btn").on("click", function(e){
            for(var i=0; i<clicked_picture.length; i++) { // 配列の長さ分の繰り返し
                $target = $(e.target);
                $target.attr({
                    download: clicked_picture[i],
                    href:  clicked_picture[i]
                });
            }    
            // <php
            //     // index.phpとかから情報がない場合の処理を書いておく
            //     if(
            //             !isset($_POST["name"]) || $_POST["name"] == "" || // 左：そもそも変数がない場合、右：変数がNULLの場合 
            //             !isset($_POST["email"]) || $_POST["email"] == "" ||
            //             !isset($_POST["age"]) || $_POST["age"] == "" ||
            //             !isset($_POST["sex"]) || $_POST["sex"] == ""
            //         ){
            //             exit("ParamError");
            //         };
                    
            //         //1. POSTデータ取得
            //         $name = $_POST["name"];
            //         $email = $_POST["email"];
            //         $age = $_POST["age"];
            //         $sex = $_POST["sex"];
                    
            //         //2. DB接続します
            //         try {
            //             $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root',''); //root：ユーザー名、最後：パスワード (localhostの場合)
            //         } catch (PDOException $e) {
            //             exit('DbConnectError:'.$e->getMessage()); //DbConnectError:は何でもいい。エラー時の表示
            //         };
                    
            //         //３．データ登録SQL作成
            //         $sql = "INSERT INTO download_table(id, name, email, age, sex, indate)
            //                     VALUES(NULL, :a1, :a2, :a3, :a4, sysdate())";
                    
            //         $stmt = $pdo->prepare($sql);
            //         $stmt->bindValue(':a1', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
            //         $stmt->bindValue(':a2', $email, PDO::PARAM_STR); 
            //         $stmt->bindValue(':a3', $age, PDO::PARAM_INT); 
            //         $stmt->bindValue(':a4', $sex, PDO::PARAM_STR);  
            //         $status = $stmt->execute();
                    
            //         //４．データ登録処理後
            //         if($status==false){ // status：処理結果が入ってくる
            //             //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
            //             $error = $stmt->errorInfo();
            //             exit("sqlError".$error[2]);
            //         }
            //     ?>
                
        });
    });
</script>
<!-- <script>
    $("#dl_btn").click(function(){
        var zip = new JSZip();
        zip.file("Hello.txt", "Hello World\n");
        var imgData = "pictures/"
        var img = zip.folder("images");
        img.file("Report_201408-001.jpg", imgData, {base64: true});
        zip.generateAsync({type:"blob"})
        .then(function(content) {
            // see FileSaver.js
            saveAs(content, "example.zip");
        });
    });
</script> -->

<!-- <script>
    // bootstrapっぽいプログレスバーのテンプレート
    var progressTemplate = "<div class=\"list-group-item\"><div class=\"progress progress-striped active\"><div class=\"progress-bar progress-bar-info\" style=\"width: 0%;\"></div></div></div>";
    var $images = $(".clicked");
    var $downloadBtn = $("#dl_btn");
    // var $progress = $("#progress-container");
    var zip;
    var deferreds;
    
    $(function(){
        
        // // 画像を選択するプラグインimage-picker.jsのスクリプト
        // $images.imagepicker({
        //  hide_select : true,
        //  show_label  : false
        // });

        // // ダウンロードしたい画像が1件以上選択されているとき、ダウンロードボタンをクリック可能にする
        // $images.on("change", _setSelectStatus);
        // _setSelectStatus();

        // zipファイル生成＆ダウンロード処理
        $downloadBtn.on("click", _createAndDownloadZip);
    });
        
    /**
     * ダウンロードボタンのクリック制御
     */
    function _setSelectStatus() {
        if ($images.val() && $images.val().length > 0) {
            $downloadBtn.removeAttr("disabled");
        } else {
            $downloadBtn.attr("disabled", "disabled");
        }
    }

    /**
     * ZIPファイルを生成する
     */
    function _createAndDownloadZip() {

        // 初期化
        // $progress.empty().append(progressTemplate).show();
        zip = new JSZip();
        deferreds = $.Deferred();
        var promise = deferreds;
        
        // 選択した画像分ループ
        $.map($images.val(), function(value, index){

            var thumbUrl = $images.find("option[value=\"" + value + "\"]").data("img-src");
            var originalUrl = thumbUrl.replace(/\/thumb\//, "/original/");

            promise = promise.then(function() {
                var newPromise = new $.Deferred();

                // オリジナル画像を読み込む
                var xhr = new XMLHttpRequest();
                xhr.open('GET', originalUrl, true);
                xhr.responseType = 'arraybuffer';
                xhr.addEventListener('load', function() {
                    // zipにレスポンスデータを追加
                    zip.file(originalUrl.match(".+/(.+?)([\?#;].*)?$")[1], xhr.response);
                    newPromise.resolve();
                });
                xhr.send();

                // プログレスバーを更新
                $progress.find(".progress-bar").width((index + 1) / $images.val().length * 100 + "%");
                return newPromise;
            });
        });

        // 画像のダウンロードが完了した後でzipファイルを生成してsaveAsメソッドでダウンロード
        promise.then(function(){
            zip.generateAsync({type:"blob"}).then(function (content) {
                saveAs(content, _formatDate(new Date(), "YYYYMMDD-hhmmss") + ".zip");
            });
            // $progress.hide();
        });
        deferreds.resolve();
    }
</script> -->

</body>
</html>

