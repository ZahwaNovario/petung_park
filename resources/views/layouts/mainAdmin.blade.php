<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Petung Park</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fafb;
        }

        .sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #fff;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar-wrapper h2 {
            font-weight: 700;
            color: #295A3F;
        }

        .sidebar-wrapper a.btn {
            text-align: left;
            font-weight: 500;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .sidebar-wrapper a.btn:hover,
        .sidebar-wrapper a.active {
            background-color: #e2b007 !important;
            color: #fff !important;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-wrapper {
                position: relative;
                width: 100%;
                height: auto;
                border-right: none;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @yield('page-css')
</head>

<body>
    @include('layouts.headerAdmin')

    <div class="sidebar-wrapper">
        @include('admin.sidebar')
    </div>

    <div class="content-wrapper">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

        <!-- Modal Success -->
        <div class="modal fade" id="BerhasilModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content shadow">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Berhasil</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">{{ session('success') }}</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                $('#BerhasilModal').modal('show');

                // Auto-close setelah 2 detik:
                setTimeout(function() {
                    $('#BerhasilModal').modal('hide');
                    // Opsional: redirect setelah close
                    // window.location = "{{ url()->current() }}"; // reload
                    // window.location = "{{ route('locations.index') }}"; // ke index lokasi
                }, 2000);
            @endif
        });
    </script>
    @yield('page-js')
</body>

</html>
