<div class="mt-1 text-right">
    {{-- Care about people's approval and you will be their prisoner. --}}
    <ul class="inline-flex rounded-md bg-gray-100 px-2 py-1 space-x-4">
        <li class="flex">
            <a class="cursor-pointer"
               wire:click="like()" >
                <i class="fa-solid fa-thumbs-up mr-2 text-green-800"></i>
            </a>
            {{ $likes }}
        </li>
        <li class="flex">
            <a class="cursor-pointer"
               wire:click="dislike()" >
                <i class="fa-solid fa-thumbs-down mr-2 text-red-800"></i>
            </a>
            {{ $dislikes }}
        </li>
    </ul>
    @error('unauthenticated')
    <div class="text-red-500">{!! $message !!}</div>
    @enderror
</div>
