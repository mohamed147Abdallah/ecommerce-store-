<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile & Dashboard - MyStore</title>
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

    <!-- Toast Notification -->
    @if(session('success'))
        <div id="toast" class="fixed top-5 right-5 z-[100] transform translate-x-0 transition-all duration-500">
            <div class="glass px-6 py-4 flex items-center gap-4 border-l-2 border-white">
                <div class="text-white animate-pulse">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-widest text-white">Success</h4>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('toast').remove(), 3000);</script>
    @endif

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Sidebar Navigation (Static) -->
        <nav class="fixed bottom-0 md:top-0 md:left-0 w-full md:w-24 md:h-screen h-16 glass-strong z-50 flex md:flex-col justify-between items-center py-0 md:py-8 px-6 md:px-0 md:border-r md:border-t-0 border-t border-white/5">
            
            <!-- Logo Icon -->
            <a href="{{ route('home') }}" class="hidden md:flex w-10 h-10 bg-white text-black items-center justify-center font-black text-xl hover:scale-110 transition-transform duration-300">
                M
            </a>

            <!-- Nav Links -->
            <div class="flex md:flex-col justify-around w-full md:w-auto md:gap-10 items-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-home text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Home</span>
                </a>
                
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-layer-group text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Shop</span>
                </a>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('products.create') }}" class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                            <i class="fas fa-plus-circle text-lg group-hover:-translate-y-1 transition-transform"></i>
                            <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6 whitespace-nowrap">Add</span>
                        </a>
                    @endif
                @endauth

                <!-- Profile Link (Active) -->
                <a href="{{ route('profile.index') }}" class="text-white hover:text-blue-400 transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-user text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Profile</span>
                </a>
            </div>

            <!-- Bottom Actions -->
            <div class="hidden md:flex flex-col gap-6 items-center">
                <a href="{{ route('cart.index') }}" class="relative group cursor-pointer text-gray-400 hover:text-white">
                    <span class="absolute -top-2 -right-2 bg-white text-black text-[9px] font-bold w-4 h-4 flex items-center justify-center">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                    <i class="fas fa-shopping-bag text-xl"></i>
                </a>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-red-500 hover:bg-red-600 hover:text-white hover:border-red-600 transition" title="Logout">
                        <i class="fas fa-sign-out-alt text-xs"></i>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-24 relative min-h-screen flex flex-col">
            
            <!-- Background Gradient -->
            <div class="fixed inset-0 z-[-1] pointer-events-none">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-900/5 rounded-full blur-[100px]"></div>
            </div>

            <div class="flex-1 max-w-[1400px] mx-auto w-full px-6 md:px-12 py-12 md:py-20">
                
                <!-- Header -->
                <div class="flex items-end gap-6 mb-12 border-b border-white/10 pb-6 animate-entry delay-100">
                    <div>
                        <h1 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter mb-2">
                            {{ $user->is_admin ? 'Dashboard' : 'My Account' }}
                        </h1>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">
                            {{ $user->is_admin ? 'Manage your profile & store' : 'Manage your personal details' }}
                        </p>
                    </div>
                </div>

                <!-- Layout Wrapper: Changes based on role -->
                <div class="{{ $user->is_admin ? 'grid grid-cols-1 lg:grid-cols-3 gap-12' : 'max-w-2xl mx-auto' }}">
                    
                    <!-- Left Column: User Profile Settings -->
                    <div class="{{ $user->is_admin ? 'lg:col-span-1' : 'w-full' }} animate-entry delay-200">
                        <div class="bg-[#0a0a0a] border border-white/10 rounded-3xl p-8 sticky top-12 shadow-2xl">
                            <h3 class="text-lg font-black text-white uppercase tracking-widest mb-8 border-b border-white/10 pb-4 flex items-center gap-3">
                                <i class="fas fa-user-cog text-gray-500"></i> Profile Settings
                            </h3>
                            
                            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')
                                
                                <div class="group">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 group-focus-within:text-white transition">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white text-sm focus:border-white focus:bg-black focus:outline-none transition-all duration-300">
                                </div>

                                <div class="group">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 group-focus-within:text-white transition">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white text-sm focus:border-white focus:bg-black focus:outline-none transition-all duration-300">
                                </div>

                                <div class="group">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 group-focus-within:text-white transition">New Password <span class="opacity-50 lowercase">(optional)</span></label>
                                    <input type="password" name="password" placeholder="••••••••"
                                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white text-sm focus:border-white focus:bg-black focus:outline-none transition-all duration-300">
                                </div>

                                <div class="group">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 group-focus-within:text-white transition">Confirm Password</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white text-sm focus:border-white focus:bg-black focus:outline-none transition-all duration-300">
                                </div>

                                <button type="submit" class="w-full bg-white text-black py-4 font-black uppercase tracking-[0.2em] hover:bg-gray-200 transition rounded-full text-xs mt-4 shadow-lg">
                                    Update Profile
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column: Stats & Categories (ONLY FOR ADMIN) -->
                    @if($user->is_admin)
                    <div class="lg:col-span-2 space-y-8 animate-entry delay-300">
                        
                        <!-- Stats Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 flex items-center justify-between group hover:border-white/20 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute inset-0 bg-blue-600/5 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1 group-hover:text-blue-400 transition">Total Products</p>
                                    <h2 class="text-5xl font-black text-white">{{ $totalProducts }}</h2>
                                </div>
                                <div class="w-14 h-14 bg-white/5 border border-white/10 text-white flex items-center justify-center rounded-2xl text-xl group-hover:scale-110 transition duration-300 relative z-10">
                                    <i class="fas fa-box-open"></i>
                                </div>
                            </div>
                            
                            <div class="bg-[#0a0a0a] border border-white/5 rounded-3xl p-6 flex items-center justify-between group hover:border-white/20 transition-all duration-300 relative overflow-hidden">
                                <div class="absolute inset-0 bg-purple-600/5 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                                <div class="relative z-10">
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1 group-hover:text-purple-400 transition">Total Categories</p>
                                    <h2 class="text-5xl font-black text-white">{{ $categories->count() }}</h2>
                                </div>
                                <div class="w-14 h-14 bg-white/5 border border-white/10 text-white flex items-center justify-center rounded-2xl text-xl group-hover:scale-110 transition duration-300 relative z-10">
                                    <i class="fas fa-tags"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Categories Manager -->
                        <div class="bg-[#0a0a0a] border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                            <div class="p-8 border-b border-white/10 flex justify-between items-center bg-white/5">
                                <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] flex items-center gap-2">
                                    <i class="fas fa-layer-group text-gray-500"></i> Category Manager
                                </h3>
                                <a href="{{ route('categories.create') }}" class="text-[10px] font-bold bg-white text-black px-4 py-2 rounded-full hover:bg-gray-200 transition uppercase tracking-wider shadow-lg">
                                    <i class="fas fa-plus mr-1"></i> New
                                </a>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-black/40 text-gray-500 text-[9px] uppercase tracking-widest font-bold">
                                        <tr>
                                            <th class="px-8 py-4">ID</th>
                                            <th class="px-8 py-4">Category Name</th>
                                            <th class="px-8 py-4 text-center">Items</th>
                                            <th class="px-8 py-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @foreach($categories as $category)
                                            <tr class="hover:bg-white/5 transition group">
                                                <td class="px-8 py-5 text-xs font-mono text-gray-600">#{{ $category->id }}</td>
                                                <td class="px-8 py-5">
                                                    <!-- Inline Edit Form -->
                                                    <form action="{{ route('profile.category.update', $category->id) }}" method="POST" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" name="name" value="{{ $category->name }}" 
                                                               class="bg-transparent border-b border-transparent hover:border-white/20 focus:border-white focus:outline-none text-white text-sm font-bold w-full transition px-1 py-1 uppercase tracking-wide">
                                                        <button title="Save Name" class="text-gray-600 hover:text-green-500 transition text-sm opacity-0 group-hover:opacity-100"><i class="fas fa-check"></i></button>
                                                    </form>
                                                </td>
                                                <td class="px-8 py-5 text-center">
                                                    <span class="bg-white/10 text-white text-[10px] font-bold px-3 py-1 rounded-full border border-white/10">
                                                        {{ $category->products_count }}
                                                    </span>
                                                </td>
                                                <td class="px-8 py-5 text-right">
                                                    <form action="{{ route('profile.category.delete', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category? Products might be detached.')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-gray-500 hover:bg-red-500 hover:text-white hover:border-red-500 transition text-xs">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <footer class="border-t border-white/10 bg-black pt-16 pb-32 md:pb-16 px-6 md:px-16 mt-auto animate-entry delay-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                    <div class="max-w-xs">
                        <h4 class="text-2xl font-black text-white mb-6 tracking-tighter">MYSTORE.</h4>
                    </div>
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-widest">
                        Future Vision Dashboard
                    </div>
                </div>
            </footer>
        </main>
    </div>

</body>
</html>