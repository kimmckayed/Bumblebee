<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat2">
        <div class="display">
            <div class="number">
                <h3 class="font-blue-sharp">
                    {{ $widget[0] }}
                    @if($widget[3]==true)
                        <small class="font-red-haze">€</small>
                    @endif
                </h3>
                <small>{{$widget[1]}}</small>
            </div>
            <div class="icon">
                <i class="{{$widget[2]}}"></i>
            </div>
        </div>
    </div>
</div>