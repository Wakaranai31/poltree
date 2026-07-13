<aside class="sidebar" data-sidebar>
    <div class="sidebar-brand">
        <span class="brand-dot"></span>
        <span>Pol<span class="brand-orange">Tree</span></span>
    </div>

    <nav class="sidebar-nav">
        @foreach ($menuItems as $item)
            <a href="{{ $item['href'] }}" 
               class="sidebar-link {{ $item['active'] ? 'active' : '' }}"
               {!! $item['attributes'] !!}
               {!! $item['href'] === '#' ? 'onclick="event.preventDefault();"' : '' !!}>
               
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    {!! $item['icon'] !!}
                </svg>
                
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>