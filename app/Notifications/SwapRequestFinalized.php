<?php

namespace App\Notifications;

use App\Models\CustomUser;
use App\Models\SwapRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SwapRequestFinalized extends Notification
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
        $desiredTitle = $this->swapRequest->getDesiredItem()?->getTitle() ?? __('notification.desired_item');
        $offeredTitle = $this->swapRequest->getOfferedItem()?->getTitle() ?? __('notification.offered_item');

        if ($this->swapRequest->getStatus() === 'Accepted') {
            $translationKey = 'notification.swap_request_accepted';
            $translationParams = [
                'desired' => $desiredTitle,
                'offered' => $offeredTitle,
            ];
        } else {
            $translationKey = 'notification.swap_request_rejected';
            $translationParams = [
                'desired' => $desiredTitle,
            ];
        }

        return [
            'swap_request_id' => $this->swapRequest->getId(),
            'translation_key' => $translationKey,
            'translation_params' => $translationParams,
        ];
    }
}
