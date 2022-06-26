<?php
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */
session_start();
require_once('funcs.php');
require_once('footer.php');
$pdo = db_conn();
loginCheck();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM kadai04_read_table03');
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail04.php?id=' . $result['id'] . '">';
        $view .= $result['indate'] . '：' . $result['name'];
        $view .= '</a>';

        $view .= '<a href="delete04.php?id=' . $result['id'] . '">';
        $view .= '[削除]';
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
    <!-- <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
        <span class="text-muted"><a href="index.php">書籍一覧に戻る</a></span>
        </div>
    </footer> -->
</body>

</html>
