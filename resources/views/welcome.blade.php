@extends('layouts.master')
@section('title') @lang('NCMEDCAD | Oficina Virtual') @endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') NCMEDCAD @endslot
        @slot('title') Officina Virtual @endslot
    @endcomponent


@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection
