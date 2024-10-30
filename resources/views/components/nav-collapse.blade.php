<!-- resources/views/components/nav-collapse.blade.php -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{ $id }}"
       aria-expanded="true" aria-controls="{{ $id }}">
        <i class="{{ $iconClass }}"></i>
        <span>{{ $title }}</span>
    </a>
    <div id="{{ $id }}" class="collapse" aria-labelledby="heading{{ $id }}" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            {{ $slot }} <!-- Menampilkan isi slot untuk item collapse -->
        </div>
    </div>
</li>
