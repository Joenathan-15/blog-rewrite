<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col items-center justify-center">
        <div class="mt-5 mx-9">
            {{ $slot }}
        </div>
        <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">Open drawer</label>

    </div>
    <div class="drawer-side">
        <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
            <h1 class="text-2xl font-semibold text-center">Joenathan's Blog</h1>
            <h1 class="text-xl font-semibold mt-5">Recent posts</h1>
            <div class="mt-3">
                @foreach ($posts as $post)
                <li><a>{{ $post->title }}</a></li>
                @endforeach
            </div>
            <h1 class="text-xl font-semibold mt-5">Project Overview</h1>
            <div class="mt-3">
                @foreach ($projects as $project)
                <li><a>{{ $project->title }}</a></li>
                @endforeach
            </div>
            <h1 class="text-xl font-semibold mt-5">Category Overview</h1>
            <div class="mt-3">
                @foreach ($categories as $category)
                <li><a>{{ $category->title }}</a></li>
                @endforeach
            </div>
        </ul>

    </div>
</div>
