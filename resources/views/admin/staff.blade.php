<li><a href="{{ route('admin.user.edit', $staffSubtree->id) }}">{{ $staffSubtree->name }}</a>
    @if ($staffSubtree->children()->count() > 0)
        <ul class="list_line">
            @foreach($staffSubtree->children as $staffSubtree)
                @include('admin.staff', $staffSubtree)
            @endforeach
        </ul>
    @endif
</li>