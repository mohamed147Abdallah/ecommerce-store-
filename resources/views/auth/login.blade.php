<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;700;900&display=swap');
        
        body { font-family: 'Outfit', sans-serif; }
        
        .glass { 
            background: rgba(15, 15, 15, 0.7); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08); 
        }

        .glass-strong {
            background: rgba(5, 5, 5, 0.9);
            backdrop-filter: blur(30px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #050505; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        /* --- Optimized Entrance Animations --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-entry {
            opacity: 0; /* Start hidden */
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: transform, opacity;
        }

        /* Adjusted Stagger Delays */
        .delay-100 { animation-delay: 0.05s; }
        .delay-200 { animation-delay: 0.1s; }
        .delay-300 { animation-delay: 0.15s; }
        .delay-500 { animation-delay: 0.25s; }
    </style>
</head>
<body class="bg-[#050505] text-gray-200 antialiased selection:bg-white selection:text-black overflow-x-hidden">

    <div class="min-h-screen w-full relative">

        <!-- Main Content Area -->
        <main class="w-full h-full min-h-screen flex flex-col justify-center items-center p-6 relative">
            
            <!-- Decorative Background Blobs -->
            <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="fixed bottom-0 left-24 w-[400px] h-[400px] bg-purple-900/5 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="w-full max-w-md relative z-10">
                
                <!-- Header -->
                <div class="text-center mb-10 animate-entry delay-100">
                    <div class="flex justify-center mb-4">
                         <a href="{{ route('home') }}" class="w-12 h-12 bg-white text-black flex items-center justify-center font-black text-2xl hover:scale-110 transition-transform duration-300 rounded-full">
                            M
                        </a>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-2">Welcome Back</h1>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Sign in to manage your account</p>
                </div>

                <!-- Form Container -->
                <div class="bg-[#0a0a0a] border border-white/5 p-8 md:p-10 relative overflow-hidden animate-entry delay-200 shadow-2xl">
                    
                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        
                        <!-- Email -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Email Address</label>
                            <div class="relative">
                                <input type="email" name="email" placeholder="YOU@EXAMPLE.COM" 
                                       class="w-full bg-neutral-900 border border-white/10 px-6 py-4 pl-12 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300" required>
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-white transition-colors"></i>
                            </div>
                            @error('email') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest group-focus-within:text-white transition">Password</label>
                                <a href="#" class="text-[10px] text-gray-500 hover:text-white font-bold uppercase tracking-wider transition">Forgot?</a>
                            </div>
                            <div class="relative">
                                <input type="password" name="password" placeholder="••••••••" 
                                       class="w-full bg-neutral-900 border border-white/10 px-6 py-4 pl-12 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300" required>
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-white transition-colors"></i>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" class="peer h-4 w-4 cursor-pointer appearance-none border border-white/20 bg-neutral-900 checked:bg-white checked:border-white transition-all rounded-sm">
                                    <i class="fas fa-check absolute left-0.5 top-0.5 text-[10px] text-black opacity-0 peer-checked:opacity-100"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-500 group-hover:text-white uppercase tracking-wider transition">Remember me</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-white text-black font-black uppercase tracking-[0.2em] py-5 hover:bg-neutral-300 transition-all duration-300 flex items-center justify-center gap-3 group shadow-lg shadow-white/5">
                            Sign In <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>

                <!-- Footer Link -->
                <div class="mt-8 text-center animate-entry delay-300">
                    <p class="text-gray-500 text-xs uppercase tracking-wide">
                        New here? 
                        <a href="{{ route('register') }}" class="text-white font-bold hover:text-blue-400 border-b border-white/20 hover:border-blue-400 transition ml-1 pb-0.5">Create Account</a>
                    </p>
                </div>
            </div>

            <!-- Footer (Optional, simplified for login page) -->
            <footer class="absolute bottom-6 w-full text-center pointer-events-none animate-entry delay-500">
                <p class="text-gray-700 text-[10px] uppercase tracking-widest">&copy; 2025 Future Vision.</p>
            </footer>
        </main>
    </div>

</body>
</html>