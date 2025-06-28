<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrescriptionItem;

class PrescriptionItemController extends Controller
{
    public function update(Request $request, $id)
    {
        $item = PrescriptionItem::findOrFail($id);
        $item->update($request->only(['medicine_name', 'dosage', 'duration_days']));

        return redirect()->back(); // 🔁 Just reload the same page
    }

    public function destroy(Request $request, $id)
    {
        $item = PrescriptionItem::findOrFail($id);
        $item->delete();

        return redirect()->back(); // 🔁 Just reload the same page
    }
}
