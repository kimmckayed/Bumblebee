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
							<h1 class="orange-header">Master Accounts <small>manage master accounts</small></h1>
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
							<h1 class="orange-header">Master Accounts <small>manage master accounts</small></h1>
						</div>
						<!-- END PAGE TITLE -->
					</div>
					<!-- END PAGE HEAD -->
						{!! $grid !!}
					<a href="{{ url('/user/register/master') }}" class="btn btn-primary form-btn pull-left">
					Add Master Account
				</a>
			<!-- END PAGE CONTENT INNER -->
				@endif

				@if(isset($edit))	
					<!-- BEGIN PAGE HEAD -->
					<div class="page-head">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1 class="orange-header">Edit Master Accounts</h1>
						</div>
						<!-- END PAGE TITLE -->
					</div>
					<!-- END PAGE HEAD -->
						{!! $edit !!}
					
			<!-- END PAGE CONTENT INNER -->
				@endif
@endsection