@extends('layouts.AdminLayout')
@push('title')
    Project
@endpush
@push('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('body')
    <div id="project_parent" class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
        <form id="project_form" class="bg-base-200 h-96 rounded-t-xl grid grid-cols-1 gap-4 p-6">
            <h1 class="text-2xl text-center">New Project</h1>
            <div class="flex flex-col">
                <input type="text" id="title" placeholder="Title" name="title"
                    class="p-2 px-3 input input-bordered w-full">
                <small id="title_error" class="text-red-500"></small>
            </div>

            <div class="flex flex-col">
                <input type="text" id="pictureLink" name="pictureLink" placeholder="Picture Link"
                    class="p-2 px-3 input input-bordered w-full">
            </div>

            <div class="flex flex-col">
                <input type="text" id="repolink" name="repolink" placeholder="Repository Link"
                    class="p-2 px-3 input input-bordered w-full">
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary">
                Add Project
            </button>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        function fetch_project() {
            showLoadingScreen();
            var data = {
                "_token": "{{ csrf_token() }}",
            };
            $.ajax({
                url: "{{ route('admin.project.list') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    $('#project_parent').children().not(':first').remove();
                    response.forEach(project => {
                        var referenceElement = $('#project_form');
                        var newProjectElement = $(
                            `
                            <a href="/admin/project/edit/${project.uuid}" class="bg-base-200 h-96 rounded-t-xl">
                                <div class="rounded-t-xl bg-cover bg-center h-full" style="background-image: url('${project.attachment_link ? project.attachment_link : "https://lh3.google.com/u/4/d/15Ha_JZRvEdj7rOEv1xXANj0zAQtsaR3z=w1920-h982-iv1" }');">
                                    <div class="p-3 backdrop-brightness-50 text-white flex items-end justify-end transition ease-in-out h-full rounded-t-xl">
                                        <div class="grid text-end">
                                            <p>${project.title}</p>
                                            <p>Visibility : ${project.visibility ? "Public" : "Private"}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            `
                        );
                        newProjectElement.insertAfter(referenceElement);
                    });

                    hideLoadingScreen()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: " + textStatus, errorThrown);
                    window.location.href = "{{ route('admin.dashboard') }}"
                }
            });
        }

        $('#project_form').submit(function(e) {
            e.preventDefault();
            $('#submitBtn').prop('disabled', true);

            var data = {
                "title": $('#title').val(),
                "attachment_link": $('#pictureLink').val(),
                "repository": $('#repolink').val(),
                "_token": "{{ csrf_token() }}",
            };

            $.ajax({
                url: "{{ route('admin.project.store') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    fetch_project();
                    // Clear form fields
                    $('#title').val('');
                    $('#pictureLink').val('');
                    $('#repolink').val('');
                },
                error: function(error) {
                    $('#title_error').text(error.responseJSON.message);
                },
                complete: function() {
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });

        $(document).ready(function() {
            fetch_project()
        });
    </script>
@endpush
