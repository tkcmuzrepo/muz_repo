<style>

/*文字カラー設定*/
/*---------フォームタイトル/*---------*/
#wrap .formbox h3{
	color:#<?php echo $html_color['site_string_title_color']?>;
}

/*---------補助文/*---------*/
#wrap .inputitemname,
#wrap .linkmessestr{
	color:#<?php echo $html_color['site_string_auxiliary_color'];?>;
}

/*---------注意文/*---------*/
.note{
	color:#<?php echo $html_color['site_string_note_color'];?>;
}

/*背景の色*/
/*---------全体背景/*---------*/
body{
	background:#<?php echo $html_color['site_bg_entire_color'];?>;
}

/*---------グループタイトル/*---------*/
#wrap .formbox h3 {
	background:#<?php echo $html_color['site_bg_group_title_color'];?>;
}

/*---------グループ背景/*---------*/
#wrap .formbox {
	background:#<?php echo $html_color['site_bg_group_color'];?>;
}

/*---------フォームタイトル/*---------*/
#wrap .inputitemname{
	background:#<?php echo $html_color['site_bg_title_color']?>;
}

/*---------フォーム背景/*---------*/
#wrap .linkmesse{
	background:#<?php echo $html_color['site_bg_form_color'];?>;
}

/*---------入力フォーム/*---------*/
#wrap input,
#wrap select,
#wrap textarea{
	background:#<?php echo $html_color['site_bg_input_color'];?>;
}

/*---------決定ボタン/*---------*/
#formsubmit{
	background:#<?php echo $html_color['site_bg_decide_btn_color'];?> !important;
}

</style>