<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Landing Page</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="flex items-center space-x-2">
            <div class="text-3xl font-bold text-gray-800 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7M16 3h-1a4 4 0 00-4 4v1m-4 4h.01M12 12h.01M16 16h.01" />
                </svg>
                <span>Your Logo</span>
            </div>
        </div>
        <nav class="space-x-6 text-gray-700 font-medium">
            <a href="#" class="text-blue-700 hover:underline">HOME</a>
            <a href="#" class="hover:text-gray-900">About</a>
            <a href="#" class="text-blue-700 hover:underline">Contact</a>
            <a href="#" class="text-blue-700 hover:underline">Pricing</a>
            <a href="#" class="bg-yellow-500 text-white px-4 py-1 rounded-full hover:bg-yellow-600 transition">Sign In</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex flex-col md:flex-row items-center justify-center max-w-7xl mx-auto px-6 py-16 bg-white mt-8 rounded-lg shadow-lg">
        <!-- Left Image -->
        <div class="md:w-1/2 flex justify-center mb-8 md:mb-0">
            <img src="https://cdn.pixabay.com/photo/2017/01/31/21/23/businessman-2027366_960_720.png" alt="Businessman Illustration" class="max-h-96" />
        </div>

        <!-- Right Text Content -->
        <div class="md:w-1/2 md:pl-12 text-center md:text-left">
            <h1 class="text-5xl font-extrabold text-gray-800 leading-tight mb-4">
                Coaching <span class="block">&amp;</span> Mentoring
            </h1>
            <p class="text-gray-700 text-lg mb-6 max-w-md">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
            <a href="#" class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-full text-lg font-semibold hover:bg-yellow-600 transition">
                Get More
            </a>
        </div>
    </main>

</body>
</html>
