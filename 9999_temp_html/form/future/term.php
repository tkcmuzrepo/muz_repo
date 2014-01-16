

<?php

include 'inc/formhearder.php';

function formfTitle_subTitle($title,$subtitle){

$item = <<< EOF
<h3 style="background: #4794CE;
position: relative;
margin: 0px;
margin-bottom: 13px;
color: #FFF;
text-align: left;
padding-left: 3%;
font-weight: normal;
line-height: 30px;
float: left;
width: 97%;
font-size: 15px;
height: 30px;
">
$title
</h3>

<p 
style=
"background: #FFF;
margin-bottom: 100px;
margin: 0 auto;
padding-left: 3%;
font-size: 12px;
">
$subtitle
</p>
EOF;

echo $item;

}


function statement($statement,$subtitle){

$item = <<< EOF
<p style="float: left;
width: 100%;
font-size: 12px;
">
$statement
</p>
EOF;
echo $item;
}



function formBox(){

$item = <<< EOF
<div
style="
width: 98%;
background: #FFF;
margin-bottom: 100px;
margin: 0 auto;
padding-bottom:10px;
margin-bottom: 25px;"
>
EOF;
echo $item;
}




function fieldDiv($name,$w){

$item = <<< EOF
<div style="
color: #51ABE3;
margin: 0 auto;
font-size: 15px;
position: relative;
width: 95%;
text-align: left;
margin-top: 10px;
">
EOF;
echo $item;
}



function ul($name,$w){

$item = <<< EOF
<ul style="
list-style-type: none;
margin: 0px;
padding: 0px;
float: left;
width: 100%;
list-style-type: none;
margin: 0px;
padding: 0px;
float: left;
width: 100%;
list-style-type: none;
">
EOF;

echo $item;
}


function li($name,$w){

$item = <<< EOF
<li style="
margin: 0px;
float: left;
margin-bottom: 5px;
padding: 0px;
padding-right: 5px;
">
EOF;

echo $item;
}




function clear($name,$w){

$item = <<< EOF
<div style="
clear: both;
">　</div>
EOF;

echo $item;
}



function itemSupplement($name){

$item = <<< EOF
<span 
style="
float: left;
height: 20px;
line-height: 20px;
padding: 0px;
margin: 0px;
font-size: 12px;"
margin-right:2px;
>
$name
</span>
EOF;

echo $item;

}



function fieldfTitleTag($name){

$item = <<< EOF
<p style="color: #4794CE;
margin-bottom: 5px;
position: relative;
display: block;
float: left;
width: 100%;
margin-top: 0px;
font-size: 12px;">
$name
<span 
style="position: absolute;
left: -5px;
color: #F00;
top: -8px;
font-size: 12px;
">●</span>
</p>
EOF;

echo $item;

}




function inputTag($name,$w){

$item = <<< EOF
<input 
type="text" 
name=$name 
value="" 
style="float: left;
width: $w;
margin-right: 5px;
font-size: 10px;
margin-left: 5px;
margin-right: 5px;
border: solid 1px #C9DBE6;
background: #E9F1F9;
">
EOF;

echo $item;
}



function selectTag($name){

$item = <<< EOF
<select 
name="$name" 
value="" 
style="margin-right: 5px;
float: left;
font-size: 10px;
border: solid 1px #C9DBE6;
background: #E9F1F9;
font-size:10px;
">
EOF;

echo $item;

}



function radio_checkbox($type,$name,$value){

$item = <<< EOF
<input 
type="$type" 
name="$name" 
value="$value"

style="
float: left;
">

EOF;

echo $item;

}


?>







<div 
style="
background: #FFF;
margin-bottom: 15px;
float: left;"
>
<h1><img src="img/headerlogo.png" alt="#" style="width:100%;"/></h1>
</div>




<div style="
width: 100%;
margin: 0 auto;"
>


    <div 
    style="margin-top: 50px;
    width: 97%;
    margin: 0 auto;"
    >
    <?php clear() ?>
    
 

    







  <form action="index.php" method="POST">

    
    <!-- formbox -->
    <?php formBox() ?>


    <!-- タイトルサブタイトル -->
    <?php formfTitle_subTitle('会員規約について','') ?>


<p 
style="
font-size:10px;
">

以下の会員規約を確認し、同意した上でご登録ください。<br/>
規約に同意される方は、画面下の「上記会員規約に同意する」ボタンをクリックして次の画面へお進みください。
※すでに登録を済ませた方は登録することはできません。<br/>
<br/>
【ジングループ　採用ホームページ会員サービス 会員規約】<br/>
<br/>
○第１条（ジングループ採用ホームページ会員サービスの定義）<br/>
「ジングループ採用ホームページ会員サービス」（以下「会員サービス」とします）とは、株式会社ジンコーポレーション（以下「当社」とします）が提供するインターネット上の就職情報サービスのことをいいます。<br/>
<br/>
<br/>
○第２条（会員）<br/>
（１）会員とは、就職活動を行う方のうち、当社が定める方法によって「会員サービス」に登録を申し込み、当社がこれを承認した方をいいます。<br/>
（２）会員は、「会員サービス」における会員向けのサービスを受けることができます。 <br/>
（３）会員は、入会の時点で本規約を承諾しなければなりません。会員が「会員サービス」を利用したときは、この会員規約を承認したものとみなします。 <br/>
<br/>
<br/>
○第３条（会員ＩＤ番号とパスワード） <br/>
（１）会員は、当社により会員ＩＤ番号を付与されたら速やかに、パスワードを登録するものとします。ただし、第５条に抵触すると当社が判断した場合は、会員ＩＤ番号を付与されないことがあります。<br/>
（２）会員は、会員ＩＤ番号及びパスワードを第三者に開示、譲渡もしくは貸与してはなりません。<br/>
（３）会員ＩＤ番号及び自ら登録したパスワードの管理および使用は、会員の責任にて行うものとし、これらの使用上の過誤または第三者による不正使用等については、当社は一切の責任を負わないものとします。<br/>
<br/>
<br/>
○第４条（会員サービス）<br/>
（１）会員は、当社が会員への事前の通知なくして、「会員サービス」の内容を変更し、その運営を中断または中止することがあることを了承します。<br/>
（２）会員は、システム障害などの事情により、会員サービス機能に支障が生じ、もしくは会員サービスが停止する等の可能性がある事を承諾するものとします。<br/>
（３）当社は、いかなる場合においても、「会員サービス」の変更、中断、中止等により発生した会員の損害に対し、一切の責任を負わないものとします。<br/>
<br/>

<br/>
○第５条（会員の禁止行為）<br/>
会員は以下の行為を行なわないものとします。<br/>
（１）他の会員、当社又は第三者の著作権、肖像権、その他知的所有権を侵害する行為<br/>
（２）他の会員、当社又は第三者の財産、信用、名誉、プライバシー、その他人権等を侵害する行為<br/>
（３）他の会員、当社又は第三者を差別、批判、攻撃、誹謗中傷する行為<br/>
（４）「会員サービス」の運営を妨げる行為、またはその恐れのある行為<br/>
（５）当社の業務を阻害する行為、又は不利益を与える行為<br/>
（６）個人的な勧誘行為、個人的な物品の売買行為、その他「会員サービス」を利用して、営業活動、営利を目的とした情報提供活動を行うこと<br/>
（７）「会員サービス」を通じて入手した情報を複製、販売、出版その他の方法により私的利用の範囲を超えて使用すること<br/>
（８）「会員サービス」における政治活動、選挙活動、宗教活動<br/>
（９）虚偽の内容に基づいて会員登録する行為<br/>
（10）犯罪的行為に結びつく行為、公序良俗に反する行為、その他、法律、法令に反する行為<br/>
<br/>
<br/>
○第６条（除名）<br/>
当社は、会員が本規約に違反したと判断した場合、もしくは会員として不適切と判断した場合、会員に事前に通知することなく、会員サービスの提供を中止することができるものとし、会員はこれを承諾するものとします。<br/>
○第７条（損害賠償）<br/>
当社は、「会員サービス」の利用、変更、中断、中止などにより発生した会員の損害すべてに対し、一切の責任を負わないものとします。<br/>
また、「会員サービス」の利用により会員又は第三者が被った損害に対しいかなる責任も負わないものとし、損害賠償をする義務は一切ないものとします。<br/>
<br/>
<br/>
○第８条（提供された情報の当社による利用）<br/>
会員は、会員から提供された情報内容を、当社が採用活動の目的およびそれに準じる情報提供の目的で利用することを了承するものとします。<br/>
当社は、正当な理由なく、この目的以外に会員の氏名など個人情報を使用したり公開したりしないものとします。<br/>
<br/>
<br/>
○第９条（本規約の変更）<br/>
当社は本規約を随時変更することができるものとします。変更の内容についてはインターネット上に表示します。この表示後、会員が「会員サービス」を利用した時点で、当該会員はこの変更を了承したものとみなします。変更を了承できない会員は退会するものとします。<br/>
<br/>
<br/>
○付則<br/>
この規約は2012年10月1日から実施します。<br/>
上記規約の内容を確認し、よろしければ「上記会員規約に同意する」ボタンをクリックしてください。<br/>
<p>


<?php clear() ?>

</div>











 
  

    <!-- フィールド -->
    <?php formBox() ?>



      <input 
      type="submit" 
      value="会員規約に同意する" 
      style="background: #4794CE;
      position: relative;
      margin: 0px;
      margin-bottom: 15px;
      color: #FFF;
      padding-left: 3%;
      font-weight: normal;
      line-height: 40px;
      float: left;
      width: 100%;
      font-size: 12px;
      text-align: center;
      text-decoration: none;
      height: 50px;
      margin-top: 20px;"
      >
      





       <?php clear() ?>
    

    </div>


  </form>




  </div>
</div>　
</body>
</html>