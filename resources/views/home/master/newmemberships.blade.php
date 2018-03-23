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
        <a href="{{ url('') }}" id="completed-btn" class="btn btn-primary form-btn pull-right" style="margin: 5px">
            Completed
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
        jQuery('#generate-certificate-btn').on('click', function () {
            var members_ids = [];
            jQuery.each(jQuery('#general_checkbox:checked'), function (key, node) {
                members_ids.push(jQuery(this).attr('member-id'));
            });

            var data = {members_ids: members_ids};
            var url = config.base_url+'/user/certificate';

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

                var url = config.base_url+'/user/certificatedone/';
                $.ajax({
                    url: url,
                    async: true,
                    type: 'POST',
                    data: JSON.stringify(data),
                    dataType: "json",
                    contentType: "application/json; charset=UTF-8"
                }).done(function (response) {
                    console.log('success');
                }).fail(function (xhr, textStatus, errorThrown) {
                    console.log('fail');
                });

                jQuery.each(response, function(key, value) {

                    src = "data:image/jpg;base64," + value.image;

                    var w = window.open();
                    w.document.write("<img src=" + src + " />");
                });

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
            var url = config.base_url+'/user/memberscompleted';

            $.ajax({
                url: url,
                async: true,
                type: 'POST',
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            }).done(function (response) {
                console.log('success');
                alert("relading");
                location.reload();
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log('fail');
            });
        });
    </script>
@endsection