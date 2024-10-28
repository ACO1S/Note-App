<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Page</title>
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

        .header {
            padding: 16px 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .header.dark {
            background-color: #2D3748;
            color: #A0AEC0;
        }

        .content {
            margin-top: 80px;
            padding: 20px;
        }

        .bg-gradient {
            background: linear-gradient(to right, #4A90E2, #A1C6EA); 
        }

        .bg-gradient-dark {
            background: linear-gradient(to right, #1a202c,  #7AB2D3); 
        }
    </style>
</head>
<body class="bg-gradient">
    <div class="header flex justify-between items-center fixed top-0 w-full bg-[#f9fafb] border-b border-gray-300 z-800">
        <a href="{{ route('index') }}" class="mb-3 mt-5 ml-5 text-5xl font-spartan" style="color: #4A628A;"><b>NOTES</b></a>
        <button onclick="toggleSidebar()" class="toggle-button text-2xl ml-2" style="color: #4A628A;">
            ☰
        </button>
    </div>

    <div id="sidebar" class="sidebar">
        <form action="{{ route('notes.search') }}" method="GET" class="search-form mb-4">
            <input type="text" name="query" placeholder="ENTER A TITLE" class="border border-[#4A628A] rounded-2xl px-3 py-1 mr-2 flex-grow min-w-[120px]">
        </form>
        
        <button onclick="toggleDarkMode()" id="darkModeButton" class="dark-mode-button mt-4">
            <span class="ml-2 ">🌙 Dark Mode</span>
        </button>
    </div>

    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <div class="content">
        @if($notes->isEmpty())
            <p class="pt-5 text-2xl font-bold" style="color: #FFFFFF;">No notes found matching your search.</p>
        @endif
       
        @foreach ($notes as $note)
            <form action="{{ route('showNotes', ['id' => $note->id]) }}" method="GET" class="mb-3 mt-5 ml-3 mr-3 font-spartan border border-customColor rounded-xl" style="color: #4A628A;">
                <button type="submit" class="w-full border-0 bg-customColor text-white py-6 rounded-xl flex items-start" style="background-color: #4A628A;">
                    <div class="w-full text-left px-4 py-3">
                        <div class="text-lg sm:text-xl md:text-2xl lg:text-3xl uppercase">
                            Title: {{ $note->title }}
                        </div>
                        <div class="mt-1 text-sm sm:text-base md:text-lg">
                            Description: {{ $note->description }}
                        </div>
                    </div>
                </button>
            </form>
            <hr>
        @endforeach

        <form action="/create" method="GET" class="fixed bottom-5 right-5 mx-auto w-full max-w-xs p-4 rounded-md flex justify-end z-10">
            <button type="submit" class="flex items-center justify-center border border-blue-900 bg-blue-900 text-white font-bold text-3xl md:text-4xl rounded-2xl w-16 h-16 pb-3">
                <b class="text-5xl font-bold">+</b>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const darkModeButton = document.getElementById("darkModeButton");
            if (localStorage.getItem("theme") === "dark") {
                document.documentElement.classList.add("dark");
                document.querySelector(".header").classList.add("dark"); 
                document.body.classList.add("bg-gradient-dark"); 
                darkModeButton.innerHTML = "☀️ Light Mode"; 
            }
        });

        function toggleDarkMode() {
            document.documentElement.classList.toggle("dark");
            const theme = document.documentElement.classList.contains("dark") ? "dark" : "light";
            localStorage.setItem("theme", theme);
            const header = document.querySelector(".header");
            const darkModeButton = document.getElementById("darkModeButton");
            header.classList.toggle("dark");

            // Change the background based on theme
            document.body.classList.toggle("bg-gradient-dark", theme === "dark");
            document.body.classList.toggle("bg-gradient", theme === "light");

            darkModeButton.innerHTML = theme === "dark" ? "☀️ Light Mode" : "🌙 Dark Mode";
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
