<?php

namespace App\Http\Controllers;

use App\Models\CustomUser;
use App\Models\Product;
use App\Models\SwapRequest;
use App\Notifications\SwapRequestCreated;
use App\Notifications\SwapRequestFinalized;
use App\Notifications\SwapRequestResponded;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SwapRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['swapRequests'] = SwapRequest::where('initiator_id', Auth::guard('web')->user()->getId())
            ->orWhereHas('desiredItem', function ($query) {
                $query->where('seller_id', Auth::guard('web')->user()->getId());
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('swap-request.index')->with('viewData', $viewData);
    }

    public function create(int $id): View|RedirectResponse
    {
        $desiredItem = Product::find($id);

        if (! $desiredItem || ! $desiredItem->getSwap() || ! $desiredItem->getAvailable()) {
            return redirect()->route('home.index')
                ->with('status', 'The desired product is not available for swap.');
        }

        $offeredItems = Product::where('seller_id', Auth::guard('web')->user()->getId())
            ->where('swap', true)
            ->where('available', true)
            ->get();

        if ($offeredItems->isEmpty()) {
            return redirect()->route('home.index')
                ->with('status', 'You don\'t have any products to offer for a swap.');
        }

        $viewData = [];
        $viewData['desiredItem'] = $desiredItem;

        return view('swap-request.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $desiredItem = Product::find($request->desired_item_id);

        $existingSwap = SwapRequest::where('initiator_id', Auth::guard('web')->user()->getId())
            ->where('desired_item_id', $request->desired_item_id)
            ->where('status', 'Pending')
            ->first();

        if ($existingSwap) {
            return redirect()->route('home.index')
                ->with('status', 'Error: You already made a swap request for this product.');
        }

        $swapRequest = SwapRequest::create([
            'initiator_id' => Auth::guard('web')->user()->getId(),
            'desired_item_id' => $request->desired_item_id,
            'status' => 'Pending',
            'date_created' => now(),
        ]);

        $desiredItem->seller->notify(new SwapRequestCreated($swapRequest));

        return redirect()->route('home.index')
            ->with('status', 'Swap request created successfully.');
    }

    public function receive(int $id): View
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getDesiredItem()->getSellerId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        $initiatorProducts = Product::where('seller_id', $swapRequest->getInitiatorId())
            ->where('swap', true)
            ->where('available', true)
            ->get();

        $initiator = CustomUser::find($swapRequest->getInitiatorId())->getName();

        $viewData = [];
        $viewData['swapRequest'] = $swapRequest;
        $viewData['desiredItem'] = $swapRequest->getDesiredItem();
        $viewData['initiatorProducts'] = $initiatorProducts;
        $viewData['initiator'] = $initiator;

        return view('swap-request.receive')->with('viewData', $viewData);
    }

    public function respond(Request $request, int $id): View|RedirectResponse
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getDesiredItem()->getSellerId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        if ($swapRequest->getStatus() !== 'Pending') {
            return redirect()->route('home.index')
                ->with('status', 'Error: This swap request has already been responded to.');
        }

        if ($request->response === 'reject') {
            $swapRequest->setStatus('Rejected');
            $swapRequest->getInitiator()->notify(new SwapRequestFinalized($swapRequest));
        } else {
            SwapRequest::validateRespond($request);

            $swapRequest->setStatus('Counter Proposed');
            $swapRequest->setOfferedItemId($request->offered_item_id);
            $swapRequest->getInitiator()->notify(new SwapRequestResponded($swapRequest));
        }

        $swapRequest->save();

        return redirect()->route('home.index', ['id' => $swapRequest->getId()])
            ->with('status', 'Answer registered succesfully.');
    }

    public function finalize(int $id): View
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getInitiatorId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        $desiredItem = Product::find($swapRequest->getDesiredItemId());
        $offeredItem = Product::find($swapRequest->getOfferedItemId());

        $responder = CustomUser::find($swapRequest->getDesiredItem()->getSellerId())->getName();

        $viewData = [];
        $viewData['swapRequest'] = $swapRequest;
        $viewData['desiredItem'] = $desiredItem;
        $viewData['offeredItem'] = $offeredItem;
        $viewData['responder'] = $responder;

        return view('swap-request.finalize')->with('viewData', $viewData);
    }

    public function close(Request $request, int $id): RedirectResponse
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getInitiatorId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        if ($swapRequest->getStatus() !== 'Counter Proposed') {
            $message = match ($swapRequest->getStatus()) {
                'Pending' => 'Error: This swap request is still pending and cannot be finalized yet.',
                'Accepted' => 'Error: This swap request has already been accepted.',
                'Rejected' => 'Error: This swap request has already been rejected.',
                default => 'Error: This swap request cannot be finalized.',
            };

            return redirect()->route('home.index')
                ->with('status', $message);
        }

        if ($request->response === 'rejected') {
            $swapRequest->setStatus('Rejected');
            $swapRequest->getInitiator()->notify(new SwapRequestFinalized($swapRequest));
        } else {
            $swapRequest->setStatus('Accepted');
            $swapRequest->setDateAccepted(now());

            $desiredItem = Product::find($swapRequest->getDesiredItemId());
            $desiredItem->setAvailable(false);
            $desiredItem->save();

            $offeredItem = Product::find($swapRequest->getOfferedItemId());
            $offeredItem->setAvailable(false);
            $offeredItem->save();

            $swapRequest->getDesiredItem()->seller->notify(new SwapRequestFinalized($swapRequest));
            $swapRequest->getOfferedItem()->seller->notify(new SwapRequestFinalized($swapRequest));
        }

        $swapRequest->save();

        return redirect()->route('swap-request.index')->with('status', 'Swap request closed successfully.');
    }
}
