@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Inventory Dashboard')}}</title>
@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Inventory Dashboard')}}</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary"><i class="fas fa-box"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>{{__('admin.Total Products')}}</h4></div>
                            <div class="card-body">{{ $totalProducts }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-cubes"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>{{__('admin.Total Stock')}}</h4></div>
                            <div class="card-body">{{ $totalStock }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>{{__('admin.Low Stock Alerts')}}</h4></div>
                            <div class="card-body">{{ $lowStock }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-times-circle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header"><h4>{{__('admin.Stock out')}}</h4></div>
                            <div class="card-body">{{ $stockOut }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h4>{{__('admin.Recent Stock Movements')}}</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('admin.Date')}}</th>
                                    <th>{{__('admin.Product')}}</th>
                                    <th>{{__('admin.Warehouse')}}</th>
                                    <th>{{__('admin.Type')}}</th>
                                    <th>{{__('admin.Stock')}}</th>
                                    <th>{{__('admin.Before')}}</th>
                                    <th>{{__('admin.After')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements as $movement)
                                <tr>
                                    <td>{{ $movement->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ $movement->product->short_name ?? '-' }}</td>
                                    <td>{{ $movement->warehouse->name ?? '-' }}</td>
                                    <td><span class="badge badge-info">{{ strtoupper($movement->type) }}</span></td>
                                    <td>{{ $movement->qty }}</td>
                                    <td>{{ $movement->qty_before }}</td>
                                    <td>{{ $movement->qty_after }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center">{{__('admin.No data found')}}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
