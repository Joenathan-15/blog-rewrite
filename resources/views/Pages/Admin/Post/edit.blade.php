@extends('layouts.AdminLayout')
@push('title')
    Project
@endpush
@push('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('body')
    <form id="form_input" class="bg-base-200 w-full lg:w-1/2 p-5 mx-auto grid gap-5">
        <img id="image_preview"
            src="{{ $post->attachment_link ? $post->attachment_link : 'https://lh3.google.com/u/4/d/15Ha_JZRvEdj7rOEv1xXANj0zAQtsaR3z=w1920-h982-iv1' }}"
            class="h-64 w-full" alt="">
        <input value="{{ $post->attachment_link }}" id="attachment_link_txt" type="text"
            class="p-2 input input-bordered w-full rounded-xl" placeholder="Picture Link">
        <input value="{{ $post->title }}" id="title_txt" type="text" class="p-2 input input-bordered w-full rounded-xl"
            placeholder="Title">
        <textarea id="editor1" name="editor1">{{ $post->content }}</textarea>
        <select id="visibility_selelect" class="select select-bordered w-full">
            <option {{ $post->visibility ? '' : 'selected' }} value="0">Private</option>
            <option {{ $post->visibility ? 'selected' : '' }} value="1">Public</option>
        </select>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button id="delete_btn" type="button" class="btn btn-primary p-3">Delete</button>
    </form>
@endsection
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        $('#attachment_link_txt').on("change", function() {
            $('#image_preview').attr("src", $('#attachment_link_txt').val())
        });
        CKEDITOR.replace('editor1');
        hideLoadingScreen();
        $("#form_input").on('submit', function(e) {
            e.preventDefault();
            var data = {
                "attachment_link": $('#attachment_link_txt').val(),
                "title": $("#title_txt").val(),
                "content": CKEDITOR.instances.editor1.getData(),
                "visibility": $('#visibility_selelect').val(),
                "_token": "{{ csrf_token() }}",
            }
            $.ajax({
                url: "{{ route('admin.post.save', $post->uuid) }}",
                method: "POST",
                data: data,
                success: function(response) {
                    window.location.href = document.referrer
                },
                error: function(error) {
                    console.error(error);
                }
            });
        })
        $('#delete_btn').on('click', function() {
            var is_okay = confirm("Are you sure?")

            if (is_okay) {
                $.ajax({
                    url: "{{ route('admin.post.delete', $post->uuid) }}",
                    method: "GET",
                    success: function(response) {
                        window.location.href = "{{ route('admin.dashboard') }}"
                        delete_success_notification("Post")
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            } else {
                return false
            }
        });
    </script>
@endpush
