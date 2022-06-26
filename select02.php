<?php
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */

// セッション開始宣言
session_start();
// funcsを起動、loginCheckの呼び出し
require_once('funcs.php');
require_once('footer.php');
loginCheck();

//２．データ登録SQL作成
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM kadai04_an_table');
$status = $stmt->execute();

//３．データ表示(ビジュアルを変えたい)
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail02.php?id=' . $result['id'] . '">';
        $view .= $result['indate'] . '：' . $result['name'];
        $view .= '</a>';

        $view .= '<a href="delete02.php?id=' . $result['id'] . '">';
        $view .= '[削除]';
        $view .= '</a>';

        $view .= '<a href="detail03.php?id=' . $result['id'] . '">';
        $view .= '[既読]';
        $view .= '</a>';

        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>読んだ書籍一覧</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index02.php">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron">
            <?= $view ?>
        </div>
    </div>
    <!-- Main[End] -->
    <?= $footer ?>
</body>

</html>
