<?php

// Author: Isabella Camacho

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

    public function show(int $id): View|RedirectResponse
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if (
            $swapRequest->getInitiatorId() !== Auth::guard('web')->user()->getId() &&
            $swapRequest->getDesiredItem()->getSellerId() !== Auth::guard('web')->user()->getId()
        ) {
            abort(403, __('swap.not_authorized'));
        }

        $desiredItem = Product::find($swapRequest->getDesiredItemId());
        $offeredItem = Product::find($swapRequest->getOfferedItemId());

        $initiator = CustomUser::find($swapRequest->getInitiatorId())->getName();
        $responder = CustomUser::find($swapRequest->getDesiredItem()->getSellerId())->getName();

        $viewData = [];
        $viewData['swapRequest'] = $swapRequest;
        $viewData['desiredItem'] = $desiredItem;
        $viewData['offeredItem'] = $offeredItem;
        $viewData['initiator'] = $initiator;
        $viewData['responder'] = $responder;

        return view('swap-request.show')->with('viewData', $viewData);
    }

    public function create(int $id): View|RedirectResponse
    {
        $desiredItem = Product::find($id);

        if (! $desiredItem || ! $desiredItem->getSwap() || ! $desiredItem->getAvailable()) {
            return redirect()->route('home.index')
                ->with('status', __('swap.product_not_available'));
        }

        $offeredItems = Product::where('seller_id', Auth::guard('web')->user()->getId())
            ->where('swap', true)
            ->where('available', true)
            ->get();

        if ($offeredItems->isEmpty()) {
            return redirect()->route('home.index')
                ->with('status', __('swap.dont_have_products'));
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
                ->with('status', __('swap.already_requested'));
        }

        $swapRequest = SwapRequest::create([
            'initiator_id' => Auth::guard('web')->user()->getId(),
            'desired_item_id' => $request->desired_item_id,
            'status' => 'Pending',
            'date_created' => now(),
        ]);

        $desiredItem->getSeller()->notify(new SwapRequestCreated($swapRequest));

        return redirect()->route('home.index')
            ->with('status', __('swap.success'));
    }

    public function receive(int $id): View|RedirectResponse
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getInitiatorId() === Auth::guard('web')->user()->getId()) {
            return redirect()->route('swap-request.show', $swapRequest->getId());
        }

        if ($swapRequest->getDesiredItem()->getSellerId() !== Auth::guard('web')->user()->getId()) {
            abort(403, __('swap.not_authorized'));
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
            abort(403, __('swap.not_authorized'));
        }

        if ($swapRequest->getStatus() !== 'Pending') {
            return redirect()->route('home.index')
                ->with('status', __('swap.already_responded'));
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
            ->with('status', __('swap.answer_registered'));
    }

    public function finalize(int $id): View|RedirectResponse
    {
        $swapRequest = SwapRequest::findOrFail($id);

        if ($swapRequest->getDesiredItem()->getSellerId() === Auth::guard('web')->user()->getId()) {
            return redirect()->route('swap-request.show', $swapRequest->getId());
        }

        if ($swapRequest->getInitiatorId() !== Auth::guard('web')->user()->getId()) {
            abort(403, __('swap.not_authorized'));
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
                'Pending' => __('swap.still_pending'),
                'Accepted' => __('swap.already_accepted'),
                'Rejected' => __('swap.already_rejected'),
                default => __('swap.error_finalizing'),
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

            $relatedSwaps = SwapRequest::where(function ($query) use ($desiredItem, $offeredItem) {
                $query->where('offered_item_id', $desiredItem->getId())
                    ->orWhere('desired_item_id', $desiredItem->getId())
                    ->orWhere('offered_item_id', $offeredItem->getId())
                    ->orWhere('desired_item_id', $offeredItem->getId());
            })
                ->where('id', '!=', $swapRequest->getId())
                ->whereNotIn('status', ['Rejected', 'Accepted'])
                ->get();

            foreach ($relatedSwaps as $relatedSwap) {
                $relatedSwap->setStatus('Rejected');
                $relatedSwap->save();

                $relatedSwap->getInitiator()->notify(new SwapRequestFinalized($relatedSwap));
                $relatedSwap->getDesiredItem()->getSeller()->notify(new SwapRequestFinalized($relatedSwap));
            }

            $swapRequest->getDesiredItem()->getSeller()->notify(new SwapRequestFinalized($swapRequest));
            $swapRequest->getOfferedItem()->getSeller()->notify(new SwapRequestFinalized($swapRequest));
        }

        $swapRequest->save();

        return redirect()->route('swap-request.index')->with('status', __('swap.success_finalizing'));
    }
}
