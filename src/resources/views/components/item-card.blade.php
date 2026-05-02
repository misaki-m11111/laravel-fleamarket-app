<div class="item-card">
    <a href="/item/{{ $item->id }}" class="item-card__link">
        <div class="item-card__image-wrap">
            <img
                src="{{ asset('storage/' . $item->image) }}"
                alt="{{ $item->name }}"
                class="item-card__image"
            >

            @if($item->sold_at)
                <span class="item-card__sold">SOLD</span>
            @endif
        </div>

        <p class="item-card__name">{{ $item->name }}</p>
    </a>
</div>