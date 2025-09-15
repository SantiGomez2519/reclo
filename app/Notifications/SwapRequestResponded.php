<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SwapRequestResponded extends Notification
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
            'offeredItemTitle' => optional($this->swapRequest->getOfferedItem())->getTitle(),
            'status' => $this->swapRequest->getStatus(),
            'message' => $this->swapRequest->getStatus() === 'Counter Proposed'
                ? 'The item owner has proposed a counter offer.'
                : 'The item owner has responded your swap request.',
        ];
    }
}
