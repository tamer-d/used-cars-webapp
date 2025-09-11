@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-light-text dark:text-dark-text']) }}>
    {{ $value ?? $slot }}
</label>
