<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - MyStore</title>
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
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            will-change: transform, opacity;
        }

        .delay-100 { animation-delay: 0.05s; }
        .delay-200 { animation-delay: 0.1s; }
        .delay-300 { animation-delay: 0.15s; }
        .delay-500 { animation-delay: 0.25s; }
    </style>
</head>
<body class="bg-[#050505] text-gray-200 antialiased selection:bg-white selection:text-black overflow-x-hidden">

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Sidebar Navigation (Static) -->
        

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-24 relative min-h-screen flex flex-col">
            
            <div class="flex-1 max-w-2xl mx-auto w-full px-6 py-12 md:py-24">
                
                <!-- Breadcrumb -->
                <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-white mb-8 transition group animate-entry delay-100">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Back to Product
                </a>

                <div class="mb-10 border-b border-white/10 pb-6 animate-entry delay-200">
                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-2">New Category</h1>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Organize your catalog structure</p>
                </div>

                <!-- Form Container -->
                <div class="bg-[#0a0a0a] border border-white/5 p-8 md:p-12 relative overflow-hidden animate-entry delay-300">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full blur-[80px] pointer-events-none"></div>

                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-8 relative z-10">
                        @csrf
                        
                        <!-- Name -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Category Name</label>
                            <div class="relative">
                                <input type="text" name="name" placeholder="E.G. ACCESSORIES" value="{{ old('name') }}"
                                       class="w-full bg-neutral-900 border border-white/10 px-6 py-4 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300 pl-12">
                                <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-white transition-colors"></i>
                            </div>
                            @error('name') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-white text-black font-black uppercase tracking-[0.2em] py-5 hover:bg-neutral-300 transition-all duration-300 flex items-center justify-center gap-3 group">
                            Create Category <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            
        </main>
    </div>

</body>
</html>