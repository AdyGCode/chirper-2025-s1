<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form action="{{ route('chirps.update', $chirp) }}"
              method="POST">
            @csrf
            @method('patch')

            <textarea
                name="message"
                rows="3"
                placeholder="{{ __("What's on your mind?") }}"
                class="block w-full p-4
				       border-gray-300 focus:border-indigo-300
				       focus:ring focus:ring-indigo-200 focus:ring-opacity-50
				       rounded-md shadow-sm shadow-black/50"
            >{{ old('message', $chirp->message) }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2"/>

            <div class="mt-4 space-x-2">
                <x-primary-button>
                    {{ __('Save') }}
                </x-primary-button>
                <a href="{{ route('chirps.index') }}">
                    {{ __('Cancel') }}
                </a>
            </div>

        </form>
    </div>

</x-app-layout>
