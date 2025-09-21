<?php

namespace App\Notifications;

use App\Models\CustomUser;
use App\Models\SwapRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SwapRequestResponded extends Notification
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
        $offeredTitle = optional($this->swapRequest->getOfferedItem())->getTitle();

        if ($this->swapRequest->getStatus() === 'Counter Proposed') {
            $translationKey = 'notification.swap_request_counter_offered';
        } else {
            $translationKey = 'notification.swap_request_responded';
        }

        return [
            'swap_request_id' => $this->swapRequest->getId(),
            'offeredItemTitle' => optional($this->swapRequest->getOfferedItem())->getTitle(),
            'status' => $this->swapRequest->getStatus(),
            'translation_key' => $translationKey,
        ];
    }
}
