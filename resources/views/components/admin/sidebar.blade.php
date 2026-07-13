<aside class="admin-sidebar">
    <div class="admin-brand">
        <span class="admin-brand-dot" aria-hidden="true"></span>
        <div class="admin-brand-text">
            <strong>Pol</strong><span>Tree</span>
        </div>
    </div>

    <nav class="admin-nav" aria-label="Menu admin">
        @foreach ($menuItems as $item)
            @php $menuIconAsset = $resolveIconAsset($item['icon']); @endphp
            <a href="{{ $item['href'] }}"
               class="admin-nav-link"
               {!! $item['active'] ? 'aria-current="page"' : '' !!}
               {!! $item['href'] === '#' ? 'aria-disabled="true" onclick="event.preventDefault();"' : '' !!}>
               
                @if ($menuIconAsset) 
                    <img src="{{ $menuIconAsset }}" alt="" aria-hidden="true">
                @else
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        {!! config('icons.admin_'.$item['icon'], config('icons.admin_default')) !!}
                    </svg>
                @endif
                
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>