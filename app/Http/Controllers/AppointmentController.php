<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date_format:Y-m-d H:i', // Ensure date format includes time
            'doctor' => 'required|string|max:255',
            'services' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        try {
            // Check if the appointment date and time are available
            $date = $validatedData['date'];
            $doctor = $validatedData['doctor'];

            // Perform additional validation as needed, e.g., check if the time is already booked
            $appointmentExists = Appointment::where('appointment_date', $date)
                ->where('doctor', $doctor)
                ->exists();

            if ($appointmentExists || (new \DateTime($date))->format('H:i') == '18:00') {
                return response()->json(['status' => 'error', 'message' => 'The selected time is not available. Please choose another time.'], 422);
            }

            // Create a new appointment record
            $appointment = new Appointment();
            $appointment->name = $validatedData['name'];
            $appointment->email = $validatedData['email'];
            $appointment->phone = $validatedData['phone'];
            $appointment->appointment_date = $date;
            $appointment->doctor = $doctor;
            $appointment->services = $validatedData['services'];
            $appointment->message = $validatedData['message'] ?? null;
            $appointment->status = 'pending'; // Set default status
            $appointment->save();

            // Return success response for AJAX
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Return error response for AJAX
            return response()->json(['status' => 'error', 'message' => 'Failed to save appointment. Please try again later.'], 500);
        }
    }

    public function create()
    {
        return view('templates.appointment_template');
    }

    public function updateStatus(Request $request)
    {
        $appointment = Appointment::find($request->id);
        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['success' => true]);
    }

    public function checkAvailability(Request $request)
    {
        $date = $request->date;
        $doctor = $request->doctor;

        $appointments = Appointment::whereDate('appointment_date', $date)
                                ->where('doctor', $doctor)
                                ->pluck('appointment_date');

        $bookedHours = $appointments->map(function ($appointment) {
            return date('H:i', strtotime($appointment));
        })->toArray();

        $availableHours = [];
        for ($hour = 10; $hour < 18; $hour++) {
            $time = sprintf('%02d:00', $hour);
            if (!in_array($time, $bookedHours)) {
                $availableHours[] = $time;
            }
        }

        return response()->json(['booked' => $bookedHours, 'available' => $availableHours]);
    }

}
