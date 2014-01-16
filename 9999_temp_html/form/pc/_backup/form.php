<?php
include 'inc/formhearder.php';
?>

<div id="main" class="fotmstart">
<div id="main_inner">


<h1>
  <img src="img/replacementface.png" class="replacementface" alt="#" />
  <img src="img/headerimg.png" class="headerimg" alt="#" />
</h1>
<div class="formbox">

<h3 class="formItem">
  <p>プロフィール</p>
</h3>

<table class="accepttable">
  <tr class="roootselector">

    <!-- パーツ -->
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">お名前 </span>
      </p>
    </th>
    <td>
      <input class="required" value="" data_title='姓' >
      <input class="required" value="" data_title='名' >
    </td>
  </tr>
  <!-- /パーツ -->

  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">ふりがな </span>
      </p>
    </th>
    <td>
      <input class="required" value="" data_title='姓(ひらがな)' >
      <input class="required" value="" data_title='名(ひらがな)' >
    </td>
  </tr>
  <!-- /パーツ -->

  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">性別 </span>
      </p>
    </th>
    <td>
      <input type="radio" class="required radioinput" name="sex" value="女性" checked >女性 
      <input type="radio" class="required radioinput" name="sex" value="男性" >男性 
    </td>
  </tr>
  <!-- /パーツ -->

  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">生年月日 </span>
      </p>
    </th>
    <td>
      <select class="inputselect required selecrdateyear">
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
        <option value="1969">1969</option>
        <option value="1968">1968</option>
        <option value="1967">1967</option>
        <option value="1966">1966</option>
        <option value="1965">1965</option>
        <option value="1964">1964</option>
        <option value="1963">1963</option>
        <option value="1962">1962</option>
        <option value="1961">1961</option>
        <option value="1960">1960</option>
        <option value="1959">1959</option>
        <option value="1958">1958</option>
        <option value="1957">1957</option>
        <option value="1956">1956</option>
        <option value="1955">1955</option>
        <option value="1954">1954</option>
        <option value="1953">1953</option>
        <option value="1952">1952</option>
        <option value="1951">1951</option>
        <option value="1950">1950</option>
        <option value="1949">1949</option>
        <option value="1948">1948</option>
        <option value="1947">1947</option>
        <option value="1946">1946</option>
        <option value="1945">1945</option>
        <option value="1944">1944</option>
        <option value="1943">1943</option>
        <option value="1942">1942</option>
        <option value="1941">1941</option>
        <option value="1940">1940</option>
        <option value="1939">1939</option>
        <option value="1938">1938</option>
        <option value="1937">1937</option>
        <option value="1936">1936</option>
        <option value="1935">1935</option>
        <option value="1934">1934</option>
        <option value="1933">1933</option>
        <option value="1932">1932</option>
        <option value="1931">1931</option>
        <option value="1930">1930</option>
        <option value="1929">1929</option>
        <option value="1928">1928</option>
        <option value="1927">1927</option>
        <option value="1926">1926</option>
        <option value="1925">1925</option>
        <option value="1924">1924</option>
        <option value="1923">1923</option>
        <option value="1922">1922</option>
        <option value="1921">1921</option>
        <option value="1920">1920</option>
        <option value="1919">1919</option>
        <option value="1918">1918</option>
        <option value="1917">1917</option>
        <option value="1916">1916</option>
        <option value="1915">1915</option>
        <option value="1914">1914</option>
        <option value="1913">1913</option>
        <option value="1912">1912</option>
        <option value="1911">1911</option>
        <option value="1910">1910</option>
        <option value="1909">1909</option>
        <option value="1908">1908</option>
        <option value="1907">1907</option>
        <option value="1906">1906</option>
        <option value="1905">1905</option>
        <option value="1904">1904</option>
        <option value="1903">1903</option>
        <option value="1902">1902</option>
        <option value="1901">1901</option>
        <option value="1900">1900</option>
      </select>
      <select class="inputselect required selecrdate">
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
      <select class="inputselect required selecrdate">
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
    </td>
  </tr>
  <!-- /パーツ -->
  
  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">郵便番号 </span>
      </p>
    </th>
    <td>
      <input id="zip" class="post_1 validate_number required form_txt-number" data_num='3' value="" placeholder="例：101" >- 
      <input id="zip1" class="post_2 validate_number required form_txt-number" data_num='4' value="" placeholder="例：0021" >
    </td>
  </tr>
  <!-- /パーツ -->


  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">都道府県 </span>
      </p>
    </th>
    <td>
      <select name="pref" id="pref" size="1" tabindex="5" class="inputselect required">
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
        <option value="99">海外</option>
      </select>
    </td>
  </tr>
  <!-- /パーツ -->
  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">住所
          <br/>(市区町郡村) 
        </span>
      </p>
    </th>
    <td>
      <input class="inputaddres required" value="" data_num='50' data_title='住所(市区町郡村)' name="addr" id="addr" class="form_txt-normal" placeholder="例：千代田区外神田1-1" >
    </td>
  </tr>
  <!-- /パーツ -->
  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">電話番号 </span>
      </p>
    </th>
    <td>
      <input class="inputtell required validate_number" value="" data_num='12' data_title='電話番号' >
    </td>
  </tr>
  <!-- /パーツ -->
  <!-- パーツ -->
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">　 E-MAIL　 </span>
      </p>
    </th>
    <td>
      <input class="inputemail required" value="" data_title='E-MAIL' >
    </td>
  </tr>
  <!-- /パーツ -->
</table>
</div>
<div class="formbox">
<h3 class="formItem">
  <p>質問</p>
</h3>
<table class="accepttable">
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">　 テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト </span>
      </p>
    </th>
    <td>
      <select name="" tabindex="5" class="inputselect">
        <option value="1">項目1</option>
        <option value="2">項目2</option>
        <option value="3">項目3</option>
      </select>
    </td>
  </tr>
  <tr>
    <th>
      <p class="inputitem">
        <img src="img/must.png" class="inputmust" alt="#" />
        <span class="inputitemname">　 テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト </span>
      </p>
    </th>
    <td>
      <select name="" tabindex="5" class="inputselect">
        <option value="1">項目1</option>
        <option value="2">項目2</option>
        <option value="3">項目3</option>
      </select>
    </td>
  </tr>
  <tr>
    <th>
      <p class="inputitem">
        <span class="inputitemname">テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト </span>
      </p>
    </th>
    <td>
      <select name="" tabindex="5" class="inputselect">
        <option value="1">項目1</option>
        <option value="2">項目2</option>
        <option value="3">項目3</option>
      </select>
    </td>
  </tr>
</table>
</div>





<div class="formbox termform" >
<h3 class="formItem">
  <img src="img/termicon.png" class="formItemIcon" alt="#" />
  <img src="img/termstr.png" class="formItemTitle" alt="#" />
</h3>
<center>
  <img src="img/term.png" class="termpng" alt="#" />
</center>
<img src="img/consent.png" class="formbottomright" id="formsubmit" alt="#" />
</div>




<?php
include 'inc/formfooter.php';
?>
