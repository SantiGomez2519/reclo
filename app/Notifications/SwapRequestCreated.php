<?php

namespace App\Notifications;

use App\Models\CustomUser;
use App\Models\SwapRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SwapRequestCreated extends Notification
{
    use Queueable;

    private $swapRequest;

    public function __construct(SwapRequest $swapRequest)
    {
        $this->swapRequest = $swapRequest;
    }

    public function via(CustomUser $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(CustomUser $notifiable): array
    {
        return [
            'swap_request_id' => $this->swapRequest->getId(),
            'desiredItemTitle' => $this->swapRequest->getDesiredItem()->getTitle(),
            'translation_key' => 'notification.swap_request_created',
        ];
    }
}
