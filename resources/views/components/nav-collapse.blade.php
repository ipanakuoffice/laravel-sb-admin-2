<!-- resources/views/components/nav-collapse.blade.php -->
@php
    // Check if any child link is active by checking if any of the URLs are active
    $isActive = $activeRoutes ?? []; // Add the active routes to this array in the parent component
    $isActive = collect($isActive)->some(fn($route) => request()->routeIs($route)) ? 'show' : '';
@endphp

<li class="nav-item">
    <a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#" data-toggle="collapse"
       data-target="#{{ $id }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}" aria-controls="{{ $id }}">
        <i class="{{ $iconClass }}"></i>
        <span>{{ $title }}</span>
    </a>
    <div id="{{ $id }}" class="collapse {{ $isActive }}" aria-labelledby="heading{{ $id }}" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            {{ $slot }} <!-- Display the content inside the collapse -->
        </div>
    </div>
</li>
