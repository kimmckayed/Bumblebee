@extends('masterapp')

@section('tab')
			@if(isset($message))
				<!-- BEGIN PAGE HEAD -->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<div class="page-title">
						<h1 class="orange-header">CarTow Users <small>manage CarTow users</small></h1>
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
						<h1 class="orange-header">CarTow Users <small>manage CarTow users</small></h1>
					</div>
					<!-- END PAGE TITLE -->
				</div>
				<!-- END PAGE HEAD -->

				{!! $grid !!}

				<a href="{{ url('/user/register/subuser') }}" class="btn btn-primary form-btn pull-left">
					Add User
				</a>
			@endif

			@if(isset($edit))
				<!-- BEGIN PAGE HEAD -->
				<div class="page-head">
					<!-- BEGIN PAGE TITLE -->
					<div class="page-title">
						<h1 class="orange-header">Edit CarTow User Accounts</h1>
					</div>
					<!-- END PAGE TITLE -->
				</div>
				<!-- END PAGE HEAD -->

				{!! $edit !!}

			@endif

			<!-- END PAGE CONTENT INNER -->
	
@endsection