<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index(){
        $applications = Application::orderBy('id', 'desc')->paginate(20);
        return view('manager.index', compact('applications'));
    }

    public function changeStatus($id){
        try {
            $application = Application::find($id);
            $application->update([
                'status' => 'completed',
            ]);
            return redirect()->back()->with('success', 'Статус заявки изменён');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
