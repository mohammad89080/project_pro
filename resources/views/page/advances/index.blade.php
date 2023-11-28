
@extends('layouts.master')
@section('css')

    @section('title')
        إدارة سلف الموظفين
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
     إدارة سلف الموظفين
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="card-body">
        <a class="button x-small" href="#" data-toggle="modal" data-target="#exampleModal">إضافة سلفة لموظف </a>
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
                            <div class="col">
                                <label for="inputName"
                                       class="control-label">اضافة سلفة لموظف </label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">اختيار الموظف</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
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
                                <th> {{ trans('forms.Name') }}</th>
                                <th>قيمة السلفة</th>
                                <th>{{ trans('forms.Status') }}</th>
                                <th>ملاحظات</th>
                                <th>{{ trans('forms.Date') }}</th>
                                <th>{{ trans('main_trans.Options') }}</th>
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

                                    <td>

                                        <a href="#"
                                        class="btn btn-outline-info btn-sm"
                                        data-toggle="modal"
                                        data-target="#edit{{ $record->id }}">تعديل البيانات</a>

                                        <form id="delete-form-{{$record->id}}" action="{{ route('advance.destroy', ['advance' => $record->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="delete" class="btn btn-outline-danger btn-sm" >حذف</button>
                                        </form>

                                    </td>
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

                                                <form action="{{ route('advance.update',$record) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName"
                                                                   class="control-label">تعديل السلفة</label>
                                                            <select name="user_id" class="custom-select">
                                                                <option value="">اختيار موظف</option>
                                                                @foreach($users as $user)
                                                                    <option value="{{ $user->id }}" {{ old('user_id', $record->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">السلفة</label>
                                                            <input id="id"
                                                                   type="number"
                                                                   name="amount"
                                                                   class="form-control"
                                                                   value="{{$record->amount}}">
                                                            @error('amount')<span class="text-danger">{{ $message }}</span>@enderror
                                                        </div>
                                                    </div>
                                                    <br>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="status" class="control-label">الحالة</label>
                                                                <select name="status" class="custom-select">
                                                                    <option value="">الحالة</option>

                                                                    <option value="Granted" {{$record->status=="Granted"?"selected":""}} >Granted</option>
                                                                    <option value="Pending" {{$record->status=="Pending"?"selected":""}}>Pending</option>
                                                                    <option value="Rejected" {{$record->status=="Rejected"?"selected":""}}>Rejected</option>
                                                                
                                                                </select>
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
                                    <th> {{ trans('forms.Name') }}</th>
                                    <th>قيمة السلفة</th>
                                    <th>{{ trans('forms.Status') }}</th>
                                    <th>ملاحظات</th>
                                    <th>{{ trans('forms.Date') }}</th>
                                    <th>{{ trans('main_trans.Options') }}</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
