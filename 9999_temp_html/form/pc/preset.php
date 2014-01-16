
<?php

/*

●バリデーションクラス名
.validate_required
.validate_number
.validate_alpha
.validate_characterlimit
.validate_email
.validate_checkbox_radio

<ul class="input_checkbox_radio validate_checkbox_radio" data_title='チェックボックス1'>
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




<div id="main" class="fotmstart">
<div id="main_inner">


<h1>
  <img src="img/replacementface.png" class="replacementface" alt="#" />
  <img src="img/headerimg.png" class="headerimg" alt="エントリー必要事項" />
</h1>


<form action="http://example.jp/smp/main/index/fasdkjflasdjflasjflas" method="POST">



<!-- 注意文章 -->
<div class="note">
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
  <p>ちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんぶんちゅういぶんちゅ</p>
</div>



<!-- グループ -->
<div class="formbox">
  
  <h3 class="formItem">
    <p>***グループ名***</p>
  </h3>


  <p class="formItemTitle_Sub">
    サブタイトルサブタイトルサブタイトルサブタイトルサブタイトルサブタイトル
  </p>


  <table class="accepttable">
    
    <!-- フィールド -->

    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          姓名 </span>
          </p>
        </th>
      <td>
        <input type="text" id="Form27Field237_0" name="data[Form27][Field237][0]" class="preset_text_name validate_required" data_title="姓" /> 
        <input type="text" id="Form27Field237_1" name="data[Form27][Field237][1]" class="preset_text_name validate_required" data_title="名" />     
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
        <input type="hidden" value="237" class="field_id">
      </td>
    </tr>




    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          姓名(フリガナ)</span>
          </p>
        </th>
        <td>
        <input type="text" id="Form27Field240_0" name="data[Form27][Field240][0]" class="preset_text_name_furigana validate_required" data_title="ふりがな(姓)" /> <input type="text"   id="Form27Field240_1" name="data[Form27][Field240][1]" class="preset_text_name_furigana validate_required"   data_title="ふりがな(名)" /> <input type="hidden" value="240" class="field_id">
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
      </td>
    </tr>

    

    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          年月</span>
          </p>
        </th>
        <td>


        <select id="Form27Field243_0" name="data[Form27][Field243][0]" class="preset_select_year_month validate_required" data_title="年月(年)">
          <option value="-" >▽選択して下さい</option>
          <option value="1900" >1900</option><option value="1901" >1901</option><option value="1902" >1902</option><option value="1903" >1903</option><option value="1904" >1904</option><option value="1905" >1905</option><option value="1906" >1906</option><option value="1907" >1907</option><option value="1908" >1908</option><option value="1909" >1909</option><option value="1910" >1910</option><option value="1911" >1911</option><option value="1912" >1912</option><option value="1913" >1913</option><option value="1914" >1914</option><option value="1915" >1915</option><option value="1916" >1916</option><option value="1917" >1917</option><option value="1918" >1918</option><option value="1919" >1919</option><option value="1920" >1920</option><option value="1921" >1921</option><option value="1922" >1922</option><option value="1923" >1923</option><option value="1924" >1924</option><option value="1925" >1925</option><option value="1926" >1926</option><option value="1927" >1927</option><option value="1928" >1928</option><option value="1929" >1929</option><option value="1930" >1930</option><option value="1931" >1931</option><option value="1932" >1932</option><option value="1933" >1933</option><option value="1934" >1934</option><option value="1935" >1935</option><option value="1936" >1936</option><option value="1937" >1937</option><option value="1938" >1938</option><option value="1939" >1939</option><option value="1940" >1940</option><option value="1941" >1941</option><option value="1942" >1942</option><option value="1943" >1943</option><option value="1944" >1944</option><option value="1945" >1945</option><option value="1946" >1946</option><option value="1947" >1947</option><option value="1948" >1948</option><option value="1949" >1949</option><option value="1950" >1950</option><option value="1951" >1951</option><option value="1952" >1952</option><option value="1953" >1953</option><option value="1954" >1954</option><option value="1955" >1955</option><option value="1956" >1956</option><option value="1957" >1957</option><option value="1958" >1958</option><option value="1959" >1959</option><option value="1960" >1960</option><option value="1961" >1961</option><option value="1962" >1962</option><option value="1963" >1963</option><option value="1964" >1964</option><option value="1965" >1965</option><option value="1966" >1966</option><option value="1967" >1967</option><option value="1968" >1968</option><option value="1969" >1969</option><option value="1970" >1970</option><option value="1971" >1971</option><option value="1972" >1972</option><option value="1973" >1973</option><option value="1974" >1974</option><option value="1975" >1975</option><option value="1976" >1976</option><option value="1977" >1977</option><option value="1978" >1978</option><option value="1979" >1979</option><option value="1980" >1980</option><option value="1981" >1981</option><option value="1982" >1982</option><option value="1983" >1983</option><option value="1984" >1984</option><option value="1985" >1985</option><option value="1986" >1986</option><option value="1987" >1987</option><option value="1988" >1988</option><option value="1989" >1989</option><option value="1990" >1990</option><option value="1991" >1991</option><option value="1992" >1992</option><option value="1993" >1993</option><option value="1994" >1994</option><option value="1995" >1995</option><option value="1996" >1996</option><option value="1997" >1997</option><option value="1998" >1998</option><option value="1999" >1999</option><option value="2000" >2000</option><option value="2001" >2001</option><option value="2002" >2002</option><option value="2003" >2003</option><option value="2004" >2004</option><option value="2005" >2005</option><option value="2006" >2006</option><option value="2007" >2007</option><option value="2008" >2008</option><option value="2009" >2009</option><option value="2010" >2010</option><option value="2011" >2011</option><option value="2012" >2012</option><option value="2013" >2013</option>
        </select>
        <span class="inputauxiliary">年</span>
        
        <select  id="Form27Field243_1" name="data[Form27][Field243][1]" class="preset_select_year_month validate_required" data_title="年月(月)">

        <option value="-" >▽選択して下さい</option>
        <option value="1" >1</option><option value="2" >2</option><option value="3" >3</option><option value="4" >4</option><option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option>
        </select><span class="inputauxiliary">月</span>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
        <input type="hidden" value="243" class="field_id">
      </td>
      </tr>
      <!-- フィールド -->



  </table>
  <input type="hidden" value="1" class="group_id">
</div>
<!-- グループ -->





<!-- グループ -->
<div class="formbox">


  <h3 class="formItem">
    <p>***グループ名***</p>
  </h3>
  
  <p class="formItemTitle_Sub">
    サブタイトルサブタイトルサブタイトルサブタイトルサブタイトルサブタイトル
  </p>


  <table class="accepttable">
    
    <!-- フィールド -->




      <!--///////////////////////////////////////
      項目
      ///////////////////////////////////////-->
      <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          郵便番号</span>
          </p>
        </th>
        <td>
        
      <!-- <input type="text"   id="Form27Field238_0" name="data[Form27][Field238][0]" class="preset_text_post validate_number validate_characterlimit validate_required"  data_num="3" data_title="郵便番号" /> 

      <input type="text"   id="Form27Field238_1" name="data[Form27][Field238][1]" class="preset_text_post validate_number validate_characterlimit validate_required"  data_num="4" data_title="郵便番号" /> -->
        
        <input type="text"  id="Form27Field238_0" name="data[Form27][Field238][0]" class="preset_text_post validate_number validate_characterlimit validate_required post_1"  data_num="3" data_title="郵便番号1" /> 
        <span class="inputauxiliary">-</span>
        <input type="text" id="Form27Field238_1" name="data[Form27][Field238][1]" class="preset_text_post validate_number validate_characterlimit validate_required post_2"  data_num="4" data_title="郵便番号2" />
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
        <input type="hidden" value="238" class="field_id">
      </td>
    </tr>
  





    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          都道府県</span>
          </p>
        </th>
        <td>

        <!-- <select  id="Form27Field241_0" name="data[Form27][Field241][0]" class="preset_select_pref validate_required" > -->
        <select id="Form27Field241_0" name="data[Form27][Field241][0]" class="preset_select_pref validate_required addressselect" data_title="都道府県">

          <option value="-" >▽選択して下さい</option>
          <option value="1" >北海道</option><option value="2" >青森県</option><option value="3" >岩手県</option><option value="4" >宮城県</option><option value="5" >秋田県</option><option value="6" >山形県</option><option value="7" >福島県</option><option value="8" >茨城県</option><option value="9" >栃木県</option><option value="10" >群馬県</option><option value="11" >埼玉県</option><option value="12" >千葉県</option><option value="13" >東京都</option><option value="14" >神奈川県</option><option value="15" >新潟県</option><option value="16" >富山県</option><option value="17" >石川県</option><option value="18" >福井県</option><option value="19" >山梨県</option><option value="20" >長野県</option><option value="21" >岐阜県</option><option value="22" >静岡県</option><option value="23" >愛知県</option><option value="24" >三重県</option><option value="25" >滋賀県</option><option value="26" >京都府</option><option value="27" >大阪府</option><option value="28" >兵庫県</option><option value="29" >奈良県</option><option value="30" >和歌山県</option><option value="31" >鳥取県</option><option value="32" >島根県</option><option value="33" >岡山県</option><option value="34" >広島県</option><option value="35" >山口県</option><option value="36" >徳島県</option><option value="37" >香川県</option><option value="38" >愛媛県</option><option value="39" >高知県</option><option value="40" >福岡県</option><option value="41" >佐賀県</option><option value="42" >長崎県</option><option value="43" >熊本県</option><option value="44" >大分県</option><option value="45" >宮崎県</option><option value="46" >鹿児島県</option><option value="47" >沖縄県</option></select>     <input type="hidden" value="241" class="field_id">
          <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
      </td>
    </tr>



    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          住所</span>
          </p>
        </th>
        <td>

        <input type="text" id="Form27Field245_0" name="data[Form27][Field245][0]" class="preset_text_address validate_required addressinput inputaddres" data_title="住所" />     
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
        <input type="hidden" value="245" class="field_id">
      </td>
    </tr>






    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          月　日</span>
          </p>
        </th>
        <td>
        <select id="Form27Field244_0" name="data[Form27][Field244][0]" class="preset_select_month_day validate_required" data_title="月日(月)">
          <option value="-" >▽選択して下さい</option>
          <option value="1" >1</option><option value="2" >2</option><option value="3" >3</option><option value="4" >4</option><option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option></select>
        <span class="inputauxiliary">月</span>
        
        <select id="Form27Field244_1" name="data[Form27][Field244][1]" class="preset_select_month_day validate_required" data_title="月日(日)">
          <option value="-" >▽選択して下さい</option>
          <option value="1" >1</option><option value="2" >2</option><option value="3" >3</option><option value="4" >4</option><option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option><option value="25" >25</option><option value="26" >26</option><option value="27" >27</option><option value="28" >28</option><option value="29" >29</option><option value="30" >30</option><option value="31" >31</option></select>
        <span class="inputauxiliary">日</span>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>

        <input type="hidden" value="244" class="field_id">
      </td>
    </tr>



    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          ラジオボタン</span>
          </p>
        </th>
        <td>

        <ul class="input_checkbox_radio" data_title='ラジオボタン'>
          <li><input type="radio" name="test3" value="その1" ><span class="chkboxname">その1</span></li>
          <li><input type="radio" name="test3" value="その2"> <span class="chkboxname">その2</span></li>
          <li><input type="radio" name="test3" value="その3"> <span class="chkboxname">その3</span></li>
          <li><input type="radio" name="test3" value="その4"> <span class="chkboxname">その4</span></li>
          <li><input type="radio" name="test3" value="その5"> <span class="chkboxname">その5</span></li>
        </ul>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>


      </td>
    </tr>



    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          ラジオボタン2</span>
          </p>
        </th>
        <td>

        <ul class="input_checkbox_radio validate_checkbox_radio" data_title='ラジオボタン'>
          <li><input type="radio" name="test4" value="その1" > <span class="chkboxname">その1</span></li>
          <li><input type="radio" name="test4" value="その2"> <span class="chkboxname">その2</span></li>
          <li><input type="radio" name="test4" value="その3"> <span class="chkboxname">その3</span></li>
          <li><input type="radio" name="test4" value="その4"> <span class="chkboxname">その4</span></li>
          <li><input type="radio" name="test4" value="その5"> <span class="chkboxname">その5</span></li>
        </ul>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>

      </td>
    </tr>



    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          チェックボックス</span>
          </p>
        </th>
        <td>

        <ul class="input_checkbox_radio validate_checkbox_radio" data_title='チェックボックス1'>
          <li><input type="checkbox" name="test" value="その1"> <span class="chkboxname">その1</span></li>
          <li><input type="checkbox" name="test" value="その2"> <span class="chkboxname">その2</span></li>
          <li><input type="checkbox" name="test" value="その3"> <span class="chkboxname">その3</span></li>
          <li><input type="checkbox" name="test" value="その4"> <span class="chkboxname">その4</span></li>
          <li><input type="checkbox" name="test" value="その5"> <span class="chkboxname">その5</span></li>
        </ul>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>

      </td>
    </tr>

    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          チェックボックス2</span>
          </p>
        </th>
        <td>

        <ul class="input_checkbox_radio" data_title='チェックボックス'>
          <li><input type="checkbox" name="test1" value="その1"> <span class="chkboxname">その1</span></li>
          <li><input type="checkbox" name="test1" value="その2"> <span class="chkboxname">その2</span></li>
          <li><input type="checkbox" name="test1" value="その3"> <span class="chkboxname">その3</span></li>
          <li><input type="checkbox" name="test1" value="その4"> <span class="chkboxname">その4</span></li>
          <li><input type="checkbox" name="test1" value="その5"> <span class="chkboxname">その5</span></li>
        </ul>
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>


      </td>
    </tr>





    <!-- フィールド -->
  </table>

  <input type="hidden" value="2" class="group_id">
</div>
<!-- グループ -->






<!-- グループ -->
<div class="formbox">
    

  <h3 class="formItem">
    <p>***グループ名***</p>
  </h3>

  <p class="formItemTitle_Sub">
    サブタイトルサブタイトルサブタイトルサブタイトルサブタイトルサブタイトル
  </p>


  <table class="accepttable">
    
    <!-- フィールド -->

      <!--///////////////////////////////////////
      項目
      ///////////////////////////////////////-->
      <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          電話番号</span>
          </p>
        </th>
        <td>

        <input type="text"   id="Form27Field239_0" name="data[Form27][Field239][0]" class="preset_text_tel validate_number validate_characterlimit validate_required inputtell"  data_num="4" data_title="電話番号1" /><span class="inputauxiliary">-</span>
        <input type="text"   id="Form27Field239_1" name="data[Form27][Field239][1]" class="preset_text_tel validate_number validate_characterlimit validate_required inputtell"  data_num="4" data_title="電話番号2" /><span class="inputauxiliary">-</span>
        <input type="text"   id="Form27Field239_2" name="data[Form27][Field239][2]" class="preset_text_tel validate_number validate_characterlimit validate_required inputtell"  data_num="4" data_title="電話番号3" />
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
        <input type="hidden" value="239" class="field_id">
    
      </td>
    </tr>
    

      <!--///////////////////////////////////////
      項目
      ///////////////////////////////////////-->
      <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          　E-MAIL　</span>
          </p>
        </th>
        <td>
          <input class="validate_email validate_required inputemail" value="" data_title='E-MAIL' >
          <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
      </td>
    </tr>



    <!--///////////////////////////////////////
    項目
    ///////////////////////////////////////-->
    <tr class="rootselector">
        <th>
          <p class="inputitem">
          <img src="img/must.png" class="inputmust" alt="#" />
          <span class="inputitemname">
          誕生日       </span>
          </p>
        </th>
        <td>
        <select  id="Form27Field242_0" name="data[Form27][Field242][0]" class="preset_select_birthday validate_required" data_title="誕生日(年)">


          <option value="-" >▽選択して下さい</option>
          <option value="1900" >1900</option><option value="1901" >1901</option><option value="1902" >1902</option><option value="1903" >1903</option><option value="1904" >1904</option><option value="1905" >1905</option><option value="1906" >1906</option><option value="1907" >1907</option><option value="1908" >1908</option><option value="1909" >1909</option><option value="1910" >1910</option><option value="1911" >1911</option><option value="1912" >1912</option><option value="1913" >1913</option><option value="1914" >1914</option><option value="1915" >1915</option><option value="1916" >1916</option><option value="1917" >1917</option><option value="1918" >1918</option><option value="1919" >1919</option><option value="1920" >1920</option><option value="1921" >1921</option><option value="1922" >1922</option><option value="1923" >1923</option><option value="1924" >1924</option><option value="1925" >1925</option><option value="1926" >1926</option><option value="1927" >1927</option><option value="1928" >1928</option><option value="1929" >1929</option><option value="1930" >1930</option><option value="1931" >1931</option><option value="1932" >1932</option><option value="1933" >1933</option><option value="1934" >1934</option><option value="1935" >1935</option><option value="1936" >1936</option><option value="1937" >1937</option><option value="1938" >1938</option><option value="1939" >1939</option><option value="1940" >1940</option><option value="1941" >1941</option><option value="1942" >1942</option><option value="1943" >1943</option><option value="1944" >1944</option><option value="1945" >1945</option><option value="1946" >1946</option><option value="1947" >1947</option><option value="1948" >1948</option><option value="1949" >1949</option><option value="1950" >1950</option><option value="1951" >1951</option><option value="1952" >1952</option><option value="1953" >1953</option><option value="1954" >1954</option><option value="1955" >1955</option><option value="1956" >1956</option><option value="1957" >1957</option><option value="1958" >1958</option><option value="1959" >1959</option><option value="1960" >1960</option><option value="1961" >1961</option><option value="1962" >1962</option><option value="1963" >1963</option><option value="1964" >1964</option><option value="1965" >1965</option><option value="1966" >1966</option><option value="1967" >1967</option><option value="1968" >1968</option><option value="1969" >1969</option><option value="1970" >1970</option><option value="1971" >1971</option><option value="1972" >1972</option><option value="1973" >1973</option><option value="1974" >1974</option><option value="1975" >1975</option><option value="1976" >1976</option><option value="1977" >1977</option><option value="1978" >1978</option><option value="1979" >1979</option><option value="1980" >1980</option><option value="1981" >1981</option><option value="1982" >1982</option><option value="1983" >1983</option><option value="1984" >1984</option><option value="1985" >1985</option><option value="1986" >1986</option><option value="1987" >1987</option><option value="1988" >1988</option><option value="1989" >1989</option><option value="1990" >1990</option><option value="1991" >1991</option><option value="1992" >1992</option><option value="1993" >1993</option><option value="1994" >1994</option><option value="1995" >1995</option><option value="1996" >1996</option><option value="1997" >1997</option><option value="1998" >1998</option><option value="1999" >1999</option><option value="2000" >2000</option><option value="2001" >2001</option><option value="2002" >2002</option><option value="2003" >2003</option><option value="2004" >2004</option><option value="2005" >2005</option><option value="2006" >2006</option><option value="2007" >2007</option><option value="2008" >2008</option><option value="2009" >2009</option><option value="2010" >2010</option><option value="2011" >2011</option><option value="2012" >2012</option><option value="2013" >2013</option></select>
        <span class="inputauxiliary">年</span>
        

        <select  id="Form27Field242_1" name="data[Form27][Field242][1]" class="preset_select_birthday validate_required" data_title="誕生日(月)">

          <option value="-" >▽選択して下さい</option>
          <option value="1" >1</option><option value="2" >2</option><option value="3" >3</option><option value="4" >4</option><option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option></select>
        <span class="inputauxiliary">月</span>
        

        <select  id="Form27Field242_2" name="data[Form27][Field242][2]" class="preset_select_birthday validate_required" data_title="誕生日(日)">

          <option value="-" >▽選択して下さい</option>
          <option value="1" >1</option><option value="2" >2</option><option value="3" >3</option><option value="4" >4</option><option value="5" >5</option><option value="6" >6</option><option value="7" >7</option><option value="8" >8</option><option value="9" >9</option><option value="10" >10</option><option value="11" >11</option><option value="12" >12</option><option value="13" >13</option><option value="14" >14</option><option value="15" >15</option><option value="16" >16</option><option value="17" >17</option><option value="18" >18</option><option value="19" >19</option><option value="20" >20</option><option value="21" >21</option><option value="22" >22</option><option value="23" >23</option><option value="24" >24</option><option value="25" >25</option><option value="26" >26</option><option value="27" >27</option><option value="28" >28</option><option value="29" >29</option><option value="30" >30</option><option value="31" >31</option></select>
        <span class="inputauxiliary">日</span>
        <input type="hidden" value="242" class="field_id">
        <p class="supplement">補足分補足分補足分<br/>補足分補足分補足分<br/>補足分補足分補足分<br/></p>
      </td>
      
      </tr>
      <!-- フィールド -->
      

  </table>
  <input type="hidden" value="3" class="group_id">
</div>
<!-- グループ -->



<div class="formbox termform" >

   <h3 class="formItem">
    <img src="img/termicon.png" class="formItemIcon" alt="弊社会員規約" />
    <p class="formItemTitle" >***グループ名***</p>
  </h3>
  
  <center>
    <p class="termmesse"><a href="termmesse_a">会員規約</a></p>
    <input type="checkbox" class="termmchk" value="true"><span class="chkboxname">会員規約に同意する</span>
  </center>


  <p class="formbottomright" id="formsubmit">会員規約に同意する</p>

</div>

</form>


</div>
</div>



<style>

/*文字カラー設定*/

/*---------フォームタイトル/*---------*/
#wrap .inputitem,
#wrap .termmesse a,
#wrap #formsubmit{
  /*color: red;*/
}

/*---------補助文/*---------*/
#wrap .supplement {
   color: red;
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
#wrap .formbox {
   /*background: red;*/
}

.accepttable tr{
  /*border: solid red 10px;*/
}

/*---------フォームタイトル/*---------*/
#wrap .termmesse,
#wrap .inputitem{
   background: red;
}

/*---------フォーム背景/*---------*/
#wrap input{
  /*background: red;*/
}

/*---------入力フォーム/*---------*/
#wrap input,
#wrap select,
#wrap textarea{
  /*background: red;*/
}

/*---------決定ボタン/*---------*/
#formsubmit{
  /*background: red;*/
}

</style>



</body>
</html>


