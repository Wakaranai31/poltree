<aside class="sidebar" data-sidebar>
    <div class="flex justify-center mb-20 px-4">
        <img src="{{ asset('images/logo-text.png') }}" alt="Logo PolTree" class="w-full max-w-52 h-auto object-contain">
    </div>
    <nav class="sidebar-nav">
        @foreach ($menuItems as $item)
        <a href="{{ $item['href'] }}"
            class="sidebar-link {{ $item['active'] ? 'active' : '' }}"
            {!! $item['attributes'] !!}
            {!! $item['href']==='#' ? 'onclick="event.preventDefault();"' : '' !!}>

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                {!! $item['icon'] !!}
            </svg>

            <span>{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>
</aside>