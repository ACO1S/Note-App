<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Note</title>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <link href="dist/output.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .printable-content,
            .printable-content * {
                visibility: visible;
            }

            .printable-content {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 20px;
                box-sizing: border-box;
            }

            .overlay,
            .sidebar {
                display: none !important;
            }

            
            .printable-content .note-content {
                border: none; 
                background: none; 
                color: inherit; 
                white-space: pre-wrap; 
                overflow: visible; 
            }
        }

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

        
        .bg-gradient {
            background: linear-gradient(to right, #DFF2EB, #A1C6EA);
        }

        
        .dark .bg-gradient {
            background: linear-gradient(to left, #2C3E50, #7AB2D3);
        }
    </style>
</head>

<body class="bg-gradient dark:bg-gradient text-gray-900 dark:text-gray-200">

    <div id="sidebar" class="sidebar">
        <button id="darkModeButton" onclick="toggleDarkMode()" class="dark-mode-button mt-4">
            🌙 <span class="ml-2">Dark Mode</span>
        </button>

        <button onclick="printPage()" class="dark-mode-button mt-4">
            🖨️ <span class="ml-2">Print</span>
        </button>
    </div>

    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <button onclick="toggleSidebar()" class="fixed top-4 right-4 z-50 text-2xl" style="color: #57A5D2;">
        ☰
    </button>

    <h1 class="mb-3 mt-5 ml-5 text-5xl font-spartan" style="color: #4A628A;"><b>NOTES</b></h1>

    <div class="printable-content">
        <div class="flex justify-center mt-0">
            <div class="bg-[#4A628A] text-[#FFFFFF] border border-gray-300 rounded-md px-6 py-3 w-screen ml-2 mr-2 max-w-2xl h-[70px] flex items-center">
                <span class="text-2xl font-spartan">{{ $note->title }}</span>
            </div>
        </div>

        <div class="flex justify-center mb-2">
            <div class="bg-[#7AB2D3] text-[#4A628A] border border-gray-300 rounded-md px-6 py-3 w-screen ml-2 mr-2 max-w-2xl h-[70px] flex items-center">
                <span class="text-base font-spartan">{{ $note->description }}</span>
            </div>
        </div>

        <div class="flex justify-center mb-1 mt-2">
            <div class="note-content bg-white text-[#4A628A] border border-gray-300 rounded-md px-6 py-3 w-screen ml-2 mr-2 max-w-2xl flex items-start focus:outline-none focus:border-blue-500 text-sm font-spartan">
                {{ $note->content }}
            </div>
        </div>
    </div>

    <div class="flex justify-center space-x-4 mt-1">
        <form action="{{ route('editNotes', ['id' => $note->id]) }}" method="GET" class="bg-gray-500 text-white px-2 py-1 md:px-4 md:py-2 rounded-md text-sm md:text-base">
            <button type="submit">EDIT</button>
        </form>

        <form action="{{ route('deleteNotes', ['id' => $note->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?')" class="bg-[#4A628A] text-white px-2 py-1 md:px-4 md:py-2 rounded-md text-sm md:text-base">
            @csrf
            @method('DELETE')
            <button type="submit">DELETE</button>
        </form>

        <form action="{{ route('index') }}" method="GET" class="bg-[#7AB2D3] text-white px-2 py-1 md:px-4 md:py-2 rounded-md text-sm md:text-base">
            <button type="submit">BACK</button>
        </form>
    </div>

    <script>
        const darkModeButton = document.getElementById("darkModeButton");
        document.addEventListener("DOMContentLoaded", () => {
            if (localStorage.getItem("theme") === "dark") {
                document.documentElement.classList.add("dark");
                darkModeButton.innerHTML = "☀️ Light Mode";
            }
        });

        function toggleDarkMode() {
            document.documentElement.classList.toggle("dark");
            const theme = document.documentElement.classList.contains("dark") ? "dark" : "light";
            localStorage.setItem("theme", theme);

            darkModeButton.innerHTML = theme === "dark" ? "☀️ Light Mode" : "🌙 Dark Mode";
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("visible");
            overlay.classList.toggle("visible");
        }

        function printPage() {
            window.print();
        }
    </script>
</body>

</html>
