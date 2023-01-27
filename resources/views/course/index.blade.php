@php
    use App\Components\SearchQueryComponent;
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="path d-flex aline-flex-end">
            <h3 class="list mb-4 d-flex align-self-end ml-2">Quản lí khóa</h3>
        </div>
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
                        <button class="btn btn-primary d-block mb-4 float-right">
                            <a class="btn btn-primary" href="{{route('courses.create')}}">Tạo mới</a>
                        </button>
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
                                        <th >Năm thành lập</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $index => $item)
                                        <tr>
                                            <td >{{$item->name}}</td>
                                            <td >{{$item->founded_year}}</td>
                                            <td class="float-right">
                                                <a class="btn btn-xs btn-info m-1" href="{{route('courses.edit', $item->id)}}">
                                                    Sửa
                                                </a>
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
