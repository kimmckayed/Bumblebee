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
							<h1 class="orange-header">Memberships <small>manage available memberships</small></h1>
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
							<h1 class="orange-header">Memberships <small>manage available memberships</small></h1>
						</div>
						<!-- END PAGE TITLE -->
					</div>
					<!-- END PAGE HEAD -->
                                            <a href="{{ url('/user/register/memberships') }}" class="btn btn-primary form-btn pull-left">
                                            Add Membership
                                            </a>
                                            {!! $grid !!}
                                        <!-- END PAGE CONTENT INNER -->
				@endif

				@if(isset($edit))	
					<!-- BEGIN PAGE HEAD -->
					<div class="page-head">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1 class="orange-header">Edit Membership</h1>
						</div>
						<!-- END PAGE TITLE -->
					</div>
					<!-- END PAGE HEAD -->
                                        <div id="editEntity"  class="saveBtnFix">
                                            {!! $edit !!}
                                        </div>
			<!-- END PAGE CONTENT INNER -->
				@endif
@endsection
@section('fast-page-script')
    <script>
        //grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection
@section('page-script')
    <script type="text/javascript">
        $('#membershipEditForm').validate({
            rules: {
               membership_name: {
                   required: true
               },
               price: {
                   required: true,
                   number: true
               },
               duration: {
                   required: true
               },
               code: {
                   required: true
               }
            }
         });
    </script>
@endsection