$("body").on("click", "#submit", function() {

		error="";
		name_sei=$(".name_sei").val();
		name_mei=$(".name_mei").val();
		name_sei_furi=$(".name_sei_furi").val();
		name_mei_furi=$(".name_mei_furi").val();
		company=$(".company").val();
		unit=$(".unit").val();
		mail=$(".mail").val();
		tel_1=$(".tel_1").val();
		tel_2=$(".tel_2").val();
		tel_3=$(".tel_3").val();
		message=$(".message").val();



		$("input").css("border","solid 1px #F8F8F8");
		$("textarea").css("border","solid 1px #F8F8F8");
		$("#error").html('');




		if(!name_sei){
			error=error+"名字を入力してください。<br/>"
			$(".name_sei").css("border","solid 1px #EA5A4B");
		}
		if(!name_mei){
			error=error+"お名前を入力してください。<br/>"
			$(".name_mei").css("border","solid 1px #EA5A4B");
		}
		
		if(!name_sei_furi){
			error=error+"名字(ひらがな)を入力してください。<br/>";
			$(".name_sei_furi").css("border","solid 1px #EA5A4B");
		}
		if (name_sei_furi.match(/[^あ-ん|^ー]/g)){
			error=error+"名字(ひらがな)、「ひらがな」のみで入力して下さい。<br/>";
			$(".name_sei_furi").css("border","solid 1px #EA5A4B");
		}
		if(!name_mei_furi){
			error=error+"お名前(ひらがな)を入力してください。<br/>";
			$(".name_mei_furi").css("border","solid 1px #EA5A4B");
		}
		if (name_mei_furi.match(/[^あ-ん|^ー]/g)){
			error=error+"名(ひらがな)、「ひらがな」のみで入力して下さい。<br/>";
			$(".name_sei_furi").css("border","solid 1px #EA5A4B");
		}
		if(!company){
			error=error+"会社名を入力してください。<br/>";
			$(".company").css("border","solid 1px #EA5A4B");
		}
		if(!unit){
			error=error+"部署を入力してください。<br/>";
			$(".unit").css("border","solid 1px #EA5A4B");
		}
		if(!mail){
			error=error+"メールアドレスを入力してください。<br/>";
			$(".mail").css("border","solid 1px #EA5A4B");
		}
		if(mail.match(/.+@.+\..+/)==null){
        	error=error+"正しいメールアドレスを入力してください。<br/>";
			$(".mail").css("border","solid 1px #EA5A4B");
	    }
		if(!tel_1){
			error=error+"電話番号1を入力してください。<br/>";
			$(".tel_1").css("border","solid 1px #EA5A4B");
		}
		if(tel_1.match(/[^0-9]+/)){
			error=error+"電話番号1を数字を入力してください。<br/>";
			$(".tel_1").css("border","solid 1px #EA5A4B");
		}
		if(!tel_2){
			error=error+"電話番号2を入力してください。<br/>";
			$(".tel_2").css("border","solid 1px #EA5A4B");
		}
		if(tel_2.match(/[^0-9]+/)){
			error=error+"電話番号2を数字を入力してください。<br/>";
			$(".tel_2").css("border","solid 1px #EA5A4B");
		}
		if(!tel_3){
			error=error+"電話番号3を入力してください。<br/>";
			$(".tel_3").css("border","solid 1px #EA5A4B");
		}
		if(tel_3.match(/[^0-9]+/)){
			error=error+"電話番号3を数字を入力してください。<br/>";
			$(".tel_3").css("border","solid 1px #EA5A4B");
		}
		if(!message){
			error=error+"お問い合わせ内容を入力してください<br/>";
			$(".message").css("border","solid 1px #EA5A4B");
		}




		// 初期化
		$("#form_html_inner").html("");
		$("#error").html("");






		if(error==""){

			var input_form = [
				{ 
					name: name_sei + name_mei,
					huri: name_sei + name_mei,
					company:company,
					unit: unit,
					mail: mail,
					tel: tel_1 + tel_2 +tel_3,
					message: message,
				},
			];

				$("#form").tmpl(input_form).appendTo("#form_html_inner");
				$("#form_html").css("display","block");
				$("#overray").css("display","block");
				var h = Math.max.apply( null, [document.body.clientHeight , document.body.scrollHeight, document.documentElement.scrollHeight, document.documentElement.clientHeight] );  
				$("#overray").css("height",h);
		
		}else{
			 $('#error').append(error);
		}


	});