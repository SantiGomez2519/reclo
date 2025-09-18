<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductSold extends Notification
{
    use Queueable;

    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_id' => $this->product->getId(),
            'product_title' => $this->product->getTitle(),
            'translation_key' => 'notification.product_sold',
            'translation_params' => ['product' => $this->product->title],
        ];
    }
}
