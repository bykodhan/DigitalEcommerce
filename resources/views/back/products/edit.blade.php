@extends('back.layouts.app')
@push('title', 'Düzenle')
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush
@section('content')
    <h3>"{{ $product->title }}" Düzenle</h3>
    <form id="product_form" action="{{ route('admin.products.update') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="{{ $product->id }}" name="product_id">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white">
                        <span><i class="fas fa-edit"></i> Ürün Bilgileri</span>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kategori*</label>
                            <select class="form-select" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($product->category_id == $category->id) selected @endif>
                                        {{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Ürün Adı*</label>
                            <div class="input-group">
                                <input required type="text" class="form-control" name="title" max="255"
                                    onchange="document.getElementById('input_slug').value = slugify(this.value)" required
                                    value="{{ $product->title }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Seo Url*</label>
                            <div class="input-group">
                                <input id="input_slug" type="text" class="form-control" name="slug" max="255"
                                    required value="{{ $product->slug }}">
                                <span class="input-group-text"><i class="fa-solid fa-link"></i></span>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label>varsa Olan Özellikler (Virgül veya Enter ile ayırınız)</label>
                            <div class="input-group">
                                <input class="form-control tags" type="text" max="255" name="accept_features"
                                    value="{{ $product->accept_features }}">
                                <span class="input-group-text"><i class="fas fa-check"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>varsa Olmayan Özellikler (Virgül veya Enter ile ayırınız)</label>
                            <div class="input-group">
                                <input class="form-control tags" type="text" max="255" name="unaccept_features"
                                    value="{{ $product->unaccept_features }}">
                                <span class="input-group-text"><i class="fa-solid fa-x"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="one_piece_check"
                                    value="1" name="one_piece" @if ($product_detail->one_piece == 1) checked @endif>
                                <label class="form-check-label" for="one_piece_check">Birden Fazla Adetli Alım
                                    Aktif</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="favorite_index"
                                    value="1" name="favorite_index" @if ($product->favorite_index == 1) checked @endif>
                                <label class="form-check-label" for="favorite_index">Anasayfa sizin için seçtiklerimiz
                                    bölümünde de gözüksün.</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div id="newRow1">
                                @if ($product->options)
                                    @foreach ($product->options as $option)
                                        <div class="mb-3" id="inputFormRow1">
                                            <div class="row g-1">
                                                <div class="col-lg-6">
                                                    <input type="text" placeholder="Seçenek Adı" class="form-control"
                                                        name="option_title[]" value="{{ $option->title }}">
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="number" min="1" step="0.25" placeholder="Fiyatı"
                                                        class="form-control" name="option_price[]"
                                                        value="{{ $option->price }}">
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="d-grid">
                                                        <button id="removeRow1" type="button" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>Sil
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button id="addRow1" type="button" class="btn btn-sm btn-primary"><i
                                    class="fas fa-plus"></i>
                                Ek Ürün&Hizmet&Seçenek Ekle</button>
                            </button>
                        </div>

                        <div class="mb-3">
                            <div id="newRow2">
                                @if ($product_detail->buttons)
                                    @foreach (json_decode($product_detail->buttons, true) as $button)
                                        <div id="inputFormRow2" class="mb-3">
                                            <div class="row g-1">
                                                <div class="col-lg-3">
                                                    <label>Buton Adı</label>
                                                    <input type="text" class="form-control" name="button_title[]"
                                                        placeholder="örn:Demo" value="{{ $button['title'] }}">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Buton Gidilecek URL(Link)</label>
                                                    <input type="text" class="form-control" name="button_href[]"
                                                        placeholder="örn: https://google.com"
                                                        value="{{ $button['href'] }}">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Yeni Sekmede Açılsın Mı ?</label>
                                                    <select class="form-select" name="button_target[]">
                                                        <option value="1"
                                                            @if ($button['target'] == 1) selected @endif>Evet</option>
                                                        <option value="0"
                                                            @if ($button['target'] == 0) selected @endif>Hayır</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>Stil <a target="_blank"
                                                            href="https://getbootstrap.com/docs/5.1/components/buttons/">Stil
                                                            Bak</a></label>
                                                    <select class="form-select" name="buton_style[]">
                                                        <option value="{{ $button['style'] }}" selected>
                                                            {{ $button['style'] }}</option>
                                                        <option value="btn-primary">btn-primary</option>
                                                        <option value="btn-secondary">btn-secondary</option>
                                                        <option value="btn-success">btn-success</option>
                                                        <option value="btn-danger">btn-danger</option>
                                                        <option value="btn-warning">btn-warning</option>
                                                        <option value="btn-info">btn-info</option>
                                                        <option value="btn-light">btn-light</option>
                                                        <option value="btn-dark">btn-dark</option>

                                                        <option value="btn-outline-primary">btn-outline-primary</option>
                                                        <option value="btn-outline-secondary">btn-outline-secondary
                                                        </option>
                                                        <option value="btn-outline-success">btn-outline-success</option>
                                                        <option value="btn-outline-danger">btn-outline-danger</option>
                                                        <option value="btn-outline-warning">btn-outline-warning</option>
                                                        <option value="btn-outline-info">btn-outline-info</option>
                                                        <option value="btn-outline-light">btn-outline-light</option>
                                                        <option value="btn-outline-dark">btn-outline-dark</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="d-grid">
                                                        <button id="removeRow2" type="button"
                                                            class="btn btn-danger mt-4"><i class="fas fa-trash"></i>
                                                            Sil</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button id="addRow2" type="button" class="btn btn-sm btn-primary"><i
                                    class="fas fa-plus"></i>
                                Ek Buton Ekle</button>
                            </button>
                        </div>
                        <div id="newRow3">
                            @if ($product_detail->customer_infos)
                                @foreach (explode(',', $product_detail->customer_infos) as $customer_info)
                                    <div class="mb-3" id="inputFormRow3">
                                        <div class="input-group">
                                            <input type="text" placeholder="örn: Alan Adınız" class="form-control"
                                                name="customer_info_field[]" value="{{ $customer_info }}">
                                            <button id="removeRow3" type="button" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                                Sil
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button id="addRow3" type="button" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                            Müşteriden İstenilecek Zorunlu Ek Bilgi Ekle
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <span><i class="fas fa-edit"></i> Ürün Bilgileri
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Fiyatı</label>
                            <div class="input-group">
                                <input class="form-control" name="price" type="number" min="1" step="0.01"
                                    class="form-control" required value="{{ $product->price }}">
                                <span class="input-group-text">₺</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>varsa İndirimli Fiyatı</label>
                            <div class="input-group">
                                <input class="form-control" type="number" min="1" step="0.01"
                                    class="form-control" name="discount_price" value="{{ $product->discount_price }}">
                                <span class="input-group-text">₺</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>varsa İndirim Yüzdesi</label>
                            <div class="input-group">
                                <input class="form-control" type="number" min="1" max="99"
                                    class="form-control" name="discount" value="{{ $product->discount }}">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Tahmini Teslimat Süresi</label>
                            <div class="input-group">
                                <input class="form-control" type="text" max="255" name="lead_time"
                                    value="{{ $product->lead_time }}">
                                <span class="input-group-text"><i class="fa-solid fa-truck-moving"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>varsa Whatsapp İle Satın Al</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">+90</span>
                                <input class="form-control" placeholder="54xxxxxxxx" type="text" max="15"
                                    name="wp" value="{{ $product_detail->wp }}">
                                <span class="input-group-text"><i class="fa-brands fa-whatsapp"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Öne Çıkarılan Görsel*</label>
                            <input class="form-control "
                                onchange="document.getElementById('img').src = window.URL.createObjectURL(this.files[0])"
                                name="img" type="file" accept=".png, .jpg, .jpeg, .gif, .webp">
                            <img width="100" id="img" class="img-fluid mb-1"
                                src="{{ asset($product->img) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="cursor: pointer" data-bs-toggle="collapse"
                        data-bs-target="#collapse_stock">
                        Ürün Otomatik Teslim Edilecek Stoklar (Eklenen linkler teslim edildiğinde
                        tıklanabilir
                        olur)
                    </div>
                    <div class="collapse show" id="collapse_stock">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="form-check ms-2">
                                    <input class="form-check-input" type="radio" name="stock_type" value="1"
                                        id="flexRadioDefault3" @if ($product_detail->stock_type == 1) checked @endif>
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Manuel Elle Teslim Edilecek (Sınırsız Stok Olur)
                                    </label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check ms-2">
                                    <input class="form-check-input" type="radio" name="stock_type" value="2"
                                        id="flexRadioDefault1" @if ($product_detail->stock_type == 2) checked @endif>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Satın Alan Herkese Aşağıdaki Satırı İlet (Sınırsız Stok Olur)
                                    </label>
                                </div>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="stock2"
                                        @if ($product_detail->stock_type == 2) value="{{ $product_stock[0]->content }}" @endif>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="form-check ms-2">
                                    <input class="form-check-input" type="radio" name="stock_type" value="3"
                                        id="flexRadioDefault2" @if ($product_detail->stock_type == 3) checked @endif>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Satın Alan Her Kişiye Özel Stok İlet (Her satır 1 adet stok olur) (Sınırlı Stok)
                                    </label>
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="stock3" class="form-control" rows="6">
@if ($product_detail->stock_type == 3)
@foreach ($product_stock as $stock)
{{ $stock->content }}
@endforeach
@endif
</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <textarea id="editor" name="content">{!! $product_detail->content !!}</textarea>
            </div>
            <div class="col-lg-12 text-center mb-3">
                <div class="d-grid gap-3 d-md-block">
                    <button type="submit" class="btn btn-primary px-5"><i class="fas fa-save"></i> Değişiklikleri Kaydet</button>
                    <button type="button" onclick="new_product()" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Yeni Ürün Olarak
                        Ekle</button>
                    <button type="button" onclick="delete_form({{$product->id}})" class="btn btn-outline-danger"><i class="fas fa-trash"></i> Sil</button>
                </div>
            </div>
        </div>
    </form>
    <form method="POST" action="{{ route('admin.products.delete') }}" id="admin_products_delete">
        @csrf
        <input type="hidden" id="input_id" value="" name="id">
    </form>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.2/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            height: 400,
            images_upload_url: '{{ route('admin.products.image.upload') }}',
            menubar: false,
            language: 'tr',
            relative_urls : false,
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
    <script>
        options_html = `
        <div class="mb-3" id="inputFormRow1">
            <div class="row g-1">
            <div class="col-lg-4">
                <input type="text" placeholder="Seçenek Adı" class="form-control" name="option_title[]">
            </div>
                <div class="col lg-5">
                    <input type="number" min="1" step="0.25" value="" placeholder="Fiyatı" class="form-control" name="option_price[]">
                </div>
            <div class="col-lg-2">
                <div class="d-grid">
                    <button id="removeRow1" type="button" class="btn btn-danger">
                        <i class="fas fa-trash"></i>Sil
                    </button>
                </div>
            </div>
            </div>
        </div>
         `;
        $("#addRow1").click(function() {
            $('#newRow1').append(options_html);
        });
        $(document).on('click', '#removeRow1', function() {
            $(this).closest('#inputFormRow1').remove();
        });

        buttons =
            `<div id="inputFormRow2" class="mb-3">
                            <div class="row g-1">
                                <div class="col-lg-3">
                                    <label>Buton Adı</label>
                                    <input type="text" class="form-control" name="button_title[]"
                                    placeholder="örn:Demo" required>
                                </div>
                                <div class="col-lg-3">
                                    <label>Buton Gidilecek URL(Link)</label>
                                    <input type="text" class="form-control" name="button_href[]"
                                    placeholder="örn: https://google.com" required>
                                </div>
                                <div class="col-lg-3">
                                    <label>Yeni Sekmede Açılsın Mı ?</label>
                                    <select class="form-select" name="button_target[]">
                                        <option value="1">Evet</option>
                                        <option value="0">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label>Stil <a target="_blank" href="https://getbootstrap.com/docs/5.1/components/buttons/">Stil Bak</a></label>
                                    <select class="form-select" name="buton_style[]">
                                        <option value="btn-primary">btn-primary</option>
                                        <option value="btn-secondary">btn-secondary</option>
                                        <option value="btn-success">btn-success</option>
                                        <option value="btn-danger">btn-danger</option>
                                        <option value="btn-warning">btn-warning</option>
                                        <option value="btn-info">btn-info</option>
                                        <option value="btn-light">btn-light</option>
                                        <option value="btn-dark">btn-dark</option>

                                        <option value="btn-outline-primary">btn-outline-primary</option>
                                        <option value="btn-outline-secondary">btn-outline-secondary</option>
                                        <option value="btn-outline-success">btn-outline-success</option>
                                        <option value="btn-outline-danger">btn-outline-danger</option>
                                        <option value="btn-outline-warning">btn-outline-warning</option>
                                        <option value="btn-outline-info">btn-outline-info</option>
                                        <option value="btn-outline-light">btn-outline-light</option>
                                        <option value="btn-outline-dark">btn-outline-dark</option>
                                    </select>
                                </div>

                                <div class="col-lg-1">
                                    <div class="d-grid">
                                        <button id="removeRow2" type="button" class="btn btn-danger mt-4"><i
                                                class="fas fa-trash"></i>
                                            Sil</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        $("#addRow2").click(function() {
            $('#newRow2').append(buttons);
        });
        $(document).on('click', '#removeRow2', function() {
            $(this).closest('#inputFormRow2').remove();
        });

        customer_infos = `
         <div class="mb-3" id="inputFormRow3">
        <div class="input-group">
            <input type="text" placeholder="örn: Alan Adınız" class="form-control" name="customer_info_field[]">
            <button id="removeRow3" type="button" class="btn btn-danger">
                <i class="fas fa-trash"></i>
                Sil
            </button>
        </div>
        </div>
         `;
        $("#addRow3").click(function() {
            $('#newRow3').append(customer_infos);
        });
        $(document).on('click', '#removeRow3', function() {
            $(this).closest('#inputFormRow3').remove();
        });
    </script>

    <script>
        document.querySelectorAll('.tags').forEach((el) => {
            let settings = {
                create: true,
                plugins: ['remove_button']
            };
            new TomSelect(el, settings);
        });
    </script>
        <script>
            function new_product(){
                document.getElementById("product_form").action = "{{ route('admin.products.store') }}";
                document.getElementById("product_form").submit();
            }
            function delete_form(id) {
                Swal.fire({
                    title: 'Ürünü silmek istediğinize emin misiniz? Bu işlem geri alınamaz!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eminim Sil!',
                    cancelButtonText: 'İptal'

                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('input_id').value = id
                        document.getElementById('admin_products_delete').submit()
                    }
                })
            }
        </script>
@endpush
