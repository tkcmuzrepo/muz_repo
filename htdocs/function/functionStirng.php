<?php
	
	/**
	 * テーブルを格子状に出力する
	 *
	 */
	function roop_tr($unique_id=1 , $bgcolor = "#f4f4f4" , $onmouserOverColor = "#ddffdd"){
		static $no;

		if(!isset($no[$unique_id])){
			$no[$unique_id] = 0;
		}else{
			$no[$unique_id]++;
		}
		if($no[$unique_id] % 2 == 1){
			$res =  "<tr style=\"background-color:{$bgcolor};\" ";
		}
		else{
			$bgcolor= "#ffffff";
			$res =  "<tr ";
		}
		if($onmouserOverColor){
			$res .= "onmouseover=\"this.style.backgroundColor='{$onmouserOverColor}'\"  onmouseout=\"this.style.backgroundColor='{$bgcolor}'\"";
		}
		return $res.">";
	}


	/**
	 * 全角スペース、半角スペースで区切られたものを配列にして返す
	 * フリーワード検索等で使う
	 * @param string $str : 検索ワード <ex> 「晴れ　東京」
	 */
		function space_to_array($str){
			//大文字を小文字に
			$str = str_replace("　"," ",$str);
			$trim = trim($str);
			if($trim){
				//半角スペース多数を１つに
				$preg = preg_replace('/\s{2,}/'," ",$trim);
				$arr = explode(" ", $preg);
				return $arr;
			}
			else{
				return false;
			}
		}

		function convertSjis($str){
			return mb_convert_encoding($str,'SJIS',"UTF-8");
		}

?>
