@extends('masterapp')
@section('tab')


			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1 class="orange-header">Dashboard <small>statistics & reports</small></h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->

			<!-- BEGIN PAGE CONTENT INNER -->
            @if(!empty($widgets['top']))
			    <div class="row margin-top-10">
                    @foreach($widgets['top'] as $view_name => $view_data)
                        @include('home.master.partials.'.$view_name.'_widget',['widget'=>$view_data])
                    @endforeach
			    </div>
            @endif

            @if(!empty($widgets['middle']))
			    <div class="row">
                    @foreach($widgets['middle'] as $view_name => $view_data)
                        @include('home.master.partials.'.$view_name.'_widget',['widget'=>$view_data])
                    @endforeach

					<!-- END PORTLET-->
			    </div>
            @endif
			<!-- END PAGE CONTENT INNER -->
@endsection