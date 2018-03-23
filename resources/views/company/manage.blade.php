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
                <h1 class="orange-header">Companies
                    <small>manage Company accounts</small>
                </h1>
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
                <h1 class="orange-header">Companies
                    <small>manage Company accounts</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->

        </div>

        {!! $grid !!}

        <a href="{{ url('/user/register/company') }}" class="btn btn-primary form-btn pull-left">
            Add Company
        </a>
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

        <div id="editEntity" class="saveBtnFix">
            {!! $edit !!}


            <div class="form paymentMethod" style="border-radius: 0;border: 0px #ffffff;margin-top: -2px;">

                <div class="form-group">

                    <label for="code" class="col-sm-2 control-label">payment Method</label>

                    <div class="col-sm-10" id="div_code">


                        <div class="help-block">{{(new \App\Models\CompanyPaymentMethod())->getNameByCompanyId($company_id)}}</div>


                    </div>

                </div>


                <br>
            </div>
        </div>


        <div class="form">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header fullWidth">Points of Contact
                        <button  type="button" class="btn btn-primary form-btn submit-button add_new_button">
                            add
                        </button></h1>
                </div>


                <!-- END PAGE TITLE -->

            </div>
            <div class="row poc">
                @include('layouts.form_errors')
                <form class="form-horizontal " role="form"
                      method="POST" action="{{ route('add_poc') }}">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <input type="hidden" name="company_id" value="{{$company_id}}">

                    <div>
                        <div class="form-group">
                            <h3 class="col-md-4 control-label orange-header full-width alignL">Add new  Point of Contact</h3>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email"
                                       value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" name="number" maxlength="16"
                                       value="{{ old('number') }}">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary form-btn submit-button save_new_poc_button">
                                Save
                            </button>
                            <button type="button" class="btn btn-primary cancel_new_poc_button">
                                Cancel
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <br>
            @foreach($list_of_poc as $poc)
                <div class="form-group">
                    <label for="code" class="col-sm-2 control-label">{{$poc->name}}</label>

                    <div class="col-sm-10">
                        <div class="">
                            <span> <i class="fa fa-phone"></i>  {{$poc->phone_number or 'no phone '}}    </span>
                            <span><i class="fa fa-envelope"></i>  {{$poc->email or 'no email '}}</span>
                            <span> <i class="fa fa-map-marker"></i> {{$poc->address or 'no address '}}</span></div>
                    </div>
                </div><br>
            @endforeach


        </div>
        @endif
                <!-- END PAGE CONTENT INNER -->

@endsection


@section('page-script')
    <script>
        $('.poc').toggle();

        $('.add_new_button').click(function(){
            $('.poc').toggle();
            $(this).toggle();
        });

        $('.cancel_new_poc_button').click(function(){
            $('.poc').toggle();
            $('.add_new_button').toggle();
            $('.poc form')[0].reset();
        });




    </script>
    <script>
        jQuery.validator.addMethod("myEmail", function (value, element) {
               return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
           }, 'Please enter a valid email address.');
        $('#customerEditForm').validate({
             rules: {
                 code: {
                     required: true
                 },
                 name: {
                     required: true
                 },
                 company_poc_email: {
                     required: true,
                     myEmail: true
                 }
             },
             highlight: function (element) {
                 $(element).closest('.form-group').removeClass('success').addClass('error');
             },
             success: function (element) {
                 element.addClass('valid')
                         .closest('.form-group').removeClass('error').addClass('success');
             }
         });
    </script>
@endsection