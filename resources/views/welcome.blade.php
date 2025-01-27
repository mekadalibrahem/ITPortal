<x-layouts.guest >
    <x-slot:title>
        welcome
    </x-slot:title>
     <!-- Hero Section -->
     <header class="bg-blue-600 text-white py-16">
        <div class="container mx-auto text-center"  >
            <h1 class="text-5xl font-bold mb-4">Welcome to the IT Request Management System</h1>
            <p class="text-xl mb-8">Manage and track all your IT-related requests in one place.</p>
           </div>
    </header>
     <!-- Features Section -->
     <section id="features" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Why Choose Our System?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <img src="{{asset("imgs/Img_1.jpg")}}" alt="Feature 1" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Streamlined Request Process</h3>
                    <p class="text-gray-600">Submit and track your requests with ease, ensuring efficient management.</p>
                </div>
                <div>
                    <img src="{{asset("imgs/roles.jpg")}}" alt="Feature 2" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Role-Based Access</h3>
                    <p class="text-gray-600">Access features based on your role, whether you're a student, staff, or admin.</p>
                </div>
                <div>
                    <img src="{{asset("imgs/notity.jpg")}}" alt="Feature 3" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Real-Time Notifications</h3>
                    <p class="text-gray-600">Stay informed with real-time notifications about your request status.</p>
                </div>
            </div>
        </div>
    </section>

     <!-- About Section -->
     <section id="about" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-4">About Our Request Management System</h2>
                    <p class="text-gray-600 mb-4">
                        Our system is designed to streamline the process of submitting and managing IT requests within the college.
                        Whether you are a student needing assistance or a staff member managing requests, our platform provides
                        a user-friendly interface to ensure your needs are met promptly and efficiently.
                    </p>
                    <p class="text-gray-600">
                        With role-based access, different levels of users can interact with the system in ways tailored to their responsibilities.
                        This ensures that the right people are handling the right tasks, improving the overall efficiency of the IT department.
                    </p>
                </div>
                <div>
                    <img src="{{asset("imgs/img_2.jpg")}}" alt="About Image" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

        <!-- Call to Action Section -->
        <section id="cta" class="py-16 bg-blue-600 text-white text-center">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
                <p class="text-xl mb-8">Join our platform today and streamline your IT request management process.</p>
                <a href="#" class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold">Sign Up Now</a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-400 py-6 text-center">
            <div class="container mx-auto">
                &copy; {{ date('Y') }} IT Request Management System. All Rights Reserved.
            </div>
        </footer>




    </x-layouts.guest>
