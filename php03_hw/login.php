<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login-page">
    <div class="form">
        <!-- ログインフォームの作成 -->
        <form class="login-form" action="selects.php" method="post">
            <!-- inputは"others"と"sex"の2つのクラスを付与 -->
            <input class="others" type="text" name="name" placeholder="name">
            <input class="others" type="email" name="email" placeholder="email">
            <input class="others" type="number" name="age" placeholder="age">
            <div class="sex">
                <input type="radio" name="sex" id="on" value="女性" checked="">
                <label for="on" class="switch-on">女性</label>
                <input type="radio" name="sex" id="off" value="男性">
                <label for="off" class="switch-off">男性</label>
            </div>
            <button>
                <!-- ボタン押下でselect.phpに情報を引き継ぐ -->
                <input type="submit" class="continue" value="Continue" href="http://localhost/php03_hw/selects.php">
                </input>
            </button>
        </form>
    </div>
</div>
</body>
</html>