<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Cart extends Model
{
	private $items=[];

	public function __construct(){
		if (Session::has('VozaoCart')){
			$this->items=Session::get('VozaoCart')->items;
		}
    }

    public function add($item, $qtd){ 
    	$this->items=[
    		'qtde' => $qtd,
    		'lote' => $item->lote,
    		'preco_unidade'=> $item->preco,
    		'preco_total_item' => $qtd*$item->preco
    	];
    }

    public function getItems(){
    	return ($this->items);
    }

    public function getTotal(){

    	$total = 0;

    	if (isset($this->items) && $this->items!==null && sizeof($this->items)>0){
    		
    		$total = $total + $this->items['preco_total_item'];
    	}
    	
    	return $total;
    }
}
