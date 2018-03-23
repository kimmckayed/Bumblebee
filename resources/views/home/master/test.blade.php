@extends('masterapp')

@section('tab')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="pre-messages"></div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script type="text/javascript" src="{{asset('js/amq_jquery_adapter.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/amq.js')}}"></script>
    <script type="text/javascript">
        var amq = org.activemq.Amq;
        amq.init({
            uri: 'https://broker1a.autonet-services.com',
            logging: true,
            timeout: 20
        });
        $('#pre-messages').after('<p>Here we gooo</p>');
        var myHandler =
            {
                rcvMessage: function(message) {
                    $('#pre-messages').after("<p>received "+message+"</p>");
                }
            };
        amq.addListener('client1','queue://ANS.RecOps.2220229',myHandler.rcvMessage);
    </script>
@endsection