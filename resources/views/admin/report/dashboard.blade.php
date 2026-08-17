@extends('admin.master_layout')
@section('title')<title>{{__('admin.Report Dashboard')}}</title>@endsection
@section('admin-content')
@include('admin.report.partials.filters')
@php $icon = $setting->currency_icon ?? ''; @endphp
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Report Dashboard')}}</h1>
        </div>
        <div class="section-body">
            <form method="GET" class="form-inline mb-3 no-print">
                <label class="mr-2 mb-2">{{__('admin.From Date')}}</label>
                <input type="date" name="from_date" class="form-control mr-2 mb-2" value="{{ $from }}">
                <label class="mr-2 mb-2">{{__('admin.To Date')}}</label>
                <input type="date" name="to_date" class="form-control mr-2 mb-2" value="{{ $to }}">
                <button class="btn btn-primary mb-2 mr-2">{{__('admin.Filter')}}</button>
                <a href="{{ route('admin.report.dashboard') }}" class="btn btn-secondary mb-2 mr-2">{{__('admin.Reset')}}</a>
                <button type="button" class="btn btn-info mb-2 mr-2" onclick="window.print()"><i class="fa fa-print"></i> {{__('admin.Print')}}</button>
                @include('admin.report.partials.export_buttons', ['report' => 'dashboard'])
            </form>

            <div class="row report-summary">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.sales', ['from_date'=>$from,'to_date'=>$to]) }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-primary"><i class="fas fa-shopping-cart"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Sales')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($salesTotal, 2) }}</div></div></div></a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.profit', ['from_date'=>$from,'to_date'=>$to]) }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-success"><i class="fas fa-chart-line"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Net Profit')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($netProfit, 2) }}</div></div></div></a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.expense', ['from_date'=>$from,'to_date'=>$to]) }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-warning"><i class="fas fa-wallet"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Expense')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($expenseTotal, 2) }}</div></div></div></a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.inventory') }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-info"><i class="fas fa-boxes"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Stock Value')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($stockValue, 2) }}</div></div></div></a>
                </div>
            </div>

            <div class="row report-summary">
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.purchase-order', ['from_date'=>$from,'to_date'=>$to]) }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-primary"><i class="fas fa-file-invoice"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Purchase Orders')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($poTotal, 2) }}</div></div></div></a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.receive', ['from_date'=>$from,'to_date'=>$to]) }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-success"><i class="fas fa-truck"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Purchase Received')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($receiveValue, 2) }}</div></div></div></a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('admin.report.returns', ['from_date'=>$from,'to_date'=>$to]) }}">
                    <div class="card card-statistic-1"><div class="card-icon bg-danger"><i class="fas fa-undo"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Returns')}}</h4></div>
                    <div class="card-body">{{ $icon }}{{ number_format($returnValue, 2) }}</div></div></div></a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-statistic-1"><div class="card-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="card-wrap"><div class="card-header"><h4>{{__('admin.Low Stock')}}</h4></div>
                    <div class="card-body">{{ $lowStock }} / {{__('admin.Stock out')}} {{ $stockOut }}</div></div></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><h4>{{__('admin.Profit Summary')}}</h4></div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr><td>{{__('admin.Sales')}} ({{ $salesCount }} {{__('admin.Orders')}})</td><td class="text-right">{{ $icon }}{{ number_format($salesTotal, 2) }}</td></tr>
                                <tr><td>{{__('admin.Cost of Goods')}}</td><td class="text-right">{{ $icon }}{{ number_format($cogs, 2) }}</td></tr>
                                <tr class="font-weight-bold"><td>{{__('admin.Gross Profit')}}</td><td class="text-right">{{ $icon }}{{ number_format($grossProfit, 2) }}</td></tr>
                                <tr><td>{{__('admin.Expense')}}</td><td class="text-right">{{ $icon }}{{ number_format($expenseTotal, 2) }}</td></tr>
                                <tr class="font-weight-bold table-success"><td>{{__('admin.Net Profit')}}</td><td class="text-right">{{ $icon }}{{ number_format($netProfit, 2) }}</td></tr>
                                <tr><td>{{__('admin.Total Stock')}} ({{__('admin.Pcs')}})</td><td class="text-right">{{ number_format($stockQty) }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><h4>{{__('admin.Last 6 Months')}}</h4></div>
                        <div class="card-body">
                            <table class="table table-sm table-striped">
                                <thead><tr><th>{{__('admin.Month')}}</th><th class="text-right">{{__('admin.Sales')}}</th><th class="text-right">{{__('admin.Profit')}}</th></tr></thead>
                                <tbody>
                                @foreach($monthly as $m)
                                <tr>
                                    <td>{{ $m['label'] }}</td>
                                    <td class="text-right">{{ number_format($m['sales'], 2) }}</td>
                                    <td class="text-right {{ $m['profit'] < 0 ? 'text-danger' : 'text-success' }}">{{ number_format($m['profit'], 2) }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><h4>{{__('admin.Expense by Category')}}</h4></div>
                        <div class="card-body">
                            <table class="table table-sm table-striped">
                                <thead><tr><th>{{__('admin.Category')}}</th><th class="text-right">{{__('admin.Amount')}}</th></tr></thead>
                                <tbody>
                                @forelse($expenseByCategory as $row)
                                <tr><td>{{ $row->category->name ?? '-' }}</td><td class="text-right">{{ number_format($row->total, 2) }}</td></tr>
                                @empty
                                <tr><td colspan="2" class="text-center">{{__('admin.No data found')}}</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
