@if($widget['vat'] && $widget['net'])

    <div class="col-md-6 col-sm-12">
    <!-- BEGIN PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-bar-chart theme-font-color hide"></i>
                <span class="caption-subject theme-font-color bold uppercase">Sales Summary</span>
                <span class="caption-helper hide">weekly stats...</span>
            </div>
            <!--<div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                        <input type="radio" name="options" class="toggle" id="option1">Today</label>
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                        <input type="radio" name="options" class="toggle" id="option2">Week</label>
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                        <input type="radio" name="options" class="toggle" id="option2">Month</label>
                </div>
            </div>-->
        </div>
        <div class="portlet-body">
                <div class="row list-separated">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="font-grey-mint font-sm">
                            Total Sales
                        </div>
                        <div class="uppercase font-hg font-red-flamingo">
                            <span class="font-lg font-grey-mint">€</span>{{ $widget['total'] }}
                        </div>
                    </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="font-grey-mint font-sm">
                                VAT
                            </div>
                            <div class="uppercase font-hg theme-font-color">
                                <span class="font-lg font-grey-mint">€</span>{{ $widget['vat'] }}
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="font-grey-mint font-sm">
                                NET
                            </div>
                            <div class="uppercase font-hg font-purple">
                                <span class="font-lg font-grey-mint">€</span>{{ $widget['net'] }}
                            </div>
                        </div>
                     </div>
            <!--<div class="row list-separated">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="font-grey-mint font-sm">
                        Total Sales
                    </div>
                    <div class="uppercase font-hg font-red-flamingo">
                        13,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="font-grey-mint font-sm">
                        Revenue
                    </div>
                    <div class="uppercase font-hg theme-font-color">
                        4,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="font-grey-mint font-sm">
                        Expenses
                    </div>
                    <div class="uppercase font-hg font-purple">
                        11,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="font-grey-mint font-sm">
                        Growth
                    </div>
                    <div class="uppercase font-hg font-blue-sharp">
                        9,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </div>
            </div>-->
            <ul class="list-separated list-inline-xs hide">
                <li>
                    <div class="font-grey-mint font-sm">
                        Total Sales
                    </div>
                    <div class="uppercase font-hg font-red-flamingo">
                        13,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </li>
                <li>
                </li>
                <li class="border">
                    <div class="font-grey-mint font-sm">
                        Revenue
                    </div>
                    <div class="uppercase font-hg theme-font-color">
                        4,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </li>
                <li class="divider">
                </li>
                <li>
                    <div class="font-grey-mint font-sm">
                        Expenses
                    </div>
                    <div class="uppercase font-hg font-purple">
                        11,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </li>
                <li class="divider">
                </li>
                <li>
                    <div class="font-grey-mint font-sm">
                        Growth
                    </div>
                    <div class="uppercase font-hg font-blue-sharp">
                        9,760 <span class="font-lg font-grey-mint">€</span>
                    </div>
                </li>
            </ul>
            <!--<div id="sales_statistics" class="portlet-body-morris-fit morris-chart" style="height: 260px">
            </div>-->
        </div>
    </div>
    <!-- END PORTLET-->
</div>
@else
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span class="font-lg font-grey-mint">€</span>{{ $widget['total'] }}
                    </h3>
                    <small>Total Sales</small>
                </div>
                <div class="icon">
                    <i class="icon-users"></i>
                </div>
            </div>
        </div>
    </div>
@endif
