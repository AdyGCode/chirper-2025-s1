<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight grow">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 gap-6 flex flex-col">

                    <h2 class="text-3xl">"Retro" Blade Templates</h2>
                    <p>Using the Blade templates from Laravel 11, with a few tweaks to provide a base for blade based
                        applications without the new UI features.</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-3 space-x-12">

                @foreach ($chirps as $chirp)
                    <section class="p-6 flex space-x-2">

                        <i class="fa-regular fa-comment-dots fa-shake
                              text-xl text-blue-400"
                           style="--fa-animation-duration: 2s;
                               --fa-animation-iteration-count: 2;
                              --fa-animation-timing: ease-in-out;"
                           aria-hidden="true"></i>

                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <h5>
                                <span class="text-gray-800">
                                {{ $chirp->user->name }}
                                </span>
                                    <small class="ml-2	text-sm text-gray-600">
                                        {{ $chirp->created_at->format('j M Y, g:i a') }}
                                    </small>
                                </h5>

                                @if($chirp->user->is(auth()->user()))
                                    <x-dropdown>

                                        <x-slot name="trigger">
                                            <button class="bg-gray-200 rounded hover:bg-black hover:text-white">
                                                <i class="fa-solid fa-bandage px-4"></i>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link
                                                :href="route('chirps.edit',$chirp)">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>

                                            <form method="POST"
                                                  action="{{ route('chirps.destroy', $chirp) }}">
                                                @csrf
                                                @method('delete')

                                                <x-dropdown-link
                                                    :href="route('chirps.destroy',$chirp)"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>

                                            </form>

                                        </x-slot>

                                    </x-dropdown>
                                @endif

                            </div>
                            <p class="mt-4 text-lg text-gray-900">
                                {{ $chirp->message }}
                            </p>

                            @livewire('like-dislike', [$chirp])

                        </div>

                    </section>
                @endforeach


            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-2 space-x-12">
                <div class="p-6 text-gray-900 gap-6 flex flex-col">
                    <h3 class="text-xl">Starter Template Includes:</h3>
                    <ul class="list-disc ml-8">
                        <li>Blade Templates circa Laravel 11</li>
                        <li>Navigation bar on guest and app layouts</li>
                        <li>Footer in guest and app layouts</li>
                        <li>Sample Users (Admin - Validated, Staff &amp; Client - not validated)</li>
                        <li><a href="https://laravel.com/docs/sanctum"
                               class="text-blue-700 underline underline-offset-3">
                                Sanctum authentication</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></li>
                        <li>Email Verification enabled</li>
                        <li><a href="https://laraveldebugbar.com"
                               class="text-blue-700 underline underline-offset-3">
                                Laravel Debug Bar</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></li>

                        <li><a href="https://laravel.com/docs/telescope"
                               class="text-blue-700 underline underline-offset-3">
                                Laravel Telescope</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></li>

                        <li><a href="https://livewire.laravel.com"
                               class="text-blue-700 underline underline-offset-3">
                                Laravel Livewire</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></li>

                        <li><a href="https://fontawesom.com"
                               class="text-blue-700 underline underline-offset-3">
                                Font Awesome 6 (Free)</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></li>

                    </ul>
                </div>

                <div class="p-6 text-gray-900 gap-6 flex flex-col">
                    <h3 class="text-xl">Template Development</h3>
                    <dl class="">
                        <dt>Adrian Gould</dt>
                        <dd>Lecturer (ASL1), <a href="https://northmetrotafe.wa.edu.au"
                                                class="text-red-700 underline underline-offset-3">
                                North Metropolitan TAFE</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i>,
                            Perth WA, Australia
                        </dd>
                        <dd>GitHub Pages: <a href="https://adygcode.github.io"
                                             class="text-blue-700 underline underline-offset-3">
                                https://adygcode.github.io</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></dd>
                        <dd>GitHub Repos: <a href="https://github.com/AdyGCode"
                                             class="text-blue-700 underline underline-offset-3">
                                https://github.com/AdyGCode</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></dd>
                        <dd>Starter Kit Repo: <a href="https://github.com/AdyGCode/retro-blade-kit"
                                                 class="text-blue-700 underline underline-offset-3">
                                Retro Blade Starter Kit</a>
                            <i class="fa-solid fa-up-right-from-square text-gray-300 text-xs"></i></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
