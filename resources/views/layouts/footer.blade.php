<footer class="mt-4  p-4 md:p-8
             bg-gray-900 dark:bg-gray-950
             text-gray-300 dark:text-gray-400
               text-sm
               grid grid-cols-1 md:grid-cols-2 gap-2">
    <section class="">
        <p>&copy; Copyright YYYY COMPANY/YOURNAME. All rights reserved.</p>
    </section>
    <section class="grid grid-cols-2 gap-4">
        <nav class="flex flex-col gap-1">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home') }}">About</a>
            <a href="{{ route('privacy') }}">Privacy</a>
            <a href="{{ route('home') }}">Terms and Conditions</a>
            <a href="{{ route('home') }}">Contact Us</a>
        </nav>
        <nav class="flex flex-col gap-1">
            <a href="{{ route('home') }}">License</a>
            <a href="{{ route('home') }}">Help</a>
            <a href="{{ route('home') }}">Link X</a>
        </nav>
    </section>
</footer>
