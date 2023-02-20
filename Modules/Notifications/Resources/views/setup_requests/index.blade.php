@extends('core::layouts.app')
@section('title', __('Setup Requests'))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" />
<style>
    .dataTables_length select {
        min-width: 65px !important;
    }
</style>
@endpush
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Setup Requests')</h1>
</div>

<div class="row">
    <div class="col-xl-2 col-lg-3 col-md-5">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-xl-10 col-lg-9 col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="setup_request_table">
                        <thead>
                            <tr>
                                <th>User's name</th>
                                <th>User's email</th>
                                <th>Amount</th>
                                <th>Requested date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                            <tr>
                                <td>{{$request->user->name}}</td>
                                <td>{{$request->user->email}}</td>
                                <td>${{$request->amount}}</td>
                                <td>{{$request->created_at->format("Y-m-d H:i:s")}}</td>
                                <td><span class="badge badge-danger">Pending</span></td>
                                <td>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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
@endsection
@push('scripts')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
<script>
    var BASE_URL = "{{ url('/') }}";
    var _token = "{{ csrf_token() }}";
    $("#setup_request_table").DataTable();
</script>
@endpush