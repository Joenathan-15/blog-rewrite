<div class="px-3 flex justify-between bg-base-200">
    <div class="py-5 px-5">
        <a class="" href="{{ route('admin.dashboard')}}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
        </a>
    </div>
    <div class="flex items-center px-3">
        <div id="hamburger_button" class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>
    </div>
</div>
<div class="md:flex md:justify-center">
    <div id="hamburger-content"
        class="bg-base-200 shadow-2xl px-3 lg:w-1/2 w-full rounded-b-xl mx-auto hidden absolute z-[100]">
        <div class="grid">
            <a class="w-full p-3 hover:bg-base-100" href="{{ route("admin.dashboard") }}">Dashboard</a>
            <a class="w-full p-3 hover:bg-base-100" href="{{ route("admin.project.index") }}">Project</a>
            <a class="w-full p-3 hover:bg-base-100" href="{{ route('admin.category.index') }}">Category</a>
            <a class="w-full p-3 hover:bg-base-100" href="{{ route('admin.logout') }}">Logout</a>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        var is_open = false

        function toggle_hamburger() {
            if (is_open) {
                $('#hamburger-content').addClass("hidden");
                is_open = false;
            } else {
                $('#hamburger-content').removeClass("hidden");
                is_open = true;
            }
        }

        function closeHamburgerIfOutsideClick(event) {
            if (!$(event.target).closest('#hamburger-content, #hamburger_button').length) {
                $('#hamburger-content').addClass("hidden");
                is_open = false;
            }
        }

        $('#hamburger_button').on("click", function(event) {
            toggle_hamburger();
            event.stopPropagation();
        });

        $(document).on("click", function(event) {
            closeHamburgerIfOutsideClick(event);
        });
    </script>
@endpush
