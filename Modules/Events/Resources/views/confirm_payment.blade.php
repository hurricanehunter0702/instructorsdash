@extends('themes::default.layout')
@section('content')
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1 class="text-center">@lang('Payment successful')</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <div class="ex-form-1 pt-5 pb-5">
        {!!$content!!}
    </div>
</div>
@endsection