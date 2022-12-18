@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Список обращений</div>

                    <div class="card-body">
                        @if(count($applications))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ид</th>
                                        <th>Тема</th>
                                        <th>Сообщение</th>
                                        <th>Имя клиента</th>
                                        <th>Email</th>
                                        <th>Файл</th>
                                        <th>Время создания</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->id }}</td>
                                            <td>{{ $application->theme }}</td>
                                            <td>{{ mb_substr($application->message, 0, 70) }}...</td>
                                            <td>{{ $application->user->name }}</td>
                                            <td>{{ $application->user->email }}</td>
                                            <td>
                                                @if($application->file)
                                                    <a href="{{ $application->getFile() }}" target="_blank">Открыть файл</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y | h:i:s', strtotime($application->created_at)) }}</td>
                                            <td>
                                                @if($application->status == 'waiting')
                                                    <a href="{{ route('application.status', ['id' => $application->id]) }}">Ответить</a>
                                                @else
                                                    Отвечено
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            Обращения отсутствуют
                        @endif
                        {{ $applications->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
