<?php
require_once '../config/database.php';
require_once '../config/functions.php';

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])) {
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Unilink Global Solution</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f8fafc', // Light shade
                        secondary: '#f97316', // Orange
                        accent: '#ea580c' // Darker orange
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-50 relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute top-[20%] right-[-10%] w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-[-20%] left-[20%] w-80 h-80 bg-orange-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

    <div class="max-w-md w-full glassmorphism rounded-2xl shadow-2xl p-8 relative z-10 mx-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Unilink Panel</h1>
            <p class="text-slate-500 mt-2 text-sm">Sign in to manage your site</p>
        </div>

        <?php display_flash_msg(); ?>

        <form action="login_action.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email, Username or Phone</label>
                <input type="text" name="login_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition duration-200 bg-white shadow-sm" placeholder="e.g. admin">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition duration-200 bg-white shadow-sm" placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 rounded text-secondary focus:ring-secondary"> Remember me
                </label>
                <a href="#" class="text-secondary hover:text-accent font-medium hover:underline transition">Forgot Password?</a>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-secondary hover:bg-accent text-white font-semibold rounded-xl shadow-lg shadow-orange-500/30 transform transition duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                Sign In
            </button>
        </form>
    </div>

</body>
</html>
