@php
    use App\Components\SearchQueryComponent;
    use App\Components
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="path d-flex aline-flex-end">
            <h3 class="list mb-4 d-flex align-self-end ml-2">Quản lí lớp</h3>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET">
                            <div class="row">
                                <div class="col-sm-6 align-items-center">
                                    <label class="trader-number col m-0">Tìm kiếm</label>
                                    <input name="search_input" type="text" class="form-control mt-1"
                                           value="{{request('search_input')}}">
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
                            <button class="btn btn-primary d-block mb-4 float-right">
                                <a class="btn btn-primary" href="{{route('classes.create')}}">Tạo mới</a>
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
                                        <th>Tên</th>
                                        <th>Môn học</th>
                                        <th>Giáo viên</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $index => $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->subjects->name}}</td>
                                            <td>{{$item->teachers->name}}</td>
                                            <td>{{\App\Enums\StatusClass::getDescription($item->status)}}</td>
                                            <td class="float-right">
                                                <?php
                                                $register = \App\Models\ClassStudent::where('class_id',
                                                    $item->id)->where('student_id',
                                                    \Illuminate\Support\Facades\Auth::user()->uuid)->first();
                                                $checkClass = \App\Models\Classes::join('class_students', 'classes.id',
                                                    'class_students.class_id')
                                                    ->where('classes.subject_id', $item->subject_id)
                                                    ->where('student_id',
                                                        \Illuminate\Support\Facades\Auth::user()->uuid)
                                                    ->get('class_students.*')
                                                    ->count();
                                                ?>

                                                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Enums\UserRole::Admin)
                                                    @if($item->status==\App\Enums\StatusClass::NOTSTART)
                                                        <a class="btn btn-primary"
                                                           href="{{route('classes.changeStatus', "class=$item->id")}}">
                                                            Mở lớp
                                                        </a>
                                                    @endif
                                                    <a class="btn btn-xs btn-info m-1 "
                                                       href="{{route('classes.edit', $item->id)}}">
                                                        Sửa
                                                    </a>
                                                @endif
                                                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Enums\UserRole::Teacher)
                                                    @if ($item->status==\App\Enums\StatusClass::START && $item->teacher_id == \Illuminate\Support\Facades\Auth::user()->uuid)
                                                        <a class="btn btn-outline-info m-1"
                                                           href="{{route('students.index', "class=$item->id")}}">
                                                            Nhập điểm
                                                        </a>
                                                    @endif
                                                @endif
                                                <a class="btn btn-success"
                                                   href="{{route('students.index', "class=$item->id")}}">
                                                    Xem thông tin lớp
                                                </a>
                                                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Enums\UserRole::Student)
                                                    @if ($item->status==\App\Enums\StatusClass::START)
                                                        <btn-prevent-cancel-class
                                                            :message-confirm="{{ json_encode('Bạn không thể hủy hoặc đăng kí do lớp đã bắt đầu học') }}"
                                                            :class-id="{{ json_encode($item->id) }}"
                                                            :student-uuid="{{ json_encode($currentUser) }}"
                                                        >
                                                        </btn-prevent-cancel-class>
                                                    @else
                                                        @if(!$register)
                                                            @if($checkClass == 0)
                                                                <btn-register-class
                                                                    :message-confirm="{{ json_encode('Bạn có muốn đăng kí vào lớp này không？') }}"
                                                                    :register-action="{{ json_encode(route('classes.register-class')) }}"
                                                                    :class-id="{{ json_encode($item->id) }}"
                                                                    :student-uuid="{{ json_encode($currentUser) }}"
                                                                >
                                                                </btn-register-class>
                                                            @else
                                                                <btn-register-already-class
                                                                    :message-confirm="{{ json_encode('Trùng với môn học đã đăng kí') }}"
                                                                    :register-action="{{ json_encode(route('classes.register-class')) }}"
                                                                    :class-id="{{ json_encode($item->id) }}"
                                                                    :student-uuid="{{ json_encode($currentUser) }}"
                                                                >
                                                                </btn-register-already-class>
                                                            @endif
                                                        @else
                                                            <btn-cancel-class
                                                                :message-confirm="{{ json_encode('Bạn có muốn hủy đăng kí lớp này không？') }}"
                                                                :cancel-action="{{ json_encode(route('classes.cancel-class')) }}"
                                                                :class-id="{{ json_encode($item->id) }}"
                                                                :student-uuid="{{ json_encode($currentUser) }}"
                                                            >
                                                            </btn-cancel-class>
                                                        @endif
                                                    @endif
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
