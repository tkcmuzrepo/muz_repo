

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

     
    <!-- formbox -->
    <?php formBox() ?>


      <!-- タイトルサブタイトル -->
      <?php formfTitle_subTitle('応募を受付けました','') ?>
    
    
      <div style="width: 82%;
      margin: 0 auto;
      display: block;
      background: #FFF;">


      <img src="img/acceptmesse.png" style="width: 100%;" alt="#" />

        <p style="color: #C0A671;
        margin: 0px;
        text-align: center;
        margin-bottom: 10px;
        margin-top: 10px;
        float: left;
        font-size: 12px;">しばらくたってもメールが受信されないようでしたら、
        お手数ですが下記までご連絡くださいますようお願いいたします。
        </p>

      <img src="img/acceptbanner.png" style="width: 100%;" alt="採用に関するお問い合わせ" />
    
    </div>

    <?php clear() ?>

    </div>



  </div>
</div>　
</body>
</html>