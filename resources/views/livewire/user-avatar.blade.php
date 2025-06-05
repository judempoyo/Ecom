<div>
    @if($user->profile_photo)
    <flux:avatar 
        circle 
        class="rounded-full cursor-pointer"
        src="{{ asset('storage/' . $user->profile_photo) }}"
    />
@else
    <div class="{{ 
        $size === 'sm' ? 'w-8 h-8 text-sm' : 
        ($size === 'lg' ? 'w-12 h-12 text-lg' : 'w-10 h-10')
    }} rounded-full bg-gray-300 dark:bg-zinc-600 flex items-center justify-center">
        <span class="text-gray-600 dark:text-gray-300">
           {{--   {{ substr($user->name, 0, 1) }}  --}}
            {{ $user->initials()}}
        </span>
    </div>
@endif
</div>