
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
                        <div class="row">
                            <div class="col">
                                <label for="inputName"
                                       class="control-label">اضافة سلفة لموظف </label>
                                <select name="user_id" class="custom-select">
                                    <option value="">اختيار الموظف</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة السلفة</label>
                                <input id="id"
                                       type="text"
                                       name="advance"
                                       class="form-control"
                                       value="">
                                @error('advance')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">إلغاء</button>
                    <button type="submit"
                            class="btn btn-danger">إضافة</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mb-30 ">
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
                                <th>العمليات</th>
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
                                    <td>{{$record->created_at}}</td>

                                    <td>


                                        <a href="#"
                                           class="btn btn-outline-info btn-sm"
                                           data-toggle="modal"
                                           data-target="#edit{{ $record->id }}">تعديل البيانات</a>
                                        {{--                                <form id="delete-form-{{$department->id}}" action="{{ route('salary.destroy', ['department' => $record->id]) }}" method="POST" style="display: inline;">--}}
                                        {{--                                    @csrf--}}
                                        {{--                                    @method('DELETE')--}}

                                        {{--                                </form>--}}

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
                                                                                    <span
                                                                                        aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('advance.update',$record->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName"
                                                                   class="control-label">اضافة راتب لموظف</label>
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
                                <th>العمليات</th>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
