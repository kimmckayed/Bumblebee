@extends('masterapp')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="margin-top: 20px;">
                    <div class="panel-body">
                        <h2 class="orange-header">Member search</h2>
                        <label for="vehicle_reg">Member's vehicle registration</label>
                        <br/>
                        <input id="vehicle_reg" class="form-control">
                        <br/>
                        <button id="search" type="button" class="btn btn-default">Search</button>

                        <br/>
                        <div id="vehicle-form">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript">

        $(document).ready(function () {

            function memberInfoItem(label, value) {
                var html = '<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                        '<label class="col-sm-3 control-label">' + label +
                        '</label><div class="col-sm-9">' +
                        '<p>' + value + '</p></div></div>';
                return html;
            }
            $('#search').click(function () {
                var reg = $('#vehicle_reg').val();
                $.ajax({
                    url: config.base_url + '/search/member/' + reg,
                    async: true,
                    dataType: "json"
                }).done(function (response) {
                    //console.log(response);
                    if(response == null) {
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                        '<label class="orange-header control-label">' +
                        '<i class="fa fa-times"></i> Could not find a member for this vehicle registration' +
                        '</label>' +
                        '</div></div>');
                    } else {
                        var member = response;
                        var name = member.title + ' ' + member.first_name + ' ' + member.last_name;
                        var phone = member.phone_number;
                        var membership_id = member.membership_id;
                        var start_date = member.start_date;
                        var company = (member.company != null)? member.company.name : 'N/A' ;
                        var call_outs = member.number_of_assists;
                        var address_1 = member.address_line_1;
                        var vehicle = member.vehicle;
                        var make = (vehicle != null )? vehicle.make : 'N/A';
                        var model = (vehicle != null )? vehicle.model : 'N/A';
                        var version = (vehicle != null )? vehicle.version_type : 'N/A';
                        var engineSize = (vehicle != null )? vehicle.engine_size : 'N/A';
                        var fuel = (vehicle != null )? vehicle.fuel_type : 'N/A';
                        var transmission = (vehicle != null )? member.transmission : 'N/A';
                        var colour = (vehicle != null )? member.colour : 'N/A';
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-form').after('<a href="'+config.base_url+'/user/services/'+member.id+'" class="btn btn-default">Add Service</a>');
                        jQuery('#vehicle-form').after('<div style="margin-bottom: 10px"></div>');
                        jQuery('#vehicle-form').after(memberInfoItem('Colour', colour));
                        jQuery('#vehicle-form').after(memberInfoItem('Transmission', transmission));
                        jQuery('#vehicle-form').after(memberInfoItem('Fuel', fuel));
                        jQuery('#vehicle-form').after(memberInfoItem('Engine size', engineSize));
                        jQuery('#vehicle-form').after(memberInfoItem('Version', version));
                        jQuery('#vehicle-form').after(memberInfoItem('Model', model));
                        jQuery('#vehicle-form').after(memberInfoItem('Make', make));
                        jQuery('#vehicle-form').after('<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                        '<h4 class="orange-header" style="font-weight: 400">Vehicle Details</h4>' +
                        '</div>');
                        jQuery('#vehicle-form').after(memberInfoItem('Address', address_1));
                        jQuery('#vehicle-form').after(memberInfoItem('Call outs', call_outs));
                        jQuery('#vehicle-form').after(memberInfoItem('Start date', start_date));
                        jQuery('#vehicle-form').after(memberInfoItem('Company', company));
                        jQuery('#vehicle-form').after(memberInfoItem('Membership ID', membership_id));
                        jQuery('#vehicle-form').after(memberInfoItem('Phone', phone));
                        jQuery('#vehicle-form').after(memberInfoItem('Name', name));
                        jQuery('#vehicle-form').after('<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                        '<h4 class="orange-header" style="font-weight: 400">Member Details</h4>' +
                        '</div>');
                    }
                }).fail(function (response) {
                    jQuery('.vehicle-info').remove();
                    jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                    '<label class="orange-header control-label">' +
                    '<i class="fa fa-times"></i> Could not retrieve member information</label>' +
                    '</div></div>');
                });
                jQuery('.vehicle-info').remove();
                jQuery('#vehicle-form').after('<div class="form-group vehicle-info">' +
                '<div><label class="orange-header control-label">' +
                '<i class="fa fa-refresh fa-spin"></i> Retrieving member information</label></div>' +
                '</div>');
            });
        });
    </script>
@endsection