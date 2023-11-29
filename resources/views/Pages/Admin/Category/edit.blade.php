@extends('layouts.AdminLayout')
@push('title')
    Catgeory
@endpush
@push('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('body')
    <form id="form_edit" class="bg-base-200 md:w-1/2 lg:w-2/5 p-5 mx-auto grid gap-5">
        <img id="image_preview"
            src="{{ $category->attachment_link ? $category->attachment_link : 'https://lh3.google.com/u/4/d/15Ha_JZRvEdj7rOEv1xXANj0zAQtsaR3z=w1920-h982-iv1' }}"
            class="h-64 w-full" alt="">
        <input id="attachment_link_txt" type="text" class="p-2 input input-bordered w-full rounded-xl"
            value="{{ $category->attachment_link }}" placeholder="Picture Link">
        <div class="grid">
            <input id="title_txt" type="text" class="p-2 input input-bordered w-full rounded-xl"
                value="{{ $category->title }}" placeholder="Title">
            <small id="title_error" class="text-red-500"></small>
        </div>
        <textarea id="description_txt" placeholder="Description" class="textarea textarea-bordered resize-none" cols="30"
            rows="5">{{ $category->description }}</textarea>
        <select id="visibility_selelect" class="select select-bordered w-full">
            <option {{ $category->visibility ? '' : 'selected' }} value="0">Private</option>
            <option {{ $category->visibility ? 'selected' : '' }} value="1">Public</option>
        </select>
        <button type="submit" class="btn btn-primary p-3">Save Changes</button>
        <button id="delete_btn" type="button" class="btn btn-primary p-3">Delete</button>
    </form>
    <div class="bg-base-200 p-3 mt-5 rounded-xl">
        <h1 class="text-center text-3xl font-semibold mt-3">Post</h1>
        <div id="post_parent" class="grid gap-5 grid-cols-1 md:grid-cols-3 xl:grid-cols-4 mt-5">
            <a id="create_post" href="{{ route('admin.post.index', 'parent_uuid=' . $category->uuid) }}"
                class="bg-base-300 hover:border border-base-300 hover:bg-base-200 transition-all duration-300 hover:text-white h-96 rounded-t-xl p-6 flex justify-center items-center">
                <div>
                    <h1 class="text-2xl text-center">Add Post</h1>
                    <h1 class="text-2xl text-center">+</h1>
                </div>
            </a>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        showLoadingScreen()
        $('document').ready(function() {
            $('#attachment_link_txt').on("change", function() {
                $('#image_preview').attr("src", $('#attachment_link_txt').val())
            });
            $.ajax({
                url: "{{ route('admin.post.find', $category->uuid) }}",
                method: "GET",
                success: function(response) {
                    hideLoadingScreen()
                    response.forEach(post => {
                        $('#post_parent').children().not(':first').remove();
                        response.forEach(post => {
                            var referenceElement = $('#create_post');
                            var newProjectElement = $(
                                `
                                <a href="/admin/post/edit/${post.uuid}" class="bg-base-300 h-96 rounded-t-xl">
                                    <div class="rounded-t-xl bg-cover bg-center h-full" style="background-image: url('${post.attachment_link ? post.attachment_link : "https://lh3.google.com/u/4/d/15Ha_JZRvEdj7rOEv1xXANj0zAQtsaR3z=w1920-h982-iv1" }');">
                                        <div class="p-3 backdrop-brightness-50 text-white flex items-end justify-end h-full rounded-t-xl">
                                            <div class="grid text-end">
                                                <p>${post.title}</p>
                                                <p>Visibility : ${post.visibility ? "Public" : "Private"}</p>
                                                </div>
                                                </div>
                                                </div>
                                                </a>
                                                `
                            );
                            newProjectElement.insertAfter(referenceElement);
                        });

                    });
                },
                error: function(error) {
                    console.error(error);
                }
            })


            $("#form_edit").on("submit", function(e) {
                e.preventDefault()
                var data = {
                    "attachment_link": $('#attachment_link_txt').val(),
                    "title": $('#title_txt').val(),
                    "description": $("#description_txt").val(),
                    "visibility": $('#visibility_selelect').val(),
                    "_token": "{{ csrf_token() }}",
                }
                $.ajax({
                    url: "{{ route('admin.category.save', $category->uuid) }}",
                    method: "POST",
                    data: data,
                    success: function(response) {
                        edit_success_notification("Category")
                    },
                    error: function(error) {
                        $('#title_error').text(error.responseJSON.message)
                    }
                })
            });

            $('#delete_btn').on('click', function() {
                var is_okay = confirm("Are you sure?")

                if (is_okay) {
                    $.ajax({
                        url: "{{ route('admin.category.delete', $category->uuid) }}",
                        method: "GET",
                        success: function(response) {
                            window.location.href = "{{ route('admin.dashboard') }}"
                            delete_success_notification("Category")
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    })
                } else {
                    return false
                }
            });
        })
    </script>
@endpush
