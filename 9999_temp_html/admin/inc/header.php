<!doctype html>
<html lang="ja">

  <head>
    <meta name="ROBOTS" content="NOINDEX">
    <title>採用フォーム管理画面</title>

    <?php
      include 'inc/url.php';
    ?>

    <link rel="stylesheet" href="css/jquery.ui.css" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui.datepicker-ja.js"></script> 
    <script type="text/javascript" src="js/jquery.tmpl.min.js"></script> 
    <script type="text/javascript" src="js/jscolor/jscolor.js"></script> 
    <script type="text/javascript" src="js/underscore.js"></script> 
    <script type="text/javascript" src="js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="js/main.js"></script> 
    <script type="text/javascript" src="js/function.js"></script> 

    <!--[if lt IE 9]>
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

 </head>
<body>



<div id="wrap">
  
    <div id="header">
      <div id="header_title">
        <div id="header_title_inner">
          <h1 id="logo"><img src="img/logo.png" alt="ミュゼプラチナム" /></h1>
          <p><img src="img/headertitle.png" alt="ミュゼプラチナム" /></p>
        </div><!-- header_title_inner -->
      </div><!-- header_title -->

      <div id="header_inner">
          <ul class="headerUl">
            <li class="selected"><a href="home.php">HOME</a></li>
            <li><a href="formmanagement.php">フォーム管理</a></li>
            <li><a href="userlist.php">ユーザー管理</a></li>
            <li id="headerUlEtc">
              その他の設定
              <ul class="headerUlAdvance">
                <li><a href="advertising.php">広告コード管理</a></li>
                <li><a href="useredit.php">ログイン情報管理</a></li>
              </ul>
            </li>
            <li class="headerUlright">
              <p><a href=""><img src="img/pdf.png" alt="操作マニュアル" /></a></p>
              <p><span class="headerUlgray">abc-1234</span> でログイン中 | <a href=""><span class="headerUlgray">ログアウト</span></a></p></li>
          </ul>

      </div><!-- header_inner -->
    </div><!-- header -->
    