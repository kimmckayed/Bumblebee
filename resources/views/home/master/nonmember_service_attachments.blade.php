@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #editEntity .col-sm-10 {
            height: inherit !important;
        }
        .form{
            width: 100% !important;
        }
        form.form .form-control{
            width: 100%;
        }
        #editEntity i[class^="icon-"],
        #editEntity i[class*="icon-"] {
            color: #FF661B;
        }
    </style>
@endsection

@section('tab')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(isset($attachments))
        <div class="page-title">
            <h1 class="orange-header">
                View service attachments
            </h1>
        </div>

        <div id="editEntity" class="form-horizontal">
            <div class="form">
                <!-- Toolbar -->
                <div class="btn-toolbar" role="toolbar">
                    <!--<div class="pull-right">
                        <a href="{{url('nonmember/edit/service')}}/?show={{$non_member_service_id}}" class="btn btn-default">Return to Service</a>
                    </div>-->
                </div>
                @if(!empty($attachments))
                <!-- Attachments -->
                <!--<div class="page-title">
                    <h3 class="orange-header">
                        Attachments
                    </h3>
                </div>-->
                <div class="form-group">
                    <div class="row">
                    @foreach($attachments as $key=>$attachment)
                        @if($key%2 == 0)
                            </div>
                            <div class="row">
                        @endif
                        <div class="col-sm-6 col-xs-12"
                             style="margin-top:5px; margin-bottom: 5px;">
                            <div class="col-sm-12" style="background-color: #efefef; border-radius: 15px;">
                                <h4><i class="
                                        @if($attachment['type']=='TaskPhoto')
                                        icon-camera
                                        @elseif($attachment['type']=='Signature')
                                        icon-pencil
                                        @endif
                                    "></i> by {{$attachment['by']}}</h4>
                                <a href="{{$attachment['url']}}" target="_blank">
                                    <img src="{{$attachment['url']}}"
                                         style="max-width: 100%; max-height: 250px; display: block; margin: 0 auto;" />
                                </a>
                                <br/>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                @else
                    <h2 class="orange-title">No attachments found for this service</h2>
                @endif
            </div>
        </div>
    @endif

@endsection
@section('fast-page-script')
    <script>
        /*grid_list.find('td:last-child').addClass('hidden');*/
    </script>
@endsection