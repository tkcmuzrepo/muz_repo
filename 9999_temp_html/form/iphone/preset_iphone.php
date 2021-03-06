
<?php
/*

●バリデーションクラス名
.validate_required
.validate_number
.validate_alpha
.validate_characterlimit
.validate_email
.validate_checkbox


例/
<ul class="validate_checkbox validate_required" data_title='チェックボックス'>
<li><input type="checkbox" name="test" value="その1"> <span class="chkboxname">その1</span></li>
<li><input type="checkbox" name="test" value="その2"> <span class="chkboxname">その2</span></li>
<li><input type="checkbox" name="test" value="その3"> <span class="chkboxname">その3</span></li>
<li><input type="checkbox" name="test" value="その4"> <span class="chkboxname">その4</span></li>
<li><input type="checkbox" name="test" value="その5"> <span class="chkboxname">その5</span></li>
</ul>



●住所入力処理クラス名

.post_1 //〒番号1
.post_2 //〒番号2

.addressselect　 //都道府県セレクト部分
.addressinput　　//住所入力部分

※
select　'-'の場合バリデーションエラーとなる
*/

?>




<div id="main" class="formstart">
<div id="main_inner">

<div class="fitimg">
  <img src="img/info.png" class="" alt="#" />
</div>

<!-- 注意文章 -->
<div class="note">
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
</div>


<form action="http://example.jp/smp/main/index/fasdkjflasdjflasjflas" method="POST">
<div class="formbox">
  <h3 class="clearfix">プロフィール</h3>

   <p class="formItemTitle_Sub clearfix">
    サブタイトルサブタイトルサブタイトルサブタイトルサブタイトルサブタイトル
  </p>


      <div class="inputitem clearfix">
          <p class="inputitemname">お名前<span class="inputmust">●</span></p>

          <input 
          type="text"
          class="validate_required validate_characterlimit" 
          value=""
          data_num='20' 
          data_title='姓'
          placeholder="姓"
          >

          <input 
          type="text"
          class="validate_required validate_characterlimit leftinput" 
          value=""
          data_num='20' 
          data_title='名'
          placeholder="名"
          >

          <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>

      </div>
        

     <div class="inputitem clearfix">
       <p class="inputitemname">ふりがな<span class="inputmust">●</span></p>
          
          <input
          type="text"
          class="validate_required validate_characterlimit" 
          value="" 
          data_num='20' 
          data_title='姓(ひらがな)'
          placeholder="姓(ひらがな)"
          >

          <input 
          type="text"
          class="validate_required validate_characterlimit leftinput" 
          value="" 
          data_num='20' 
          data_title='名(ひらがな)'
          placeholder="名(ひらがな)" 
          >

          <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>

      </div>



      <div class="inputitem clearfix">
        <p class="inputitemname">性別<span class="inputmust">●</span></p>
        <input 
        type="radio" 
        class="validate_required radioinput" 
        name="sex" 
        value="女性" 
        checked
        >
        
        <span class="inputUnit">女性</span> 

        <input type="radio" 
        class="validate_required radioinput" 
        name="sex" 
        value="男性"
        >

        <span class="inputUnit">男性</span> 

        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>

      </div>



      <div class="inputitem clearfix">
        <p class="inputitemname">チェックボックス<span class="inputmust">●</span></p>


        <ul class="validate_checkbox validate_required" data_title='チェックボックス'>
          <li><input type="checkbox" name="test" value="その1"> <span class="chkboxname">その1</span></li>
          <li><input type="checkbox" name="test" value="その2"> <span class="chkboxname">その2</span></li>
          <li><input type="checkbox" name="test" value="その3"> <span class="chkboxname">その3</span></li>
          <li><input type="checkbox" name="test" value="その4"> <span class="chkboxname">その4</span></li>
          <li><input type="checkbox" name="test" value="その5"> <span class="chkboxname">その5</span></li>
        </ul>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
      </div>



     <div class="inputitem clearfix">
        <p class="inputitemname">チェックボックス2<span class="inputmust">●</span></p>


        <ul class="validate_checkbox validate_required" data_title='チェックボックス'>
          <li><input type="checkbox" name="test2" value="その1"> <span class="chkboxname">その1</span></li>
          <li><input type="checkbox" name="test2" value="その2"> <span class="chkboxname">その2</span></li>
          <li><input type="checkbox" name="test2" value="その3"> <span class="chkboxname">その3</span></li>
          <li><input type="checkbox" name="test2" value="その4"> <span class="chkboxname">その4</span></li>
          <li><input type="checkbox" name="test2" value="その5"> <span class="chkboxname">その5</span></li>
        </ul>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
      </div>

      <div class="inputitem clearfix">
        <p class="inputitemname">生年月日<span class="inputmust">●</span></p>
      
      <select 
      class="inputselect validate_required selectdateyear"
      data_title='生年月日(年)'
      >
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
      </select><span class="inputUnit">年</span> 
    
      <select
      class="inputselect validate_required selectdate"
      data_title='生年月日(月)'
      >
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
      </select><span class="inputUnit">月</span> 

      <select
      class="inputselect validate_required selectdate"
      data_title='生年月日(日)'
      >
        
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
      </select><span class="inputUnit"></span> 

      <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
     </div>


      <div class="inputitem clearfix">
        <p class="inputitemname">郵便番号<span class="inputmust">●</span></p>
        
        <input 
        class="validate_number validate_required validate_characterlimit form_txt-number post_1 inputzip" 
        data_num='3' 
        value="" 
        placeholder="" 
        data_title='郵便番号1'
        >

        <p class="inputcenter">-</p>
        <input 
        class="validate_number validate_required validate_characterlimit form_txt-number post_2 inputzip" 
        data_num='4' 
        value="" 
        placeholder=""
        data_title='郵便番号2'
        >
      </div>


     <div class="inputitem clearfix">

        <p class="inputitemname">都道府県<span class="inputmust">●</span></p>
        <select 
        size="1" 
        tabindex="5" 
        class="validate_required addressselect"
        data_title='都道府県'
        >

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

        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
    </div>

    <div class="inputitem clearfix">
        <p class="inputitemname">住所(市区町郡村)<span class="inputmust">●</span></p>
        <input 
        class="validate_required validate_characterlimit addressinput inputmax" 
        value="" 
        data_num='50' 
        data_title='住所(市区町郡村)' 
        class="form_txt-normal addressinput" 
        placeholder="例：千代田区外神田1-1"
        >
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
    </div>

    <div class="inputitem clearfix">
        <p class="inputitemname">電話番号<span class="inputmust">●</span></p>
        <input type="tell" class="preset_text_tel validate_number validate_characterlimit validate_required inputtell"  data_num="4" data_title="電話番号1" /><span class="inputauxiliary">-</span>
        <input type="tell" class="preset_text_tel validate_number validate_characterlimit validate_required inputtell"  data_num="4" data_title="電話番号2" /><span class="inputauxiliary">-</span>
        <input type="tell" class="preset_text_tel validate_number validate_characterlimit validate_required inputtell"  data_num="4" data_title="電話番号3" />
    </div>

    <div class="inputitem clearfix">
          <p class="inputitemname">E-MAIL<span class="inputmust">●</span></p>
          <input
          type="email"
          class="validate_email validate_required validate_characterlimit inputmax" 
          value=""
          data_num='50'
          data_title='E-MAIL'
          placeholder="メールアドレスを入力してください。"
          >
          <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
    </div>
  </div>


  <div class="formbox">
    <h3 class="formItem">質問</h3>

  <p class="formItemTitle_Sub clearfix">
    サブタイトルサブタイトルサブタイトルサブタイトルサブタイトルサブタイトル
  </p>

      <div class="inputitem clearfix">
        <p class="inputitemname">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<span class="inputmust">●</span></p>
        
        <select
        name="" 
        tabindex="5" 
        class="inputselect validate_required"
        data_title='選択項目1'
        >
        <option value="-">▽選択</option>
        <option value="1">項目1</option>
        <option value="2">項目2</option>
        <option value="3">項目3</option>
        </select>

        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
       </div>

      <div class="inputitem clearfix">
        <p class="inputitemname">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<span class="inputmust">●</span></p>
        
        <select
        name="" 
        tabindex="5" 
        class="inputselect validate_required"
        data_title='選択項目2'
        >
        <option value="-">▽選択</option>
        <option value="1">項目1</option>
        <option value="2">項目2</option>
        <option value="3">項目3</option>
        </select>

        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
       </div>


      <div class="inputitem clearfix">
        <p class="inputitemname">ご意見・ご感想<span class="inputmust">●</span></p>
        <textarea
        placeholder="ご意見・ご感想をご記入ください"
        class="validate_required validate_characterlimit" 
        value=""
        data_num='100'
        data_title='ご意見・ご感想'
        placeholder="ご意見・ご感想をご記入ください"
        ></textarea>

        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
       </div>

  </div>
</form> 



    <div class="formbox termform">
      <h3 class="formItem">
        <span class="inputitem_bub">会員規約について</span>
      <img src="img/term.png" class="formItemTitle" alt="#" />
      </h3>

      <div class="inputitem clearfix">
        <p class="linkmessestr">弊社会員規約をお読みください。</p>
        <a href="#" class="linkmesse">会員規約</a>
        <input type="checkbox" class="termmchk" value="true"><span class="chkboxname">会員規約に同意する</span>
      </div>

      <p class="linkmesse_2" id="formsubmit">会員規約に同意する</p>

    </div>


  </div>
</div>






<style>

/*文字カラー設定*/
/*---------フォームタイトル/*---------*/
#wrap .formbox h3{
  /*color: red;*/
}

/*---------補助文/*---------*/
#wrap .inputitemname,
#wrap .linkmessestr{
   /*color: red;*/
}

/*---------注意文/*---------*/
.note{
    /*color: red;*/
}

/*背景の色*/
/*---------全体背景/*---------*/
body{
  /*background: red;*/
}

/*---------グループタイトル/*---------*/
#wrap .formbox h3 {
   /*background: red;*/
}

/*---------グループ背景/*---------*/
#wrap .formItemTitle_Sub,
#wrap .formbox {
   background: red;
}

/*---------フォームタイトル/*---------*/
#wrap .inputitemname{
   background: red;
}

/*---------フォーム背景/*---------*/
#wrap .linkmesse{
  background: red;
}

/*---------入力フォーム/*---------*/
#wrap input,
#wrap select,
#wrap textarea{
  background: red;
}

/*---------決定ボタン/*---------*/
#formsubmit{
  background: red;
}


</style>


</body>
</html>





