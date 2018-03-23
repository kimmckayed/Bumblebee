@extends('masterapp')

@section('content')
<style type="text/css">
    #addFleet{
        width: 100% !important;
    }
    #addFleet .form-control{
        width: 75% !important;
    }
</style>

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading orange-header" style="font-size:24px">
                @if($fleet != null)
                Update Fleet "{{$fleet->name}}"
                @else
                New Fleet
                @endif
            </div>
            <div class="panel-body">
                @if(isset($message))
                    <div class="alert alert-success">
                        {{ $message }}<br><br>
                    </div>
                @endif
                @include('layouts.form_errors')
                <form method="post" id="addFleet" action="{{ route('fleet_add_post') }}"
                      enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                    <div class="addFleet">

                @if($fleets != null)
                    <div class="form-group control-group row">
                        <label for="fleet_id" class="col-sm-4 control-label">
                            Fleet<span class="orange-header">*</span>
                        </label>
                        <div class="col-md-8">
                            <select class="form-control" id="fleet_id" name="fleet_id" required>
                                <option></option>
                                @foreach($fleets as $fleet)
                                    <option value="{{ $fleet['id'] }}"
                                            >{{ $fleet['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else

                    @if($fleet != null)
                        <input type="hidden" name="fleet_id" value="{{$fleet->id}}">
                    @endif

                        <div class="form-group control-group row">
                            <label for="fleet_name" class="col-sm-4 control-label">
                                Fleet name<span class="orange-header">*</span>
                            </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="fleet_name" id="fleet_name" required
                                    @if($fleet != null)
                                        value="{{$fleet->name}}"
                                    @endif
                                >
                            </div>
                        </div>
                        <div class="form-group control-group row" id="companies_container">
                            <label for="company" class="col-sm-4 control-label">
                                Company<span class="orange-header">*</span>
                            </label>
                            <div class="col-md-8">
                                @if($fleet != null)
                                <label>{{$fleet_company->name}}</label>
                                <input type="hidden" name="company" value="{{$fleet_company->id}}">
                                @else
                                <select class="form-control" id="company" name="company" required
                                        onchange="getMembershipsForCompany($(this).val())">
                                    <option></option>
                                    <option value="create_company">Create a new company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company['id'] }}"
                                            @if($fleet != null && $fleet->company_id == $company['id'])
                                                selected
                                            @endif
                                            >{{ $company['name'] }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group control-group row" id="memberships_container">
                            <label for="membership_type" class="col-md-4 control-label">
                                Membership Type<span class="orange-header">*</span>
                            </label>
                            <div class="col-md-8">
                                @if($fleet != null)
                                <label>{{$fleet_membership->membership_name}}</label>
                                <input type="hidden" id="membership_type" name="membership_type"
                                       value="{{$fleet_membership->id}}" duration="{{$fleet_membership->duration}}">
                                @else
                                <select class="form-control" id="membership_type" name="membership_type" required>
                                    <option></option>
                                    <option value="create_membership">Create a new membership</option>
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="form-group control-group row">
                            <label class="col-sm-4 control-label">Start date for cover</label>

                            <div class="col-md-8">
                                <input type="date" class="form-control" id="start-date" name="start_date"
                                       value="{{ old('start_date') }}" readonly>
                                @if(( new \App\Managers\AuthManager())->isAnyRole(['master','sales','finance']))
                                    <br/>
                                    <span>
                                        Allow changing the start date
                                        <input type="checkbox"  class="form-control"
                                               onclick="$('#start-date').prop('readonly',false);$(this).parent().parent().parent().hide()">
                                    </span>
                                @endif
                            </div>
                        </div>
                @endif
                        <div class="row">
                            <div class="col-md-12">
                                <p>Download the template file then upload it with the updated data
                                    <a href="{{ asset('assets/media/fleet-template.xls') }}" download>Download template</a>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#template_instructions">Template Instructions</button>
                                <!-- Modal -->
                                <div id="template_instructions" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Template Instructions</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>1-Vehicle Registration in mandatory</p>
                                                <p>2-Start Date is mandatory</p>
                                                <p>3-For dates, use one of the following date formats (all examples are 1st of August, 2017):</p>
                                                <p>- 1-8-2017</p>
                                                <p>- 8/1/2017</p>
                                                <p>- 2017-8-1</p>
                                                <p>- 1-August-2017</p>
                                                <p>- 1-Aug-17</p>
                                                <p>4-All other non-mandatory fields must be left blank if no data is available</p>
                                            </div>
                                            <!--<div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <br/>
                        <div class="upload-button">Select Updated File</div>
                        <input class="file-upload" name="fleetExcelFile" type="file"
                               accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                               required/>
                    </div>
                    <br/>
                    <div class="btns form">
                        <!--<input type="button" name="create" class="btn green" value="Create"
                               onClick="validateNewGroupForm();">-->
                        <button class="btn btn-default" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script type="text/javascript">
    function setExpiryDate() {
        var duration = ($('#membership_type').attr('type')=='hidden')? $('#membership_type').attr('duration') : $('#membership_type').find('option:selected').attr('duration');
        var durationSplit = duration.split(' ');
        var number_of_months = durationSplit[0];
        // var monthsTimestamp = months * 30 * 24 * 60 * 60;
        var start_date_selector = $('#start-date');

        var startDate = start_date_selector.val();
        var expirationDate = moment(startDate).add(number_of_months, 'months').format("YYYY-MM-DD");


        var months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        jQuery('.expiration-label').remove();
        jQuery('#membership_duration').remove();

        start_date_selector.after('<div class="expiration-label">' +
        '<input type="hidden" name="membership_expiration" value="' + expirationDate + '">' +
        '<h4 class="orange-header"> This membership will expire on ' + moment(expirationDate).format("DD MMMM YYYY") +
        ' according to the above start date unless another start date is provided in the template</h4>' +
        '</div>' +
        '<div id="membership_duration">' +
        '<input type="hidden" name="membership_duration" value="' + duration + '">' +
        '</div>');
    }
    jQuery(document).ready(function () {

        jQuery(document).on('focus', '[name="expiration_date[from]"]', function () {
            // alert('focus');
            jQuery('[name="expiration_date[from]"]').datepicker();
        });

        jQuery(document).on('focus', '[name="expiration_date[to]"]', function () {
            // alert('focus');
            jQuery('[name="expiration_date[to]"]').datepicker();
        });

        var start_date_selector = $('#start-date');
        start_date_selector.val(moment().add(3, 'days').format("YYYY-MM-DD"));
        // start_date_selector.attr('min', moment().format("YYYY-MM-DD"));

        /*if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
            setExpiryDate();*/

        start_date_selector.on('change', function () {
            if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
                setExpiryDate();
            else {
                jQuery('.expiration-label').remove();
            }

        });

        jQuery('#membership_type').on('change', function () {
            if(jQuery('#membership_type').val() == 'create_membership'){
                var memberships_container = $('#memberships_container');
                memberships_container.after('<div id="new_membership_container" style="border: 1px black dashed; padding-top: 10px; margin-bottom: 10px;">' +
                '<div class="form-group control-group row">' +
                '<label class="col-md-4 control-label">Name<span class="orange-header">*</span></label>' +
                '<div class="col-md-8">' +
                '<input type="text" class="form-control" name="membership_name" required>' +
                '</div>' +
                '</div>' +
                '<div class="form-group control-group row">' +
                '<label class="col-md-4 control-label">Gross Price<span class="orange-header">*</span></label>' +
                '<div class="col-md-8">' +
                '<input type="text" class="form-control" name="price" required>' +
                '</div>' +
                '</div>' +
                '<div class="form-group control-group row">' +
                '<label class="col-md-4 control-label">Duration<span class="orange-header">*</span></label>' +
                '<div class="col-md-8 form-inline">' +
                '<input type="number" class="form-control" name="duration" required>' +
                '<label>months</label>' +
                '</div>' +
                '</div>' +
                '<div class="form-group control-group row">' +
                '<label class="col-md-4 control-label">Code<span class="orange-header">*</span></label>' +
                '<div class="col-md-8">' +
                '<input type="text" class="form-control" name="membership_code" required>' +
                '</div>' +
                '</div>' +
                '<div class="form-group control-group row">' +
                '<label class="col-md-4 control-label">Number of Callouts</label>' +
                '<div class="col-md-8">' +
                '<input type="number" class="form-control" name="number_of_callouts">' +
                '</div>' +
                '</div>' +
                '</div>');
            } else {
                $('#new_membership_container').remove();
                if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
                    setExpiryDate();
                else {
                    jQuery('.expiration-label').remove();
                }
            }
        });

        if(jQuery('#company').val() != '' && jQuery('#company').val() != null){
            getMembershipsForCompany(jQuery('#company').val());
        }

        if($('#membership_type').attr('type')=='hidden'){
            setExpiryDate();
        }
    });

    function getMembershipsForCompany(company_id){
        if(company_id == 'create_company'){
            $('#new_membership_container').remove();
            var companies_container = $('#companies_container');
            companies_container.after('<div id="new_company_container" style="border: 1px black dashed; padding-top: 10px; margin-bottom: 10px;">' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Company Code<span class="orange-header">*</span></label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="code" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Company Name<span class="orange-header">*</span></label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="company_name" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Website</label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="website">' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Location Address</label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="address">' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Memberships</label>' +
            '<div class="col-md-8">' +
            '@foreach($memberships as $membership)' +
            '<div class="checkbox">' +
            '<label>' +
            '<input name="memberships[]" type="checkbox" value="{{ $membership['id'] }}"/>' +
            '{{ $membership["membership_name"] }}' +
            '</label>' +
            '</div>' +
            '@endforeach' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label" for="payment_method">' +
            'Payment method:' +
            '</label>' +
            '<div class="col-md-8">' +
            '<select class="form-control" id="payment_method" name="payment_method">' +
            '<option value="1" >Pay As You Go</option>' +
            '<option value="2" >Monthly Bill</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<h3 class="col-md-4 control-label orange-header">Main Point of Contact</h3>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Username<span class="orange-header">*</span></label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="username" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Name<span class="orange-header">*</span></label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="poc_name" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Email<span class="orange-header">*</span></label>' +
            '<div class="col-md-8">' +
            '<input type="text" class="form-control" name="poc_email" required>' +
            '</div>' +
            '</div>' +
            '<div class="form-group control-group row">' +
            '<label class="col-md-4 control-label">Phone Number</label>' +
            '<div class="col-md-8">' +
            '<input type="number" class="form-control" name="poc_number">' +
            '</div>' +
            '</div>' +
            '</div>');
            company_id = 6;
        } else {
            $('#new_company_container').remove();
        }
        var url = config.base_url+'/memberships_for_company?company_id='+company_id;
        $.ajax({
            url: url,
            async: true,
            dataType: "json",
            contentType: "application/json; charset=UTF-8"
        }).done(function (response) {
            $('#membership_type').empty();
            $('#membership_type').append('<option></option>'+'<option value="create_membership">Create a new membership</option>');
            $(response).each(function(){
                $('#membership_type').append('<option value="'+this.id+'" duration="'+this.duration+'">'+this.membership_name+'</option>');
            });
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log('fail');
        });
    }
</script>
@endsection