<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEdm;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Mail;

class PatientController extends Controller
{
    public function availablity(Request $request){
		$user = Patient::where('timeSlot', $request->timeSlot)->where('date', $request->date)->first();
		
		if(!$user){
			return response()->json(['message' => 200]);
		}else{
			return response()->json(['message' => 404]);
		}
	}

    public function store(Request $request) {

		$userData = ['name' => $request->fullName, 'email' => $request->email, 'date' => $request->date, 'timeSlot' => $request->timeSlot];
		Patient::create($userData);
		$patient = Patient::orderBy('id', 'desc')->first();
		Mail::to($userData['email'])->send(new NotificationEdm($patient));
		return response()->json([
			'status' => 200,
		]);
	}
}
