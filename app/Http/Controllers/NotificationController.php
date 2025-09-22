<?php

// Author: Isabella Camacho

namespace App\Http\Controllers;

use App\Notifications\ProductSold;
use App\Notifications\SwapRequestCreated;
use App\Notifications\SwapRequestFinalized;
use App\Notifications\SwapRequestResponded;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        $notifications->each(function ($notification) {
            $data = $notification->data;

            if (isset($data['translation_key'])) {
                $translationParams = $data['translation_params'] ?? [];
                $notification->translated_message = __(
                    $data['translation_key'],
                    $translationParams
                );
            } else {
                $notification->translated_message = $data['message'] ?? __('notification.new_notification');
            }
        });

        $viewData['allNotifications'] = $notifications;

        return view('notification.index')->with('viewData', $viewData);
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
                return redirect()->route('swap-request.index')->with('status', __('swap.success_finalizing'));
            case ProductSold::class:
                return redirect()->route('product.my-products');
            default:
                return redirect()->route('notification.index');
        }
    }
}
