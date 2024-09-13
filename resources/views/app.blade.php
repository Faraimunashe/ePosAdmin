<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        @vite('resources/js/app.js')
        @vite('resources/css/app.css')
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
        @inertiaHead
        <style>
            /* Custom scrollbar for a more polished look */
            ::-webkit-scrollbar {
              width: 8px;
            }
            ::-webkit-scrollbar-track {
              background: #f1f1f1;
            }
            ::-webkit-scrollbar-thumb {
              background-color: #888;
              border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
              background-color: #555;
            }
        </style>
    </head>
    <body class="bg-gray-100 flex flex-col min-h-screen">
        @inertia
    </body>
</html>
