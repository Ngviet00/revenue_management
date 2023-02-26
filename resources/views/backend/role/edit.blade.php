@extends('layouts.app')

@section('title')
    Update Role
@endsection

@section('custom-css')
    <link href="{{ asset('css/backend/role/style.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid form-create">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cập nhật Role</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <form method="post" action="{{ route('admin.role.update', $role->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" readonly class="form-control" id="id" name="id" value="{{ $role->id }}">
                </div>
                <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" placeholder="Name">
                    @error('name')
                        <label class="text-danger mt-1">{{ $message }}</label>
                    @enderror
                </div>
                <div class="text-center">
                    <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="ml-2 btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>

    </div>
@endsection
