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
							<h1 class="orange-header">Codess <small>manage Codes</small></h1>
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
							<h1 class="orange-header">Codes <small>manage  Codes</small></h1>
						</div>
						<!-- END PAGE TITLE -->
					</div>
					<!-- END PAGE HEAD -->
                                            <a href="{{ url('/user/register/codes') }}" class="btn btn-primary form-btn pull-left">
                                            Add Codes
                                            </a>
                                            {!! $grid !!}
                                        <!-- END PAGE CONTENT INNER -->
				@endif

				@if(isset($edit))	
					<!-- BEGIN PAGE HEAD -->
					<div class="page-head">
						<!-- BEGIN PAGE TITLE -->
						<div class="page-title">
							<h1 class="orange-header">Edit Codes</h1>
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
@section('page-script')
	<script type="text/javascript">
		$('form').validate({
			rules: {
				name: {
					required: true
				},
				code: {
					required: true
				},
				discount: {
					required: true,
					number: true
				},
				date_start: {
					required: true,
					date: true
				},
				date_end: {
					required: true,
					date: true
				},
				uses_total: {
					required: true,
					number: true
				}
			}
		});
	</script>
@endsection
		@section('fast-page-script')
            <script>
        grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection