<?php

namespace App\Notifications;

use App\Models\CustomUser;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductSold extends Notification
{
    use Queueable;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via(CustomUser $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(CustomUser $notifiable): array
    {
        return [
            'product_id' => $this->product->getId(),
            'product_title' => $this->product->getTitle(),
            'translation_key' => 'notification.product_sold',
            'translation_params' => ['product' => $this->product->title],
        ];
    }
}
