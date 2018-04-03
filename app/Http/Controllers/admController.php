<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Precos;
use App\LoteAtual;
use App\Cart;
use App\Order;
use App\User;
use Session;
use Closure;

use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Vsmoraes\Pdf\PdfFacade as PDF;

use App\Notifications\VozaoNotify;
 

class admController extends Controller
{
	private $mPrecos;
	private $mLoteAtual;
	private $lote_atual;
	private $preco_atual;
	
	public function __construct(Precos $mPrecos, LoteAtual $mLoteAtual )
    {
        $this->mPrecos = $mPrecos;
		$this->mLoteAtual = $mLoteAtual;

		$serie = $this->mLoteAtual->all();
		//lote_atual tem q ser 1.. 
		if(sizeof($serie)==1){ 
			$this->lote_atual = $this->mLoteAtual->select('lote_atual')->where('id',1)->first();
			$this->preco_atual = $this->mPrecos->where('lote',$this->lote_atual->lote_atual)->first();
		}else{
			$this->preco_atual = [];
		}
	}
	
	public function testemail(){
		$user = new User;
		$order = new Order;
		
		$user = $user->where('id','14')->first();
		$pedido = $order->where('id','25')->first();
		
		$user->notify(new VozaoNotify($user, $pedido, "eTxgImsXY83omsr3xew4nP3bMMwA4uv4"));
		
		echo "ok";
	}
		
	public function index(){
		if (Session::has('VozaoCart')){
			$num_carrinho = 1;
		}else{
			$num_carrinho = 0;
		}

		$preco_atual = $this->preco_atual;

		return view('homevozao', compact('preco_atual', 'num_carrinho'));
	}

	public function help(){
		return view('help');
	}
	
    public function comprar(Request $request){		
		$qtde = $request->get('qtde_ingressos');

		$subtotal = $request->get('total');

		$cart = new Cart;
		
		$cart->add($this->preco_atual, $qtde);
				

		//return $cart->getItems();
		
			if (Session::has('VozaoCart')){
				$request->session()->forget('VozaoCart');
			}

			$request->session()->put('VozaoCart', $cart);
			
			return redirect(route('ver_carrinho'));
	}
	
	public function comprar_get(Closure $next){
		//echo "se caiu aqui eh pq o user clicou comprar sem registro";
		return $next($request);
	}
	
	public function termosdeuso(){
		return view('termosuso');
	}
	//ADM functions =========================


	public function pedidos_index(Order $pedido, User $user){
		$pedidos = $pedido->where("status",3)->orderby('created_at','desc')->get();
		$users = $user->get();

		$somaTotalPedidos = $pedido->getSomaTotal();
		$somaTotalPedidosPagos = $pedido->getSomaTotalPago();
		$somaTotalPedidosPendentes = $pedido->getSomaTotalPendente();
		
		$somaTotalingressos = $pedido->getSomaTotalingressos();
		$somaTotalingressosPagos = $pedido->getSomaTotalingressosPagos();
		$somaTotalingressosPendentes = $pedido->getSomaTotalingressosPendentes();

		
		return view("admPedidos", compact('pedidos', 'users', 'somaTotalPedidos', 'somaTotalPedidosPagos', 'somaTotalPedidosPendentes', 'somaTotalingressos', 'somaTotalingressosPagos', 'somaTotalingressosPendentes'));
	}

	public function usuarios_index(User $user){
		$users = $user->orderby('created_at','desc')->get();
		return view("admListaUsers", compact('users'));
	}
	
	public function precos_index(){
		$precos = $this->mPrecos->orderBy('lote')->get();
		
		$lote_atual = $this->mLoteAtual->where('id',1)->first();
			
		$lotes = $this->mPrecos->select("lote")->distinct()->orderBy("lote")->get();
		
		return view("admPrecos", compact('precos', 'lote_atual', 'lotes'));
	}
	
	public function salva_precos($string_salvar){
		//echo $string_salvar;
		$campos = explode("*",$string_salvar);
		
		$lote= $campos[0];
		$preco= $campos[1];
		
		$this->mPrecos->lote = $lote;
		$this->mPrecos->preco = $preco;
    	try{
			$this->mPrecos->save();
			echo "ok";
		}catch(Exception $e){
			echo $e->getMessage();
		}

		//print_r($campos);
	}
	
	public function deleta_precos($id_preco){
		 $this->mPrecos->find($id_preco)->delete();
	}
	
	
	public function edita_meusdados_inline(Request $request, $campo, $id_user){
        $user= new User;
		
		$serie = $user->find($id_user);
        $value = $request->get('value');
		$serie->$campo = $value;
        $serie->save();
    }
	 public function edita_preco_inline(Request $request, $id_preco){
        $serie = $this->mPrecos->find($id_preco);
        $value = $request->get('value');
		$value = str_replace(",",".",$value);
		if(!is_numeric($value)){
			$value=0;
		}
		$serie->preco = $value;
        $serie->save();
    }
	
	public function salva_lote_atual($tipo, $lote){
		$serie = $this->mLoteAtual->where('id',1)->get();
		if(sizeof($serie)==0){
			$this->mLoteAtual->lote_atual = $lote;
			$this->mLoteAtual->save();
		}elseif(sizeof($serie)==1){
			$this->mLoteAtual->where('id',1)->update(['lote_atual' => $lote]);
		}else{
			//$this->mLoteAtual->where('1','1')->delete();
			//$this->mLoteAtual->lote_atual = $lote;
			//$this->mLoteAtual->save();
		}
		echo "ok";
	}

	//FIM ADM Functions ===========================================

	public function carrinho_index(){
		
		$cart = new Cart;
		$items = $cart->getItems();

		$total_carrinho =  $cart->getTotal();
		$taxa = ($total_carrinho*(float)(config('pagseguro.taxa')));

		$total_com_taxa = $total_carrinho + $taxa;
	
		$taxa = str_replace(".",",",number_format(round($taxa,2),2));
		$total_sem_taxa = str_replace(".",",",number_format($total_carrinho,2));
		$total_com_taxa = str_replace(".",",",number_format($total_com_taxa,2));

		if (isset($items) && $items!==null && sizeof($items)>0){
			$items['preco_unidade'] = str_replace(".",",",number_format($items['preco_unidade'],2));
		}

		return view('cart', compact('items','total_carrinho','taxa', 'total_com_taxa'));
	}

	public function remover_carrinho(Request $request){
			
			if (Session::has('VozaoCart')){
				$request->session()->forget('VozaoCart');
			}
			
			return redirect(route('index_route'));
	}

	public function meuspedidos(Order $pedido){
		$orders = $pedido->where('user_id',Auth::user()->id)->orderby('created_at','desc')->get();
	 
	 		if (Session::has('VozaoCart')){
			$num_carrinho = 1;
		}else{
			$num_carrinho = 0;
		}

		return view('meuspedidos', compact('orders', 'num_carrinho'));
	}

	public function meusdados(User $user){
		$eu = $user->where('id',Auth::user()->id)->first();

		return view('meusdados', compact('eu'));
	}

	public function congrats(){
		return view('congrats');
	}

	public function qr_code_generator($reference_number, $user){

		$pedido = new Order;

		$pedido = $pedido->where('reference', $reference_number)->first();

		$user_cpf = $user->cpf;

		$user_cpf = preg_replace('/[^0-9]/', '', $user_cpf);
		
		$parte_um     = substr($user_cpf, 0, 3);
		$parte_dois   = substr($user_cpf, 3, 3);
		$parte_tres   = substr($user_cpf, 6, 3);
		$parte_quatro = substr($user_cpf, 9, 2);

		$user_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro"; 

		$info_ingressos="";

		for($i=1;$i<=$pedido->qtde;$i++){
			$info_ingressos=$info_ingressos."<p>1x - OPEN BAR - LOTE $pedido->lote</p>";
		}
		
		$qr_png = "<img src='data:image/png;base64,".base64_encode(QrCode::format('png')->size(200)->generate(md5($reference_number)))." '>";


		$html = "

<!doctype html>
    <head>
    	<style>
    	  @font-face {
    		font-family: 'Roboto', sans-serif;
			font-style: normal;
    		font-weight: 400;
    		src: url('".public_path('layout/fonts/Roboto-Bold.ttf')."');
  			}
    	  @font-face {
    		font-family: 'Anton-Regular';
    		font-style: normal;
    		font-weight: bold;
    		src: url('".public_path('layout/fonts/Anton-Regular.ttf')."');
  			}

    		*{
    			margin: 0;
    			padding: 0;
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
    			font-family: 'Roboto', sans-serif;
    			font-weight: 100;
    			font-size: 12px;
       		}

    	

			#recados{
    			width: 40%;
    			height: 100%;
    			float: right;
    			padding-right: 8%;
    			padding-left: 2%;
    			font-family: 'Roboto', sans-serif;
    			font-weight: 200;
    		}

    		.box{
    			width: 100%;
    			margin-bottom: 20px;
    		}

    		.label{
    			text-transform: uppercase;
    			font-family: 'Roboto', sans-serif;
    			font-weight: 600;
    			font-size: 12px;
    			color: #8F8F8F;
    			border-bottom: 1px solid #E0E0E0;
    		}

    		#header_box{
    			font-family: 'Roboto', sans-serif;
    			font-weight: bold;
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
		    		<h1>NATAL VOZÃO 2017</h1>
		    		<h3>Pedido #".rand(1000, 9999)."</h3>
	    		</div>
	    	</div>
	    	<br>

    		<div class='box'>
	    		<div class='label_box' style='border-bottom: 1px solid #E0E0E0;'>
		    		<spam class='label' style='border-bottom: 0px;'>Data e Horário</spam>
	    		</div>

                <div id='info_box'>
                    <div class='info'>
                        <p>25/12/2017</p>
                        <p>1h00</p>
                    </div>
                </div>
            </div><!--box-->

            <div class='box'>
	    		<div class='label_box' style='border-bottom: 1px solid #E0E0E0;'>
		    		<spam class='label' style='border-bottom: 0px;'>Local</spam>
	    		</div>

	    		<div id='info_box'>
		    		<div class='info'>
		    			<p>CHÁCARA ALVORADA</p>
		    			<p></p>
		    			<p>Araraquara - SP</p>
    				</div>
	    		</div>
    		</div><!--box-->

    		<div class='box'>
	    		<div class='label_box' style='border-bottom: 1px solid #E0E0E0;'>
		    		<spam class='label' style='border-bottom: 0px;'>Ingresso(s) - $pedido->qtde unidade(s)</spam>
	    		</div>

	    		<div id='info_box'>
		    		<div class='info'>
		    			$info_ingressos
		    		</div>
	    		</div>
    		</div><!--box-->

    		<div class='box'>
	    		<div class='label_box' style='border-bottom: 1px solid #E0E0E0;'>
		    		<spam class='label' style='border-bottom: 0px;'>Comprador</spam>
	    		</div>

	    		<div id='info_box'>
		    		<div class='info'>
		    			<p>$user->name</p>
		    		</div>
					<div class='info'>
		    			<p>CPF: $user->cpf</p>
		    		</div>
	    		</div>
    		</div><!--box-->

   
    		<div class='box' style='padding-left: 20%;'>
    			$qr_png
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
    			<p>Obs: Imprima ou leve este compravante no seu celular.</p>
    		</div>
    	</div><!--recados -->
    	
    </body>
</html>
";
	
	//echo asset('/layout');
	//	PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save('C:/pdf/myfile.pdf');

		//return view("qr_code", compact('qr_png'));
	$cpf= preg_replace('/[^0-9]/', '', $user_cpf);

	if(!file_exists(storage_path()."/vouchers/$reference_number")){
		mkdir(storage_path()."/vouchers/$reference_number");
	}

	//dd($html);
	return PDF::load($html, 'A4', 'landscape')->filename(storage_path()."/vouchers/$reference_number/"."VozaoVoucher".$cpf.".pdf")->output();
}


public function grava_checkout(Order $pedido, Request $request){
		//dd($request->all());

		$pedido->user_id =Auth::user()->id;
		$pedido->reference = $request->ref_number;
		$pedido->ref_number_md5 = md5($request->ref_number);
		$pedido->pagseguro_transaction_code = $request->transactionCode;
		$pedido->qtde = $request->qtde ;
		$pedido->lote= $request->lote ;
		$pedido->preco_total = $request->preco_total_com_taxa ;
		$pedido->status= 1;

		$pedido->save();

		if (Session::has('VozaoCart')){
			$request->session()->forget('VozaoCart');
		}

		$this->qr_code_generator($request->ref_number, Auth::user());
		
	}

public function baixa_voucher(Request $request){
	$files = scandir(storage_path().'/vouchers');

	foreach($files as $file) {
		if ($request->ref_number == md5($file)){
			if(is_file(storage_path()."/vouchers/$file/VozaoVoucher".substr($file, 0,11).".pdf")){
				
				$arq = storage_path()."/vouchers/$file/VozaoVoucher".substr($file, 0,11).".pdf";

				header("Content-Description: File Transfer"); 
				header("Content-Type: application/octet-stream"); 
				header("Content-Disposition: attachment; filename='" . basename($arq) . "'"); 

				readfile ($arq);

				return;
			}
		}
 	}
 	//echo "nao deve entrar aqui.. se entrou nao encontrou o voucher";
 	return redirect(route('meuspedidos'));
}

public function baixa_voucher_email($ref_num){
	$files = scandir(storage_path().'/vouchers');

	foreach($files as $file) {
		if ($ref_num == md5($file)){
			if(is_file(storage_path()."/vouchers/$file/VozaoVoucher".substr($file, 0,11).".pdf")){
				
				$arq = storage_path()."/vouchers/$file/VozaoVoucher".substr($file, 0,11).".pdf";

				header("Content-Description: File Transfer"); 
				header("Content-Type: application/octet-stream"); 
				header("Content-Disposition: attachment; filename='" . basename($arq) . "'"); 

				readfile ($arq);

				return;
			}
		}
 	}
 	//echo "nao deve entrar aqui.. se entrou nao encontrou o voucher";
 	return false;
}

public function contato (Request $request){
	$nome = $request->get('nome');
	$email = $request->get('email');
	$tel = $request->get('tel');
	$msg = $request->get('msg');

	$str = $nome."<br>".$email."<br>".$tel."<br><br>".$msg;
	
	mail("guazarito@gmail.com","VOZAO - AJUDA!!!!",$str);

	return redirect(route('help'));
}


}
