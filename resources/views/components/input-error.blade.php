@props(['messages'])

@if ($messages)
    <div class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md px-[0.850rem]">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
                <li>{{ $messages[0] }}</li>
        </ul>
    </div>
@endif
