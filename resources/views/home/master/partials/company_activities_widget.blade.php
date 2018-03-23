<div class="col-md-6 col-sm-12">
    <!-- BEGIN PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption caption-md">
                <i class="icon-bar-chart theme-font-color hide"></i>
                <span class="caption-subject theme-font-color bold uppercase">Company Activity</span>
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
            <!--<div class="row number-stats margin-bottom-30">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="stat-left">
                        <div class="stat-chart">
                            <div id="sparkline_bar"></div>
                        </div>
                        <div class="stat-number">
                            <div class="title">
                                Total
                            </div>
                            <div class="number">
                                2460
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="stat-right">
                        <div class="stat-chart">
                            <div id="sparkline_bar2"></div>
                        </div>
                        <div class="stat-number">
                            <div class="title">
                                New
                            </div>
                            <div class="number">
                                719
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="table-scrollable table-scrollable-borderless">
                <table class="table table-hover table-light">
                    <thead>
                    <tr class="uppercase">
                        <th>
                            Company
                        </th>
                        <th>
                            Memberships Value
                        </th>
                        <th>
                            VAT
                        </th>
                        <th>
                            Gross
                        </th>
                        <th>
                            Rate
                        </th>
                    </tr>
                    </thead>
                    @foreach($widget['companies'] as $companyFayez)
                    <tr>
                        <td>
                            {{ $companyFayez['name'] }}
                            <!--<a href="javascript:;" class="primary-link">Brain</a>-->
                        </td>
                        <td>
                            €{{ round(($companyFayez['sum']*100)/123 ,0) }}

                        </td>
                        <td>
                            €{{ round($companyFayez['sum']-($companyFayez['sum']*100)/123 ,0) }}
                        </td>
                        <td>
                            €{{ round($companyFayez['sum'], 0) }}
                        </td>
                        <td>
                            <span class="bold theme-font-color">{{ round($companyFayez['sum']/$widget['companies_total']*100, 2) }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>