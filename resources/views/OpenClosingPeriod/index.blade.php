{!!Html::breadcrumb(['Open/Closing Period'])!!}
{!!Html::pageheader('Open/Closing Period')!!}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_filter'])
                    {!!Html::fopen('Toggle Filter')!!}
                        <div class="col-md-6">
                            {!!Html::select('company_code','Company Code', $companyCode,'')!!}
                            {!!Html::select('month','Month', $months,'')!!}
                        </div>
                        <div class="col-md-6">
                            {!!Html::select('year','Fiscal Year', $years,'')!!}
                            {!!Html::select('navigation_ids', 'Report Name', $reportNavigations, '', ['multiple' => true])!!}
                        </div>
                    {!!Html::fclose()!!}
                @endif

                {!!Html::topen([
                    'no_loading'    => true,
                    'show_download' => true,
                    'show_print'    => true,
                    'show_print'    => true,
                    'no_xls'        => true
                ])!!}
                    <thead>
                        <tr>
                            <th colspan="2">Reports Name</th>
                            <th colspan="32">Period&nbsp;(<span>[[filter.period_label]]</span>)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-if="navigation_reports.length >= 1">
                            <td style="width:180px;"></td>
                            <td style="width:180px;"></td>
                            <td ng-repeat="day in rangeLimit(filter.limit_day)" class="text-center" style="width:30px;">[[ day ]]</td>
                            <td class="text-center" style="width:30px;">Options</td>
                        </tr>
                        <tr ng-if="navigation_reports.length >= 1" ng-repeat="navigation_report in navigation_reports track by $index">
                            <td rowspan="[[navigation_report.row_span]]" ng-if="navigation_report.row_span > 0">[[ navigation_report.parent_name ]]</td>
                            <td>[[ navigation_report.child_name ]]</td>
                            <td ng-repeat="day in navigation_report.dates track by $index">
                                <input type="checkbox" ng-disabled="navigation_report.period_status == 'close'" ng-checked="day == 'close'" ng-click="changePeriodDateStatus(navigation_report.parent_id,navigation_report.child_id,($index +1))">
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" ng-if="showCheckAllButton(navigation_report.parent_id,navigation_report.child_id)" ng-click="checkAll(navigation_report.parent_id,navigation_report.child_id)"> <span class="glyphicon glyphicon-check"></span>&nbsp;Check All</button>
                                <button type="button" class="btn btn-info btn-sm" ng-disabled="showCheckAllButton(navigation_report.parent_id,navigation_report.child_id)" ng-if="navigation_report.period_status == 'open'" ng-click="closeReportPeriod(navigation_report.parent_id,navigation_report.child_id)"><span class="glyphicon glyphicon-ban-circle"></span>&nbsp;Close</button>
                                <button type="button" class="btn btn-info btn-sm" ng-if="navigation_report.period_status == 'close'" ng-click="openReportPeriod(navigation_report.parent_id,navigation_report.child_id)"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Open</button>
                            </td>
                        </tr>
                        <tr ng-if="navigation_reports.length == 0">
                            <td colspan="3">No Records</td>
                        </tr>
                    </tbody>
                {!!Html::tclose()!!}
            </div>
        </div>
    </div>
</div>