@extends('masterapp')

@section('tab')


    @if(isset($grid))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">New Members
                    <small>in the last week</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <a href="#" id="completed-btn" class="btn btn-primary form-btn pull-right" style="margin: 5px">
            Completed
        </a>
        <a href="#" id="send-welcomePack-btn"
           class="btn btn-primary form-btn pull-right"
           style="margin: 5px">
            Welcome Pack sent
        </a>
        <a href="#" id="generate-certificate-btn"
           class="btn btn-primary form-btn pull-right"
           style="margin: 5px">
            Generate Certificate
        </a>

        <!-- END PAGE HEAD -->

        {!! $grid !!}
        @endif
                <!-- END PAGE CONTENT INNER -->


@endsection
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('page-script')
    <script type="text/javascript">
        jQuery('#general_checkbox_all').change(function (event) {
            if (this.checked) { // check select status
                jQuery.each(jQuery('[id=general_checkbox]'), function (key, node) {
                    jQuery(this).parents('span').addClass("checked");
                    jQuery(this).prop("checked", true);
                });
            } else {
                jQuery.each(jQuery('[id=general_checkbox]'), function (key, node) {
                    jQuery(this).parents('span').removeClass("checked");
                    jQuery(this).prop("checked", false);
                });
            }
        });


        jQuery('#generate-certificate-btn').on('click', function () {
            $('body').loading({
                message: 'Generating Certificates ...'
            });
            setTimeout(function () {

            }, 2000);
            var members_ids = [];
            jQuery.each(jQuery('#general_checkbox:checked'), function (key, node) {
                members_ids.push(jQuery(this).attr('member-id'));
            });
            var current_url = window.location.href;
            var data = {members_ids: members_ids};
            var url = config.base_url + '/user/certificate';

            /*data['members_ids'] = members_ids;
             console.log(JSON.stringify(data));*/
            $.ajax({
                url: url,
                async: true,
                type: 'POST',
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            }).done(function (response) {

                console.log('success');

                var url = config.base_url + '/user/certificatedone/';
                $.ajax({
                    url: url,
                    async: true,
                    type: 'POST',
                    data: JSON.stringify(data),
                    dataType: "json",
                    contentType: "application/json; charset=UTF-8"
                }).done(function (response) {
                    console.log('success');
                    //location.reload();
                }).fail(function (xhr, textStatus, errorThrown) {
                    console.log('fail');
                });
                // /*
                //window.open(response.zip,'_blank');
                window.location.assign(response.zip);
                setTimeout(function () {
                    window.location.assign(current_url);
                }, 1000);
                $('body').loading('stop');
                //*/
                /*
                 jQuery.each(response, function(key, value) {

                 var w = window.open();
                 w.location = value.image;
                 });*/


            }).fail(function (xhr, textStatus, errorThrown) {
                console.log('fail');
            });

        });

        jQuery('#send-welcomePack-btn').on('click', function () {

            var members_ids = [];
            jQuery.each(jQuery('#general_checkbox:checked'), function (key, node) {
                members_ids.push(jQuery(this).attr('member-id'));
            });

            var data = {members_ids: members_ids};
            var url = config.base_url + '/user/welcomepacksent';

            /*data['members_ids'] = members_ids;
             console.log(JSON.stringify(data));*/
            $.ajax({
                url: url,
                async: true,
                type: 'POST',
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            }).done(function (response) {

                console.log('success');
                location.reload();

            }).fail(function (xhr, textStatus, errorThrown) {
                console.log('fail');
            });

        });

        jQuery('#completed-btn').on('click', function () {
            var members_ids = [];
            jQuery.each(jQuery('#general_checkbox:checked'), function (key, node) {
                members_ids.push(jQuery(this).attr('member-id'));
            });

            var data = {members_ids: members_ids};
            var url = config.base_url + '/user/memberscompleted';

            $.ajax({
                url: url,
                async: true,
                type: 'POST',
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json; charset=UTF-8",
                success: function (data) {
                    if (data.status == 'fail') {
                        var message = 'Members with Ids: ';
                        for (var i = 0; i < data.failedMembers.length; i++) {
                            message += '[' + data.failedMembers[i] + '] ';
                        }
                        message += '\n failed completion as one or more of [Accept T&C, Certifacte, Welcome Pack] is not set ';


                        swal({
                            title: "Alert!",
                            text: message,
                            type: "warning",
                            closeOnConfirm: true
                        }, function () {
                            location.reload();
                        });
                    }else{

                        console.log("success");
                        location.reload();
                    }
                },
                error: function (e) {
                    console.log(e.message);
                }
            });

        });
    </script>
@endsection