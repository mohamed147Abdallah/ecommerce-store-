<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - MyStore</title>
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
        .delay-700 { animation-delay: 0.35s; }
    </style>
</head>
<body class="bg-[#050505] text-gray-200 antialiased selection:bg-white selection:text-black overflow-x-hidden">

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Sidebar Navigation (Static - No Animation) -->
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
                        <a href="{{ route('products.create') }}" class="text-white hover:text-blue-400 transition-colors duration-300 flex flex-col items-center gap-1 group">
                            <i class="fas fa-plus-circle text-lg group-hover:-translate-y-1 transition-transform"></i>
                            <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6 whitespace-nowrap">Add</span>
                        </a>
                    @endif
                @endauth

                <!-- Profile Link (Added as requested) -->
                @auth
                <a href="{{ route('profile.index') }}" class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-user text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Profile</span>
                </a>
                @endauth

               

                <!-- Mobile Cart -->
                <a href="{{ route('cart.index') }}" class="relative group cursor-pointer md:hidden">
                    <span class="absolute -top-1 -right-1 bg-white text-black text-[9px] font-bold w-3 h-3 flex items-center justify-center rounded-sm">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                    <i class="fas fa-shopping-bag text-gray-500 group-hover:text-white transition-colors"></i>
                </a>
            </div>

            <!-- Bottom Actions -->
            <div class="hidden md:flex flex-col gap-6 items-center">
                <a href="{{ route('cart.index') }}" class="relative group cursor-pointer">
                    <span id="cart-badge" class="absolute -top-2 -right-2 bg-white text-black text-[9px] font-bold w-4 h-4 flex items-center justify-center">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                    <i class="fas fa-shopping-bag text-xl text-gray-400 group-hover:text-white transition"></i>
                </a>
                
                <!-- Auth / Profile Avatar -->
                @auth
                    <div class="relative group">
                        <a href="{{ route('profile.index') }}" class="block">
                            <div class="w-8 h-8 rounded-full bg-neutral-800 border border-white/20 flex items-center justify-center text-xs font-bold text-white uppercase hover:border-white transition cursor-pointer">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </a>
                        
                        <!-- Hover Menu -->
                        <div class="absolute left-full bottom-0 ml-4 mb-[-10px] w-48 bg-black border border-white/10 p-4 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50 glass">
                             <p class="text-sm text-white font-bold truncate">{{ Auth::user()->name }}</p>
                             <p class="text-[10px] text-gray-500 uppercase mb-3 truncate">{{ Auth::user()->email }}</p>
                             
                             @if(Auth::user()->is_admin)
                                <a href="{{ route('products.create') }}" class="block text-xs font-bold text-blue-400 hover:text-white mb-2 uppercase"><i class="fas fa-plus mr-1"></i> Add Product</a>
                             @endif
                             
                             <a href="{{ route('profile.index') }}" class="block text-xs font-bold text-gray-400 hover:text-white mb-2 uppercase">My Profile</a>

                             <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-white uppercase w-full text-left">Logout</button>
                             </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition"><i class="fas fa-user text-xs"></i></a>
                @endauth
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-24 relative min-h-screen flex flex-col">
            
            <div class="flex-1 max-w-4xl mx-auto w-full px-6 py-12 md:py-20">
                
                <!-- Breadcrumb -->
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-white mb-8 transition group animate-entry delay-100">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Back to Products
                </a>

                <div class="mb-10 border-b border-white/10 pb-6 animate-entry delay-200">
                    <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-2">New Product</h1>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Enter item details for the catalog</p>
                </div>

                <!-- Form Container -->
                <div class="bg-[#0a0a0a] border border-white/5 p-8 md:p-12 relative overflow-hidden animate-entry delay-300">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-[100px] pointer-events-none"></div>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10">
                        @csrf
                        
                        <!-- Name -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Product Name</label>
                            <input type="text" name="name" placeholder="E.G. NEON RUNNER V2" value="{{ old('name') }}"
                                   class="w-full bg-neutral-900 border border-white/10 px-6 py-4 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300">
                            @error('name') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category & Price Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <div class="flex justify-between items-center mb-3">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest group-focus-within:text-white transition">Category</label>
                                    <a href="{{ route('categories.create') }}" class="text-[10px] text-blue-500 hover:text-white font-bold uppercase tracking-wider transition flex items-center gap-1">
                                        <i class="fas fa-plus"></i> New
                                    </a>
                                </div>
                                
                                @if($categories->count() > 0)
                                    <div class="relative">
                                        <select name="category_id" class="w-full bg-neutral-900 border border-white/10 px-6 py-4 text-white text-sm font-bold appearance-none focus:outline-none focus:border-white focus:bg-black transition-all duration-300 cursor-pointer">
                                            <option value="" disabled selected>SELECT CATEGORY</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-red-900/10 border border-red-500/20 p-4 flex items-center justify-between">
                                        <span class="text-red-500 text-[10px] font-bold uppercase tracking-wide">No Categories Found</span>
                                        <a href="{{ route('categories.create') }}" class="text-[10px] font-bold bg-red-600 text-white px-3 py-1 hover:bg-red-500 transition uppercase">Create</a>
                                    </div>
                                @endif
                                @error('category_id') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                            </div>

                            <div class="group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Price ($)</label>
                                <input type="number" step="0.01" name="price" placeholder="0.00" value="{{ old('price') }}"
                                       class="w-full bg-neutral-900 border border-white/10 px-6 py-4 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300">
                                @error('price') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Stock & Image Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Stock Quantity</label>
                                <input type="number" name="stock" placeholder="UNITS" value="{{ old('stock') }}"
                                       class="w-full bg-neutral-900 border border-white/10 px-6 py-4 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300">
                                @error('stock') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                            </div>

                            <div class="group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Product Image</label>
                                <div class="relative">
                                    <input type="file" name="image" class="block w-full text-sm text-gray-400
                                        file:mr-4 file:py-4 file:px-6
                                        file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest
                                        file:bg-white file:text-black
                                        hover:file:bg-gray-200 file:cursor-pointer cursor-pointer
                                        bg-neutral-900 border border-white/10
                                    "/>
                                    
                                </div>
                                @error('image') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 group-focus-within:text-white transition">Description</label>
                            <textarea name="description" rows="5" placeholder="ENTER PRODUCT DETAILS..." 
                                      class="w-full bg-neutral-900 border border-white/10 px-6 py-4 text-white text-sm font-bold placeholder-gray-700 focus:outline-none focus:border-white focus:bg-black transition-all duration-300">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-[10px] uppercase font-bold mt-2 tracking-wide">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-white text-black font-black uppercase tracking-[0.2em] py-5 hover:bg-neutral-300 transition-all duration-300 flex items-center justify-center gap-3 group">
                            Save Product <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <footer class="border-t border-white/10 bg-black pt-16 pb-32 md:pb-16 px-6 md:px-16 mt-auto animate-entry delay-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                    <div class="max-w-xs">
                        <h4 class="text-2xl font-black text-white mb-6 tracking-tighter">MYSTORE.</h4>
                    </div>
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-widest">
                        Admin Dashboard Access
                    </div>
                </div>
            </footer>
        </main>
    </div>

</body>
</html>