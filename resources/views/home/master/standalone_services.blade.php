@extends('masterapp')

@section('page-style')
<link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
<style>
    form.form-horizontal .form-control,
    form.form-horizontal .select2-container{
        width: 100% !important;
    }
    form.form-horizontal .btn.btn-info{
        border-radius: 25px !important;
        padding: 1px 8px !important;
    }
    #quote table td {
        padding-top: 5px !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading orange-header" style="font-size:24px">New Service</div>
                <div class="panel-body col-md-12">
                    <div class="col-sm-6 col-xs-12" id="form-container">
                        @include('layouts.form_errors')
                        <form class="form-horizontal col-md-12" role="form" method="POST"
                              action="{{ url('/nonmember/addservice') }}" style="width: 100%;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @if($user_type != 'service_company')
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Order type</label>
                                <label class="col-md-4">
                                    <input type="radio" value="customer" name="order_type" onchange="changeOrderType(this)" checked="checked" required>Customer
                                </label>
                                <label class="col-md-4">
                                    <input type="radio" value="cartow" name="order_type" onchange="changeOrderType(this)">CarTow
                                </label>
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="vehicle_reg" class="col-sm-3 control-label">Vehicle registration</label>
                                <div class="col-sm-9">
                                    <input id="vehicle_reg" name="vehicle_reg" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="form-group control-group" id="vehicle-form" style="margin: 0px !important;">
                            </div>
                            <div class="form-group">
                                <label for="customer_name" class="col-sm-3 control-label">Customer name</label>
                                <div class="col-sm-9">
                                    <input id="customer_name" name="customer_name" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="customer_phone" class="col-sm-3 control-label">Customer phone</label>
                                <div class="col-sm-9">
                                    <input id="customer_phone" name="customer_phone" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Service Type</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="service_id" name="service_id">
                                        @foreach($service_types as $type)
                                            <option value="{{ $type['id'] }}">{{ $type['type'] }}</option>
                                        @endforeach
                                        @if($user_type != 'service_company')
                                        <option value="CarTow.ie HQ order">CarTow.ie HQ order</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-3 control-label">Date/Time</label>
                                <div class="col-sm-9 control-label" style="text-align: left">
                                    <span>{{ date('d-m-Y h:i A',time()) }}</span>
                                    <input type="hidden" name="time_stamp" value="{{ date('d-m-Y h:i A',time()) }}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Note</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="note" name="note" rows="2" maxlength="255" placeholder="Optional note to driver"></textarea>
                                </div>
                            </div>

                            <?php
                                /*$client_companies = [
                                    '7 DAY AUTO',
                                    'A 1 MARSDEN','A1 MOTORS','AA AUTOS HAROLDS CROSS','About Time Ltd','Ace Autobody (Finglas)','Ace Autobody (Long Mile)','Ace Autobody (Naas)','Ace Autobody Bray','Ace Autobody Coolock Ltd.','Ace Autobody Ltd','ACME SYSTEMS LTD','Additional Cash Charges','Advance Assist Membership','Advance Pitstop Head Office','Aerlingus Cash Account','Agnew Recovery Services LTD','Airport Kia Motors','Airside Ford','Airside Renault','AJK Motors Ltd','ALAN MCCLEAN','Alexandra School Motoring','ALLIANZ PLC','Allspares Kildare','An Garda Sochna','Annesley Williams','Ansley Motors','ARB UNDERWRITING','AS NEW CRASH REPAIRS','Asgard Claims','Ashley Ford','AshMore Ryder Ltd','Assoc of Veh Rec Oper Ltd','Atlas Autoservice (Kylemore)','ATLAS AUTOSERVICE LTD','Atlas Autoservices (Baldoyle)','Atlas Autoservices (Drumcondra)','Atlas Blanchardstown','Atlas Cash Sales','Atlas Sandyford','Auto Claims Solutions Ltd','Autocity','Automobile Association','AUTOMOTIVE INCIDENT MANAGEMENT','Avis','AVIVA IRELAND','AWP Assistance Ireland Ltd','AWP Assistance UK Ltd','AXA Assistance','Axa Assistance France Assurances','Axa Assistance Polska S.A.','AXA RTA',
                                    'Balgriffin Motors','Blanchardtsown 4 x 4','BO BO MOTORS','Bodycraft','Bodyshop Direct','Brooks Garage',
                                    'C W TRANSPORT','Call Assist Limited','Canavan Ford','CAR CRAFT','CAR DOCK','Cardock Classics','CARS OF FAIRVIEW','CarTow.ie','CarTow.ie Membership','Carworx','CASH SALES ZERO','Cassin Auto Repairs','Catalpa Underwriting Agency Limited','CLIFFORDS FIRE PLACE','CLIFFORDS FIRE PLACE (TIGHE)','Clontarf Autos','Collinson Insurance Services Ltd.','Coolock Commercials','COURTNEY MOTORS','CRASH SERVICES','CROFTON MOTORS','CUBIC MODULSYSTEMS',
                                    'DELANY MOTORS','Denning Cars','DENNIS MAHONY','DENNIS MAHONY BODY REPAIRS','Do not use see Cash Sales A/C','DOLPHIN MOTORS','DOMINIC LILLIS','Dunwoody & Dobson',
                                    'easyAssist (Direct Payment)','easyAssist Membership','Electronic Tuning Service Ltd','Emerald Facilities','Enterprise Rent A Car','ER TRAVEL LTD. T/A EASIRENT','ESB Network fleet & Equipment (Tallaght)','ESB Network Fleet & Equipment (Summerhill)','ESB TALBOT MOTORS','Euro Assistance UK Ltd','EUROPCAR RENTAL','Europe Assistance','EXCEL AUTO CARE','Excel Autocare (Old Airport)','Excel Autocare (Santry)',
                                    'Fairview Motors','FINGLAS FORD (JD)','First Choice Auto\'s','Fleet Support','FMG','FOUR POINT ASSISTANCE','FUEL INJECTIONS SERVICES',
                                    'Galway Plant & Tool Hire','Gannons City Recovery','garage express','Gerry Nolan (AUTOPOIN)','Gerry Nolan (GERRYN)','Grange Road Motors Ltd','Green Flag','Greg Martin Crash Repairs','GT SALES & SERVICES',
                                    'Hanover Tyres Ltd','HOWARDS ENGINEERING','Hutton & Meade (Blanchardstown)','HUTTON & MEADE (Norhtwest Business Park)',
                                    'Inter Partner Assistance (Leatherhead)','Inter Partner Assistance Espana','INTER PARTNER ASSISTANCE.','IRELAND ASSIST','Irish School Motoring','IRISH TOWING SERVICE','Irish Towing Services',
                                    'JD RECOVERY','JDM Specialist Cars Ltd','JF Motors','JOHN BEAVER AUTO REPAIRS','JOHNNY / TOMMY JOBS',
                                    'K & C GARAGE','KEENAN Property Managment','Kenco Underwriting Ltd',
                                    'Lamb & O\'Connor','Lambe & O Connor','Lanesborough C; D; E; & F','LANTERN RECOVERY SPECIALSTS PLC',
                                    'M50 Truck & Van Centre','M50 TRUCK AND VAN CENTRE','Manor Mill Managment','Maple Leaf Property Mgnt Co Lt','Marren Enginerring','MARTIN FORRESTER MOTORS','Marvis Properties','MC kenna O Neill motors','MC NAMARAS GARAGE','MD PROPERTY','Merrion Fleet Management Ltd','MICHAEL GRANT RENAULT MOTORS','Michael Regan','Micheal Grant Motors','Micheal O\'Reilly Motors','MILES REILLY','Moore Garage','MOTO WORLD','Motorfreight','MOTORIST LEGAL PROTECTION','Motorists Insurance Services (MIS001)','Motorists Insurance Services (MISINSUR)','MR GEARBOX FINGLAS','Mr Ray Ebbs',
                                    'NATION WIDE BREAKDOWN','Newgate motors','NISSAN LIFFEY VALLEY','North Brook Motor Company',
                                    'Paddywagon Tours Ltd.','Parfit','Park Motors','Patrona Underwriters','PC Commercials','Philip Scanlon','Phonix Motors','Pilsen Auto Ltd','PK Motors','PK MOTORS BLACKROCK','PLANT AND PLANTERS','Pollock Lifts','Porsche Centre Dublin','PPRD Managment LTD (ODPM)','PPRD Managment LTD (PPRD)',
                                    'Q Park',
                                    'R.A.C. ACCOUNTS','Rath Service Station','Rathfarnham Ford','Realt Paper Ltd','Recovery24','Rialto Ford','RIGHT PRICE CARS (RIGHTPC)','RIGHT PRICE CARS (RSCARS)','RINGSUN BLINDS','Robertstown Motors','ROYAL SUN ALLIANCE','RSA Insurance IRL','RTR',
                                    'Saint Michaels House','SALVAGE DIRECT (SALDIREC)','SALVAGE DIRECT (SALNORTH)','SANTRY MOTORS','SCAN AUTO ELECTRICAL','SCAN taxi centre','SCRAP / ABANDONDED','scully autocare','Seat Ireland','See Airside Ford A/c','SEJIM MTRS','SERTIS INSURANCE','Sertus','Sheehy Mtrs','SHOOTING STAR','Sigma Wireless Communications Ltd','SIMPLY SWEDISH LTD.','SIXT Rent A Car Ireland','SMITH & BRANIGAN LTD.','SORAGHANS','Statewide Towing','STEVE GUARD','Stoney Property Management Co','Supervalve','SWEENEYS GARAGE (SWEENEY)','SWEENEYS GARAGE (SWEENEYS)',
                                    'TADG RIORDAN MOTORS','TALBOT MTRS GARAGE','Taragan Alex','The Bodyshop and Service Centre','THRIFTY VAN RENTALS','TOM HARRINGTON','Tom Murphy Recovery (TMUR01)','Tom Murphy Recovery (TOM001)','Tom Murphy Recovery (TOMMURPH)','TOM WALSH MOTORS (TOMWALSH)','TOM WALSH MOTORS (WALSH)','Top In Pops','TOTAL FUNDRAISING','TOTAL RECOVERY LTD','TR Motor Services Ltd.','Tractamotors','Travelers Insurance','Treanor Security Systems','Truck & Bus Parts',
                                    'Unified Technology Solutions',
                                    'V R N L','Vantastic Ltd','VEHICLE RESCUE NETWORK LTD','Volkwagon Group Ireland Ltd',
                                    'WEBB MOTORS','WESTBROOK MOTORS','Westly Motors','White and Delahunty','White and Delahunty Motors Ltd','Willie O Brien','Windsor Airside','WINDSOR LIFFEY VALLEY','Windsor Motors','WINSOR MOTORS BRAY','WISE PROPERTY','Wrightway Underwriting Ltd',
                                    'X GARAGE LIMITED',
                                    'YOMAC CARS',
                                    'Zoe Wong','ZURICH INSURANCE',
                                ];*/
                            ?>
                            <div class="form-group">
                                <label for="client_company" class="col-sm-3 control-label">Client company</label>
                                <div class="col-sm-9 control-label" style="text-align: left">
                                    @if($user_type == 'service_company')
                                        <input type="hidden" value="Mapfre-8184">
                                        <span>Mapfre</span>
                                    @else
                                    <select id="client_company" name="client_company" class="form-control" onchange="changeClientCompany(this.value)" required>
                                        <option></option>
                                        <!--<option value="CarTow.ie-8380">CarTow.ie</option>-->
                                        @foreach($client_companies as $company)
                                            <option value="{{$company->name}}-{{$company->bringg_id}}">{{$company->name}}</option>
                                        @endforeach
                                        <!--<option value="AIG-8820">AIG</option>
                                        <option value="First Ireland (Direct Payment)-8713">First Ireland (Direct Payment)</option>
                                        <option value="First Ireland Membership Account-8713">First Ireland Membership Account</option>
                                        <option value="First Ireland Roadside Assistance / Breakdown Recovery-8713">First Ireland Roadside Assistance / Breakdown Recovery</option>
                                        <option value="FBD-8254">FBD</option>
                                        <option value="Joe Duffy-8302">Joe Duffy</option>
                                        <option value="Liberty Insurance-8253">Liberty Insurance</option>
                                        <option value="Mapfre-8184">Mapfre</option>-->
                                    </select>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p style="font-size: 16px; color: #FF661B; font-weight: 400">
                                        Vehicle / Order location
                                        <button class="btn btn-info" type="button" data-toggle="tooltip"
                                            title="Type the address for autocomplete or click on the map to copy the location's data">?</button>
                                    </p>
                                </div>
                                <label for="address" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-9">
                                    <input id="address" name="address" class="form-control" placeholder="type for autocomplete or from map" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lat" class="col-sm-3 control-label">Latitude</label>
                                <div class="col-sm-9">
                                    <input id="lat" name="lat" class="form-control" placeholder="from autocomplete or map click" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lon" class="col-sm-3 control-label">Longitude</label>
                                <div class="col-sm-9">
                                    <input id="lon" name="lon" class="form-control" placeholder="from autocomplete or map click" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p style="font-size: 16px; color: #FF661B; font-weight: 400">
                                        Vehicle destination
                                    </p>
                                </div>
                                <label for="vehicle_destination" class="col-sm-3 control-label">Destination address</label>
                                <div class="col-sm-9">
                                    <input id="vehicle_destination" name="vehicle_destination" class="form-control" placeholder="Address text"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tolls" class="col-sm-3 control-label">Tolls</label>
                                <div class="col-sm-9 control-label" style="text-align: left">
                                    <select id="tolls" name="tolls[]" multiple="multiple" class="form-control" onchange="changeToll(this.id)">
                                        @foreach($tolls as $toll)
                                            <option value="{{$toll->name}}-{{$toll->cost}}-{{$toll->taxValue()}}">{{$toll->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <label><input type="radio" name="to_pay" value="Client to pay" required/> <span>Client to pay</span></label>
                                    <br/>
                                    <label><input type="radio" name="to_pay" value="Customer to pay" /> <span>Customer to pay</span></label>
                                    <br/>
                                    <label><input type="radio" name="to_pay" value="Override" /> <span>Override</span></label>
                                    <label for="to_pay" class="error" style="display: none">This field is required</label>
                                    <br/>
                                    <input id="override_reason" name="override_reason" class="form-control" placeholder="Override reason (required)" style="display: none"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="eta_setting" class="col-sm-3 control-label">ETA</label>
                                <div class="col-sm-9" style="text-align: left">
                                    <select id="eta_setting" name="eta_setting" class="form-control">
                                    <option value="">Default (60 minutes)</option>
                                    <option value="45-30">45 minutes</option>
                                    <option value="90-60">90 minutes</option>
                                    <option value="120-90">120 minutes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="hidden" id="company_max_distance"/>
                                <input type="hidden" id="extra_mileage_tax" value="{{$extra_mileage_tax}}"/>
                                <div class="col-sm-3" id="pre-distance"></div>
                            </div>
                            <div class="form-group">
                                <div id="pre-quote"></div>
                            </div>
                            <input type="hidden" name="total_distance" value="0 km"/>
                            <input type="hidden" name="extra_distance" value="0km: €0"/>
                            <input type="hidden" name="extra_distance_tax" value="€0"/>
                            <input type="hidden" name="tolls" />
                            <input type="hidden" name="quote-total" value="€0"/>

                            <div class="form-group control-group">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <button id="form-submit" type="submit" class="btn btn-primary form-btn submit-button">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div id="map-container" class="col-sm-6 col-xs-12" style="height: 500px;">
                        <div id="map" style="width:100%; height: 100%;"></div>
                    </div>
                </div>

                <div class="panel-heading orange-header">&nbsp</div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    var map;
    var directionsService;
    var directionsDisplay;
    var marker;
    var marker_dest;
    var a_latlng;
    var b_latlng;
    var distance;
    var distance_kilometers;
    var distance_miles;
    var distance_text;
    var extra_distance = 0;
    var company_covered;
    var company_covered_tolls;
    var company_value_per_extra = 0;
    var company_distance_unit;
    var toll_found;
    var toll_data = [];
    var extra_mileage_tax = 0;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 53.349536, lng: -6.260135}
        });
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setComponentRestrictions(
                {'country': ['ie','gb']});
        a_latlng = null;

        var input2 = document.getElementById('vehicle_destination');
        var autocomplete_dest = new google.maps.places.Autocomplete(input2);
        autocomplete_dest.setComponentRestrictions(
                {'country': ['ie','gb']});
        b_latlng = null;

        marker = new google.maps.Marker({
            map: map,
            label: 'A',
            anchorPoint: new google.maps.Point(0, -29)
        });
        marker_dest = new google.maps.Marker({
            map: map,
            label: 'B',
            anchorPoint: new google.maps.Point(0, -29)
        });
        marker.setVisible(false);
        marker_dest.setVisible(false);
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();
        directionsDisplay.setMap(map);

        google.maps.event.addListener(map, "click", function(event) {
            // get lat/lon of click
            var clickLat = event.latLng.lat();
            var clickLon = event.latLng.lng();
            // check distance if destination is available
            a_latlng = event.latLng;
            if(b_latlng != null){
                //var distance = Math.round(google.maps.geometry.spherical.computeDistanceBetween(a_latlng, b_latlng))/1000;
                var request = {
                    origin : a_latlng,
                    destination : b_latlng,
                    travelMode : 'DRIVING'
                };
                directionsService.route(request, function(response, status) {
                    if (status == 'OK') {
                        distance_kilometers = Math.round(response.routes[0].legs[0].distance.value*2)/1000;
                        distance_miles = distance_kilometers*0.62137;
                        if(company_distance_unit == 'm'){
                            distance = distance_miles;
                            distance_text = distance_miles.toFixed(2);
                        } else {
                            distance = distance_kilometers;
                            distance_text = distance_kilometers.toFixed(2);
                        }
                        console.log(distance);
                        toll_found = false;
                        response.routes[0].legs[0].steps.forEach(function (item, index) {
                            if(item.instructions.toLowerCase().includes('toll road')){
                                toll_found = true;
                            }
                        });
                        jQuery('#distance').remove();
                        $("input[name='total_distance']").val(distance_text+' '+company_distance_unit);
                        var max_distance = jQuery('#company_max_distance').val();
                        max_distance = parseFloat(parseFloat(max_distance).toFixed(2));
                        var distance_block = '<div class="col-sm-8 sol-sm-offset-2 col-xs-12" id="distance">';
                        if (max_distance != 0 && max_distance != '' && distance > max_distance) {
                            extra_distance = distance-max_distance;
                            distance_block += '<p id="max_all_p" style="font-size: 16px; color: #D10019; font-weight: 400">Round Trip Distance Total is ' + distance_text + ' ' + company_distance_unit + '</p>';
                            //' and the maximum allowance is ' + max_distance +' '+ company_distance_unit ;
                        } else {
                            extra_distance = 0;
                            distance_block += '<p style="font-size: 16px; color: #00923B; font-weight: 400">Round trip distance: ' + distance_text +' '+ company_distance_unit + '</p>';
                        }
                        distance_block += '<ul style="padding-left: 0">';
                        if(toll_found){
                            distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: There is a Toll on this road</li>';
                        }
                        if(company_covered == '0'){
                            distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra mileage</li>';
                        }
                        if(company_covered_tolls == '0'){
                            distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra tolls</li>';
                        }
                        distance_block += '</ul>';
                        distance_block += '</div>';
                        jQuery('#pre-distance').after(distance_block);
                        quoteCalculation();
                        directionsDisplay.setDirections(response);
                        marker.setVisible(false);
                        marker_dest.setVisible(false);
                    } else {
                        console.log(status);
                        console.log(response);
                    }
                });
            }
            // show in input box
            document.getElementById("lat").value = clickLat.toFixed(5);
            document.getElementById("lon").value = clickLon.toFixed(5);
            // change marker position
            marker.setVisible(false);
            marker.setPosition(event.latLng);
            marker.setVisible(true);
            $.ajax({
                url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+clickLat+','+clickLon+'&key=AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM',
                async: true,
                dataType: "json"
            }).done(function (response) {
                //console.log(response.results[0]);
                document.getElementById("address").value = response.results[0].formatted_address;
            }).fail(function (response) {
                console.log(response);
            });
        });

        autocomplete.addListener('place_changed', function() {
            //infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            } else {
                document.getElementById("lat").value = place.geometry.location.lat().toFixed(5);
                document.getElementById("lon").value = place.geometry.location.lng().toFixed(5);
                // check distance if location is available
                a_latlng = place.geometry.location;
                if(b_latlng != null){
                    //var distance = Math.round(google.maps.geometry.spherical.computeDistanceBetween(a_latlng, b_latlng))/1000;
                    var request = {
                        origin : a_latlng,
                        destination : b_latlng,
                        travelMode : 'DRIVING'
                    };
                    directionsService.route(request, function(response, status) {
                        if (status == 'OK') {
                            distance_kilometers = Math.round(response.routes[0].legs[0].distance.value*2)/1000;
                            distance_miles = distance_kilometers*0.62137;
                            if(company_distance_unit == 'm'){
                                distance = distance_miles;
                                distance_text = distance_miles.toFixed(2);
                            } else {
                                distance = distance_kilometers;
                                distance_text = distance_kilometers.toFixed(2);
                            }
                            console.log(distance);
                            toll_found = false;
                            response.routes[0].legs[0].steps.forEach(function (item, index) {
                                if(item.instructions.toLowerCase().includes('toll road')){
                                    toll_found = true;
                                }
                            });
                            jQuery('#distance').remove();
                            $("input[name='total_distance']").val(distance_text+' '+company_distance_unit);
                            var max_distance = jQuery('#company_max_distance').val();
                            max_distance = parseFloat(parseFloat(max_distance).toFixed(2));
                            var distance_block = '<div class="col-sm-8 sol-sm-offset-2 col-xs-12" id="distance">';
                            if (max_distance != 0 && max_distance != '' && distance > max_distance) {
                                extra_distance = distance-max_distance;
                                distance_block += '<p id="max_all_p" style="font-size: 16px; color: #D10019; font-weight: 400">Round Trip Distance Total is ' + distance_text + ' ' + company_distance_unit + '</p>';
                                //' and the maximum allowance is ' + max_distance +' '+ company_distance_unit ;
                            } else {
                                extra_distance = 0;
                                distance_block += '<p style="font-size: 16px; color: #00923B; font-weight: 400">Round trip distance: ' + distance_text +' '+ company_distance_unit + '</p>';
                            }
                            distance_block += '<ul style="padding-left: 0">';
                            if(toll_found){
                                distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: There is a Toll on this road</li>';
                            }
                            if(company_covered == '0'){
                                distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra mileage</li>';
                            }
                            if(company_covered_tolls == '0'){
                                distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra tolls</li>';
                            }
                            distance_block += '</ul>';
                            distance_block += '</div>';
                            jQuery('#pre-distance').after(distance_block);
                            quoteCalculation();
                            directionsDisplay.setDirections(response);
                            marker.setVisible(false);
                            marker_dest.setVisible(false);
                        } else {
                            console.log(status);
                            console.log(response);
                        }
                    });
                }
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(12);
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });

        autocomplete_dest.addListener('place_changed', function() {
            //infowindow.close();
            marker_dest.setVisible(false);
            var place = autocomplete_dest.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            // check distance if location is available
            b_latlng = place.geometry.location;
            if(a_latlng != null){
                //var distance = Math.round(google.maps.geometry.spherical.computeDistanceBetween(a_latlng, b_latlng))/1000;
                var request = {
                    origin : a_latlng,
                    destination : b_latlng,
                    travelMode : 'DRIVING'
                };
                directionsService.route(request, function(response, status) {
                    if (status == 'OK') {
                        distance_kilometers = Math.round(response.routes[0].legs[0].distance.value*2)/1000;
                        distance_miles = distance_kilometers*0.62137;
                        if(company_distance_unit == 'm'){
                            distance = distance_miles;
                            distance_text = distance_miles.toFixed(2);
                        } else {
                            distance = distance_kilometers;
                            distance_text = distance_kilometers.toFixed(2);
                        }
                        console.log(distance);
                        toll_found = false;
                        response.routes[0].legs[0].steps.forEach(function (item, index) {
                            if(item.instructions.toLowerCase().includes('toll road')){
                                toll_found = true;
                            }
                        });
                        jQuery('#distance').remove();
                        $("input[name='total_distance']").val(distance_text+' '+company_distance_unit);
                        var max_distance = jQuery('#company_max_distance').val();
                        max_distance = parseFloat(parseFloat(max_distance).toFixed(2));
                        var distance_block = '<div class="col-sm-8 sol-sm-offset-2 col-xs-12" id="distance">';
                        console.log('dis: '+distance+', max: '+max_distance+', extra: '+extra_distance);
                        if (max_distance != 0 && max_distance != '' && distance > max_distance) {
                            extra_distance = distance-max_distance;
                            distance_block += '<p id="max_all_p" style="font-size: 16px; color: #D10019; font-weight: 400">Round Trip Distance Total is ' + distance_text + ' ' + company_distance_unit + '</p>';
                            // and the maximum allowance is ' + max_distance +' '+ company_distance_unit + '</p>';
                        } else {
                            extra_distance = 0;
                            distance_block += '<p style="font-size: 16px; color: #00923B; font-weight: 400">Round trip distance: ' + distance_text +' '+ company_distance_unit + '</p>';
                        }
                        distance_block += '<ul style="padding-left: 0">';
                        if(toll_found){
                            distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: There is a Toll on this road</li>';
                        }
                        if(company_covered == '0'){
                            distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra mileage</li>';
                        }
                        if(company_covered_tolls == '0'){
                            distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra tolls</li>';
                        }
                        distance_block += '</ul>';
                        distance_block += '</div>';
                        jQuery('#pre-distance').after(distance_block);
                        quoteCalculation();
                        directionsDisplay.setDirections(response);
                        marker.setVisible(false);
                        marker_dest.setVisible(false);
                    } else {
                        console.log(status);
                        console.log(response);
                    }
                });
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(12);
            }
            marker_dest.setPosition(place.geometry.location);
            marker_dest.setVisible(true);
        });
    }
    function changeOrderType(elem){
        var vehicle_reg = $('#vehicle_reg');
        var customer_name = $('#customer_name');
        var customer_phone = $('#customer_phone');
        if($(elem).val() == 'cartow'){
            vehicle_reg.removeAttr('required');
            vehicle_reg.parent().parent().hide();
            customer_name.removeAttr('required');
            customer_name.parent().parent().hide();
            customer_phone.removeAttr('required');
            customer_phone.parent().parent().hide();
            jQuery('.vehicle-info').hide();
            $('#client_company').val('CarTow.ie-8380').trigger('change');
            $('#service_id').val('CarTow.ie HQ order');
        } else if($(elem).val() == 'customer') {
            vehicle_reg.attr('required', '');
            vehicle_reg.parent().parent().show();
            customer_name.attr('required', '');
            customer_name.parent().parent().show();
            customer_phone.attr('required', '');
            customer_phone.parent().parent().show();
            jQuery('.vehicle-info').show();
            $('#client_company').val('').trigger('change');
        }
    }
    function changeClientCompany(company) {
        var company_max_distance = jQuery('#company_max_distance');
        var company_name = company.split('-')[0];
        if(company_name!='') {
            var the_url = '{{url('client-company/single')}}' + '/' + company_name;
            $.ajax({
                url: the_url,
                async: true,
                dataType: "json"
            }).done(function (response) {
                if (response != null) {
                    company_max_distance.val(response.maximum_allowance);
                    company_value_per_extra = response.additional_value;
                    company_distance_unit= response.distance_unit;
                    company_covered= response.covered;
                    company_covered_tolls= response.additional_tolls;
                } else {
                    company_max_distance.val('');
                    company_value_per_extra = 0;
                    company_distance_unit= 'km';
                    company_covered = 0;
                    company_covered_tolls= 0;
                }
                if (a_latlng != null && b_latlng != null) {
                    var max_distance = company_max_distance.val();
                    max_distance = parseFloat(parseFloat(max_distance).toFixed(2));
                    console.log('max = '+max_distance);
                    console.log('distance = '+distance);
                    if(company_distance_unit == 'm'){
                        distance = distance_miles;
                        distance_text = distance_miles.toFixed(2);
                    } else {
                        distance = distance_kilometers;
                        distance_text = distance_kilometers.toFixed(2);
                    }
                    jQuery('#distance').remove();
                    $("input[name='total_distance']").val(distance_text+' '+company_distance_unit);
                    var distance_block = '<div class="col-sm-8 sol-sm-offset-2 col-xs-12" id="distance">';
                    if (max_distance != 0 && max_distance != '' && distance > max_distance) {
                        extra_distance = distance-max_distance;
                        distance_block += '<p id="max_all_p" style="font-size: 16px; color: #D10019; font-weight: 400">Round Trip Distance Total is ' + distance_text + ' ' + company_distance_unit + '</p>';
                        //' and the maximum allowance is ' + max_distance +' '+ company_distance_unit + '</p>';
                    } else {
                        extra_distance = 0;
                        distance_block += '<p style="font-size: 16px; color: #00923B; font-weight: 400">Round trip distance: ' + distance_text +' '+ company_distance_unit + '</p>';
                    }
                    distance_block += '<ul style="padding-left: 0">';
                    if(toll_found){
                        distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: There is a Toll on this road</li>';
                    }
                    if(company_covered == '0'){
                        distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra mileage</li>';
                    }
                    if(company_covered_tolls == '0'){
                        distance_block += '<li style="font-size: 16px; color: #D10019; font-weight: 400; ">Warning: Client company is not covered for extra tolls</li>';
                    }
                    distance_block += '</ul>';
                    distance_block += '</div>';
                    jQuery('#pre-distance').after(distance_block);
                    quoteCalculation();
                }
            }).fail(function (response) {
                console.log(response);
            });
        }
    }
    function changeToll(toll_container) {
        var tolls_array = $('#'+toll_container).select2('data');
        toll_data = [];
        if(tolls_array.length>0) {
            tolls_array.forEach(function (item, index) {
                toll_data.push(item.id.split('-'));
            });
        }
        quoteCalculation();
    }
    function quoteCalculation() {
        var total_quote=0;
        jQuery('#quote').remove();
        var quote_block = '<div class="col-sm-8 col-sm-offset-2" id="quote"> <table style="width: 100%;">';
        var tolls_for_input = '';
        if(toll_data.length>0){
            var tolls_sub_total = 0;
            quote_block += '<tr><td><span style="font-size: 16px; color: #FF661B; font-weight: 400">Tolls total:</span></td></tr>';
            toll_data.forEach(function(item,index){
                var toll_cost = parseFloat(item[1]);
                var toll_tax = parseFloat(item[2]);
                var toll_value_display = (toll_cost+((toll_tax*toll_cost)/100)).toFixed(2);
                var toll_total = parseFloat(toll_value_display);
                tolls_sub_total += toll_total;
                total_quote += toll_total;
                quote_block += '<tr><td><span style="font-size: 14px; color: #FF661B;">'+item[0]+'</span></td><td><span style="font-size: 14px;">€'+toll_value_display+'</span></td></tr>';
                tolls_for_input += item[0]+': €'+toll_value_display;
                if(index != toll_data.length-1) tolls_for_input += ', ';
            });
            quote_block += '<tr><td><span style="font-size: 14px; font-weight: 400; color: #FF661B;">Subtotal:</span></td><td><span style="font-size: 14px; font-weight: 400;">€'+tolls_sub_total.toFixed(2)+'</span></td></tr>';
            $('button#form-submit').removeAttr('disabled');
        } else {
            if(toll_found) {
                $('button#form-submit').attr('disabled', 'true');
            } else {
                $('button#form-submit').removeAttr('disabled');
            }
        }
        $("input[name='tolls']").val(tolls_for_input);
        total_quote = parseFloat(total_quote.toFixed(2));
        var extra_distance_for_input = '0'+company_distance_unit+': €0';
        var extra_distance_tax_for_input = '€0';
        if(extra_distance>0){
            extra_distance = parseFloat(extra_distance.toFixed(2));
            extra_mileage_tax = parseFloat($('#extra_mileage_tax').val())/100;
            var extra_distance_value_display = (extra_distance*company_value_per_extra).toFixed(2);
            var extra_distance_value = parseFloat(extra_distance_value_display);
            if(extra_distance_value < 10.00){
                extra_distance_value = 10.00;
                extra_distance_value_display = (extra_distance_value).toFixed(2);
            }
            extra_distance_for_input = String(extra_distance)+company_distance_unit+': €'+extra_distance_value_display;
            //$('p#max_all_p').hide();
            $('#minimum-extra-value').remove();
            $('p#max_all_p').after('<p id="minimum-extra-value" style="font-size: 16px; color: #D10019; font-weight: 400">The mileage is outside your Insurance T&C’s and the additional cost is:</p>');

            var extra_mileage_tax_value_display = (extra_mileage_tax*extra_distance_value).toFixed(2);
            var extra_mileage_tax_value = parseFloat(extra_mileage_tax_value_display);
            var extra_distance_sub_total = extra_distance_value + extra_mileage_tax_value;
            total_quote += extra_distance_sub_total;
            extra_distance_tax_for_input = extra_mileage_tax_value_display;
            quote_block += '<tr><td><span style="font-size: 16px; color: #FF661B; font-weight: 400">Extra mileage:</span></td></tr>';
            quote_block += '<tr><td><span style="font-size: 14px; color: #FF661B;">Total Distance: </span></td><td><span style="font-size: 14px;">'+distance+' '+ company_distance_unit +'</span></td></tr>' +
            '<tr><td><span style="font-size: 14px; color: #FF661B;">Cost: </span></td><td><span style="font-size: 14px;">€'+extra_distance_value_display + '</span></td></tr>' +
            '<tr><td><span style="font-size: 14px; color: #FF661B;">VAT: </span></td><td><span style="font-size: 14px;">€'+extra_mileage_tax_value_display+'</span></td></tr>' +
            '<tr><td><span style="font-size: 14px; font-weight: 400; color: #FF661B;">Subtotal: </span></td><td><span style="font-size: 14px; font-weight: 400;">€'+extra_distance_sub_total.toFixed(2)+'</span></td></tr>';
        }
        $("input[name='extra_distance']").val(extra_distance_for_input);
        $("input[name='extra_distance_tax']").val(extra_distance_tax_for_input);
        quote_block += '<tr><td><span style="font-size: 16px; font-weight: 600; color: #FF661B;">TOTAL QUOTE: </span></td><td><span style="font-size: 16px; font-weight: 600;">€'+total_quote.toFixed(2)+'</span></td></tr>';
        quote_block += '</table> </div>';
        $('#pre-quote').after(quote_block);
        $("input[name='quote-total']").val('€'+total_quote.toFixed(2));
        console.log('total quote: '+total_quote);
    }
    $(document).ready(function(){
        $("#client_company").select2();
        $("#tolls").select2();
        $('[data-toggle="tooltip"]').tooltip();
        document.getElementById('map-container').style.height = document.getElementById("form-container").clientHeight+'px';

        function vehicleInfoItem(label, value, name) {
            var html = '<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                '<label class="col-sm-3 control-label">' + label +
                '</label><div class="col-sm-9">' +
                '<div class="form-control-static">' + value +
                '</div><input name="' + name + '" type="hidden" value="' + value + '"/></div>' +
                '</div>';
            return html
        }
        $('#vehicle_reg').change(function () {
            var reg = $('#vehicle_reg').val();
            $.ajax({
                url: 'https://portal.cartow.ie/user/vehicle/' + reg,
                async: true,
                dataType: "json"
            }).done(function (response) {
                if (response.error_code == '10') {
                    jQuery('.vehicle-info').remove();
                    jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                    '<label class="orange-header control-label">' +
                    '<i class="fa fa-times"></i> No data available for this vehicle' +
                    '</label>' +
                    '</div></div>');
                } else {
                    if (response.error_code == '100' || response.error_code == '101' || response.error_code == '102' || response.error_code == '103' || response.error_code == '104' || response.error_code == '105') {
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                        '<label class="orange-header control-label">' +
                        '<i class="fa fa-times"></i> Could not retrieve vehicle info' +
                        '</label>' +
                        '</div></div>');
                    } else {
                        var vehicle = response.vehicle;
                        var make = vehicle.make;
                        var model = vehicle.model;
                        var version = vehicle.version;
                        var engineSize = vehicle.engineSize;
                        var fuel = vehicle.fuel;
                        var transmission = vehicle.transmission;
                        var colour = vehicle.colour;
                        if (make === '' || make == null)
                            make = '-';
                        if (model === '' || model == null)
                            model = '-';
                        if (version === '' || version == null)
                            version = '-';
                        if (engineSize === '' || engineSize == null)
                            engineSize = '-';
                        if (fuel === '' || fuel == null)
                            fuel = '-';
                        if (transmission === '' || transmission == null)
                            transmission = '-';
                        if (colour === '' || colour == null)
                            colour = '-';
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-form').after('<div style="margin-bottom: 10px"></div>');
                        jQuery('#vehicle-form').after(vehicleInfoItem('Colour', colour, 'colour'));
                        jQuery('#vehicle-form').after(vehicleInfoItem('Transmission', transmission, 'transmission'));
                        jQuery('#vehicle-form').after(vehicleInfoItem('Fuel', fuel, 'fuel'));
                        jQuery('#vehicle-form').after(vehicleInfoItem('Engine Size', engineSize, 'engine-size'));
                        jQuery('#vehicle-form').after(vehicleInfoItem('Version', version, 'version'));
                        jQuery('#vehicle-form').after(vehicleInfoItem('Model', model, 'model'));
                        jQuery('#vehicle-form').after(vehicleInfoItem('Make', make, 'make'));

                        jQuery('#vehicle-form').after('<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                        '<h4 class="orange-header" style="font-weight: 400">Vehicle Details</h4>' +
                        '</div>');
                    }
                }
            }).fail(function (response) {
                jQuery('.vehicle-info').remove();
                jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                '<label class="orange-header control-label">' +
                '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                '</div></div>');
            });
            jQuery('.vehicle-info').remove();
            jQuery('#vehicle-form').after('<div class="form-group vehicle-info">' +
            '<div><label class="orange-header control-label">' +
            '<i class="fa fa-refresh fa-spin"></i> Retrieving vehicle information</label></div>' +
            '</div>');
        });
        //auto select CarTow.ie as default client company
        $('#client_company').val('CarTow.ie-8380').trigger('change');

        $('input[name="to_pay"]').on('click change', function (e) {
            var override_reason_selector = $('#override_reason');
            if(this.value == 'Override'){
                override_reason_selector.show();
                override_reason_selector.attr('required','true');
            } else {
                override_reason_selector.hide();
                override_reason_selector.removeAttr('required');
            }
        });
    });
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM&libraries=geometry,places&callback=initMap">
</script>
<!--<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwb_VKz0L9C01D-bbswNCiT2L8WFLSFcw&libraries=geometry,places&callback=initMap">
</script>-->
@endsection