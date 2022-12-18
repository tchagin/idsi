<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Jobs\SendApplicationToMailJob;
use App\Mail\ApplicationMail;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(){
        return view('client.index');
    }

    public function application(Request $request){
        $client_application = Application::where('user_id', auth()->user()->id)->orderby('id', 'desc')->first();
        if (isset($client_application)){
            $application_date = $client_application->created_at;
            $current_date = $application_date->addHours(24);
            $dt = Carbon::now()->toDateTimeString(); # Дата
        }

        if (isset($client_application) && ($dt < $current_date)){
            return redirect()->route('client.index')->with('error', 'Отправка формы возможно только 1 раз в сутки');
        }else{
            $rules = ([
                'theme' => 'required',
                'message' => 'required',
                'file' => 'nullable',
                'user_id' => 'required',
            ]);

            $messages = [
                'theme.required' => 'Поле тема обязательно для заполнения',
                'theme.max' => 'Поле тема обязательно для заполнения',
                'message.required' => 'Поле сообщение обязательно для заполнения',
            ];
            $validator = Validator::make($request->all(), $rules, $messages)->validate();

            $data = $request->all();
            $data['file'] = Application::uploadFile($request);
            $application = Application::create($data);

            $body = "<p><b>Тема:</b> {$application->theme}</p>";
            $body .= "<p><b>Сообщение:</b> {$application->message}</p>";
            $body .= "<p><b>Имя клиента:</b> {$application->user->name}</p>";
            $body .= "<p><b>Email:</b> {$application->user->email}</p>";
            $uploadFile = asset('/uploads/' . $application->file);
            if (isset($application->file)){
                $body .= "<a href=\"{$uploadFile}\" target='_blank'>Скачать файл</a>";
            }

//        SendApplicationToMailJob::dispatch($body)->onQueue('application-mail');
            $emailJobs = (new SendApplicationToMailJob($body))->onQueue('application-mail');
            dispatch($emailJobs);

            return redirect()->route('client.index')->with('success', 'Данные отправлены');
        }

    }

    public function changeStatus($id){
        $application = Application::find($id);
        $application->update([
            'status' => 'completed',
        ]);
        return redirect()->back()->with('success', 'Статус заявки изменён');
    }
}
