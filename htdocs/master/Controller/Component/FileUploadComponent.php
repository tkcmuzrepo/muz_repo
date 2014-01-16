<?php
/**
* @author 2008/07/22 11:40:55 赤羽根
*
* ■概要
*
* ファイルアップロードを管理するクラス
* アップロード時にリサイズをする事もあるので
* その部分の処理は、resize_imgクラスに依存します
*
* validateメソッドの$typeはメンバ変数$allowedMimeの"key"を指定して下さい。
*
* ※注意
*
*	1. ファイルのアップロード時は<form enctype="multipart/form-data">が必要だから気をつけて
*
*	2. アップロードするファイル名が日本語の場合、リネームをしないとファイル名が化けます。
*	   validateで日本語名ファイルをエラーチェック{$jp_ng_flg=TRUE}するか、アップロード時に{$rename_flg=TRUE}にしてください。
*
*   3. validateのMIMEタイプチェックは、【画像ファイル以外は】完全ではありません。
*	   なぜなら拡張子でMIMEタイプを判別しているからです。
*	   MIMEタイプ取得関数で、mime_content_typeがありますが、精度がとても低く信用できません。
*	   画像以外のファイルでバリデーションチェックする場合、check_mime_typeメソッドを拡張して下さい。
*	   (１行目のパターンなどから判断する方法等で)
*	   それが前提になります。
*
* ■更新履歴
*
*/

/*
# -----------------
# サンプル
# -----------------
require_once("resize_img.php");
require_once("fileUpload.php");

$file = new FileUpload();

# アップロードされているか
if( $file->is_set("user_data")){

	# バリデーション
	if( $file->validate("user_data" , 1900 , "img" , 1 , 0)){

		# アップロード
		if(!$res = $file->upload("user_data" , "./upload/m/" , null, false ,100,100)){
			echo $file->err_msg;
		}
		if(!$res = $file->upload("user_data" , "./upload/s/" , null, false ,50,50)){
			echo $file->err_msg;
		}
	}else{
		echo $file->err_msg;
	}
}
# -------------------------
# cake ver サンプル
# -------------------------

if($this->data){
	if($this->FileUpload->is_set("fdata")){
		# バリデーション
		if( $this->FileUpload->validate("fdata" , 1900 , "img" , 1 , 0)){
			# アップロード
			if(!$res = $this->FileUpload->upload("fdata" , USER_DATA , false, false ,30,30)){
				v($this->FileUpload->err_type);
			}
			$this->data["User"]["image_path"] = (basename($res));
		}else{
			v($this->FileUpload->err_type);
		}
	}
	if($this->Diary->save($this->data)){
			$this->redirect("./");
		}
	}
}
*/

require_once("resize_img.php");

class FileUploadComponent extends Component{

	var $components = array("ResizeImg");
	
	# ファイル要領MAXサイズ
	var $size = 100000;
	
	# $_FILES
	var $file;
	
	# 対象ファイルが画像か
	var $img_flg; 
	
	# ファイル名に日本語が含まれないか、もしくは正しいファイル名かチェックする正規表現
	var $file_name_regix = '/^[a-zA-Z0-9|_|-]+(\.)*[a-zA-Z0-9]+$/';
	
	# MIMEタイプ
	var $mime_type;
	
	var $err_type_ary = array();
	var $err_msg_ary = array();

 	public function initialize(Controller $controller) {
		
		$this->controller=$controller;
		$this->file = array();
		if(isset($_FILES)){
			$this->file = $_FILES;
		}
  	}

	#
	# @author Kiyosawa 
	# @date 
	function __construct(){
	}
	
	#
	# ファイルがアップロードされているかチェック
	#
	function is_set($input_name){
		return (isset($this->file[$input_name]["name"]) 
				and $this->file[$input_name]["name"] 
				and $this->file[$input_name]["type"] 
				and $this->file[$input_name]["tmp_name"] 
				and $this->file[$input_name]["size"]
		);
	}

	#
	# ファイルのアップロード
	# 
	# $input_name			<input name="">
	# $upload_file_path 	アップロードするパス
	# $upload_file_name 	保存名。指定が無ければ date("YMDHIS") .uniqid("b")
	# $rename_flg 			名前をリネームするか（不特定多数が同ディレクトリにファイルをアップロードする場合は1）0：しない
	# $width				リサイズ時：最大横
	# $height				リサイズ時：最大縦
	#
	function upload($input_name , $upload_file_path , $upload_file_name ="" , $rename_flg=0  , $width="", $height="")
	{
		
		// アップロード時も最低限バリデーションをかける
		$this->img_flg = false;
		if(!$this->validate($input_name)){
			return false;
		}
		
		//ファイル名が指定されていない時
		if(!$upload_file_name){
			//元の名前のまま
			if(!$rename_flg) {
				$upload_file_name = $this->file[$input_name]["name"][$this->controller->MuzFormImage->name]['image_path'];
			}
			//ユニークな名前を生成
			else{
				$upload_file_name = date("is") . "_" . substr(uniqid("b") , 5 , 4) .".";				
				# 拡張子はアップロード時のものと同じ
				$pathinfo = (pathinfo($this->file[$input_name]["name"][$this->controller->MuzFormImage->name]['image_path']));
				$ext = $pathinfo["extension"];
				$upload_file_name .= $ext;
			}
		}
		
		if(!file_exists($upload_file_path)){
				$this->err_type = 1;
				$this->err_msg = __LINE__ . ":ディレクトリが存在しません";
				return false;
		}
		
		$upload_file = $upload_file_path . $upload_file_name;
		
		# 画像ファイルでリサイズ指定がされていたら
		$set_resize = ($width or $height) ? true : false;
		if($this->img_flg and $set_resize){
			
			$this->resize_img=new resizeImg();
			$tmp_name=$this->file[$input_name]['tmp_name'][$this->controller->MuzFormImage->name]['image_path'];
			$res=$this->resize_img->resize($tmp_name, $width, $height, $upload_file);			
			
			if($res[0] == 1){
				# アップロードパスを返却
				return ($res[1]);
			}else{
				return false;
			}
		}
		# 通常ファイル
		else {
			$result  = move_uploaded_file($this->file[$input_name]['tmp_name'][$this->controller->MuzFormImage->name]['image_path'], $upload_file);
			if($result === false){
				return false;
			} else {
				# アップロードパスを返却
				return $upload_file;
			}
		}
	}
	
	
	/**
	 *
	 * @author Kiyosawa 
	 * @date 
	 */
	function validateParent($input_name  , $size="" , $type="" , $null_ng_flg = 0 , $jp_ng_flg = 0){
		for($i=0;$i<count($input_name);$i++){
			$validateBox[$input_name[$i]] = $this->validate($input_name[$i] , $size="" , $type="" , $null_ng_flg = 0 , $jp_ng_flg = 0);
		}
	}
	
	
	# ファイルのアップロードチェック
	#
	# text    $input_name
	# int     $size (KB)
	# string  $type "img","pdf" など
	# bool    $null_ng_flg 1の時は NULL でエラー
	# bool    $jp_ng_flg 1の時はファイルが日本語名でエラー。
	#		  ※日本語ファイル名を許可する場合、アップロード時は必ずリネームをかけないと化けます
	#
	function validate($input_name  , $size="" , $type="" , $null_ng_flg = 0 , $jp_ng_flg = 0)
	{

		#来てる
		# MIMEタイプをセット
		$this->mime_type = $this->get_mime_type($input_name);
		
		$this->size = ($size) ? $size : $this->size;
		# null時　許可をしていない場合、false
		#     　　許可している場合、true
		
		if(!isset($this->file[$input_name])){
			if($null_ng_flg){
				$this->err_type_ary[$input_name] = $this->err_type = 2;
				$this->err_msg_ary[$input_name]['message'] = $this->err_msg = "ファイルが追加されていません";
				$this->err_msg_ary[$input_name]['err_type'] = 2;
				v(__LINE__);
				return false;
			}else{
				return true;
			}
		}
		
		# 不正チェック
		#if(!is_uploaded_file($this->file[$input_name]["tmp_name"])){
		if(!is_uploaded_file($this->file[$input_name]["tmp_name"][$this->controller->MuzFormImage->name]['image_path'])){
				
				$error_mes="追加されたファイル【{$this->file[$input_name]}['name'][$this->controller->MuzFormImage->name]['image_path']】は不正です";
				$this->err_type_ary[$input_name] = $this->err_type = 3;
				$this->err_msg_ary[$input_name]['message'] = $this->err_msg = $error_mes;
				$this->err_msg_ary[$input_name]['err_type'] = 3;
				return false;
		}
		
		# ファイルタイプチェック
		if($type){
			if(!$this->check_mime_type($this->mime_type , $type)){
			
				$error_mes="ファイル名【{$this->file[$input_name]['name'][$this->controller->MuzFormImage->name]['image_path']}】は形式が違います";
				$this->err_type_ary[$input_name] = $this->err_type = 5;
				$this->err_msg_ary[$input_name]['message'] = $this->err_msg=$error_mes;
				$this->err_msg_ary[$input_name]['err_type'] = 5;
				return false;
			}
		}
		
		# ファイル名チェック
		if($jp_ng_flg and !preg_match($this->file_name_regix , $this->file[$input_name]["name"][$this->controller->MuzFormImage->name]['name'])){
			
			$error_mes="ファイル名【{$this->file[$input_name]['name'][$this->controller->MuzFormImage->name]['image_path']}】に使用出来ない文字が存在します（日本語ファイル名はダメ:{$this->file[$input_name]["name"][$this->controller->MuzFormImage->name]['image_path']}）";
			$this->err_type_ary[$input_name] = $this->err_type = 6;
			$this->err_msg_ary[$input_name]['message'] = $this->err_msg=$error_mes;
			$this->err_msg_ary[$input_name]['err_type'] = 6;
			return false;
		}
		
		# サイズチェック
		if($this->size){
			$data_size = $this->file[$input_name]["size"][$this->controller->MuzFormImage->name]['image_path']/1024 ;
			if($data_size > $this->size){
				
				$error_mes="ファイル名【{$this->file[$input_name]['name'][$this->controller->MuzFormImage->name]['image_path']}】はサイズが大きすぎです{$data_size}KB > {$size}KB";
				$this->err_type_ary[$input_name] = $this->err_type = 4;
				$this->err_msg_ary[$input_name]['message'] = $this->err_msg=$error_mes;
				$this->err_msg_ary[$input_name]['err_type'] = 4;
				return false;
			}
		}
		return true;
	}
	#
	# ファイルの種類をチェック
	# 
	# return bool 
	#
	function check_mime_type($mime_type,$type){
		#echo $mime_type;
		return (in_array($mime_type , $this->allowedMime[$type]));
	}
	
	#
	# MIMEタイプを取得する
	#  一括でMIMEタイプを判断する方法は無いので
	#  案件毎にここを拡張しなくてはいけません
	#
	# return string MIMEタイプ
	# 
	function get_mime_type($input_name){
		return $this->_get_mime_type($input_name);
	}
	function _get_mime_type($input_name){
		
		if(!isset($this->file[$input_name])) return null ;
		
		// 画像の場合mimeタイプ取得
		if($info = @getimagesize($this->file[$input_name]["tmp_name"][$this->controller->MuzFormImage->name]['image_path'])){
			$this->img_flg = 1;
			return $info["mime"];
		
		}
		// PHPでmimeタイプを取得
		// いまいち精度が悪い。
		/*
		if (empty($info) && function_exists('mime_content_type')) {
			$mime = mime_content_type($this->file[$input_name]["tmp_name"]);
			if($mime) return $mime;
		}
		*/
		
		// ブラウザ情報を返す
		// 画像以外はこの方法になるが、
		// セキュリティとしては低度なので注意。画像以外の時は多少考えないとだめ。。
		return $this->file[$input_name]["type"];
	}
	# MIMEタイプチェックリスト
	var $allowedMime = array( 
		//HTML
		"html" => array(
			"text/html",
		),
		//CSV
		"csv" => array(
			'application/octet-stream',
			"application/vnd.ms-excel",
			"text/csv"
		),
		//GIF画像
		"gif" => array(
			'image/gif',
		),
		//JPG画像
		"jpg" => array(
			'image/jpeg',
			'image/pjpeg',
		),
		//PNG画像
		"png" => array(
			'image/png',
		),
		//画像全般
		"img" => array(
			  'image/jpeg',
			  'image/pjpeg', 
			  'image/png', 
			  'image/gif', 
			  'application/x-shockwave-flash'
			  #'image/x-tiff', 
		),
		//PDFファイル
		"pdf" => array(
			  'application/pdf',                // pdf
			  'application/x-pdf', 
			  'application/acrobat', 
			  'text/pdf',
			  'text/x-pdf', 
		),
		//テキストファイル
		"text" => array(
			  'text/plain',                     // text
		),
		//ワードファイル
		"word" => array(
			  'application/msword',             // word
		),
		//パワーポイント
		"powerpoint" => array(
			  'application/mspowerpoint',       // powerpoint
			  'application/powerpoint',
			  'application/vnd.ms-powerpoint',
			  'application/x-mspowerpoint',
		),
		// エクセル
		"excel" => array(
			  'application/x-msexcel',          // excel
			  'application/excel',
			  'application/x-excel',
			  'application/vnd.ms-excel',
		),
		//圧縮ファイル
		"compressed" => array(
			  'application/x-compressed',       // compressed files
			  'application/x-zip-compressed',
			  'application/zip',
			  'multipart/x-zip',
			  'application/x-tar',
			  'application/x-compressed',
			  'application/x-gzip',
			  'application/x-gzip',
			  'multipart/x-gzip'
		),
		"swf" => array(
			'application/x-shockwave-flash'
		)
   );

}//END class
?>