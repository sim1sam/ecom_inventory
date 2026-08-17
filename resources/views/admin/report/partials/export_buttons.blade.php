@php
    $exportQuery = request()->query();
    if (isset($from)) {
        $exportQuery['from_date'] = $from;
    }
    if (isset($to)) {
        $exportQuery['to_date'] = $to;
    }
@endphp
<a href="{{ route('admin.report.export', array_merge($exportQuery, ['report' => $report, 'format' => 'excel'])) }}" class="btn btn-success mb-2 mr-1">
    <i class="fa fa-file-excel"></i> {{__('admin.Excel')}}
</a>
<a href="{{ route('admin.report.export', array_merge($exportQuery, ['report' => $report, 'format' => 'csv'])) }}" class="btn btn-secondary mb-2 mr-1">
    <i class="fa fa-file-csv"></i> CSV
</a>
<a href="{{ route('admin.report.export', array_merge($exportQuery, ['report' => $report, 'format' => 'pdf'])) }}" class="btn btn-danger mb-2">
    <i class="fa fa-file-pdf"></i> PDF
</a>
