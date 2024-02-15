@extends('back.layouts.app')
@push('title', 'Sıkça Sorulan Sorular')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between bg-white">
                    Sıkça Sorulan Sorular
                    <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-secondary btn-sm"><i
                            class="fas fa-plus"></i> Yeni Soru Ekle</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Soru</th>
                                    <th>Cevap</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $faq)
                                    <tr>
                                        <td>{{ $faq->id }}</td>
                                        <td>{{ $faq->title }}</td>
                                        <td>{!! $faq->content !!}</td>
                                        <td>
                                            <form action="{{ route('admin.site.settings.faqs.delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $faq->id }}">
                                                <button class="btn btn-sm btn-outline-danger border-0"><i
                                                        class="fas fa-trash"></i> Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Soru Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.site.settings.faqs.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Soru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i
                                        class="fas fa-pencil-alt text-secondary"></i></span>
                                <input type="text" class="form-control" name="title" value="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cevap</label>
                            <div class="input-group">
                                <textarea id="editor" name="content" class="form-control" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Soru Ekle
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            height: 250,
            menubar: false,
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
