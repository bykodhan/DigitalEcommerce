<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="admin@filadmin.com">
    <meta name="author" content="@bykodhan - admin@filadmin.com">
    <link rel="icon" type="image/x-icon" href="/back/favicon.ico">
    <!--- @bykodhan - admin@filadmin.com -->
    <title>@stack('title') | FilAdmin</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome6/css/all.min.css')}}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('back/css/filadmin.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bs5/bootstrap.min.css') }}" rel="stylesheet">
    @stack('head')
</head>

<body id="page-top" class="sidebar-toggled">
    <!--- @bykodhan - admin@filadmin.com -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('back.layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('back.layouts.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Tüm Hakları &copy; admin@filadmin.com aittir.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/bs5/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('back/js/filadmin.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
    @stack('scripts')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        slugify = function(text) {
            var trMap = {
                'çÇ': 'c',
                'ğĞ': 'g',
                'şŞ': 's',
                'üÜ': 'u',
                'ıİ': 'i',
                'öÖ': 'o'
            };
            for (var key in trMap) {
                text = text.replace(new RegExp('[' + key + ']', 'g'), trMap[key]);
            }
            return text.replace(/[^-a-zA-Z0-9\s]+/ig, '') // remove non-alphanumeric chars
                .replace(/\s/gi, "-") // convert spaces to dashes
                .replace(/[-]+/gi, "-") // trim repeated dashes
                .toLowerCase();

        }
    </script>
    @if (Session::has('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ Session::get('success') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ Session::get('error') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
</body>
<!--- @bykodhan - admin@filadmin.com -->
</html>
