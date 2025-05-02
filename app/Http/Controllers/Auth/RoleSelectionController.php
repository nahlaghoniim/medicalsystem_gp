namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleSelectionController extends Controller
{
    // Show the role selection view
    public function show()
    {
        return view('auth.select-role');
    }

    // Store the selected role for the authenticated user
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:doctor,pharmacist',
        ]);

        $user = auth()->user();
        $user->role = $request->role;
        $user->save();

        return $request->role === 'doctor'
            ? redirect()->route('dashboard.doctor.index')
            : redirect()->route('dashboard.pharmacist');
    }
}
