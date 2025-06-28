@extends('layouts.app')

@section('content')
<div>
     
     <!-- Hero Section -->
    <section class="relative bg-cover bg-center text-white min-h-screen" style="background-image: url('/images/hero.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <!-- Navbar -->
        <nav class="relative z-20 container mx-auto px-6 py-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/wessal.png') }}" alt="Logo" class="h-10">
                <span class="text-2xl font-bold text-white">WESAL</span>
            </div>
            <ul class="flex space-x-8 text-sm font-semibold text-white">
                <li><a href="#" class="hover:text-[#FFCC00]">Home</a></li>
                <li><a href="#about" class="hover:text-[#FFCC00]">About Us</a></li>
                <li><a href="#services" class="hover:text-[#FFCC00]">Services</a></li>
                <li><a href="#contact" class="hover:text-[#FFCC00]">Contact Us</a></li>
            </ul>
            <div class="flex items-center space-x-6">
                <a href="{{ route('login') }}" class="text-lg hover:text-gray-300">Login</a>
                <a href="{{ route('register') }}" class="text-lg hover:text-gray-300">Sign Up</a>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="relative z-10 flex flex-col justify-center items-center text-center px-6 pt-24 md:pt-40">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">A Smarter Way to Track, Prescribe, and Care</h1>
            <p class="text-md md:text-lg mb-8 max-w-2xl">Join a connected system where doctors and pharmacists collaborate effortlessly.</p>
            <a href="#features"
               class="inline-block bg-[#1D5E86] text-white border border-white px-6 py-3 rounded-lg font-semibold hover:bg-[#174c6a] transition-colors duration-300 shadow-sm">
               Connect with Your Patients
            </a>
        </div>
    </section>

    <!-- Additional sections remain unchanged from the original content -->
</div>

    <!-- Key Features -->
    <section id="features" class="py-20 bg-white text-[#292D32]">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-12 text-center">Key Features</h2>
            <div class="grid md:grid-cols-4 gap-6">
                @php
                    $features = [
                        ['icon' => '🗂️', 'title' => 'Smart Dashboard', 'desc' => 'View all patient records and history in one place.'],
                        ['icon' => '📋', 'title' => 'Prescription Sync', 'desc' => 'Instant updates between doctors and pharmacists.'],
                        ['icon' => '🩺', 'title' => 'Live Health Tracking', 'desc' => 'Monitor vitals and receive real-time alerts.'],
                        ['icon' => '🔗', 'title' => 'Full System Link', 'desc' => 'Integrates with app, bracelet, and pill box.']
                    ];
                @endphp

                @foreach ($features as $f)
                    <div class="p-6 rounded-xl border bg-white text-[#292D32] shadow hover:shadow-lg transition">
                        <div class="text-3xl mb-4">{{ $f['icon'] }}</div>
                        <h3 class="text-lg font-semibold mb-2">{{ $f['title'] }}</h3>
                        <p class="text-sm">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-[#F6F9FC] text-[#292D32]">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <p class="uppercase text-sm font-semibold text-[#1D5E86] mb-2">Who we are</p>
                <h2 class="text-3xl font-bold mb-4">Your Gateway to Smarter, Safer Healthcare</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    We connect doctors, pharmacists, and patients with real-time health monitoring, simple prescriptions,
                    and smart devices to improve safety and care. Our system ensures better communication and seamless treatment workflows.
                </p>
                <a href="#" class="bg-[#1D5E86] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#174c6a] transition">
                    Learn more
                </a>
            </div>
            <div class="relative">
                <img src="/images/after.jpg" alt="doctor heart" class="rounded-xl w-full max-w-sm mx-auto object-cover shadow-md">
                <div class="absolute top-4 right-4 bg-white shadow px-3 py-1 rounded text-sm font-semibold text-[#1D5E86]">100% Secure</div>
                <div class="absolute bottom-4 left-4 bg-white shadow px-3 py-1 rounded text-sm font-semibold text-[#1D5E86]">Fully Connected</div>
            </div>
        </div>
    </section>

    
    <!-- Our Services -->
    <section id="services" class="py-20 bg-white text-center text-[#292D32]">
        <div class="container mx-auto px-6">
            <p class="text-[#1D5E86] uppercase font-semibold mb-2">Our services</p>
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Patient Ecosystem Overview</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-12">
                Our system provides a complete healthcare experience for patients through smart, connected tools:
            </p>

            <div class="grid md:grid-cols-3 gap-8 text-left">
                @foreach([
                    ['images/1.jpg', '📱', 'Patient & Caregiver Mobile App', 'Track health, receive alerts, and stay connected anytime, anywhere.'],
                    ['images/2.jpg', '⌚', 'Smart Bracelet', 'Continuous health monitoring with real-time vitals tracking.'],
                    ['images/3.jpg', '💊', 'Smart Pill Box', 'Automated medication reminders to ensure safe and timely doses.']
                ] as [$img, $icon, $title, $desc])
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition">
                        <img src="{{ asset($img) }}" alt="{{ $title }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="w-12 h-12 flex items-center justify-center bg-[#1D5E86] text-white rounded-full text-xl mb-4">
                                {{ $icon }}
                            </div>
                            <h3 class="text-lg font-semibold text-[#1D5E86] mb-2">{{ $title }}</h3>
                            <p class="text-gray-600 mb-4">{{ $desc }}</p>
                            <div class="text-right">
                                <a href="#" class="inline-block text-[#1D5E86] text-xl">→</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative bg-cover bg-center min-h-[550px] flex items-center text-white" style="background-image: url('{{ asset('images/ready.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-70 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-6xl mx-auto px-6">
            <div class="max-w-xl text-left space-y-6">
                <h2 class="text-4xl md:text-5xl font-bold leading-tight">
                    Ready to Transform<br>Healthcare?
                </h2>
                <p class="text-lg md:text-xl text-gray-200">
                    Take the first step towards smarter, safer, and more connected care.
                </p>
                <a href="#" class="inline-block bg-[#FFCC00] text-[#1D5E86] px-6 py-3 rounded-md font-semibold text-lg shadow hover:bg-yellow-400 transition">
                    Download the App →
                </a>
            </div>
        </div>
    </section>


         <!-- Contact Us -->
    <section id="contact" class="py-20 bg-gray-100 text-[#292D32]">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-[#1D5E86] mb-6 text-center">Contact Us</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <form class="bg-white p-6 rounded-xl shadow">
                    <div class="grid gap-4">
                        <input type="text" placeholder="Your Name" class="w-full px-4 py-3 border rounded" required>
                        <input type="email" placeholder="Your Email" class="w-full px-4 py-3 border rounded" required>
                        <input type="text" placeholder="Your Phone" class="w-full px-4 py-3 border rounded" required>
                        <textarea placeholder="Your Message" rows="4" class="w-full px-4 py-3 border rounded" required></textarea>
                        <button type="submit" class="bg-[#1D5E86] text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">Send</button>
                    </div>
                </form>
                <div class="text-gray-700 text-lg space-y-4">
                    <p><strong>Email:</strong> support@smarthealthcare.com</p>
                    <p><strong>Phone:</strong> +56913295643</p>
                    <p><strong>Address:</strong> Cairo, Egypt</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#292D32] text-gray-300 text-sm py-10">
        <div class="container mx-auto px-6 grid md:grid-cols-4 gap-8">
            <div>
                <h4 class="text-white font-semibold mb-2">WESAL</h4>
                <ul>
                    <li><a href="#" class="hover:underline">About us</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                    <li><a href="#" class="hover:underline">Review us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-2">Services</h4>
                <ul>
                    <li>Doctor Dashboard</li>
                    <li>Pharmacist Dashboard</li>
                    <li>Patient App</li>
                    <li>Smart Bracelet</li>
                    <li>Medication Box</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-2">Support</h4>
                <ul>
                    <li>Terms & Conditions</li>
                    <li>Privacy Policy</li>
                    <li>FAQ</li>
                    <li>Help Center</li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-2">Contact</h4>
                <p>(569) 13295643</p>
                <p>support@gmail.com</p>
            </div>
        </div>
        <div class="text-center text-gray-400 mt-8">© 2025 WESAL. All rights reserved.</div>
    </footer>
</div>
@endsection