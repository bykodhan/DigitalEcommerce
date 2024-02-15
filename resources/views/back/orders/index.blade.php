@extends('back.layouts.app')
@push('title', $title)
@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white">
                    <span>Siparişler :
                        @if ($title == 'Onay Bekleyenler')
                            <span class="badge bg-warning">{{ $title }}</span>
                        @elseif($title == 'Stok Bekleyenler')
                            <span class="badge bg-info">{{ $title }}</span>
                        @elseif($title == 'Tamamlananlar')
                            <span class="badge bg-success">{{ $title }}</span>
                        @elseif($title == 'İptal Edilenler')
                            <span class="badge bg-secondary">{{ $title }}</span>
                        @endif
                    </span>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>NO</th>
                                    <th>Müşteri</th>
                                    <th>Ürün</th>
                                    <th>Bilgi</th>
                                    <th>Seçenek</th>
                                    <th>Adet</th>
                                    <th>Kupon</th>
                                    <th>Tutar</th>
                                    <th>Not</th>
                                    <th>Tarih</th>
                                    <th>Ödeme</th>
                                    <th>Stok</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->order_id }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                                data-bs-target="#customer_info_{{ $order->id }}">
                                                {{ $order->email }}
                                            </button>
                                            <div class="modal fade" id="customer_info_{{ $order->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Müşteri Bilgileri
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-1">
                                                                <div class="col-6">
                                                                    <p>
                                                                        <strong>Müşteri Adı:</strong>
                                                                    </p>
                                                                    <p>
                                                                        <strong>Müşteri Soyadı:</strong>
                                                                    </p>
                                                                    <p>
                                                                        <strong>Müşteri Telefon:</strong>
                                                                    </p>
                                                                    <p>
                                                                        <strong>Müşteri Mail:</strong>
                                                                    </p>
                                                                    <p>
                                                                        <strong>Müşteri IP:</strong>
                                                                    </p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p>
                                                                        {{ $order->name }}
                                                                    </p>
                                                                    <p>
                                                                        {{ $order->surname }}
                                                                    </p>
                                                                    <p>
                                                                        <a title="Whatsappdan Yaz"
                                                                            href="https://api.whatsapp.com/send?phone=0{{ Str::replace(' ', '', Str::replace('-', '', Str::replace(')', '', Str::replace('(', '', $order->phone)))) }}">
                                                                            {{ $order->phone }}
                                                                        </a>
                                                                    </p>
                                                                    <p>
                                                                        <a title="Mail Gönder"
                                                                            href="mailto:{{ $order->email }}">
                                                                            {{ $order->email }}
                                                                        </a>
                                                                    </p>
                                                                    <p>
                                                                        {{ $order->user_ip }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $order->product_title }} ({{ money($order->product_price) }} ₺)
                                        </td>
                                        <td>
                                            @if ($order->customer_answers)
                                                <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                                    data-bs-target="#customer_answer_modal_{{ $order->id }}">Detay</button>

                                                <div class="modal fade" tabindex="-1"
                                                    id="customer_answer_modal_{{ $order->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Müşteriden İstenilen Bilgiler</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul>
                                                                    @foreach (json_decode($order->customer_answers, true) as $answer)
                                                                        <li>
                                                                            {{ $answer['field'] }} :
                                                                            {{ $answer['answer'] }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->option_name)
                                                {{ $order->option_name }} ({{ money($order->option_price) }})
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->qty }}
                                        </td>
                                        <td>
                                            @if ($order->coupon_code)
                                                {{ $order->coupon_code }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ money($order->amount_paid) }}</td>
                                        <td>
                                            @if ($order->note)
                                                <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                                    data-bs-target="#note_modal_{{ $order->id }}">Detay</button>
                                            @else
                                                -
                                            @endif
                                            <div class="modal fade" id="note_modal_{{ $order->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Müşteriden Gelen Not
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                {{ $order->note }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $order->created_at->isoFormat('D MMMM HH:mm') }}</td>
                                        <td>
                                            @if ($order->payment_status == 0)
                                                <span class="badge bg-danger">Ödenmedi</span>
                                            @else
                                                <span class="badge bg-success">Onaylanmış</span>
                                                <small>{{ $order->payment_method }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->stock_content)
                                                <button class="btn btn-sm btn-light text-dark" title="Stok Düzenle"
                                                    href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit_stock_{{ $order->id }}">
                                                    <i class="fas fa-edit"></i>
                                                    Stok Düzenle
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-light text-dark" title="Stok Ekle"
                                                    href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit_stock_{{ $order->id }}">
                                                    <i class="fas fa-plus"></i>
                                                    Stok Ekle
                                                </button>
                                            @endif
                                            <div class="modal fade" id="edit_stock_{{ $order->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                {{ $order->order_id }} için stok ekle/düzenle
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.orders.edit.stock') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="order_id"
                                                                    value="{{ $order->order_id }}">
                                                                <div class="mb-3">
                                                                    <label class="mb-1">Stok Bilgileri</label>
                                                                    <textarea name="stock_content" class="form-control" rows="3">{{ $order->stock_content }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="mb-1">
                                                                        Tahmini Teslimat</label>
                                                                    <input type="text" max="50"
                                                                        class="form-control" name="lead_time"
                                                                        placeholder="Teslim Edildi vb."
                                                                        value="{{ $order->lead_time }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">İptal</button>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="fas fa-save"></i>
                                                                        Kaydet
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                @if ($order->order_status == 0 || $order->order_status == 1)
                                                    <form class="form-inline" action="{{ route('admin.orders.ok') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="order_id"
                                                            value="{{ $order->order_id }}">

                                                        <button class="btn btn-sm btn-outline-success" title="Onayla">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <button onclick="cancel_form({{ $order->id }})" title="İptal Et"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-x"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Sil"
                                                    onclick="delete_form({{ $order->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @if ($order->order_status == 2)
                                                    <form class="form-inline"
                                                        action="{{ route('admin.orders.order_send_mail') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="order_id"
                                                            value="{{ $order->order_id }}">

                                                        <button class="btn btn-sm btn-outline-success"
                                                            title="Sipariş Bilgileri Mail Olarak Gönder">
                                                            <i class="fas fa-envelope"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#ID</th>
                                    <th>NO</th>
                                    <th>Müşteri</th>
                                    <th>Ürün</th>
                                    <th>Bilgi</th>
                                    <th>Seçenek</th>
                                    <th>Adet</th>
                                    <th>Kupon</th>
                                    <th>Tutar</th>
                                    <th>Not</th>
                                    <th>Tarih</th>
                                    <th>Ödeme</th>
                                    <th>Stok</th>
                                    <th>İşlem</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            {{ $orders->links() }}
        </div>
    </div>
    <form method="POST" action="{{ route('admin.orders.cancel') }}" id="admin_orders_cancel">
        @csrf
        <input type="hidden" id="input_id_cancel" name="id" value="">
    </form>
    <form method="POST" action="{{ route('admin.orders.delete') }}" id="admin_orders_delete">
        @csrf
        <input type="hidden" id="input_id" name="id" value="">
    </form>
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 100,
                "paging": false,
                "order": [],
                "scrollY": '80vh',
                "scrollCollapse": true,
                "scrollX": true,
                "language": {
                    "emptyTable": "Veri Bulunamadı",
                    "info": "Toplam _TOTAL_ Kayıttan _START_ - _END_ Arası",
                    "infoEmpty": "Kayıt Yok",
                    "infoFiltered": "(_MAX_ Kayıt İçerisinden Bulunan)",
                    "lengthMenu": "Sayfada _MENU_ Kayıt Gösteriliyor",
                    "paginate": {
                        "first": "İlk",
                        "last": "Son",
                        "next": "Sonraki",
                        "previous": "Önceki"
                    },
                    "search": "Bul:",
                    "zeroRecords": "Eşleşen Kayıt Bulunmadı"
                }
            });
        });
    </script>
    <script>
        function delete_form(id) {
            Swal.fire({
                title: 'Siparişi silmek istediğinize emin misiniz? Stok varsa stoklar tekrar ürüne yüklenir! Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim Sil!',
                cancelButtonText: 'İptal'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id').value = id
                    document.getElementById('admin_orders_delete').submit()
                }
            })
        }

        function cancel_form(id) {
            Swal.fire({
                title: 'Siparişi iptal etmek istediğinize misiniz? Stok varsa stoklar tekrar ürüne yüklenir! Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim İptal Et!',
                cancelButtonText: 'Etme'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id_cancel').value = id
                    document.getElementById('admin_orders_cancel').submit()
                }
            })
        }
    </script>
@endpush
