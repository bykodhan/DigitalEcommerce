@extends('back.layouts.app')
@push('title', 'Düzenle')
@section('content')
    <form action="{{ route('admin.pages.update') }}" method="POST">
        <input type="hidden" name="id" value="{{ $page->id }}">
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <span><i class="fas fa-edit"></i> "{{ $page->title }}" Düzenle</span>
                    </div>
                    <div class="card-body pb-1">
                        @csrf
                        <div class="row g-1">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label>Başlık* (meta title)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title" max="255"
                                            onchange="document.getElementById('input_slug').value = slugify(this.value)"
                                            required value="{{ $page->title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label>Seo Url*</label>
                                    <div class="input-group">
                                        <input id="input_slug" type="text" class="form-control" name="slug"
                                            max="300" required value="{{ $page->slug }}">
                                        <span class="input-group-text bg-white"><i class="fa-solid fa-link"></i></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label>Açıklama (meta description)</label>
                                    <div class="input-group">
                                        <input class="form-control tags" type="text" max="255" name="description"
                                            value="{{ $page->description }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 shadow-sm">
                <textarea id="editor" name="content">{!! $page->content !!}</textarea>
            </div>
            <div class="col-lg-6 mx-auto d-grid">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Değişiklikleri Kaydet</button>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            height: 600,
            menubar: false,
            language: 'tr',
            advlist_number_styles: "default",
            advlist_bullet_styles: "default",
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'h2 h3 bold italic blockquote strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor hr | link image media | table emoticons codesample | ltr rtl |  removeformat help fullscreen preview code',
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote forecolor backcolor quickimage quicktable',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            automatic_uploads: true,
            image_title: true,

            paste_auto_cleanup_on_paste: true,
            paste_remove_styles: true,
            paste_remove_styles_if_webkit: true,
            paste_strip_class_attributes: true,
            paste_postprocess: function(plugin, args) {
                var allElements = args.node.getElementsByTagName("img");
                for (i = 0; i < allElements.length; ++i) {
                    allElements[i].className = "img-fluid";
                }
            },

            file_picker_types: 'image',
            image_class_list: [{
                title: 'Responsive',
                value: 'img-fluid'
            }],

            /* and here's our custom image picker*/
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                // Provide image and alt text for the image dialog

                /*
                Note: In modern browsers input[type="file"] is functional without
                even adding it to the DOM, but that might not be the case in some older
                or quirky browsers like IE, so you might want to add it to the DOM
                just in case, and visually hide it. And do not forget do remove it
                once you do not need it anymore.
                */

                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function() {
                        /*
                        Note: Now we need to register the blob in TinyMCEs image blob
                        registry. In the next release this part hopefully won't be
                        necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            }

        });
    </script>
@endpush
