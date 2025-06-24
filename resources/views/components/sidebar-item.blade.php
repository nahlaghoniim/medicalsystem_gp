@props(['active' => false, 'icon' => null])

<div class="flex items-center space-x-2 px-3 py-2 rounded-lg cursor-pointer font-medium text-sm
    {{ $active ? 'bg-blue-100 text-blue-800' : 'text-gray-700 hover:bg-gray-100' }}">
    @if ($icon)
        <i class="{{ $icon }} w-4 h-4"></i>
    @endif
    <span>{{ $slot }}</span>
</div>