@extends('layouts.main')

@section('content')
<style>
    .role-card {
        border: 1px solid #d1d5db; /* Tailwind gray-300 */
        border-radius: 0.5rem;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .role-card.selected {
        border-color: #3b82f6; /* Tailwind blue-500 */
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.4); /* blue glow */
    }

    .role-card img {
        width: 64px;
        height: 64px;
        object-fit: contain;
    }

    .role-card span {
        margin-top: 1rem;
        font-size: 1.125rem;
        font-weight: 600;
    }
</style>

<div class="flex justify-center items-center min-h-screen bg-gray-50">
    <div class="bg-white rounded-lg shadow-md p-10 max-w-3xl w-full text-center">
        <h2 class="text-2xl font-bold text-red-500 mb-2">Choose Your Role</h2>
        <p class="text-gray-600 mb-8">Select how you’ll use the Smart Healthcare System</p>

        <form method="POST" action="{{ route('role.save') }}">
            @csrf
            <input type="hidden" name="role" id="selectedRole">

            <div class="flex justify-center gap-8">
                <!-- Doctor Card -->
                <div class="role-card" data-role="doctor" onclick="selectRole('doctor')">
                    <img src="{{ asset('images/doctor.photo.png') }}" alt="Doctor Icon">
                    <span>a Doctor</span>
                </div>

                <!-- Pharmacist Card -->
                <div class="role-card" data-role="pharmacist" onclick="selectRole('pharmacist')">
                    <img src="{{ asset('images/pharmacist.photo.png') }}" alt="Pharmacist Icon">
                    <span>a Pharmacist</span>
                </div>
            </div>

            @error('role')
                <p class="text-red-500 text-sm mt-4">{{ $message }}</p>
            @enderror

            <button type="submit" class="mt-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Continue
            </button>
        </form>
    </div>
</div>

<script>
    function selectRole(role) {
        document.getElementById('selectedRole').value = role;

        const cards = document.querySelectorAll('.role-card');
        cards.forEach(card => {
            card.classList.remove('selected');
        });

        const selectedCard = document.querySelector(`.role-card[data-role="${role}"]`);
        if (selectedCard) selectedCard.classList.add('selected');
    }
</script>
@endsection
