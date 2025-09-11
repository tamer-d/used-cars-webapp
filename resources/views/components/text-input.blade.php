@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-light-primary dark:focus:border-dark-primary focus:ring-light-primary dark:focus:ring-dark-primary rounded-md shadow-sm']) }}>
