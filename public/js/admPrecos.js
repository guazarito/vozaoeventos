	  		function remove(item){
				$('#'+item).remove();
			}
			
		    function excluir(id){
				$('*').css( 'cursor', 'wait' );
				$.ajax({
					type: "GET",
					url: "/adm/precos/delete/" + id,
					async: false,
					statusCode: {
						500: function() {
						  $('*').css( 'cursor', 'default' );
						  alert("Erro ao deletar");
						}
					}
				}).done(function(data) {                  
					//alert(data);
					location.reload();
					$('*').css( 'cursor', 'default' );
				});
			}
		
		$(document).ready(function() {
			$.fn.editable.defaults.mode = 'inline';

			$('.editable_field').editable({
				escape: true
			});
						
					
			$('#btnSalvaLoteAtual').click(function(){
				$('*').css( 'cursor', 'wait' );
				var lote = $('select[name="lote_atual').find(":selected").text();
				$.ajax({
					type: "GET",
					url: "/adm/precos/loteatual/F/" + lote,
					async: false,
					statusCode: {
						500: function() {
						  $('*').css( 'cursor', 'default' );
						  alert("Erro ao salvar");
						}
					}
				}).done(function(data) {                  
					$('*').css( 'cursor', 'default' );
				});
			});
			
				
			$('#add_preco').click(function(){
				//alert('a');
				var ult_id = parseInt($('#ul_precos li:last-child').attr('id'));
				var id = ult_id+1;
				$("#ul_precos").append('<li class="li_precos" id="'+id+'">Lote: <select name="lote'+id+'"><option value="0" selected></option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> Preço: R$ <input type="text" name="preco'+id+'"></input><button type="button" onclick="remove('+id+')" class="btn btn-default">Remover</button></li>');
			});
		
			$("#btnLimpar").click(function(){
				$(".li_precos").each(function() {
					$(this).children("select").each(function() {
						$(this).prop('selectedIndex', 0);
					});
					$(this).children("input").each(function() {
						$(this).val("");
					});
				});
			});
			
			$("#btnSalvar").click(function(){
				$('*').css( 'cursor', 'wait' );
				var salva = 1;
				//valida os campos ---------------------------------------------
				$(".li_precos").each(function(index) {
					var remove=0;
					$(this).children("select").each(function() {
						if ($('select[name="'+$(this).attr("name")+'"]').find(":selected").text()==""){
							remove++;
						}
					}); //children select each
					$(this).children("input").each(function() {
						if($('input[name='+$(this).attr("name")+']').val()==""){
							remove++;
						}else{
							$('input[name='+$(this).attr("name")+']').val( $('input[name='+$(this).attr("name")+']').val().replace(",",".").trim() );
							if (isNaN($('input[name='+$(this).attr("name")+']').val())){
								//alert('nao eh numero');
								$('input[name='+$(this).attr("name")+']').val("0");
							}
						}
					});//children input each
					if (remove==2 && parseInt($(this).attr("id"))!=1 ){
						$('#'+$(this).attr("id")).remove();
					}else{
						var linha = parseInt(index)+1;
						if(remove>=1){
							$('*').css( 'cursor', 'default' );
							alert("Preencha todos campos da linha "+ linha +"!");
							salva=0;
						}
					}
				});//each li
				//fim valida os campos ---------------------------------------------
				//aqui salva se salva=1:  
				if (salva==1){
					var string_salva="";
					$(".li_precos").each(function(index) {
						string_salva="";
						$(this).children("select").each(function() {
							string_salva = string_salva + "*" + $('select[name="'+$(this).attr("name")+'"]').find(":selected").val();
						});
						$(this).children("input").each(function() {
							string_salva = string_salva + "*" + $('input[name='+$(this).attr("name")+']').val();
						});	
						string_salva = string_salva.substring(1, string_salva.lenght);
						//alert(string_salva);
						$.ajax({
							type: "GET",
							url: "/adm/precos/salva/" + string_salva,
							async: false,
							statusCode: {
								500: function() {
								  //alert("ERRO");
								}
							}
						}).done(function(data) {                  
							//alert(data);
							if(data=="ok"){
								location.reload();
							}
						});
					});//each li
				}//fim If salva=1
			});
		});