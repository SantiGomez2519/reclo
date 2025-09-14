<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SwapRequestCreated extends Notification
{
    use Queueable;

    private $swapRequest;

    public function __construct($swapRequest)
    {
        $this->swapRequest = $swapRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'swap_request_id' => $this->swapRequest->getId(),
            'desiredItemTitle' => $this->swapRequest->getDesiredItem()->getTitle(),
            'message' => 'Someone has created a swap request for one of your products.',
        ];
    }
}
