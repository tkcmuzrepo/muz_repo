function Zip(){
/*
 *	■郵便番号から住所情報の自動入力処理( zipaddr7.js Ver7.14 )
 *
 *	The use is free of charge. / ご利用は無料です。
 *	@demo    http://zipaddr.com/
 *	@link    http://www.pierre-soft.com/
 *	@author  Tatsuro, Terunuma <info@pierre-soft.com>
 *
 *	[htmlの定義]
 *	<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>  or
 *
 *	<script src="http://zipaddr.com/js/zipaddr7.js" charset="UTF-8"></script>  or
 *	<script src="https://zipaddr-com.ssl-xserver.jp/js/zipaddr7.js" charset="UTF-8"></script>
 *
 * 	[html内のid名見直し]
 *	郵便番号,都道府県(select),区市町村,住所
 *	 zip     pref             city     addr
 */
//	共通
this.pt= "1";       // 都道府県select欄 1:id, 2:名称
this.pn= "1";       // 都道府県idの桁数 2:2桁
this.sl= "---選択"; // option[0]
this.sc= "";        // value
this.lin="----------"; // 都道府県(Group)区切り
this.dli="-";       // 郵便番号の区切り
this.mrk="〒";
this.wa= "workarea";// null:ガイダンスなし, etc:id名(workarea)旧バージョン用
this.bgc="#009999"; // x-wa bgcolor
this.lnc="#ffffcc"; // link color
this.fweight="";    // 文字の太さ
this.design="1";    // ガイダンスのデザイン、sp:通常,1:コンパクト版
this.family="ヒラギノ角ゴ Pro W3,Hiragino Kaku Gothic Pro,メイリオ,Meiryo,ＭＳ Ｐゴシック,sans-serif";
this.debug="";      // 1:debug-mode
//
this.min= "4";      // 拡張用(mini)
this.sel= "10";     // 拡張用(selectc)
this.wok= "";       // 拡張用(1:企業を除く)
this.left=22;       // offsetLeft
this.top= 18;       // offsetTop
this.emsg="1";      // 1:エラーメッセージを阻止する
this.welcart="";    // 1:on
this.eccube="";     // 1:on
this.smart= "";     // SmartPhone 1:jQuery-mobile,2:etc
this.guide= "&nbsp;@head@pageNL@lineNL&nbsp;@count@close&nbsp;@zipaddr"; // G-layout、NL:改行
this.contract="WRRS2uQhW66E"; // 契約コード(c)

//  郵便番号(7桁/上3)用　下4桁      都道府県          市区町村          地域
this.zp= "zip";  this.zp1= "zip1";  this.pr= "pref";  this.ci= "city";  this.ad= "addr";
this.zp2="zip2"; this.zp21="zip21"; this.pr2="pref2"; this.ci2="city2"; this.ad2="addr2";
this.zp3="zip3"; this.zp31="zip31"; this.pr3="pref3"; this.ci3="city3"; this.ad3="addr3";
this.zp4="zip4"; this.zp41="zip41"; this.pr4="pref4"; this.ci4="city4"; this.ad4="addr4";
this.zp5="zip5"; this.zp51="zip51"; this.pr5="pref5"; this.ci5="city5"; this.ad5="addr5";
this.zp6="zip6"; this.zp61="zip61"; this.pr6="pref6"; this.ci6="city6"; this.ad6="addr6";
//        zip7, zip71, pref7, city7, addr7        // zip7～以降は上記体系で名称は固定です。
this.zipmax=6;                                    // 7個以上の設置はこの値を変更して拡張します。
/*	<-↑ 以上はオウンコーディングで変更可能です-> */

this.zipaddr= "zipaddr";
this.xvr= "7.14";
this.xzp= "";       // zip(key)
this.xzz= "";       // -
this.xpr= "";       // pref
this.xci= "";       // city
this.xad= "";       // addr
this.p= new Array();
this.p1=new Array();
this.r= new Array();
this.i= new Array();
this.a= new Array();
this.xul= new Array(3);
this.xuls=new Array(3);
this.xuse= 0;       // 1:論理チェックok
this.xlisten= "";   // 1:ｷIE,2:IE
}
var ZP= new Zip;
Zip.fcs=function(){Zip.nfcs(ZP.zp, ZP.zp1);};Zip.fcs2=function(){Zip.nfcs(ZP.zp2,ZP.zp21);};Zip.fcs3=function(){Zip.nfcs(ZP.zp3,ZP.zp31);};Zip.fcs4=function(){Zip.nfcs(ZP.zp4,ZP.zp41);};Zip.fcs5=function(){Zip.nfcs(ZP.zp5,ZP.zp51);};Zip.fcs6=function(){Zip.nfcs(ZP.zp6,ZP.zp61);};Zip.nfcs=function(zp,zp1){var keys=document.getElementById(zp).value;keys=Zip.zenk_hank(keys);keys=keys.replace(/-/g, '');keys=keys.replace(/\s/g,'');if(keys.length==3 ) document.getElementById(zp1).focus();};Zip.inp=function(){ZP.xzp=ZP.zp; ZP.xzz=ZP.zp1; ZP.xpr=ZP.pr; ZP.xci=ZP.ci; ZP.xad=ZP.ad; Zip.chk();};Zip.inp2=function(){ZP.xzp=ZP.zp2;ZP.xzz=ZP.zp21;ZP.xpr=ZP.pr2;ZP.xci=ZP.ci2;ZP.xad=ZP.ad2;Zip.chk();};Zip.inp3=function(){ZP.xzp=ZP.zp3;ZP.xzz=ZP.zp31;ZP.xpr=ZP.pr3;ZP.xci=ZP.ci3;ZP.xad=ZP.ad3;Zip.chk();};Zip.inp4=function(){ZP.xzp=ZP.zp4;ZP.xzz=ZP.zp41;ZP.xpr=ZP.pr4;ZP.xci=ZP.ci4;ZP.xad=ZP.ad4;Zip.chk();};Zip.inp5=function(){ZP.xzp=ZP.zp5;ZP.xzz=ZP.zp51;ZP.xpr=ZP.pr5;ZP.xci=ZP.ci5;ZP.xad=ZP.ad5;Zip.chk();};Zip.inp6=function(){ZP.xzp=ZP.zp6;ZP.xzz=ZP.zp61;ZP.xpr=ZP.pr6;ZP.xci=ZP.ci6;ZP.xad=ZP.ad6;Zip.chk();};Zip.entry=function(){if(typeof zipaddr_ownb==="function" )  zipaddr_ownb();Zip.urlgen();Zip.Module();if(ZP.debug =="1" ) Zip.debug();if(ZP.eccube=="1"&&typeof Zip.eccube ==="function" ) Zip.eccube();if(ZP.welcart=="1"&&typeof Zip.welcart==="function" ) Zip.welcart();if(ZP.smart!=""  &&typeof Zip.SPhone ==="function" ) Zip.SPhone();if(typeof zipaddr_eccube==="function" )zipaddr_eccube();if(typeof zipaddr_own ==="function" ) zipaddr_own();Zip.named(ZP.zp); Zip.named(ZP.zp1); Zip.named(ZP.pr); Zip.named(ZP.ci); Zip.named(ZP.ad);Zip.named(ZP.zp2);Zip.named(ZP.zp21);Zip.named(ZP.pr2);Zip.named(ZP.ci2);Zip.named(ZP.ad2);Zip.named(ZP.zp3);Zip.named(ZP.zp31);Zip.named(ZP.pr3);Zip.named(ZP.ci3);Zip.named(ZP.ad3);Zip.named(ZP.zp4);Zip.named(ZP.zp41);Zip.named(ZP.pr4);Zip.named(ZP.ci4);Zip.named(ZP.ad4);Zip.named(ZP.zp5);Zip.named(ZP.zp51);Zip.named(ZP.pr5);Zip.named(ZP.ci5);Zip.named(ZP.ad5);Zip.named(ZP.zp6);Zip.named(ZP.zp61);Zip.named(ZP.pr6);Zip.named(ZP.ci6);Zip.named(ZP.ad6);Zip.set(ZP.zp, ZP.zp1, 1);Zip.set(ZP.zp2,ZP.zp21,2);Zip.set(ZP.zp3,ZP.zp31,3);Zip.set(ZP.zp4,ZP.zp41,4);Zip.set(ZP.zp5,ZP.zp51,5);Zip.set(ZP.zp6,ZP.zp61,6);Zip.maxset();if(ZP.xuse==0&&ZP.emsg!="1" ) alert("There is not a target(zipaddrc.js)");if(ZP.xuse==1 ) Zip.zipaddrc();if(typeof zipaddr_owna==="function" )  zipaddr_owna();};Zip.debug=function(){var ans="Start-"+ZP.zipaddr+"_Ver"+ZP.xvr+"\n";ans+="EC-CUBE: "+ZP.eccube +"\n";ans+="Welcart: "+ZP.welcart+"\n";ans+="SmartPhone:"+ZP.smart+"\n";alert(ans);};Zip.maxset=function(){for( i=7;i<=ZP.zipmax;i++){ZP.p[i]="zip" + i;ZP.p1[i]="zip" + i +"1";ZP.r[i]="pref"+ i;ZP.i[i]="city"+ i;ZP.a[i]="addr"+ i;Zip.named(ZP.p[i]);Zip.named(ZP.p1[i]);Zip.named(ZP.r[i]);Zip.named(ZP.i[i]);Zip.named(ZP.a[i]);Zip.set(ZP.p[i], ZP.p1[i], i);}};Zip.set=function(zip,zip1, i){if(document.getElementById(zip)&&document.getElementById(zip1)){var obj=document.getElementById(zip); ZP.xuse=1;Zip.setime(obj);if(ZP.smart==""){Zip.set1(obj, i);}var obj=document.getElementById(zip1);Zip.setime(obj);Zip.set2(obj, i);}else if(document.getElementById(zip)){var obj=document.getElementById(zip); ZP.xuse=1;Zip.setime(obj);Zip.set2(obj, i);}};Zip.set1=function(obj, i){if(i==1 ) Zip.addEv(obj, 'keyup', Zip.fcs  );else {if(i >=7){var cmnd="Zip.fcs"+ i +"=function(){Zip.nfcs(ZP.p["+ i +"],ZP.p1["+ i +"]);};";try { eval(cmnd); }catch(e){alert(cmnd+"?1");}}var cmnd="Zip.addEv(obj,'keyup',Zip.fcs"+ i +");";try { eval(cmnd); }catch(e){alert(cmnd+"?2");}}};Zip.set2=function(obj, i){if(i==1 ) Zip.addEv(obj, 'keyup', Zip.inp  );else {if(i >=7){var cmnd="Zip.inp"+ i +"=function(){ZP.xzp=ZP.p["+ i +"];ZP.xzz=ZP.p1["+ i +"];";cmnd+="ZP.xpr=ZP.r["+ i +"];ZP.xci=ZP.i["+ i +"];ZP.xad=ZP.a["+ i +"];Zip.chk();};";try { eval(cmnd); }catch(e){alert(cmnd+"?3");}}var cmnd="Zip.addEv(obj,'keyup',Zip.inp"+ i +");";try { eval(cmnd); }catch(e){alert(cmnd+"?4");}}};Zip.addEv=function(obj,type,func){if(obj.addEventListener){obj.addEventListener(type,func,false);ZP.xlisten="1";}else if(obj.attachEvent){obj.attachEvent('on'+type,func);ZP.xlisten="2";}};Zip.named=function(id){if(document.getElementsByName(id)&&!document.getElementById(id)){var elm=document.getElementsByName(id);if(elm.length==1 ) elm[0].id=id;}};Zip.setime=function(obj){obj.style.imeMode="disabled";};Zip.zenk_hank=function(data){var zenk="０１２３４５６７８９ー－‐―";var hank="0123456789----";var ans="";for( var i=0;i<data.length;i++){var s=data.charAt(i);var n=zenk.indexOf(s,0);if(n >=0 ) s=hank.charAt(n);ans+=s;}return ans;};Zip.urlgen=function(){ZP.xul[0]="%u3044a%u3046sp%u3044-f%u3042or%u3046m.j%u3042p";ZP.xul[1]="%u3042z%u3046i%u3044pa%u3042d%u3046dr.co%u3042m";ZP.xuls[0]="ss1.co%u3044res%u3046sl.jp/"+ ZP.xul[0];ZP.xuls[1]="zipaddr-com.s%u3046sl-x%u3044server.jp";};Zip.zipaddrc=function(){var n=1;var url=location.protocol=="https:" ?  ZP.xuls[n] : ZP.xul[n];url=unescape(url);url=url.replace(/う/g,'');url=url.replace(/あ/g,'');url=url.replace(/い/g,'');url=url.replace(/え/g,'');var us=location.protocol +'/'+'/'+ url +"/js/ziparc7.php?v=86";Zip.scall(us);};Zip.scall=function(us){var s=document.createElement("script");s.setAttribute("type","text/javascript");s.setAttribute("src",us);s.setAttribute("charset","UTF-8");document.body.appendChild(s);};Zip.Module=function(){var smt="";var ua=navigator.userAgent;if((ua.indexOf('iPhone')>0&&ua.indexOf('iPad')==-1)||ua.indexOf('Android')>0){smt="1";}if(typeof fnCallAddress==="function"){ZP.eccube="1";if(ZP.smart==""&&smt=="1" ) ZP.smart="2";}else if(typeof uscesL10n!="undefined"&&document.getElementById("zipcode")){ZP.welcart="1";if(ZP.smart==""&&smt=="1" ) ZP.smart="2";}else if(ZP.smart!=""){;}else if(smt=="1" ) ZP.smart="2";};Zip.eccube=function(){ZP.zp= "zip01";ZP.zp1="zip02";ZP.pr= "pref";ZP.ad= "addr01";ZP.zp2="deliv_zip01";ZP.zp21="deliv_zip02";ZP.pr2="deliv_pref";ZP.ad2="deliv_addr01";ZP.zp3="order_zip01";ZP.zp31="order_zip02";ZP.pr3="order_pref";ZP.ad3="order_addr01";ZP.zp4="shipping_zip01";ZP.zp41="shipping_zip02";ZP.pr4="shipping_pref";ZP.ad4="shipping_addr01";ZP.top= 21;ZP.sl= "都道府県を選択";ZP.contract="BkbEqEhhBe9z";};Zip.welcart=function(){ZP.zp="zipcode";ZP.ad="address1";var id0="pref";var id1= "member_pref";var id2="customer_pref";var id3="delivery_pref";if(document.getElementById(id0) ) ZP.pr=id0;else if(document.getElementById(id1) ) ZP.pr=id1;else if(document.getElementById(id2) ) ZP.pr=id2;else if(document.getElementById(id3) ) ZP.pr=id3;};Zip.SPhone=function(){ZP.min="7";ZP.left=30;ZP.top=25;ZP.dli="";ZP.sl="都道府県を選択して下さい。";};if(window.addEventListener){window.addEventListener('load',Zip.entry,true);}else if(window.attachEvent){window.attachEvent('onload',Zip.entry,true);}try{$(document).on('pageinit',function(e){ZP.smart="1";Zip.entry();});}catch(e){;}