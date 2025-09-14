<?php

namespace App\Http\Controllers;

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

    public function create(Request $request): View|RedirectResponse
    {
        $desiredItem = Product::find($request->desired_item_id);

        if (! $desiredItem || ! $desiredItem->getSwap() || ! $desiredItem->getAvailable()) {
            return redirect()->route('home.index')
                ->with('error', 'The desired product is not available for swap.');
        }

        $offeredItems = Product::where('seller_id', Auth::guard('web')->user()->getId())
            ->where('swap', true)
            ->where('available', true)
            ->get();

        if ($offeredItems->isEmpty()) {
            return redirect()->route('home.index')
                ->with('error', 'You don\'t have any products to offer for a swap.');
        }

        $viewData = [];
        $viewData['title'] = 'Confirm your swap request';
        $viewData['desiredItem'] = $desiredItem;

        return view('swap_request.create')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $desiredItem = Product::find($request->desired_item_id);

        $swapRequest = SwapRequest::create([
            'initiator_id' => Auth::guard('web')->user()->getId(),
            'desired_item_id' => $request->desired_item_id,
            'status' => 'Pending',
            'date_created' => now(),
        ]);

        $desiredItem->seller->notify(new SwapRequestCreated($swapRequest));

        return redirect()->route('home.index')
            ->with('success', 'Swap request created successfully.');
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

        $viewData = [];
        $viewData['title'] = 'Receive Swap Request';
        $viewData['swapRequest'] = $swapRequest;
        $viewData['desiredItem'] = $swapRequest->getDesiredItem();
        $viewData['initiatorProducts'] = $initiatorProducts;

        return view('swap_request.receive')->with('viewData', $viewData);
    }

    public function respond(Request $request, int $id): View|RedirectResponse
    {
        SwapRequest::validateRespond($request);

        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getDesiredItem()->getSellerId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        if ($request->response === 'reject') {
            $swapRequest->setStatus('Rejected');
            $swapRequest->getInitiator()->notify(new SwapRequestRequestFinalized($swapRequest));
        } else {
            if (! $request->offered_item_id) {
                return back()->withErrors(['You must select a product to accept the swap request.']);
            }
            $swapRequest->setStatus('Counter Proposed');
            $swapRequest->setOfferedItemId($request->offered_item_id);
            $swapRequest->getInitiator()->notify(new SwapRequestResponded($swapRequest));
        }

        $swapRequest->save();

        return redirect()->route('home.index', ['id' => $swapRequest->getId()])
            ->with('success', 'Answer registered succesfully.');
    }

    public function finalize(Request $request, int $id): View
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getInitiatorId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        $desiredItem = Product::find($swapRequest->getDesiredItemId());
        $offeredItem = Product::find($swapRequest->getOfferedItemId());

        $viewData = [];
        $viewData['title'] = 'Swap counter-offer';
        $viewData['swapRequest'] = $swapRequest;
        $viewData['desiredItem'] = $desiredItem;
        $viewData['offeredItem'] = $offeredItem;

        return view('swap_request.finalize')->with('viewData', $viewData);
    }

    public function close(Request $request, int $id): RedirectResponse
    {
        SwapRequest::validateFinalize($request);

        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getInitiatorId() !== Auth::guard('web')->user()->getId()) {
            abort(403, 'No autorizado');
        }

        if ($request->response === 'reject') {
            $swapRequest->setStatus('Rejected');
            $swapRequest->getInitiator()->notify(new SwapRequestFinalized($swapRequest));
        } else {
            $swapRequest->setStatus('Accepted');
            $swapRequest->setDateAccepted(now());

            $swapRequest->getDesiredItem()->update(['available' => false]);
            $swapRequest->getOfferedItem()->update(['available' => false]);

            $swapRequest->getDesiredItem()->seller->notify(new SwapRequestFinalized($swapRequest));
            $swapRequest->getOfferedItem()->seller->notify(new SwapRequestFinalized($swapRequest));
        }

        $swapRequest->save();

        return redirect()->route('swap_request.index')->with('status', 'Swap request finalized successfully.');
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Your Swap Requests';
        $viewData['swapRequests'] = SwapRequest::where('initiator_id', Auth::guard('web')->user()->getId())
            ->orWhereHas('desiredItem', function ($query) {
                $query->where('seller_id', Auth::guard('web')->user()->getId());
            })
            ->get();

        return view('swap_request.index')->with('viewData', $viewData);
    }
}
