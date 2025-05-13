<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('doctor_id', Auth::id())->with('patient')->get();
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Paid,Pending',
        ]);

        $payment = Payment::create([
            'doctor_id' => Auth::id(),
            'patient_id' => $data['patient_id'],
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);

        return response()->json($payment, 201);
    }

    public function show($id)
{
    $payment = Payment::find($id);

    if (!$payment) {
        return response()->json(['message' => 'Payment not found.'], 404);
    }

    return response()->json($payment);
}

    public function update(Request $request, Payment $payment)
    {
        $this->authorizeAccess($payment);

        $data = $request->validate([
            'amount' => 'numeric|min:0',
            'status' => 'in:Paid,Pending',
        ]);

        $payment->update($data);
        return response()->json($payment);
    }

    public function destroy(Payment $payment)
    {
        $this->authorizeAccess($payment);
        $payment->delete();
        return response()->json(['message' => 'Deleted']);
    }

    private function authorizeAccess(Payment $payment)
    {
        if ($payment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
