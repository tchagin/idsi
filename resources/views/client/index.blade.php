@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать заявку</div>

                    <div class="card-body">
                        <form action="{{ route('client.application') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">

                            <div class="form-group mb-3">
                                <label for="theme">Тема</label>
                                <input type="text" name="theme" class="form-control" value="{{ old('theme') }}" maxlength="100">
                            </div>
                            <div class="form-group mb-3">
                                <label for="theme">Сообщение</label>
                                <textarea name="message" id="" class="form-control">{{ old('message') }}</textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="theme">Прикрепить файл</label>
                                <input type="file" name="file" class="form-control" value="{{ old('theme') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
