@props(['user'])

@php
    $image = $user->profile->image ?? null;
@endphp

<div class="user-icon">
    @if ($image)
        <img src="{{ asset('storage/' . $image) }}" alt="ユーザー画像">
    @else
        <div class="user-icon__placeholder"></div>
    @endif
</div>