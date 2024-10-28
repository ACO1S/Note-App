<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X_UA_Compatible" content="ie=edge">
    <title>Create Note</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <link href="dist/output.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        .sidebar {
            background-color: #f9fafb;
            border-left: 1px solid #e5e7eb; 
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0; 
            right: -250px;
            transition: right 0.3s; 
            z-index: 1000;
            padding: 20px; 
        }

        .sidebar.visible {
            right: 0; 
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 900;
        }

        .overlay.visible {
            display: block;
        }

        .dark-mode-button {
            background-color: transparent;
            border: none;
            color: #4A628A;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .dark-mode-button:hover {
            color: #2c3e50;
        }

        .dark .dark-mode-button {
            color: #a0aec0;
        }
        .toggle-button {
            transition: color 0.3s;
        }
        .dark .toggle-button {
            color: white;
        }
        
       
        .bg-gradient-light {
            background: linear-gradient(to right, #DFF2EB, #A1C6EA); 
        }

       
        .bg-gradient-dark {
            background: linear-gradient(to left, #1a202c, #7AB2D3); 
        }
    </style>
</head>

<body class="bg-gradient-light">
    
    <div id="sidebar" class="sidebar">
        <button id="darkModeButton" onclick="toggleDarkMode()" class="dark-mode-button mt-4">
            🌙 <span class="ml-2">Dark Mode</span>
        </button>
    </div>

    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <button onclick="toggleSidebar()" class="fixed top-4 right-4 z-50 text-2xl" style="color: #57A5D2;">
        ☰
    </button>

    <h1 class="mb-3 mt-5 ml-5 text-5xl font-spartan" style="color: #4A628A;"><b>NOTES</b></h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('createNotes') }}" method="POST">
        @method('POST')
        @csrf
        
        <div class="flex justify-center mt-5">
            <input type="text" id="title" name="title" placeholder="UNTITLED" required class="border border-gray-300 rounded-md px-6 py-3 w-screen ml-2 mr-2 max-w-2xl focus:outline-none focus:border-blue-500 text-2xl font-spartan">
        </div>
        <div class="flex justify-center mb-2">
            <input type="text" id="description" name="description" placeholder="DESCRIPTION" required class="border border-gray-300 rounded-md px-6 py-3 w-screen ml-2 mr-2 max-w-2xl focus:outline-none focus:border-blue-500 text-base font-spartan">
        </div>
        <div class="flex justify-center mb-2 mt-2;">
            <textarea id="content" name="content" placeholder="CONTENT..." required class="border border-gray-300 rounded-md px-6 py-3 w-screen h-[calc(450px)] ml-2 mr-2 max-w-2xl focus:outline-none focus:border-blue-500 text-sm font-spartan"></textarea><br>
        </div>

        <div class="sticky top-0 background-color: #DFF2EB z-10 flex justify-center space-x-4">
            <button type="submit" class="flex items-center justify-center border border-blue-900 bg-blue-900 text-white font-bold rounded-md h-8 
            w-20 md:w-24 lg:w-28">SUBMIT</button>
            <a href="{{ route('index') }}" class="flex items-center justify-center border border-gray-400 bg-gray-300 text-gray-800 font-bold rounded-md h-8 
            w-20 md:w-24 lg:w-28">GO BACK</a>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const darkModeButton = document.getElementById("darkModeButton");

            if (localStorage.getItem("theme") === "dark") {
                document.documentElement.classList.add("dark");
                document.body.classList.remove("bg-gradient-light");
                document.body.classList.add("bg-gradient-dark");
                darkModeButton.innerHTML = "☀️ Light Mode"; 
            }
        });

        function toggleDarkMode() {
            document.documentElement.classList.toggle("dark");
            const theme = document.documentElement.classList.contains("dark") ? "dark" : "light";
            localStorage.setItem("theme", theme);
            const darkModeButton = document.getElementById("darkModeButton");

            if (theme === "dark") {
                document.body.classList.remove("bg-gradient-light");
                document.body.classList.add("bg-gradient-dark");
                darkModeButton.innerHTML = "☀️ Light Mode"; 
            } else {
                document.body.classList.remove("bg-gradient-dark");
                document.body.classList.add("bg-gradient-light");
                darkModeButton.innerHTML = "🌙 Dark Mode"; 
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("visible");
            overlay.classList.toggle("visible");
        }
    </script>
</body>
</html>
