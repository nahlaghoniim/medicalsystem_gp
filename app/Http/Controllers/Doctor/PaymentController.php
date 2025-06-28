<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment; // ✅ Add this line
use App\Models\Appointment;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $payments = Payment::with(['patient', 'appointment'])->latest()->get();
    return view('dashboard.doctor.payments.index', compact('payments'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string',
            'status' => 'required|in:paid,unpaid,refunded',
        ]);
    
        \App\Models\Payment::create($validated);
    
        return redirect()->route('doctor.payments.index')->with('success', 'Payment recorded.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $payment = Payment::with(['patient', 'appointment'])->findOrFail($id);
    return view('dashboard.doctor.payments.show', compact('payment'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function markPaid(Appointment $appointment)
{
    if (!$appointment->payment) {
        $appointment->payment()->create([
            'status' => 'paid',
            'amount' => 100, // or your dynamic value
        ]);
    } else {
        $appointment->payment->update(['status' => 'paid']);
    }

    return response()->json(['status' => 'paid']);
}

}
