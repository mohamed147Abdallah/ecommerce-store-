<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyStore - Future Vision</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lenis@1.1.2/dist/lenis.min.js"></script>
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

        body {
            font-family: 'Outfit', sans-serif;
        }

        html.lenis,
        html.lenis body {
            height: auto;
        }

        .lenis.lenis-smooth {
            scroll-behavior: auto !important;
           
        }

        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }

        .lenis.lenis-stopped {
            overflow: hidden;
        }

        .lenis.lenis-scrolling iframe {
            pointer-events: none;
        }

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

        .text-stroke {
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.3);
            color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #050505;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .hide-scroll::-webkit-scrollbar {
            display: none;
        }

        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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

        .delay-100 {
            animation-delay: 0.05s;
        }

        .delay-200 {
            animation-delay: 0.1s;
        }

        .delay-300 {
            animation-delay: 0.15s;
        }

        .delay-500 {
            animation-delay: 0.25s;
        }

        .delay-700 {
            animation-delay: 0.35s;
        }
    </style>
</head>

<body class="bg-[#050505] text-gray-200 antialiased selection:bg-white selection:text-black overflow-x-hidden">

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed top-5 right-5 z-[100] transform translate-x-full opacity-0 transition-all duration-500 cubic-bezier(0.175, 0.885, 0.32, 1.275)">
        <div class="glass px-6 py-4 flex items-center gap-4 border-l-2 border-white">
            <div class="text-white animate-pulse">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-widest text-white">Success</h4>
                <p class="text-[10px] text-gray-400 uppercase tracking-wide" id="toast-message">Item added to cart!</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- Sidebar Navigation (Static) -->
        <nav
            class="fixed bottom-0 md:top-0 md:left-0 w-full md:w-24 md:h-screen h-16 glass-strong z-50 flex md:flex-col justify-between items-center py-0 md:py-8 px-6 md:px-0 md:border-r md:border-t-0 border-t border-white/5">

            <!-- Logo Icon -->
            <a href="{{ route('home') }}"
                class="hidden md:flex w-10 h-10 bg-white text-black items-center justify-center font-black text-xl hover:scale-110 transition-transform duration-300">
                M
            </a>

            <!-- Nav Links -->
            <div class="flex md:flex-col justify-around w-full md:w-auto md:gap-10 items-center">
                <a href="{{ route('home') }}"
                    class="text-white hover:text-blue-400 transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-home text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span
                        class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Home</span>
                </a>

                <a href="{{ route('products.index') }}"
                    class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                    <i class="fas fa-layer-group text-lg group-hover:-translate-y-1 transition-transform"></i>
                    <span
                        class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Shop</span>
                </a>
                @auth
                    @if (Auth::user()->is_admin)
                        <a href="{{ route('products.create') }}"
                            class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                            <i class="fas fa-plus-circle text-lg group-hover:-translate-y-1 transition-transform"></i>
                            <span
                                class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6 whitespace-nowrap">Add</span>
                        </a>
                    @endif
                @endauth

                <!-- Profile Link -->
                @auth
                    <a href="{{ route('profile.index') }}"
                        class="text-gray-500 hover:text-white transition-colors duration-300 flex flex-col items-center gap-1 group">
                        <i class="fas fa-user text-lg group-hover:-translate-y-1 transition-transform"></i>
                        <span
                            class="text-[8px] uppercase font-bold tracking-widest opacity-0 md:group-hover:opacity-100 transition-opacity absolute mt-6">Profile</span>
                    </a>
                @endauth

                <!-- Mobile Cart -->
                <a href="{{ route('cart.index') }}" class="relative group cursor-pointer md:hidden">
                    <span
                        class="absolute -top-1 -right-1 bg-white text-black text-[9px] font-bold w-3 h-3 flex items-center justify-center rounded-sm">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                    <i class="fas fa-shopping-bag text-gray-500 group-hover:text-white transition-colors"></i>
                </a>
            </div>

            <!-- Bottom Actions -->
            <div class="hidden md:flex flex-col gap-6 items-center">
                <a href="{{ route('cart.index') }}" class="relative group cursor-pointer">
                    <span id="cart-badge"
                        class="absolute -top-2 -right-2 bg-white text-black text-[9px] font-bold w-4 h-4 flex items-center justify-center">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                    <i class="fas fa-shopping-bag text-xl text-gray-400 group-hover:text-white transition"></i>
                </a>

                <!-- Auth / Profile Avatar -->
                @auth
                    <div class="relative group">
                        <a href="{{ route('profile.index') }}" class="block">
                            <div
                                class="w-8 h-8 rounded-full bg-neutral-800 border border-white/20 flex items-center justify-center text-xs font-bold text-white uppercase hover:border-white transition cursor-pointer">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </a>

                        <!-- Hover Menu -->
                        <div
                            class="absolute left-full bottom-0 ml-4 mb-[-10px] w-48 bg-black border border-white/10 p-4 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 z-50 glass">
                            <p class="text-sm text-white font-bold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 uppercase mb-3 truncate">{{ Auth::user()->email }}</p>

                            @if (Auth::user()->is_admin)
                                <a href="{{ route('products.create') }}"
                                    class="block text-xs font-bold text-blue-400 hover:text-white mb-2 uppercase"><i
                                        class="fas fa-plus mr-1"></i> Add Product</a>
                            @endif

                            <a href="{{ route('profile.index') }}"
                                class="block text-xs font-bold text-gray-400 hover:text-white mb-2 uppercase">My Profile</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-xs font-bold text-red-500 hover:text-white uppercase w-full text-left">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="w-8 h-8 rounded-full border border-white/20 flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition"><i
                            class="fas fa-user text-xs"></i></a>
                @endauth
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-24 relative min-h-screen flex flex-col">

            <!-- Search Overlay -->
            <div id="search-overlay"
                class="fixed inset-0 bg-black/95 z-[60] hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
                <button onclick="toggleSearch()"
                    class="absolute top-10 right-10 text-white text-2xl hover:rotate-90 transition-transform"><i
                        class="fas fa-times"></i></button>
                <h2 class="text-white/50 font-bold uppercase tracking-[0.3em] text-sm mb-4">Type to search</h2>
                <form action="{{ route('search') }}" method="GET" class="w-full flex justify-center">
                    <input type="text" name="query" value="{{ request('query') }}"
                        placeholder="WHAT ARE YOU LOOKING FOR?"
                        class="bg-transparent border-b-2 border-white/20 text-white text-2xl md:text-5xl font-black uppercase placeholder-white/10 focus:outline-none focus:border-white w-3/4 text-center py-4">
                </form>
            </div>

            <!-- Admin Product Selector Modal (Updated) -->
            @auth
                @if (Auth::user()->is_admin)
                    <div id="admin-product-selector"
                        class="fixed inset-0 bg-black/90 z-[70] hidden flex-col items-center justify-center p-6">
                        <div
                            class="bg-[#0a0a0a] border border-white/10 w-full max-w-4xl h-[80vh] flex flex-col rounded-xl overflow-hidden shadow-2xl animate-entry">

                            <!-- Header -->
                            <div class="flex justify-between items-center p-6 border-b border-white/10">
                                <h3 class="text-white font-bold uppercase tracking-widest">Select Featured Product</h3>
                                <button onclick="toggleProductModal()" class="text-gray-500 hover:text-white transition"><i
                                        class="fas fa-times text-xl"></i></button>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 overflow-y-auto p-6">
                                @php
                                    // Fallback to latestProducts if products isn't passed from controller
                                    $adminProducts = isset($products) ? $products : $latestProducts;
                                @endphp

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($adminProducts as $p)
                                        <div onclick="selectHeroProduct({{ json_encode($p) }})"
                                            class="cursor-pointer group relative border border-white/5 hover:border-blue-500 transition-all duration-300 rounded-lg overflow-hidden bg-neutral-900">
                                            <!-- Image Container (Uncropped) -->
                                            <div class="w-full h-40 bg-white/5 flex items-center justify-center p-2">
                                                <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://via.placeholder.com/400x400' }}"
                                                    class="max-w-full max-h-full object-contain opacity-80 group-hover:opacity-100 transition">
                                            </div>
                                            <div class="p-3">
                                                <h5 class="text-white text-xs font-bold truncate">{{ $p->name }}</h5>
                                                <p class="text-gray-500 text-[10px]">${{ $p->price }}</p>
                                            </div>
                                            <div
                                                class="absolute inset-0 bg-blue-600/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                <span
                                                    class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase">Select</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination (Inside Modal) -->
                                <div class="mt-8 border-t border-white/10 pt-4 flex justify-center">
                                    <!-- Use appends('modal', 1) to keep modal open on page reload -->
                                    @if (method_exists($adminProducts, 'links'))
                                        {{ $adminProducts->appends(['modal' => '1'])->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Hero Section: Dynamic Product Display (Resized) -->
            <header id="hero-section"
                class="relative w-full py-20 lg:py-32 flex items-center bg-[#050505] overflow-hidden px-6 md:px-16">
                <!-- Subtle Background Image -->
                <div class="absolute inset-0 z-0 opacity-20 pointer-events-none">
                    <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop"
                        class="w-full h-full object-cover filter grayscale contrast-125">
                </div>
                <div
                    class="absolute inset-0 bg-gradient-to-b from-[#050505] via-[#050505]/90 to-[#050505] z-0 pointer-events-none">
                </div>

                <div
                    class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px] pointer-events-none z-0">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-900/5 rounded-full blur-[100px] pointer-events-none z-0">
                </div>

                <div
                    class="grid grid-cols-1 lg:grid-cols-2 w-full gap-12 items-center relative z-10 max-w-6xl mx-auto">

                    @php
                        // In a real app, this might come from a DB setting. Default to first.
                        $heroProduct = $latestProducts->first();
                    @endphp

                    @if ($heroProduct)
                        <!-- Left Content: Store Branding (Static) -->
                        <div class="order-2 lg:order-1 animate-entry delay-100">

                            <!-- Admin Edit Button Trigger -->
                            @auth
                                @if (Auth::user()->is_admin)
                                    <button onclick="toggleProductModal()"
                                        class="mb-6 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-2 transition">
                                        <i class="fas fa-edit"></i> Change Featured
                                    </button>
                                @endif
                            @endauth

                            <span
                                class="inline-block py-1 px-3 border border-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-6">
                                Est. 2025
                            </span>
                            <h1
                                class="text-4xl md:text-6xl font-black text-white leading-[0.9] tracking-tighter mb-6 uppercase">
                                FUTURE <br> <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-600">VISION</span>
                            </h1>
                            <p
                                class="text-gray-400 text-sm leading-relaxed mb-8 border-l-2 border-white/20 pl-6 max-w-md">
                                Experience the pinnacle of modern design. Our latest collection brings together style,
                                comfort, and innovation for the bold.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <a href="#shop"
                                    class="bg-white text-black px-8 py-3 text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition shadow-lg shadow-white/5 flex items-center gap-2 rounded-full">
                                    Explore Shop
                                </a>
                                <a id="hero-link" href="{{ route('products.show', $heroProduct->id) }}"
                                    class="px-8 py-3 text-xs font-black uppercase tracking-widest text-white border border-white/20 hover:border-white transition flex items-center gap-2 rounded-full">
                                    View Featured <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Right Image: Best Seller Frame Style -->
                        <div class="order-1 lg:order-2 relative animate-entry delay-200 flex justify-center py-10">

                            <!-- The Main Image Container (The Frame) -->
                            <div
                                class="relative z-10 w-full max-w-sm border border-white/20 bg-[#0a0a0a] rounded-3xl overflow-visible shadow-2xl">

                                <!-- Best Seller Badge (Straddling Top) -->
                                <div class="absolute top-4 left-4 z-20">
                                    <span
                                        class="bg-yellow-500 text-black text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                                        <i class="fas fa-fire"></i> Best Seller
                                    </span>
                                </div>

                                <!-- The Image -->
                                <a id="hero-image-link" href="{{ route('products.show', $heroProduct->id) }}"
                                    class="block w-full h-auto relative overflow-hidden rounded-3xl group">
                                    <img id="hero-image"
                                        src="{{ $heroProduct->image ? asset('storage/' . $heroProduct->image) : 'https://via.placeholder.com/800x1000/1a1a1a/333333?text=Product' }}"
                                        class="w-full h-auto transition duration-700 group-hover:scale-105 filter contrast-110 brightness-90"
                                        alt="{{ $heroProduct->name }}">
                                    <!-- Overlay for hover -->
                                    <div
                                        class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>
                                </a>

                                <!-- Product Info (Floating Capsule - Straddling Bottom) -->
                                <div
                                    class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-[90%] bg-[#0a0a0a]/90 backdrop-blur-xl border border-white/10 rounded-full p-2 pl-5 pr-2 z-30 shadow-2xl flex justify-between items-center">
                                    <div class="flex flex-col justify-center overflow-hidden">
                                        <p id="bs-card-desc"
                                            class="text-[9px] text-blue-400 uppercase tracking-widest leading-tight truncate">
                                            {{ $heroProduct->category->name ?? 'Premium' }}
                                        </p>
                                        <div class="flex items-baseline gap-2">
                                            <h4 id="bs-card-name"
                                                class="text-white font-bold text-sm tracking-wide truncate max-w-[120px]">
                                                {{ $heroProduct->name }}
                                            </h4>
                                            <span id="bs-card-price" class="text-white/60 text-xs font-medium">
                                                ${{ $heroProduct->price }}
                                            </span>
                                        </div>
                                    </div>

                                    <form id="bs-card-add-form" action="{{ route('cart.add', $heroProduct->id) }}"
                                        method="POST" class="add-to-cart-form shrink-0">
                                        @csrf
                                        <!-- Small Circular Cart Button -->
                                        <button type="submit"
                                            class="w-10 h-10 bg-white text-black rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-lg group-hover:scale-110">
                                            <i class="fas fa-shopping-bag text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Decorative Elements (Behind) -->
                            <div
                                class="absolute -top-6 -right-6 w-32 h-32 border-t border-r border-white/10 rounded-tr-[50px] -z-10 opacity-60">
                            </div>
                            <div
                                class="absolute -bottom-6 -left-6 w-32 h-32 border-b border-l border-white/10 rounded-bl-[50px] -z-10 opacity-60">
                            </div>
                        </div>
                    @else
                        <!-- Fallback Static Content -->
                        <div class="order-2 lg:order-1 animate-entry delay-100">
                            <span
                                class="inline-block py-1 px-3 border border-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-6">New
                                Season</span>
                            <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter mb-4">
                                FUTURE</h1>
                            <p class="text-gray-300 mb-8 max-w-md">No products available yet. Sign in to add items.</p>
                        </div>
                        <div class="order-1 lg:order-2 relative animate-entry delay-200 flex justify-center">
                            <div
                                class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border border-white/10 group max-w-sm w-full">
                                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000&auto=format&fit=crop"
                                    class="w-full h-[450px] object-cover transition duration-700 group-hover:scale-105 filter contrast-110 brightness-90"
                                    alt="Hero Image">
                            </div>
                        </div>
                    @endif
                </div>
            </header>

            <!-- Category Filter Strip -->
            <section
                class="sticky top-0 z-40 bg-[#050505]/90 backdrop-blur-md border-y border-white/5 py-4 animate-entry delay-300">
                <div class="max-w-[1600px] mx-auto px-6 overflow-x-auto no-scrollbar flex gap-4 md:justify-center">
                    <a href="{{ route('home') }}#shop"
                        class="whitespace-nowrap px-6 py-2 text-xs font-black uppercase tracking-widest border transition rounded-full {{ !request('category') ? 'bg-white text-black border-white' : 'border-white/20 text-gray-500 hover:text-white hover:border-white' }}">
                        All Items
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ route('home', ['category' => $category->id]) }}#shop"
                            class="whitespace-nowrap px-6 py-2 text-xs font-black uppercase tracking-widest border transition rounded-full {{ request('category') == $category->id ? 'bg-white text-black border-white' : 'border-white/20 text-gray-500 hover:text-white hover:border-white' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- Product Grid Section -->
            <section id="shop" class="max-w-[1600px] mx-auto px-6 py-20 animate-entry delay-500">

                @if (request('category'))
                    <!-- Filtered View (Single Grid) -->
                    @php
                        $selectedCategory = $categories->firstWhere('id', request('category'));
                        $filteredProducts = $selectedCategory ? $selectedCategory->products : collect([]);
                    @endphp

                    <div class="mb-12 flex items-end justify-between">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter mb-2">
                                {{ $selectedCategory->name ?? 'Category' }}
                            </h2>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Filtered Selection</p>
                        </div>
                        <div class="hidden md:block h-px flex-1 bg-white/10 mx-8 mb-2"></div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">
                            {{ $filteredProducts->count() }} Products
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12">
                        @forelse($filteredProducts as $product)
                            <div class="group">
                                <div
                                    class="relative aspect-[3/4] bg-[#0a0a0a] border border-white/5 overflow-hidden mb-4 rounded-3xl">
                                    <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x600/1a1a1a/333333?text=Product' }}"
                                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                                    </a>

                                    <div
                                        class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-black/60 backdrop-blur-md border-t border-white/10">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                            class="add-to-cart-form">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-white text-xs font-bold uppercase flex justify-between items-center hover:text-blue-400 transition">
                                                Add to Cart <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                        @if ($product->category)
                                            <a href="{{ route('home', ['category' => $product->category->id]) }}#shop"
                                                class="hover:text-white transition-colors">
                                                {{ $product->category->name }}
                                            </a>
                                        @else
                                            Collection
                                        @endif
                                    </p>
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-sm font-bold text-white uppercase tracking-wide truncate w-32">
                                            <a
                                                href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                        </h3>
                                        <span class="text-sm font-bold text-white">${{ $product->price }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full py-20 text-center border border-dashed border-white/10 rounded-lg">
                                <h3 class="text-xl font-bold text-white mb-2">No Products Found in
                                    {{ $selectedCategory->name ?? 'this category' }}</h3>
                                <p class="text-gray-500 text-sm">Check back later for new arrivals.</p>
                                <a href="{{ route('home') }}#shop"
                                    class="inline-block mt-4 text-xs font-bold text-white border-b border-white hover:text-gray-300 transition">View
                                    All Products</a>
                            </div>
                        @endforelse
                    </div>
                @else
                    <!-- Default View: Categories in Rows -->
                    <div class="mb-16 text-center">
                        <h2 class="text-3xl md:text-4xl font-black text-white uppercase tracking-tighter mb-2">Curated
                            Collections</h2>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-widest">Explore our latest
                            arrivals by category</p>
                    </div>

                    @foreach ($categories as $category)
                        @if ($category->products->count() > 0)
                            @php
                                $pCount = $category->products->count();
                                $isScrollable = $pCount > 4;
                            @endphp
                            <div class="mb-20 border-b border-white/5 pb-12 last:border-0 relative group/slider">
                                <!-- Category Header -->
                                <div class="flex items-end justify-between mb-8 px-2">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-2xl font-black text-white uppercase tracking-tighter">
                                            {{ $category->name }}</h3>
                                        <span
                                            class="px-2 py-1 bg-white/10 text-[10px] font-bold text-white rounded">{{ $pCount }}</span>
                                    </div>
                                    <a href="{{ route('home', ['category' => $category->id]) }}#shop"
                                        class="text-xs font-bold uppercase text-gray-500 hover:text-white transition flex items-center gap-2">
                                        View All <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>

                                <!-- Scroll Buttons (Only visible if > 4 items) -->
                                <div class="relative">
                                    @if ($isScrollable)
                                        <button onclick="scrollContainer(this, -1)"
                                            class="absolute left-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/80 border border-white/10 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-black transition-all duration-300 opacity-0 group-hover/slider:opacity-100 -ml-6 shadow-xl">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button onclick="scrollContainer(this, 1)"
                                            class="absolute right-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/80 border border-white/10 rounded-full flex items-center justify-center text-white hover:bg-white hover:text-black transition-all duration-300 opacity-0 group-hover/slider:opacity-100 -mr-6 shadow-xl">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    @endif

                                    <!-- Products Row -->
                                    <div
                                        class="{{ $isScrollable ? 'product-scroll-container flex overflow-x-auto gap-6 pb-8 hide-scroll -mx-6 px-6 md:mx-0 md:px-0 scroll-smooth' : 'flex flex-wrap justify-center gap-6 pb-8' }}">
                                        @foreach ($category->products as $product)
                                            <div
                                                class="group flex-none {{ $isScrollable ? 'w-[85vw] sm:w-[300px] md:w-[350px]' : 'w-full sm:w-[48%] lg:w-[23%]' }}">
                                                <div
                                                    class="relative aspect-[3/4] bg-[#0a0a0a] border border-white/5 overflow-hidden mb-4 rounded-3xl">
                                                    <a href="{{ route('products.show', $product->id) }}"
                                                        class="block w-full h-full">
                                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x600/1a1a1a/333333?text=Product' }}"
                                                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                                                    </a>

                                                    <div
                                                        class="absolute bottom-0 left-0 w-full p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 bg-black/60 backdrop-blur-md border-t border-white/10">
                                                        <form action="{{ route('cart.add', $product->id) }}"
                                                            method="POST" class="add-to-cart-form">
                                                            @csrf
                                                            <button type="submit"
                                                                class="w-full text-white text-xs font-bold uppercase flex justify-between items-center hover:text-blue-400 transition">
                                                                Add to Cart <i class="fas fa-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p
                                                        class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">
                                                        <a href="{{ route('home', ['category' => $category->id]) }}#shop"
                                                            class="hover:text-white transition-colors">
                                                            {{ $category->name }}
                                                        </a>
                                                    </p>
                                                    <div class="flex justify-between items-start">
                                                        <h3
                                                            class="text-sm font-bold text-white uppercase tracking-wide truncate w-full">
                                                            <a
                                                                href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                                        </h3>
                                                        <span
                                                            class="text-sm font-bold text-white pl-2">${{ $product->price }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </section>

            <!-- Minimal Footer -->
            <footer class="border-t border-white/10 bg-black py-16 animate-entry delay-500">
                <div class="max-w-[1600px] mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="col-span-1 md:col-span-2">
                        <h4 class="text-2xl font-black text-white tracking-tighter mb-6">MYSTORE.</h4>
                        <p class="text-gray-500 text-sm max-w-sm leading-relaxed">
                            Redefining the digital shopping experience with cutting-edge design and premium quality
                            products.
                        </p>
                    </div>
                    <div>
                        <h5 class="text-white text-xs font-bold uppercase tracking-widest mb-6">Explore</h5>
                        <ul class="space-y-4 text-xs text-gray-500">
                            <li><a href="#" class="hover:text-white transition">New Arrivals</a></li>
                            <li><a href="#" class="hover:text-white transition">Best Sellers</a></li>
                            <li><a href="#" class="hover:text-white transition">Collections</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="text-white text-xs font-bold uppercase tracking-widest mb-6">Connect</h5>
                        <div class="flex gap-4">
                            <a href="#"
                                class="w-10 h-10 border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-black transition rounded-full"><i
                                    class="fab fa-twitter"></i></a>
                            <a href="#"
                                class="w-10 h-10 border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-black transition rounded-full"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="#"
                                class="w-10 h-10 border border-white/20 flex items-center justify-center text-white hover:bg-white hover:text-black transition rounded-full"><i
                                    class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
                <div
                    class="text-center mt-16 pt-8 border-t border-white/10 text-gray-600 text-[10px] uppercase tracking-widest">
                    &copy; 2025 Future Vision. All Rights Reserved.
                </div>
            </footer>

        </main>
    </div>

    <!-- Scripts -->
    <script>
         const lenis = new Lenis({
            duration: 2.0, // Increased duration for heavier feel
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }

        requestAnimationFrame(raf);
        // Scroll Preservation Script
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = sessionStorage.getItem('homeScrollPos');
            if (scrollpos) {
                document.documentElement.style.scrollBehavior = 'auto';
                window.scrollTo(0, scrollpos);
                sessionStorage.removeItem('homeScrollPos');
                setTimeout(function() {
                    document.documentElement.style.scrollBehavior = '';
                }, 50);
            }

            const savedHero = localStorage.getItem('admin_selected_hero');
            if (savedHero) {
                try {
                    const product = JSON.parse(savedHero);
                    updateHeroUI(product);
                } catch (e) {
                    console.error('Error loading saved hero product', e);
                }
            }

            // Check for modal param on load to re-open if needed (after pagination reload)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('modal') === '1') {
                const modal = document.getElementById('admin-product-selector');
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.style.display = 'flex';
                }
            }

            @if (session('success'))
                showToast("{{ session('success') }}");
            @endif
        });

        window.addEventListener('beforeunload', function(e) {
            sessionStorage.setItem('homeScrollPos', window.scrollY);
        });

        function toggleSearch() {
            const overlay = document.getElementById('search-overlay');
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                overlay.style.display = 'flex';
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10);
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    overlay.style.display = 'none';
                }, 300);
            }
        }

        function toggleProductModal() {
            const modal = document.getElementById('admin-product-selector');
            if (modal) {
                if (modal.classList.contains('hidden')) {
                    // Open
                    modal.classList.remove('hidden');
                    modal.style.display = 'flex';
                    // Add param without reload
                    const url = new URL(window.location);
                    url.searchParams.set('modal', '1');
                    window.history.pushState({}, '', url);
                } else {
                    // Close
                    modal.classList.add('hidden');
                    modal.style.display = 'none';
                    // Remove param without reload
                    const url = new URL(window.location);
                    url.searchParams.delete('modal');
                    window.history.pushState({}, '', url);
                }
            }
        }

        function updateHeroUI(product) {
            const imgPath = product.image ? '/storage/' + product.image :
                'https://via.placeholder.com/800x1000/1a1a1a/333333?text=Product';
            document.getElementById('hero-image').src = imgPath;
            document.getElementById('hero-image-link').href = '/products/' + product.id;
            document.getElementById('hero-link').href = '/products/' + product.id;
            document.getElementById('bs-card-name').innerText = product.name;
            document.getElementById('bs-card-desc').innerText = product.category ? product.category.name : (product
                .category_name || 'Featured');
            document.getElementById('bs-card-price').innerText = '$' + product.price;
            document.getElementById('bs-card-add-form').action = '/cart/add/' + product.id;
        }

        function selectHeroProduct(product) {
            updateHeroUI(product);
            localStorage.setItem('admin_selected_hero', JSON.stringify(product));
            toggleProductModal();
            showToast('Hero product updated & saved locally!');
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = message;
            toast.classList.remove('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
            }, 3000);
        }

        // --- Event Delegation for Add to Cart Forms ---
        document.body.addEventListener('submit', function(e) {
            if (e.target.closest('.add-to-cart-form')) {
                e.preventDefault();
                const form = e.target.closest('.add-to-cart-form');
                const btn = form.querySelector('button');
                const originalContent = btn.innerHTML;

                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (response.ok) return response.text();
                        throw new Error('Err');
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newCount = doc.querySelector('#cart-badge') ? doc.querySelector('#cart-badge')
                            .innerText.trim() : null;
                        if (newCount) {
                            document.querySelectorAll('#cart-badge, .md\\:hidden span').forEach(el => el
                                .innerText = newCount);
                        }
                        showToast('Item added successfully!');
                    })
                    .catch(error => {
                        showToast('Something went wrong!');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalContent;
                    });
            }
        });

        // --- New Button Scroll Logic ---
        function scrollContainer(btn, direction) {
            const container = btn.parentElement.querySelector('.product-scroll-container');
            const cardWidth = container.querySelector('.group').offsetWidth + 24; // Card width + gap
            const scrollAmount = cardWidth * direction; // + for right, - for left

            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>
