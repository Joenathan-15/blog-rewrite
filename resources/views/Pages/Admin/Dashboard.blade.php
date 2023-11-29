@extends('layouts.AdminLayout')
@push('title')
    Dashboard
@endpush
@push('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('body')
    <div class="grid lg:grid-cols-3 gap-10">
        <div class="bg-base-200 py-5 text-white grid items-center">
            <h1 class="text-2xl font-semibold text-center">Post Created</h1>
            <h1 id="post_count" class="text-xl font-semibold text-center">0</h1>
        </div>
        <div class="bg-base-200 py-5 text-white grid items-center">
            <h1 class="text-2xl font-semibold text-center">Category Created</h1>
            <h1 id="category_count" class="text-xl font-semibold text-center">0</h1>
        </div>
        <div class="bg-base-200 py-5 text-white grid items-center">
            <h1 class="text-2xl font-semibold text-center">Project Created</h1>
            <h1 id="project_count" class="text-xl font-semibold text-center">0</h1>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            showLoadingScreen();
            var data = {
                "_token": "{{ csrf_token() }}",
            };
            $.ajax({
                url: "{{ route('admin.count') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    $('#post_count').text(response.post)
                    $('#category_count').text(response.category)
                    $('#project_count').text(response.project)
                    hideLoadingScreen()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: " + textStatus, errorThrown);
                }
            });
        });
    </script>
@endpush
