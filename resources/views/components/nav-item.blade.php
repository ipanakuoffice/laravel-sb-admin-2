<li class="nav-item {{ Nav::isRoute($routeName) }}">
    <a class="nav-link" href="{{ route($routeName) }}">
        <i class="{{ $iconClass }}"></i>
        <span>{{ __($label) }}</span></a>
</li>
