<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        return $this->to($this->order->billing_email, $this->order->billing_name)
                    ->subject('Order from Bookshop.com')
                    ->markdown('emails.order_placed');         // غيرناها وقت استعملنا الـ laravel default email template
                    //->view('emails.order_placed');

        /* 
        الـ from
        ممكن نمرقها من هوق عادي 
        $this->from()
        او ممكن نعمل متل ما عملنا هون، انه خزناها بملف الـ env
        او بالاحرى هنيك كان في خانتين ثابتين مع بيانات الـ mail
        ونحنا بس عبيناهن متل ما بدنا، حطينا فيهن ايميل الـ admin
        واسمه
        */
    }
}
