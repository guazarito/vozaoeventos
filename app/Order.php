<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Order extends Model
{
    public function getUserName($user_id){
    	$user = new User;
    	return $user->select('name')->where('id', $user_id)->first();
    }

    public function getSomaTotal(){
    	return $this->sum('preco_total');
    }

    public function getSomaTotalPago(){
    	return $this->where('status','3')->sum('preco_total');
    }
	
	public function getSomaTotalPendente(){
    	return $this->where('status','<>','3')->where('status','<>','4')->where('status','<>','7')->sum('preco_total');
    }
	
	public function getSomaTotalingressos(){
    	return $this->sum('qtde');
    }
	
	public function getSomaTotalingressosPagos(){
    	return $this->where('status','3')->sum('qtde');
    }
	
	public function getSomaTotalingressosPendentes(){
    	return $this->where('status','<>','3')->where('status','<>','4')->where('status','<>','7')->sum('qtde');
    }	
	
	public function getSomaTotalingressosCancelados(){
    	return $this->where('status','7')->sum('qtde');
    }
}

