@extends('admin.master_layout')
@section('title')<title>{{__('admin.Expense Categories')}}</title>@endsection
@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{__('admin.Expense Categories')}}</h1>
        </div>
        <div class="section-body">
            <p class="text-muted">{{__('admin.Create your own expense categories. These appear when you add an expense')}}</p>
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header"><h4>{{__('admin.Add New')}}</h4></div>
                        <div class="card-body">
                            <form action="{{ route('admin.expense-category.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>{{__('admin.Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required placeholder="{{__('admin.Rent, Salary, Transport')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('admin.Status')}}</label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{__('admin.Active')}}</option>
                                        <option value="0">{{__('admin.Inactive')}}</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary">{{__('admin.Save')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>{{__('admin.Name')}}</th>
                                        <th>{{__('admin.Expenses')}}</th>
                                        <th>{{__('admin.Status')}}</th>
                                        <th>{{__('admin.Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $c)
                                    <tr>
                                        <td>
                                            <form action="{{ route('admin.expense-category.update', $c->id) }}" method="POST" class="form-inline">
                                                @csrf @method('PUT')
                                                <input type="text" name="name" class="form-control form-control-sm mr-1" value="{{ $c->name }}" required style="max-width:160px">
                                                <input type="hidden" name="status" value="{{ $c->status }}">
                                                <button class="btn btn-sm btn-primary">{{__('admin.Update')}}</button>
                                            </form>
                                        </td>
                                        <td>{{ $c->expenses_count }}</td>
                                        <td>
                                            <form action="{{ route('admin.expense-category.update', $c->id) }}" method="POST" class="d-inline">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="name" value="{{ $c->name }}">
                                                <select name="status" class="form-control form-control-sm d-inline" style="width:auto" onchange="this.form.submit()">
                                                    <option value="1" {{ $c->status ? 'selected' : '' }}>{{__('admin.Active')}}</option>
                                                    <option value="0" {{ !$c->status ? 'selected' : '' }}>{{__('admin.Inactive')}}</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            @if($c->expenses_count)
                                            -
                                            @else
                                            <a href="javascript:;" class="btn btn-danger btn-sm" onclick="deleteData({{ $c->id }})"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>function deleteData(id){$("#deleteForm").attr("action",'{{ url("admin/expense-category") }}/'+id);$("#deleteModal").modal("show");}</script>
@endsection
