@php
    // Original menu was 3 levels deep (Door > Membrane Door > 2D Membrane Door)
    $children = $level >= 2 ? collect() : $category->navChildren;
@endphp

@if($children->isNotEmpty())
    <li class="dropdown">
        <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }} <i class="fas fa-arrow-right m-h" aria-hidden="true"></i></a>
        <ul class="submenu {{ $children->count() > 8 ? 'sscrl' : '' }}">
            @foreach($children as $child)
                @include('partials.nav-category', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    </li>
@else
    <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
@endif