@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $viewData['title'] }}</h1>

    @if($viewData['allNotifications']->count() > 0)
        <div class="list-group">
            @foreach($viewData['allNotifications'] as $notification)
                <div class="list-group-item d-flex justify-content-between align-items-center
                    {{ $notification->read_at ? '' : 'list-group-item-action list-group-item-light' }}">
                    
                    <div>
                        <strong>{{ $notification->data['message'] ?? 'New notification' }}</strong>
                        <br>
                        <small class="text-muted">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>

                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="GET">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-outline-primary">
                                View notification
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

    @else
        <div class="alert alert-info">
            You don't have any notifications.
        </div>
    @endif
</div>
@endsection
