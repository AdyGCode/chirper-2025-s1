<x-app-layout>

    <x-slot name="header" >
        <h2 class="grow font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>

        <p><a href="{{ route('users.create') }}"
              class="bg-gray-100 p-2 rounded">New User</a></p>

        <form action="{{ route('users.index') }}" method="GET">
            <x-text-input id="search"
                          type="text"
                          name="search"
                          />

            <button type="submit" class="bg-gray-200    ">Search</button>
        </form>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <article class="my-0">

                    <header class="grid grid-cols-10 bg-gray-500 text-gray-50 text-lg px-4 py-2">
                        <span class="col-span-1">#</span>
                        <span class="col-span-4">User</span>
                        <span class="col-span-1">Added</span>
                        <span class="col-span-1">Role</span>
                        <span class="col-span-1">Actions</span>
                    </header>

                    @foreach ($users as $user)
                        <section
                            class="px-4 grid grid-cols-10 py-1 hover:bg-gray-100 border-b border-b-gray-300 transition duration-150">
                            <p class="col-span-1">{{ $loop->index + 1 }}</p>

                            <h5 class="flex flex-col col-span-4 text-gray-800">
                                {{ $user->name }}
                                <br>
                                <small class="text-xs text-gray-400">
                                    {{ $user->email }}
                                </small>
                            </h5>

                            <p class="text-xs text-gray-400 col-span-1 p-1">
                                {{ $user->created_at->format('j M Y') }}
                            </p>

                            <p class="col-span-1">
                                <span class="text-xs bg-gray-800 text-gray-100 rounded-full px-2 py-0.5">
                                    Role
                                </span>
                            </p>
                            <!-- Only Admin and Staff access these options -->
                            <form method="POST"
                                  class="col-span-2 flex border border-gray-300 rounded-full px-0 overflow-hidden"
                                  action="{{ route('users.delete', $user) }}">

                                @csrf

                                <a href="{{ route('users.show', $user) }}"
                                   class="bg-gray-100 hover:bg-blue-500
                                          text-blue-800 hover:text-gray-100 text-center
                                          border-r border-r-gray-300
                                          transition ease-in-out duration-300
                                          grow px-2
                                          rounded-l">
                                    <i class="fa-solid fa-user  text-sm"></i>
                                    {{ __('Show') }}
                                </a>

                                <a href="{{ route('users.edit', $user) }}"
                                   class="bg-gray-100 hover:bg-amber-500
                                        text-amber-800 hover:text-gray-100  text-center
                                          border-x border-x-gray-300
                                          transition ease-in-out duration-300
                                          grow px-2 ">
                                    <i class="fa-solid fa-user-edit  text-sm"></i>
                                    {{ __('Edit') }}
                                </a>

                                <button type="submit"
                                        class="bg-gray-100 hover:bg-red-500
                                             text-red-800 hover:text-gray-100 text-center
                                             border-l border-l-gray-300
                                               transition ease-in-out duration-300
                                               grow px-2
                                               rounded-r ">
                                    <i class="fa-solid fa-user-minus  text-sm"></i>
                                    {{ __('Delete') }}
                                </button>

                            </form>
                            <!-- /Only Admin and Staff access these options -->

                        </section>
                    @endforeach
                    <footer class="px-4 pb-2 pt-4 ">
                        {{ $users->links() }}
                    </footer>
                </article>

            </div>
        </div>
    </div>
</x-app-layout>
