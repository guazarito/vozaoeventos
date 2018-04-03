

<!doctype html>
    <head>
    	<style>
    		*{
    			margin: 0;
    			padding: 0;
    		}

    		p{
    			font-family: 'Roboto Condensed', sans-serif;
    			font-weight: 400;
    			font-size: 16px;
    		}

    		h1, h2, h3{
    			font-family: 'Anton', sans-serif;
    			font-weight: 400;
    		}

    		body{
    			width: 100%;
    			height: 100%;
    			padding-top: 50px;
    		}

    		#info{
    			width: 40%;
    			height: 100%;
    			float: left;
    			padding-left: 9%;
    			border-right: 2px dotted black;
       		}

    		#info h1{
    			font-family: 'Anton', sans-serif;
    			font-weight: 400;
    		}

			#recados{
    			width: 40%;
    			height: 100%;
    			float: right;
    			padding-right: 8%;
    			padding-left: 2%;
    		}

    		.box{
    			width: 100%;
    			margin: 10px 0;
    			float: left;
    		}

    		.label{
    			text-transform: uppercase;
    			font-family: 'Roboto Condensed', sans-serif;
    			font-weight: 600;
    			font-size: 12px;
    			color: #8F8F8F;
    			border-bottom: 1px solid #E0E0E0;
    		}

    		.label_box{
    			margin-bottom: 5px;

    		}

    	</style>
    </head>

    <body>

    	<div id='info'>
    		<div class='box'>
    			<div id='header_box'>
		    		<h1 >NATAL VOZÃO 2017</h1>
		    		<h3>Pedido #1712</h3>
	    		</div>
	    	</div>

    		<div class='box'>
	    		<div class='label_box'>
		    		<div class='label' style='border-bottom: 1px solid #E0E0E0;'>Data e Horário</div>
	    		</div>

                <div id='info_box'>
                    <div class='info'>
                        <p>25/12/2017</p>
                        <p>1h00</p>
                    </div>
                </div>
            </div><!--box-->

            <div class='box'>
                <div class='label_box'>
                    <div class='label' style='border-bottom: 1px solid #E0E0E0;'>Local</div>
                </div>

	    		<div id='info_box'>
		    		<div class='info' style='width: 50%; float: left;'>
		    			<p>CHÁCARA ALVORADA</p>
		    			<p></p>
		    			<p>Araraquara - SP</p>
    				</div>
	    		</div>
    		</div><!--box-->

    		<div class='box'>
	    		<div class='label_box' style='border-bottom: 1px solid #E0E0E0;'>
		    		<spam class='label' style='border-bottom: 0px;'>Ingresso(s)</spam>
	    		</div>

	    		<div id='info_box'>
		    		<div class='info'>
		    			<p>1x - OPEN BAR - LOTE 1 - R$ 60,00</p>
		    			<p>1x - OPEN BAR - LOTE 1 - R$ 60,00</p>
		    			<p>1x - OPEN BAR - LOTE 1 - R$ 60,00</p>
		    		</div>
	    		</div>
    		</div><!--box-->

    		<div class='box'>
	    		<div class='label_box' style='border-bottom: 1px solid #E0E0E0;'>
		    		<spam class='label' style='border-bottom: 0px;'>Comprador</spam>
	    		</div>

	    		<div id='info_box'>
		    		<div class='info'>
		    			<p>Gustavo Azarito Silva</p>
		    		</div>
					<div class='info'>
		    			<p>CPF: 368.531.888-88</p>
		    		</div>
	    		</div>
    		</div><!--box-->

   
    		<div class='box' style='padding-left: 35%;'>
    			{!!	$qr_png !!}
    		</div>
    	</div><!--info -->

    	<div id='recados'>
    		<div class='box'>
    			<h2>É obrigatório apresentar este comprovante junto com um documento de identificação original com foto.</h2>
    			<br>
    			<h2>Não é permitido a entrada de menores de 18 anos.</h2>
    			<br>
    			<h1><u>Se beber, não dirija !</u></h1>
    			<br>
    			<br>
    			<br>
    			<p>Obs: Imprima ou leve este compravante no seu Smartphone.</p>
    		</div>
    	</div><!--recados -->
    	
    </body>
</html>




