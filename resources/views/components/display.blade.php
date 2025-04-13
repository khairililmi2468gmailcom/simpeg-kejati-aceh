@props(['label'])

<div {{ $attributes->merge(['class' => '']) }}>
    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    <div class="rounded-md border border-gray-200 bg-gray-50 hover:bg-[#00A181] hover:text-white text-black px-3 py-2 text-sm">
        {{ $slot }}
    </div>
</div>