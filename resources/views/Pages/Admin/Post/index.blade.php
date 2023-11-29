@extends('layouts.AdminLayout')
@push('title')
    Project
@endpush
@push('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('body')
    <form id="form_input" class="bg-base-200 w-full lg:w-1/2 p-5 mx-auto grid gap-5">
        <img id="image_preview" src="https://lh3.google.com/u/4/d/15Ha_JZRvEdj7rOEv1xXANj0zAQtsaR3z=w1920-h982-iv1"
            class="h-64 w-full" alt="">
        <input id="attachment_link_txt" type="text" class="p-2 input input-bordered w-full rounded-xl"
            placeholder="Picture Link">
        <div>
            <input id="title_txt" type="text" class="p-2 input input-bordered w-full rounded-xl" placeholder="Title">
            <small id="title_error" class="text-red-500"></small>
        </div>
        <textarea id="editor1" name="editor1"></textarea>
        <button type="submit" class="btn btn-primary">Save Changes</button>
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
                "_token": "{{ csrf_token() }}",
                "parent_uuid": "{{ $parent_uuid }}"
            }
            $.ajax({
                url: "{{ route('admin.post.store') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    window.location.href = document.referrer
                },
                error: function(error) {
                    $("#title_error").text(error.responseJSON.message)
                }
            });
        })
    </script>
@endpush
