(function() {

	/**
	 * Altera o <title> para o Sandbox
	 * @author Fernando Faria - cin_ffaria@uolinc
	 */
	$('head title').text('PagSeguro Sandbox - Confirma��o de Pagamento');

	/* Remove o link "Esqueci minha senha" do Checkout - Identifica��o  */
	$('#hasAccountDiv .option-detail .insertion-guide a').hide();
	$('#identificationForm .insertion-guide a').hide();

	/* Remove os bot�es "Gerar boleto" do p�s-Checkout TEF e Boleto */
	$('#showBooklet').hide();

	/* Remove a mensagem "Clique aqui e escolha outro meio de pagamento." */
	$('.tefMessage').hide();

	/**
	 * Insere a flag "Voc� est� em ambiente de testes"
	 */
	var sbFlag = function(){
		var me = $(".centerDiv");
		var flag = [];
		flag.push('<span><p class="sandbox-info"><span>Voc� est� em ambiente de teste</span></p>');
		me.append(flag);
	}();

	$("#main-header h1 img").attr('src',  'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/i/sandbox/common/logo/300x50-t.png');

	/*
	 * Remove um caractere "-" do markup que vem do checkout
	 */
	var cleanUp = function(){
		if($('#shopDetails').length){
			$("#shopDetails div:first").html($("#shopDetails div").html().replace(/\-$/gm,'')); 
		} else {
			return false;
		}
	};

	cleanUp();
	
	
})();