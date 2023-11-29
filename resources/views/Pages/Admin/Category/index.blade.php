@extends('layouts.AdminLayout')
@push('title')
    Category
@endpush
@push('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('body')
    <div id="category_parent" class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
        <form id="form_input" class="bg-base-200 h-96 rounded-t-xl grid grid-cols-1 gap-4 p-6">
            <h1 class="text-2xl text-center">New Catgeory</h1>
            <div class="flex flex-col">
                <input type="text" id="title_txt" placeholder="Title" name="title"
                    class="p-2 px-3 input input-bordered w-full">
                <small id="title_error" class="text-red-500"></small>
            </div>

            <div class="flex flex-col">
                <input type="text" id="pictureLink_txt" name="pictureLink" placeholder="Picture Link"
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
        function fetch_category() {
            showLoadingScreen();
            var data = {
                "_token": "{{ csrf_token() }}",
            };
            $.ajax({
                url: "{{ route('admin.category.list') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    $('#category_parent').children().not(':first').remove();
                    response.forEach(category => {
                        var referenceElement = $('#form_input');
                        var newProjectElement = $(
                            `
                            <a href="/admin/category/edit/${category.uuid}" class="bg-base-200 h-96 rounded-t-xl">
                                <div class="rounded-t-xl bg-cover bg-center h-full" style="background-image: url('${category.attachment_link ? category.attachment_link : "https://lh3.google.com/u/4/d/15Ha_JZRvEdj7rOEv1xXANj0zAQtsaR3z=w1920-h982-iv1" }');">
                                    <div class="p-3 backdrop-brightness-50 text-white flex items-end justify-end transition ease-in-out h-full rounded-t-xl">
                                        <div class="grid text-end">
                                            <p>${category.title}</p>
                                            <p>Visibility : ${category.visibility ? "Public" : "Private"}</p>
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

        $("#form_input").on('submit', function(e) {
            e.preventDefault();
            var data = {
                "attachment_link": $('#pictureLink_txt').val(),
                "title": $("#title_txt").val(),
                "_token": "{{ csrf_token() }}",
            }
            $.ajax({
                url: "{{ route('admin.category.store') }}",
                method: "POST",
                data: data,
                success: function(response) {
                    $('#title_txt').val('');
                    $('#pictureLink_txt').val('');
                    fetch_category()
                },
                error: function(error) {
                    $("#title_error").text(error.responseJSON.message)
                }
            });
        })



        $('#document').ready(function() {
            fetch_category();
        })
    </script>
@endpush
