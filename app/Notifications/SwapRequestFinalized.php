<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SwapRequestFinalized extends Notification
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

        $desiredTitle = $this->swapRequest->getDesiredItem()->getTitle() ?? 'Producto solicitado';
        $offeredTitle = $this->swapRequest->getOfferedItem()->getTitle() ?? 'Producto ofrecido';

        if ($this->swapRequest->getStatus() === 'Accepted') {
            $message = 'The swap between "'.$desiredTitle.'" and "'.$offeredTitle.'" has been ACCEPTED.';
        } else {
            $message = 'The swap request of "'.$desiredTitle.'" has been REJECTED.';
        }

        return [
            'swap_request_id' => $this->swapRequest->getId(),
            'message' => $message,
        ];
    }
}
