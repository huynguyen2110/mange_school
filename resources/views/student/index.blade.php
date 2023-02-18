@php
    use App\Components\SearchQueryComponent;
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="path d-flex aline-flex-end">
            <h3 class="list mb-4 d-flex align-self-end ml-2">
                Quản lí sinh viên
            </h3>


        </div>
        @if($request->class)
            <?php
                $class = \App\Models\Classes::where('id', $request->class)->first();
            ?>
            <h4 class="list mb-4 d-flex align-self-end ml-2">
                Sinh viên lớp {{$class->name}}
            </h4>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET">
                            <div class="row">
                                <div class="col-sm-6 align-items-center">
                                    <label class="trader-number col m-0">Tìm kiếm</label>
                                    <input name="search_input" type="text" class="form-control mt-1" value="{{request('search_input')}}">
                                </div>
                                <div class="pl-4 col-sm-2 d-flex justify-content-center w-100 h-50 mt-4">
                                    <button class="btn btn-primary w-100 h-50">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Enums\UserRole::Admin)
                            <button class="btn btn-primary d-block mb-4 float-right" style="margin-left: 10px">
                                <a class="btn btn-primary" href="{{route('students.create')}}">Tạo mới</a>
                            </button>
                            <button class="btn btn-primary d-block mb-4 float-right">
                                <a class="btn btn-primary" href="{{route('students.exportPdf')}}">Xuất PDF</a>
                            </button>
                        @endif
                        <div class="col-sm-3 mb-4">
                            <limit-page-option :limit-page-option="{{ json_encode(PAGE_SIZE_LIMIT) }}"
                                               :new-size-limit="{{ $newSizeLimit }}">
                            </limit-page-option>
                        </div>
                        @if (count($users) > 0)
                            <div class="tanemaki-table">
                                <table class="table table-responsive-sm table-striped border">
                                    <thead>
                                    <tr>
                                        <th >Tên</th>
                                        <th >Email</th>
                                        <th >Ngành</th>
                                        <th >Khóa</th>
                                        @if($request->class)
                                            <th >Điểm giữa kì</th>
                                            <th >Điểm cuối kì</th>
                                            <th >Tổng điểm</th>
                                        @endif
                                        @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Enums\UserRole::Admin)
                                            <th></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $index => $item)
                                        <tr>
                                            <td >{{$item->name}}</td>
                                            <td >{{$item->email}}</td>
                                            @if($item->majors)
                                                <td >{{$item->majors->name}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if($item->courses)
                                                <td >{{$item->courses->name}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if($request->class)
                                                <?php
                                                    $score = $item->scores->where('class_id',$request->class)->first()
                                                ?>

                                                @if($score)
                                                    <td>{{$score->midterm_score}}</td>
                                                    <td>{{$score->final_score}}</td>
                                                    <td>{{$score->total}}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
                                            <?php
                                                $checkTeacher = \App\Models\Classes::where('id', $request->class)
                                                    ->where('teacher_id', \Illuminate\Support\Facades\Auth::user()->uuid)
                                                    ->first();
                                            ?>
                                            <td class="float-right">
                                                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Enums\UserRole::Admin)
                                                    <a class="btn btn-xs btn-info m-1 " href="{{route('students.edit', $item->uuid)}}">
                                                        Sửa
                                                    </a>
                                                    <btn-delete-confirm
                                                        :message-confirm="{{ json_encode('Bạn có muốn xóa sinh viên này không？') }}"
                                                        :delete-action="{{ json_encode(route('students.destroy', $item->uuid)) }}">
                                                    </btn-delete-confirm>
                                                @endif


                                                @if($request->class && $checkTeacher)
                                                    <a class="btn btn-success" href="{{route('students.score',["student=$item->uuid", "class=$request->class"])}}">
                                                        Nhập điểm
                                                    </a>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $users->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                        @else
                            <div class="tanemaki-table">
                                <table class="table table-responsive-sm table-striped border">
                                    <td><span>Không có dữ liệu</span></td>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
