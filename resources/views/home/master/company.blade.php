@extends('masterapp')
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('tab')
			@if(isset($message))
				<!-- BEGIN PAGE HEAD -->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<div class="page-title">
						<h1 class="orange-header">Companies <small>manage Company accounts</small></h1>
					</div>
					<!-- END PAGE TITLE -->
				</div>
				<!-- END PAGE HEAD -->

				{!! $message !!}

			@endif
			
			@if(isset($grid))
				<!-- BEGIN PAGE HEAD -->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<div class="page-title">
						<h1 class="orange-header">Companies <small>manage Company accounts</small></h1>
					</div>
					<!-- END PAGE TITLE -->
					
				</div>
				<!-- END PAGE HEAD -->
                                <!-- <a href="/cartow/public/user/register/company" class="btn btn-primary">
                                        Add Company Account
                                </a> -->

                                @if((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance']))
                                <a href="{{ url('/user/register/company') }}" class="btn btn-primary form-btn pull-left">
                                        Add Company
                                </a>
                                @endif

                                {!! $grid !!}

			@endif
			@if(isset($edit))
				<!-- BEGIN PAGE HEAD -->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<div class="page-title">
						<h1 class="orange-header">Edit Company Accounts</h1>
					</div>
					<!-- END PAGE TITLE -->
					
				</div>
				<!-- END PAGE HEAD -->
					<!-- <a href="/cartow/public/user/register/company" class="btn btn-primary">
						Add Company Account
					</a> -->

					{!! $edit !!}
			@endif
			<!-- END PAGE CONTENT INNER -->
@endsection
@section('fast-page-script')
    <script>
        grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection