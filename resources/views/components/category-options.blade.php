@props(['categories', 'parentId' => null, 'level' => 0])

@foreach ($categories->where('parent_id', $parentId) as $category)
    @if ($parentId === null)
        {{-- Parent level: use optgroup --}}
        <optgroup label="{{ $category->name }}">
            <x-category-options :categories="$categories" :parentId="$category->id" :level="$level + 1" />
        </optgroup>
    @else
        {{-- Child levels: use options with indentation --}}
        <option value="{{ $category->id }}" style="padding-left: {{ $level * 1.5 }}em;">
            {{ str_repeat('— ', $level - 1) }}{{ $category->name }}
        </option>
        {{-- Recursively render children --}}
        <x-category-options :categories="$categories" :parentId="$category->id" :level="$level + 1" />
    @endif
@endforeach
