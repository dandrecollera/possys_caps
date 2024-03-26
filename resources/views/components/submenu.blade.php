@php
    $path = request()->path();
@endphp

<a href="#" style="text-decoration: none; color: black">
    <i class="fa-solid fa-bell me-3"></i>
</a>
<a href="#" style="text-decoration: none; color: black">
    <i class="fa-solid fa-message me-3"></i>
</a>
<a href="/settings" style="text-decoration: none;{{ $path == 'settings' ? 'color: #92140c;' : 'color: black;' }}">
    <i class="fa-solid fa-gear me-3"></i>
</a>
