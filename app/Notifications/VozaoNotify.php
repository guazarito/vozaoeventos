<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class VozaoNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
	 public $user;
	 public $pedido;
	 public $token;
    public function __construct($user, $pedido, $token)
    {
        $this->user=$user;
		$this->pedido=$pedido;
        $this->token=$token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
					->greeting("Olá, ". $this->user->name) 
					->subject("Confirmação de pagamento Natal Vozão 2017")
					->line('Estamos muito felizes que a sua compra foi confirmada!')
                    ->line('Por favor, baixe o Voucher (clicando no botão abaixo), imprima ou salve no seu celular, e leve-o com você no dia do evento.')
                    ->line('Não compartilhe este arquivo com ninguém!')
					->line('Detalhes do pedido:')
					->line("Nome: ".$this->user->name)
					->line("Cpf: ".$this->user->cpf)
					->line("Quantidade: ".$this->pedido->qtde)
					->line("Valor total: R$".str_replace(".",",",number_format($this->pedido->preco_total,2)))
					->action('Baixar Voucher', url(config('app.url').route('baixavoucher_email', [$this->pedido->ref_number_md5, $this->token], false)))
                    ->line('Obrigado por comprar conosco. Aproveite!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
