<?php
/*
* GD自動サムネイル作成 + 中川修正2006/02/03
* 
* Copyright 2002- Akihiro Asai. All rights reserved.
* http://aki.adam.ne.jp
* aki@mx3.adam.ne.jp
* 
* □ 機能概要
* ・指定されたイメージのサムネイルを表示します。
* ・出力する大きさを指定する事ができます。
* ・出力されるイメージのアスペクト比は維持されます。
* 
* □ 更新履歴
* 2002/08/19 最大縦幅の部分を一部手直し
* 2003/01/31 デフォルトでアスペクト比が固定
* 2003/04/11 最大横幅と最大縦幅を外部より指定可能
* 2003/04/25 GD2用に関数変更
* 2003/06/21 GD1/2をバージョンに応じて変更できるように修正
* 2003/06/25 imageCopyResampledの部分を修正
* 2004/01/28 スクリプト全体を書き直し。引数「pass」を「path」に変更。
* 2005/12/08 関数の自動判別 gif形式に対応 透過gif・透過pngに対応（GD2.0.1以降）  
*/

/*
# ---------------------------------
# サンプル
# ---------------------------------
$img = new resizeImg();
$resize = $img->resize("./red_yoko.gif", 100, 100, null, false , false);
if($resize[0]==false){
	echo $resize[1];
}
*/

#class ResizeImgComponent extends Component{
class ResizeImg{
	
	//最大横
	var $imgMaxWidth;
	
	//最大縦
	var $imgMaxHeight;
	
	//元画像を削除するか
	var $del_flg = 0;
	
	//許可する画像形式
	var $allow_img_type = array(
		 1 # gif
		,2 # jpg
		,3 # png
	);
	// リサイズ後のファイル名のプレフィックス：upload_fpathを使用しない時の自動リネーム
	var $prefix = "re_";
	
	/*
 	public function initialize(Controller $controller) {
		
		$this->controller=$controller;
		if(!empty($controller->params->data)){
			$this->sendData=$controller->params->data;
		}
  	}
	*/
	
	/*
	* サムネイル画像の作成
	*
	* string $path 元の画像パス
	* integer $width 最大縦
	* integer $height 最大横
	* string $upload_fpath 出力ファイル名
	* bool $del_flg 元の画像を削除するか 0:しない 1:する
	* bool $header 画像を生成せずに単にサムネイラーとして出力される
	*/
	function resize($path, $width, $height, $upload_fpath="", $del_flg="" , $header = false) {
		
		# ファイル名に指定が無ければ、$prefix+元のファイル名
		if(!$upload_fpath){
			$info = pathinfo($path);
			$info["basename"] = $this->prefix .$info["basename"];
			$upload_fpath = $info["dirname"] ."/". $info["basename"];
		}
		
		if($del_flg === "") $del_flg = $this->del_flg;
		
		if(!isset($path)) {
			return array(0, "イメージのパスが設定されていません。");
		}
		
		if(!file_exists($path)) {
			return array(0, "指定されたパスにファイルが見つかりません。:{$path}");
		}
		
		// 画像の大きさをセット
		if($width) $this->imgMaxWidth = $width;
		if($height) $this->imgMaxHeight = $height;
		
		$size = @GetimageSize($path);
		//print_r($size);exit;
		$re_size = $size;
		
		//アスペクト比固定処理
		if($this->imgMaxWidth != 0) {
			$tmp_w = $size[0] / $this->imgMaxWidth;
		}
		
		if($this->imgMaxHeight != 0) {
			$tmp_h = $size[1] / $this->imgMaxHeight;
		}

		if($tmp_w > 1 || $tmp_h > 1) {
			if($this->imgMaxHeight == 0) {
				if($tmp_w > 1) {
					$re_size[0] = $this->imgMaxWidth;
					$re_size[1] = $size[1] * $this->imgMaxWidth / $size[0];
				}
			} else {
				if($tmp_w > $tmp_h) {
					$re_size[0] = $this->imgMaxWidth;
					$re_size[1] = $size[1] * $this->imgMaxWidth / $size[0];
				} else {
					$re_size[1] = $this->imgMaxHeight;
					$re_size[0] = $size[0] * $this->imgMaxHeight / $size[1];
				}
			}
		}
		
		$imagecreate = function_exists("imagecreatetruecolor") ? "imagecreatetruecolor" : "imagecreate";
		$imageresize = function_exists("imagecopyresampled") ? "imagecopyresampled" : "imagecopyresized";

		// 許可する画像リストになかった場合
		if(!in_array($size[2],$this->allow_img_type)){
			return array(0, "この画像形式は許可されていません。");
		}

		switch($size[2]) {
			
			// gif形式
			case "1":
				if(function_exists("imagecreatefromgif")) {
					$src_im = imagecreatefromgif($path);
					$upload_im = $imagecreate($re_size[0], $re_size[1]);
					
					$transparent = imagecolortransparent($src_im);
					$colorstotal = imagecolorstotal ($src_im);
					
					$upload_im = imagecreate($re_size[0], $re_size[1]);
					if (0 <= $transparent && $transparent < $colorstotal) {
						imagepalettecopy ($upload_im, $src_im);
						imagefill ($upload_im, 0, 0, $transparent);
						imagecolortransparent ($upload_im, $transparent);
					}
          			$imageresize($upload_im, $src_im, 0, 0, 0, 0, $re_size[0], $re_size[1], $size[0], $size[1]);

					if(function_exists("imagegif")) {						
						// 画像出力
						if($header){
							header("Content-Type: image/gif");
							imagegif($upload_im);
							return "";
						}else{
						
							$path_ary=explode('.',$upload_fpath);
							$upload_fpath=$upload_fpath;
							if($path_ary[count($path_ary)-1]!='gif'){
								$upload_fpath.='.gif';
							}
							
							#$upload_fpath = $upload_fpath . ".gif";
		                    if($re_size[0] == $size[0] && $re_size[1] == $size[1]) {
		                        // サイズが同じ場合には、そのままコピーする。(画質劣化を防ぐ）           
		                        copy($path, $upload_fpath);
		                    } else {
		                        imagegif($upload_im, $upload_fpath);
		                    }
						}						
						imagedestroy($src_im);
						imagedestroy($upload_im);
					} else {
						// 画像出力
						if($header){
							header("Content-Type: image/png");
							imagepng($upload_im);
							return "";
						}else{
							#$upload_fpath = $upload_fpath . ".png";
		                    if($re_size[0] == $size[0] && $re_size[1] == $size[1]) {
		                        // サイズが同じ場合には、そのままコピーする。(画質劣化を防ぐ）           
		                        copy($path, $upload_fpath);
		                    } else {
		                        imagepng($upload_im, $upload_fpath);
		                    }
						}
						imagedestroy($src_im);
						imagedestroy($upload_im);
					}
				} else {
					// サムネイル作成不可の場合（旧バージョン対策）
					$upload_im = imageCreate($re_size[0], $re_size[1]);
					imageColorAllocate($upload_im, 255, 255, 214); //背景色
					
					// 枠線と文字色の設定
					$black = imageColorAllocate($upload_im, 0, 0, 0);
					$red = imageColorAllocate($upload_im, 255, 0, 0);
					
					imagestring($upload_im, 5, 10, 10, "GIF $size[0]x$size[1]", $red);
					imageRectangle ($upload_im, 0, 0, ($re_size[0]-1), ($re_size[1]-1), $black);
					
					// 画像出力
					if($header){
						header("Content-Type: image/png");
						imagepng($upload_im);
						return "";
					}else{
						#$upload_fpath = $upload_fpath . ".png";
						imagepng($upload_im, $upload_fpath);
					}
					imagedestroy($src_im);
					imagedestroy($upload_im);
				}
				break;
				
			// jpg形式
			case "2": 
			
				$src_im = imageCreateFromJpeg($path);
				$upload_im = $imagecreate($re_size[0], $re_size[1]);
                
                $imageresize( $upload_im, $src_im, 0, 0, 0, 0, $re_size[0], $re_size[1], $size[0], $size[1]);

				// 画像出力
				if($header){
					header("Content-Type: image/jpeg");
					imageJpeg($upload_im);
					return "";
				}else{
					#$upload_fpath = $upload_fpath . ".jpg";

					$path_ary=explode('.',$upload_fpath);
					$upload_fpath=$upload_fpath;
					if($path_ary[count($path_ary)-1]!='jpg'){
						$upload_fpath.='.jpg';
					}
                    
                    if($re_size[0] == $size[0] && $re_size[1] == $size[1]) {
                        // サイズが同じ場合には、そのままコピーする。(画質劣化を防ぐ）       
                        copy($path, $upload_fpath);
                    } else {
                        imageJpeg($upload_im, $upload_fpath);
                    }
				}
				
				imagedestroy($src_im);
				imagedestroy($upload_im);      			
				break;
    
			// png形式    
			case "3": 

				$src_im = imageCreateFromPNG($path);
				
				$colortransparent = imagecolortransparent($src_im);
				if ($colortransparent > -1) {
					$upload_im = $imagecreate($re_size[0], $re_size[1]);
					imagepalettecopy($upload_im, $src_im);
					imagefill($upload_im, 0, 0, $colortransparent);
					imagecolortransparent($upload_im, $colortransparent);
					imagecopyresized($upload_im,$src_im, 0, 0, 0, 0, $re_size[0], $re_size[1], $size[0], $size[1]);
				} else {				
					$upload_im = $imagecreate($re_size[0], $re_size[1]);
					imagecopyresized($upload_im,$src_im, 0, 0, 0, 0, $re_size[0], $re_size[1], $size[0], $size[1]);
					
					(imagecolorstotal($src_im) == 0) ? $colortotal = 65536 : $colortotal = imagecolorstotal($src_im);
					
					imagetruecolortopalette($upload_im, true, $colortotal);
				}
				
				// 画像出力
				if($header){
					header("Content-Type: image/png");
					imagepng($upload_im);
					return "";
				}else{
					
					$path_ary=explode('.',$upload_fpath);
					$upload_fpath=$upload_fpath;
					if($path_ary[count($path_ary)-1]!='png'){
						$upload_fpath.='.png';
					}
					
                    if($re_size[0] == $size[0] && $re_size[1] == $size[1]) {
                        // サイズが同じ場合には、そのままコピーする。(画質劣化を防ぐ）           
                        copy($path, $upload_fpath);
                    } else {
                        imagepng($upload_im, $upload_fpath);
                    }
				}
				imagedestroy($src_im);
				imagedestroy($upload_im);
				
				break;
				
			default:
				return array(0, "イメージの形式が不明です。");
		}
		# 2008/07/18 09:45:32 赤羽根 権限付加
		@chmod( dirname($upload_fpath), 0755);
		
		# 2008/07/18 09:38:07 赤羽根 元画像削除処理
		if($this->del_flg){
			@unlink($path);
		}
		return array(1, $upload_fpath);
	}
}

?>