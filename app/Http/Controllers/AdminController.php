<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showappointment()
    {
        $data = Appointment::all();
        return view('admin.showappointment', compact('data'));
    }

    public function acceptAppointment($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->status = 'Accepted';
            $appointment->save();

            // Send email using a view
            Mail::send('emails.appointment_accepted', [
                'name' => $appointment->name,
                'appointment_date' => $appointment->appointment_date,
                'doctor' => $appointment->doctor,
                'services' => $appointment->services
            ], function($message) use ($appointment) {
                $message->to($appointment->email)
                        ->subject('Appointment Accepted');
            });

            return response()->json(['success' => true, 'status' => 'Accepted']);
        }
        return response()->json(['success' => false], 404);
    }

    public function cancelAppointment($id)
{
    $appointment = Appointment::find($id);
    if ($appointment) {
        $appointment->status = 'Canceled';
        $appointment->save();

        // Send email using a view
        Mail::send('emails.appointment_canceled', [
            'name' => $appointment->name
        ], function($message) use ($appointment) {
            $message->to($appointment->email)
                    ->subject('Appointment Canceled');
        });

        return response()->json(['success' => true, 'status' => 'Canceled']);
    }
    return response()->json(['success' => false], 404);
}

}
