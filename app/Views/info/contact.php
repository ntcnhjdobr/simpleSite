<script type="text/javascript">

	emailIsCheck = false;	

	function checkEmail () {
		
		if (!$('#email').attr('value') && emailIsCheck==false){
			emailIsCheck = confirm('Отправить без обратного адреса?');
		}else{
			emailIsCheck = true;
		};

		if (!emailIsCheck && !$('#email').hasClass('errorInput')) {
			$('#email').addClass('errorInput');
		}else if(emailIsCheck && $('#email').hasClass('errorInput')){
			$('#email').removeClass('errorInput');
		}
		
		return emailIsCheck;		
	}
	
	function checkText () {
		var textIsCheck = $('#text').attr('value') ? true : false;
		
		if (!$('#text').attr('value') && !$('#text').hasClass('errorInput')) {
			$('#text').addClass('errorInput');
			alert ('Текст письма обязателен');
		}else if(textIsCheck && $('#text').hasClass('errorInput')) {
			$('#text').removeClass('errorInput');
		}
		return textIsCheck;
	}
	
	function checkForm () {			

		if (!checkEmail()) {
			return false;
		};				

		if (!checkText()) {
			return false;
		};		
		
		this.disabled=true;
		return true;
	}
</script>

<br/><br/>
<div class="form">
	<h2>Форма обратной связи</h2>
	<?php if (isset($status) && $status) { ?>
		<div style="margin: 5px 0; padding: 2px 10px; border: 1px solid gray; background-color: white; ">
		<?php echo $status; ?>
		</div>
	<?php }?>
	
	<form method="POST" class="contact">
		<div class="input">
			<label>Ваш e-mail:</label>
			<input type="text" name="email" id="email" value="" />
		</div>
		
		<div class="input">
			<label><b class="required">*</b>Текст письма:</label>
			<textarea name="text" onkeyUp="resizeTextarea(this);" id="text"></textarea>
		</div>
		
		<div class="input submit">
			<input type="submit" value="Отправить" onclick="return checkForm()"/>
		</div>
	</form>
</div>


<br style="clear: both;">

