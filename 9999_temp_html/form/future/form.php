
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
style="
color: #F00;
font-size: 12px;
">必須</span>
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

    
    <div 
    style="margin-top:20px;
    width: 97%;
    margin: 0 auto;"
    >　<img src="img/info.png" alt="#" style="width:100%;"/>
    </div>
    


      <!-- 注意文章 -->
      <div style="font-size: 12px;background: #FFF;">

          <p style="padding:3px;">
            ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ
          </p>
      
          <p style="padding:3px;">
              ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ
          </p>
      </div>



  <form action="index.php" method="POST">

    
    <!-- formbox -->
    <?php formBox() ?>


      <!-- タイトルサブタイトル -->
      <?php formfTitle_subTitle('タイトル','サブタイトルサブタイトルサブタイトル') ?>
      


      <!-- フィールド -->
      <?php fieldDiv() ?>

          <?php fieldfTitleTag("お名前")?>
          <?php inputTag("name1","80px") ?>
          <?php inputTag("name2","80px") ?>
          <?php statement('コメントコメントコメント') ?>

      </div>
      


      <!-- フィールド -->
      <?php fieldDiv() ?>
  
            <?php fieldfTitleTag("ふりがな")?>
            <?php inputTag("kana1","80px") ?>
            <?php inputTag("kana2","80px") ?>
            <?php statement('コメントコメントコメント') ?>

      </div>
      



      <!-- フィールド -->
      <?php fieldDiv() ?>
        <?php fieldfTitleTag("性別")?>

        <?php ul()?>
           <?php li()?>
            <?php radio_checkbox("radio","sex","女性")?>
            <?php itemSupplement("女性")?>

          </li>
          <?php li()?>
            <?php radio_checkbox("radio","sex","男性")?>
            <?php itemSupplement("男性")?>
          </li>
        </ul>

        <?php statement('コメントコメントコメント') ?>

      </div>




      
      <!-- フィールド -->
      <?php fieldDiv() ?>

      <?php fieldfTitleTag("チェックボックス")?>


         <?php ul()?>
           <?php li()?>
            <?php radio_checkbox("checkbox","test","その1")?>
            <?php itemSupplement("その1")?>
          </li>
          <?php li()?>
            <?php radio_checkbox("checkbox","test","その2")?>
            <?php itemSupplement("その2")?>
          </li>
         <?php li()?>
            <?php radio_checkbox("checkbox","test","その3")?>
            <?php itemSupplement("その3")?>
          </li>
         <?php li()?>
            <?php radio_checkbox("checkbox","test","その4")?>
            <?php itemSupplement("その4")?>
          </li>
         <?php li()?>
            <?php radio_checkbox("checkbox","test","その5")?>
            <?php itemSupplement("その5")?>
          </li>
        </ul>

  
      <?php statement('コメントコメントコメント') ?>

      </div>
      


      <!-- フィールド -->
      <?php fieldDiv() ?>

         <?php fieldfTitleTag("生年月日")?>
         <?php selectTag("y") ?>


          <option value="-">▽選択</option>
          <option value="2013">2013</option>
          <option value="2012">2012</option>
          <option value="2011">2011</option>
          <option value="2010">2010</option>
          <option value="2009">2009</option>
          <option value="2008">2008</option>
          <option value="2007">2007</option>
          <option value="2006">2006</option>
          <option value="2005">2005</option>
          <option value="2004">2004</option>
          <option value="2003">2003</option>
          <option value="2002">2002</option>
          <option value="2001">2001</option>
          <option value="2000">2000</option>
          <option value="1999">1999</option>
          <option value="1998">1998</option>
          <option value="1997">1997</option>
          <option value="1996">1996</option>
          <option value="1995">1995</option>
          <option value="1994">1994</option>
          <option value="1993">1993</option>
          <option value="1992">1992</option>
          <option value="1991">1991</option>
          <option value="1990">1990</option>
          <option value="1989">1989</option>
          <option value="1988">1988</option>
          <option value="1987">1987</option>
          <option value="1986">1986</option>
          <option value="1985">1985</option>
          <option value="1984">1984</option>
          <option value="1983">1983</option>
          <option value="1982">1982</option>
          <option value="1981">1981</option>
          <option value="1980">1980</option>
          <option value="1979">1979</option>
          <option value="1978">1978</option>
          <option value="1977">1977</option>
          <option value="1976">1976</option>
          <option value="1975">1975</option>
          <option value="1974">1974</option>
          <option value="1973">1973</option>
          <option value="1972">1972</option>
          <option value="1971">1971</option>
          <option value="1970">1970</option>
        </select>


        <?php itemSupplement("年")?>


        <?php selectTag("m") ?>
          <option value="-">▽選択</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
        </select>


        <?php itemSupplement("月")?>
       
       <?php selectTag("d") ?>

          <option value="-">▽選択</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>

        <?php itemSupplement("")?>

        <?php statement('コメントコメントコメント') ?>


      </div>
      



      <!-- フィールド -->
      <?php fieldDiv() ?>


              <?php fieldfTitleTag("郵便番号")?>

      
              <?php inputTag("zip1","30px") ?>
        
              <span 
              style="padding-left: 5px;
              padding-right: 5px;
              float: left;
              height: 15px;
              line-height: 15px;
              margin-right: 5px;
              ">-</span>

              <?php inputTag("zip2","30px") ?>
              <?php statement('コメントコメントコメント') ?>


      </div>
      




      <!-- フィールド -->
      <?php fieldDiv() ?>

          <?php fieldfTitleTag("住所")?>
          <?php selectTag("eria") ?>


          <option value="-">▽選択</option>
          <option value="1">北海道</option>
          <option value="2">青森県</option>
          <option value="3">岩手県</option>
          <option value="4">宮城県</option>
          <option value="5">秋田県</option>
          <option value="6">山形県</option>
          <option value="7">福島県</option>
          <option value="8">茨城県</option>
          <option value="9">栃木県</option>
          <option value="10">群馬県</option>
          <option value="11">埼玉県</option>
          <option value="12">千葉県</option>
          <option value="13">東京都</option>
          <option value="14">神奈川県</option>
          <option value="15">新潟県</option>
          <option value="16">富山県</option>
          <option value="17">石川県</option>
          <option value="18">福井県</option>
          <option value="19">山梨県</option>
          <option value="20">長野県</option>
          <option value="21">岐阜県</option>
          <option value="22">静岡県</option>
          <option value="23">愛知県</option>
          <option value="24">三重県</option>
          <option value="25">滋賀県</option>
          <option value="26">京都府</option>
          <option value="27">大阪府</option>
          <option value="28">兵庫県</option>
          <option value="29">奈良県</option>
          <option value="30">和歌山県</option>
          <option value="31">鳥取県</option>
          <option value="32">島根県</option>
          <option value="33">岡山県</option>
          <option value="34">広島県</option>
          <option value="35">山口県</option>
          <option value="36">徳島県</option>
          <option value="37">香川県</option>
          <option value="38">愛媛県</option>
          <option value="39">高知県</option>
          <option value="40">福岡県</option>
          <option value="41">佐賀県</option>
          <option value="42">長崎県</option>
          <option value="43">熊本県</option>
          <option value="44">大分県</option>
          <option value="45">宮崎県</option>
          <option value="46">鹿児島県</option>
          <option value="47">沖縄県</option>
        </select>


          <?php statement('コメントコメントコメント') ?>

      </div>
      


      <!-- フィールド -->
      <?php fieldDiv() ?>

          <?php fieldfTitleTag("都道府県")?>
          <?php inputTag("city","90%") ?>
          <?php statement('コメントコメントコメント') ?>

      </div>
      


      <!-- フィールド -->
      <?php fieldDiv() ?>

              <?php fieldfTitleTag("電話番号")?>
              <?php inputTag("tel1","40px") ?>
        
              <span 
              style="padding-left: 5px;
              padding-right: 5px;
              float: left;
              height: 15px;
              line-height: 15px;
              margin-right: 5px;
              ">-</span>
        
              <?php inputTag("tel3","40px") ?>

              <span 
              style="padding-left: 5px;
              padding-right: 5px;
              float: left;
              height: 15px;
              line-height: 15px;
              margin-right: 5px;
              ">-</span>
        
              <?php inputTag("tel3","40px") ?>
              <?php statement('コメントコメントコメント') ?>

      </div>


      
      <!-- フィールド -->
      <?php fieldDiv() ?>
    
         <?php fieldfTitleTag("メールアドレス")?>
         <?php inputTag("mail","90%") ?>
         <?php statement('コメントコメントコメント') ?>

      </div>


      <?php clear() ?>


</div>






    <!-- formbox -->
     <?php formBox() ?>
      

      <!-- タイトルサブタイトル -->
      <?php formfTitle_subTitle('タイトル','サブタイトルサブタイトルサブタイトル') ?>

      

      <!-- フィールド -->
      <?php fieldDiv() ?>
         <?php fieldfTitleTag("その他")?>
              
              <textarea rows="6" 
              style="
              float: left;
              width: 95%;
              border: solid 1px #C9DBE6;
              background: #E9F1F9;
              "></textarea>

        <?php statement('コメントコメントコメント') ?>

      </div>


       <?php clear() ?>



    </div>





    <!-- フィールド -->
    <?php formBox() ?>

      <h3 style="background: #4794CE;
        background: #4794CE;
        position: relative;
        margin: 0px;
        margin-bottom: 13px;
        color: #FFF;
        text-align: left;
        padding-left:10%;
        font-weight: normal;
        line-height: 30px;
        float: left;
        width: 90%;
        font-size: 15px;
        height: 30px;
      ">
      会員規約について
      
      <img
      src="img/term.png" 
      style="width: 22px;
      position: absolute;
      left:0px;
      top:4px;" 
      alt="#"/>
      </h3>


       <?php fieldDiv() ?>
         <?php itemSupplement("弊社会員規約をお読みください。")?>

          
          <a 
          href="#" 
          style="background: #4794CE;
          position: relative;
          margin: 0px;
          margin-bottom: 15px;
          color: #FFF;
          padding-left: 3%;
          font-weight: normal;
          line-height: 30px;
          float: left;
          width: 97%;
          font-size: 13px;
          height: 30px;
          text-align: center;
          text-decoration: none;">
          会員規約</a>


        <?php ul()?>
          <?php li()?>
             <?php radio_checkbox("checkbox","term","true")?>
             <?php itemSupplement("会員規約に同意する")?>
          </li>
        </ul>
      

      </div>
      


      <input 
      type="submit" 
      value="会員規約に同意する" 
      style="background: #C0A671;
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