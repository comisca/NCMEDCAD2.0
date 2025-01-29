<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.title-meta')
    @include('layouts.head')
    <style>

        *:focus {
        !important;
            border: 1px solid #1670BE;
            box-shadow: 0 0 3px #1670BE;
            outline-offset: 0px;
            outline: none;

        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin: auto;
        }

        .loading-text {
            margin-top: 20px;
            font-family: 'Open Sans', sans-serif, Verdana;
            font-size: 20px;
            color: #4b4b4c;
            text-align: center;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    <style>
        .progress-circle {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(#4caf50 0%, #4caf50 25%, #ddd 25%, #ddd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .progress-circle .circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .countdown {
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            transition: color 0.3s ease;
        }

        .countdown.text-danger {
            color: #dc3545;
        }

        .alert {
            transition: all 0.3s ease;
        }

        /* Estilos para la tabla */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .power-grid-table {
            font-size: 0.9rem;
        }

        .power-grid-table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 12px;
            border-bottom: 2px solid #dee2e6;
        }

        .power-grid-table tbody tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.2s ease;
        }

        /* Estilos para los filtros */
        .filters-container {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .filter-pill {
            background: #e9ecef;
            border-radius: 20px;
            padding: 5px 15px;
            margin: 3px;
            display: inline-block;
            font-size: 0.85rem;
        }

        /* Estilos para la paginación */
        .pagination {
            margin-top: 20px;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Estilos para los botones de acciones */
        .btn-group {
            margin: 5px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Estilos para el buscador */
        .search-box {
            margin-bottom: 1rem;
        }

        .search-input {
            border-radius: 20px;
            padding: 8px 15px;
            border: 1px solid #ced4da;
        }

        /* Estilos para estados */
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #28a745;
            color: white;
        }

        .status-inactive {
            background-color: #dc3545;
            color: white;
        }

        .status-pending {
            background-color: #ffc107;
            color: black;
        }
    </style>
    @livewireStyles
    <!-- Adds the Core Table Styles -->
    @rappasoftTableStyles

    <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
    @rappasoftTableThirdPartyStyles
    {{--    @vite(['resources/js/app.js'])  <!-- Incluye el archivo JavaScript compilado -->--}}
</head>

<body>
<!-- Begin page -->
<div id="layout-wrapper">

    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')

            </div>
            <!-- container-fluid -->

        </div>

        <!-- End Page-content -->
        @include('layouts.footer')

    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
@include('layouts.right-sidebar')
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

@include('layouts.vendor-scripts')

@livewireScripts
<!-- Adds the Core Table Scripts -->
@rappasoftTableScripts

<!-- Adds any relevant Third-Party Scripts (e.g. Flatpickr) -->
@rappasoftTableThirdPartyScripts
@include('components.shortcuts')

</body>
</html>
