<div>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Swiftalk - Fast, Real-time Chat App</title>
        @livewireStyles
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            .hero-gradient {
                background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    </head>


    <body class="font-sans antialiased text-gray-900">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('images/Web_Logo.png') }}" alt="Swiftalk Logo" class="h-10">
                        <span class="text-xl font-bold text-gray-900">Swiftalk</span>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-8">
                    <a href="#features" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Features</a>
                    <a href="#how-it-works" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">How It Works</a>
                    <a href="#pricing" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Pricing</a>
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign Up Free</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    Real-time Chat Made Simple
                </h1>
                <p class="mt-6 max-w-lg mx-auto text-xl">
                    Swiftalk delivers lightning-fast messaging with all the features you need and none of the clutter.
                </p>
                <div class="mt-10 flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-md text-lg font-medium hover:bg-gray-100">
                        Get Started
                    </a>
                    <a href="#demo" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-md text-lg font-medium hover:bg-white hover:text-blue-600">
                        Live Demo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Powerful Features
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-500">
                    Everything you need for seamless communication
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="feature-card pt-6 bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out">
                    <div class="px-6 pb-8">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fas fa-bolt text-xl"></i>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">Lightning Fast</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Real-time messaging with Livewire powered WebSockets for instant delivery.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card pt-6 bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out">
                    <div class="px-6 pb-8">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">Group Chats</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Create unlimited groups with customizable permissions and moderation tools.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card pt-6 bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out">
                    <div class="px-6 pb-8">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                            <i class="fas fa-file-upload text-xl"></i>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">File Sharing</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Share images, documents, and other files with built-in previews.
                        </p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card pt-6 bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out">
                    <div class="px-6 pb-8">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-red-500 text-white">
                            <i class="fas fa-mobile-alt text-xl"></i>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">Mobile Friendly</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Fully responsive design that works perfectly on any device.
                        </p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card pt-6 bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out">
                    <div class="px-6 pb-8">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-yellow-500 text-white">
                            <i class="fas fa-shield-alt text-xl"></i>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">End-to-End Encryption</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Optional encryption for sensitive conversations (coming soon).
                        </p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card pt-6 bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out">
                    <div class="px-6 pb-8">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <i class="fas fa-plug text-xl"></i>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">Integrations</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Connect with your favorite tools like Slack, Discord, and more.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div id="how-it-works" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    How Swiftalk Works
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-500">
                    Get started in just a few simple steps
                </p>
            </div>

            <div class="mt-16">
                <div class="space-y-16 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
                    <!-- Step 1 -->
                    <div class="group relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white group-hover:bg-blue-600">
                            <span class="text-xl font-bold">1</span>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Create Your Account
                        </h3>
                        <p class="mt-2 text-base text-gray-500">
                            Sign up in seconds with just your email address or social account.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="group relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white group-hover:bg-blue-600">
                            <span class="text-xl font-bold">2</span>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Connect With Others
                        </h3>
                        <p class="mt-2 text-base text-gray-500">
                            Invite colleagues or friends via email or shareable link.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="group relative">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white group-hover:bg-blue-600">
                            <span class="text-xl font-bold">3</span>
                        </div>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Start Chatting
                        </h3>
                        <p class="mt-2 text-base text-gray-500">
                            Enjoy real-time messaging with all the powerful features.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Section -->
    <div id="demo" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-8 lg:mb-0">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Try Swiftalk Now
                    </h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500">
                        Experience the speed and simplicity of our chat interface with our interactive demo.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md text-lg font-medium">
                            Start Free Trial
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white p-4 rounded-lg shadow-xl border border-gray-200">
                        <!-- This would be your live demo component -->
                        <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-comments text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600">Live Chat Demo</p>
                                <p class="text-sm text-gray-500 mt-2">(Would show real demo in production)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div id="pricing" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Simple, Transparent Pricing
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-gray-500">
                    No hidden fees. No surprises.
                </p>
            </div>

            <div class="mt-16 space-y-8 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
                <!-- Free Tier -->
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Free</h3>
                        <p class="mt-4 text-sm text-gray-500">
                            Perfect for individuals and small groups
                        </p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$0</span>
                            <span class="text-base font-medium text-gray-500">/month</span>
                        </p>
                        <a href="{{ route('register') }}" class="mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Get Started
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h4 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h4>
                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Up to 10 users</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Basic messaging</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">File sharing (10MB limit)</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">1 group chat</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Pro Tier -->
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Pro</h3>
                        <p class="mt-4 text-sm text-gray-500">
                            For growing teams that need more
                        </p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$9</span>
                            <span class="text-base font-medium text-gray-500">/month</span>
                        </p>
                        <a href="{{ route('register') }}" class="mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Upgrade Now
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h4 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h4>
                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Up to 50 users</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Advanced messaging</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">File sharing (100MB limit)</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Unlimited group chats</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Message history (6 months)</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Enterprise Tier -->
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Enterprise</h3>
                        <p class="mt-4 text-sm text-gray-500">
                            For organizations with advanced needs
                        </p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">$29</span>
                            <span class="text-base font-medium text-gray-500">/month</span>
                        </p>
                        <a href="{{ route('register') }}" class="mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Contact Sales
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h4 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h4>
                        <ul class="mt-6 space-y-4">
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Unlimited users</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">All Pro features</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">File sharing (1GB limit)</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Unlimited message history</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Priority support</p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                    <i class="fas fa-check"></i>
                                </div>
                                <p class="ml-3 text-sm text-gray-500">Custom integrations</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-700">
        <div class="max-w-2xl mx-auto py-16 px-4 text-center sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ready to transform your communication?</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-blue-200">
                Join thousands of happy users who switched to Swiftalk.
            </p>
            <a href="{{ route('register') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 sm:w-auto">
                Sign up for free
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <h3 class="text-white text-lg font-semibold">
                        Swiftalk
                    </h3>
                    <p class="mt-4 text-gray-400 text-sm">
                        The fastest, simplest way to communicate with your team, friends, or family.
                    </p>
                </div>
                <div>
                    <h3 class="text-white text-sm font-semibold tracking-wider uppercase">Product</h3>
                    <ul class="mt-4 space-y-4">
                        <li>
                            <a href="#features" class="text-gray-400 hover:text-white text-sm">Features</a>
                        </li>
                        <li>
                            <a href="#pricing" class="text-gray-400 hover:text-white text-sm">Pricing</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white text-sm">API</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-sm font-semibold tracking-wider uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white text-sm">About</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white text-sm">Blog</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white text-sm">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8 flex justify-between">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Swiftalk. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    </body>

</div>
