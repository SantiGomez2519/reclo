<?php

namespace App\Http\Controllers;

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
        $viewData['title'] = 'All your notifications';
        $viewData['allNotifications'] = Auth::guard('web')->user()->notifications;

        return view('notification.index')->with('viewData', $viewData);
    }

    public function read(string $id): RedirectResponse
    {
        $notification = Auth::guard('web')->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        switch ($notification->type) {
            case 'App\Notifications\SwapRequestCreated':
                return redirect()->route('swap-request.receive', $notification->data['swap_request_id']);
            case 'App\Notifications\SwapRequestResponded':
                return redirect()->route('swap-request.finalize', $notification->data['swap_request_id']);
            case 'App\Notifications\SwapRequestFinalized':
                return redirect()->route('swap-request.index')->with('status', 'Swap request finalized successfully.');
            default:
                return redirect()->route('notification.index');
        }
    }
}
