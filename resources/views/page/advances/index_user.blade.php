
@extends('layouts.master')
@section('css')

    @section('title')
        إدارة السلف
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
     إدارة السلف 
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="card-body">
        <a class="button x-small" href="#" data-toggle="modal" data-target="#exampleModal">طلب سلفة </a>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: 'Cairo', sans-serif;"
                        id="exampleModalLabel">
                        إدارة السلف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('advance.store')}}" method="POST">
                        {{ csrf_field() }}
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="rrr">
                                قيمة السلفة
                            </label>
                            <div class="col-sm-8">
                                <input type="number" min="1" name="amount" class="form-control" required>
                                @error('amount')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="rrr">
                                ملاحظات
                            </label>
                            <div class="col-sm-8">
                                <textarea name="notes" id="" cols="40" rows="7" class="form-control"></textarea>
                                @error('notes')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">إلغاء</button>
                    <button type="submit"
                            class="btn btn-success">تأكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 mb-30 ">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        {{--                                                table-striped--}}
                        <table id="datatable" class="table  table-bordered p-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الأسم</th>
                                <th>قيمة السلفة</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>التاريخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($advances as $record)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$record->user->name}}</td>
                                    <td>{{$record->amount}} $</td>
                                    <td><span style="color:white; font-size:1rem;"
                                        @if ($record->status=='Pending')
                                            class="badge badge-warning p-2"
                                        @elseif ($record->status=='Granted')
                                            class="badge badge-success p-2"
                                        @elseif ($record->status=='Rejected')
                                            class="badge badge-danger p-2"
                                        @endif
                                    >
                                        {{$record->status}}
                                    </span></td>
                                    <td>{{$record->notes}}</td>
                                    <td>{{$record->created_at}}</td>

                                    
                                </tr>
                                <!--تعديل قسم جديد -->
                                <div class="modal fade"
                                     id="edit{{ $record->id }}"
                                     tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    style="font-family: 'Cairo', sans-serif;"
                                                    id="exampleModalLabel">
                                                    تعديل البيانات
                                                </h5>
                                                <button type="button" class="close"
                                                        data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('advance.update',$record->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">الراتب</label>
                                                            <input id="id"
                                                                   type="text"
                                                                   name="salary"
                                                                   class="form-control"
                                                                   value="{{$record->salary_amount}}">
                                                            @error('salary')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>

                                                    </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                <button type="submit"
                                                        class="btn btn-danger">تعديل</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>الأسم</th>
                                <th>الراتب</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>التاريخ</th>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
