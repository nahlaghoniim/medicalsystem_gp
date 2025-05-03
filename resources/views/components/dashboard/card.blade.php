<div {{ $attributes->merge(['class' => 'bg-white p-6 rounded-2xl shadow']) }}>
    @isset($title)
        <h2 class="text-xl font-bold mb-4">{{ $title }}</h2>
    @endisset
    {{ $slot }}
</div>
