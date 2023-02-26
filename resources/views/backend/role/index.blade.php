@extends('layouts.app')

@section('title')
    List Role
@endsection

@section('custom-css')
    <link href="{{ asset('css/backend/role/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid list-role">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Role</h1>
            <a href="{{ route('admin.role.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                Tạo mới quyền
            </a>
        </div>

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 mb-2 topic-alert" role="alert">
                <strong>{{session()->get('success')}}</strong>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3 mb-2 topic-alert" role="alert">
                <strong>{{ session()->get('error') }}</strong>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    @if(count($roles) > 0)
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="w-7 text-center">STT</th>
                                <th>Tên</th>
                                <th class="w-10 text-center">Sửa</th>
                                <th class="w-10 text-center">Xoá</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $key => $role)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-capitalize">{{ $role->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.role.edit', $role->id)}}" class="text-primary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.role.delete', $role->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-primary">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            {{--                            @forelse($roles as $key => $role)--}}
                            {{--                                <tr>--}}
                            {{--                                    <td class="text-center">{{ $key + 1 }}</td>--}}
                            {{--                                    <td class="text-capitalize">{{ $role->name }}</td>--}}
                            {{--                                    <td class="text-center">--}}
                            {{--                                        <a href="{{ route('admin.role.edit', $role->id)}}" class="text-primary">--}}
                            {{--                                            <i class="fa-solid fa-pen-to-square"></i>--}}
                            {{--                                        </a>--}}
                            {{--                                    </td>--}}
                            {{--                                    <td class="text-center">--}}
                            {{--                                        <form action="{{ route('admin.role.delete', $role->id) }}" method="POST">--}}
                            {{--                                            @csrf--}}
                            {{--                                            @method('DELETE')--}}
                            {{--                                            <button type="submit" class="btn text-primary">--}}
                            {{--                                                <i class="fa-solid fa-trash"></i>--}}
                            {{--                                            </button>--}}
                            {{--                                        </form>--}}
                            {{--                                    </td>--}}
                            {{--                                </tr>--}}
                            {{--                            @empty--}}
                            {{--                                <tr>--}}
                            {{--                                    Không tìm thấy dữ liệu--}}
                            {{--                                </tr>--}}
                            {{--                            @endforelse--}}
                            </tbody>
                        </table>
                    @else
                        <h5 class="text-center">Không tìm thấy dữ liệu</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/backend/manage-role.js') }}"></script>
@endsection
