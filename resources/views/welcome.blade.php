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
