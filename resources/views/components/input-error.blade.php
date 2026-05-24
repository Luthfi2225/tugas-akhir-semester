@props(['messages'])

@if ($messages)
    <div class="dark:bg-[#3a3a3a] border dark:border-black rounded-md px-[0.850rem]">
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
                <li>{{ $messages[0] }}</li>
        </ul>
    </div>
@endif
