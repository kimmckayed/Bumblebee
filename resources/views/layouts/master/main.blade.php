@extends('masterapp')
@section('content')
    {!! $content !!}
@endsection
@section('page-script')
    <script src="{{ asset('assets/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.input-daterange').datepicker();
        });
    </script>

@endsection
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
@endsection