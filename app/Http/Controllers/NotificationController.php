<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Notifications\SwapRequestCreated;
use App\Notifications\SwapRequestResponded;
use App\Notifications\SwapRequestFinalized;
use App\Notifications\ProductSold;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(): View
    {
        $viewData = [];
        $notifications = Auth::guard('web')->user()->notifications;

        // Add translated messages to each notification without mutating data attribute
        $notifications->each(function ($notification) {
            $notification->translated_message = $this->getTranslatedMessage($notification);
        });

        $viewData['allNotifications'] = $notifications;

        return view('notification.index')->with('viewData', $viewData);
    }

    private function getTranslatedMessage($notification): string
    {
        switch ($notification->type) {
            case SwapRequestCreated::class:
                return __('notification.swap_request_created');

            case SwapRequestResponded::class:
                $status = $notification->data['status'] ?? 'pending';
                if (strtolower($status) === 'accepted') {
                    return __('notification.swap_request_accepted', [
                        'desired' => $notification->data['desiredItemTitle'] ?? __('product.title'),
                        'offered' => $notification->data['offeredItemTitle'] ?? __('product.title'),
                    ]);
                } elseif (strtolower($status) === 'rejected') {
                    return __('notification.swap_request_rejected', [
                        'desired' => $notification->data['desiredItemTitle'] ?? __('product.title'),
                        'offered' => $notification->data['offeredItemTitle'] ?? __('product.title'),
                    ]);
                } else {
                    return __('notification.swap_request_responded');
                }

            case SwapRequestFinalized::class:
                return __('notification.swap_request_finalized');

            default:
                return $notification->data['message'] ?? __('notification.new_notification');
        }
    }

    public function read(string $id): RedirectResponse
    {
        $notification = Auth::guard('web')->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        switch ($notification->type) {
            case SwapRequestCreated::class:
                return redirect()->route('swap-request.receive', $notification->data['swap_request_id']);
            case SwapRequestResponded::class:
                return redirect()->route('swap-request.finalize', $notification->data['swap_request_id']);
            case SwapRequestFinalized::class:
                return redirect()->route('swap-request.index')->with('status', 'Swap request finalized successfully.');
            case ProductSold::class:
                return redirect()->route('product.my-products')->with('status', 'View your orders for details.');
            default:
                return redirect()->route('notification.index');
        }
    }
}
