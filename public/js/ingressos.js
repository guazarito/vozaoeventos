	
		$(document).ready(function() {
			
			$("#comprar-botao").click(function(){
				var qtde = $('select#qtde-ingresso').find(":selected").val();
				if (qtde=="0"){
					$(".msg").css('display','block');
				}else{
					$(".msg").css('display','none');
					$("#vozao2017").submit();
				}
			});
			
			var preco_ingresso = [],
				preco_final = [];

			$("span#preco-ingresso").each(function(index) {
				preco_ingresso[index] = $(this).text().replace(",",".");
			});
	
		    $("select#qtde-ingresso").each(function(index) {
				var size = preco_ingresso.length;
				$(this).on('change', function(e) {
					var optionSelected = $("option:selected", this);
					var valueSelected = this.value,
						preco = 0;
					preco_final[index] = preco_ingresso[index] * valueSelected;
					for (i = 0; i < size; i++) {
						if (preco_final[i] == undefined) {
							preco_final[i] = 0;
						}
						preco = preco + preco_final[i];
					}
					$("#preco-total").val(preco.toFixed(2).replace(".",","));
				});
			});
		});
		