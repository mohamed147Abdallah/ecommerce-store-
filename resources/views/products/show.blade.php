<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - MyStore</title>
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

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-5 right-5 z-[100] transform translate-x-full opacity-0 transition-all duration-500 cubic-bezier(0.175, 0.885, 0.32, 1.275)">
        <div class="glass px-6 py-4 flex items-center gap-4 border-l-2 border-white">
            <div class="text-white animate-pulse">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-widest text-white">Success</h4>
                <p class="text-[10px] text-gray-400 uppercase tracking-wide" id="toast-message">Item added to cart</p>
            </div>
        </div>
    </div>

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
                
                <a href="{{ route('products.index') }}" class="text-white hover:text-blue-400 transition-colors duration-300 flex flex-col items-center gap-1 group">
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

                <!-- Profile Link -->
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
            
            <!-- Search Overlay -->
            <div id="search-overlay" class="fixed inset-0 bg-black/95 z-[60] hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
                <button onclick="toggleSearch()" class="absolute top-10 right-10 text-white text-2xl hover:rotate-90 transition-transform"><i class="fas fa-times"></i></button>
                <h2 class="text-white/50 font-bold uppercase tracking-[0.3em] text-sm mb-4">Type to search</h2>
                <form action="{{ route('search') }}" method="GET" class="w-full flex justify-center">
                    <input type="text" name="query" value="{{ request('query') }}" placeholder="WHAT ARE YOU LOOKING FOR?" class="bg-transparent border-b-2 border-white/20 text-white text-2xl md:text-5xl font-black uppercase placeholder-white/10 focus:outline-none focus:border-white w-3/4 text-center py-4">
                </form>
            </div>

            <!-- Image Zoom Modal (ADDED HERE) -->
            <div id="image-zoom-modal" class="fixed inset-0 z-[200] bg-black/95 hidden items-center justify-center opacity-0 transition-opacity duration-300" onclick="closeZoom()">
                <button onclick="closeZoom()" class="absolute top-8 right-8 text-white text-4xl hover:rotate-90 transition-transform z-[201]"><i class="fas fa-times"></i></button>
                <img id="zoomed-image-target" src="" class="max-h-[90vh] max-w-[90vw] object-contain shadow-2xl shadow-white/10 transition-transform duration-300 transform scale-95" onclick="event.stopPropagation()">
            </div>

            <!-- Background Gradient (Subtle) -->
            <div class="fixed inset-0 z-[-1] pointer-events-none">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-900/5 rounded-full blur-[100px]"></div>
            </div>

            <div class="flex-1 max-w-[1400px] mx-auto w-full px-6 md:px-12 py-12 md:py-20">
                
                <!-- Breadcrumb -->
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-white mb-10 transition group animate-entry delay-100">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Back to Shop
                </a>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                    
                    <!-- Image Section -->
                    <!-- Added onclick="openZoom()" and cursor-zoom-in -->
                    <div class="relative bg-[#0a0a0a] border border-white/5 overflow-hidden group h-[500px] lg:h-[700px] rounded-3xl animate-entry delay-200 cursor-zoom-in" onclick="openZoom()">
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#333 1px, transparent 1px); background-size: 20px 20px;"></div>
                        
                        <img id="main-product-img-source"
                             src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/800x800/1a1a1a/333333?text=No+Image' }}" 
                             class="w-full h-full object-contain p-6 transition duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100" 
                             alt="{{ $product->name }}">
                        
                        <!-- Floating Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-bold px-4 py-2 uppercase tracking-wider rounded-full">
                                {{ $product->category->name ?? 'General' }}
                            </span>
                        </div>
                        
                        <!-- Zoom Hint Icon -->
                        <div class="absolute bottom-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="bg-black/50 text-white w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-md border border-white/10">
                                <i class="fas fa-expand"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="flex flex-col justify-center animate-entry delay-300">
                        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 uppercase leading-[0.9] tracking-tighter">
                            {{ $product->name }}
                        </h1>
                        
                        <div class="flex items-center gap-6 mb-10 border-b border-white/10 pb-8">
                            <span class="text-4xl font-bold text-white">${{ $product->price }}</span>
                            
                            @if($product->stock > 0)
                                <div class="px-3 py-1 border border-green-500/30 bg-green-500/10 text-green-500 text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> In Stock
                                </div>
                            @else
                                <div class="px-3 py-1 border border-red-500/30 bg-red-500/10 text-red-500 text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Sold Out
                                </div>
                            @endif
                        </div>

                        <div class="mb-12">
                            <h3 class="text-white text-xs font-bold uppercase tracking-widest mb-4">Description</h3>
                            <p class="text-gray-400 text-sm leading-relaxed border-l-2 border-white/20 pl-6">
                                {{ $product->description }}
                            </p>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form mb-12">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-white text-black font-black uppercase text-sm tracking-[0.2em] py-5 hover:bg-neutral-200 transition-all duration-300 flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed rounded-full shadow-lg shadow-white/5">
                                Add to Bag <i class="fas fa-plus"></i>
                            </button>
                        </form>

                        <!-- Features -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-[#050505] border border-white/10 p-6 flex flex-col gap-2 group hover:bg-[#0a0a0a] transition rounded-2xl">
                                <i class="fas fa-truck text-white/50 text-xl mb-2 group-hover:text-white transition"></i>
                                <h5 class="text-white text-[10px] font-bold uppercase tracking-widest">Fast Delivery</h5>
                                <p class="text-[10px] text-gray-500">Global shipping available</p>
                            </div>
                            <div class="bg-[#050505] border border-white/10 p-6 flex flex-col gap-2 group hover:bg-[#0a0a0a] transition rounded-2xl">
                                <i class="fas fa-shield-alt text-white/50 text-xl mb-2 group-hover:text-white transition"></i>
                                <h5 class="text-white text-[10px] font-bold uppercase tracking-widest">Secure Checkout</h5>
                                <p class="text-[10px] text-gray-500">Encrypted transactions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="border-t border-white/10 bg-black pt-16 pb-32 md:pb-16 px-6 md:px-16 mt-auto animate-entry delay-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                    <div class="max-w-xs">
                        <h4 class="text-2xl font-black text-white mb-6 tracking-tighter">MYSTORE.</h4>
                        <p class="text-gray-500 text-xs leading-loose">
                            Crafting the future of retail through minimalist design and superior quality materials.
                        </p>
                    </div>
                    <div class="w-full md:w-auto">
                        <h5 class="text-white text-[10px] font-bold uppercase tracking-widest mb-6">Newsletter</h5>
                        <div class="flex border-b border-white/20 py-2">
                            <input type="email" placeholder="ENTER EMAIL" class="bg-transparent border-none text-white text-xs font-bold uppercase w-full focus:outline-none placeholder-gray-700">
                            <button class="text-white hover:text-blue-500 transition"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Zoom Functions
        function openZoom() {
            const modal = document.getElementById('image-zoom-modal');
            const targetImg = document.getElementById('zoomed-image-target');
            const sourceImg = document.getElementById('main-product-img-source');
            
            // Set source
            targetImg.src = sourceImg.src;
            
            // Show modal
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            
            // Animation
            setTimeout(() => { 
                modal.classList.remove('opacity-0'); 
                targetImg.classList.remove('scale-95');
                targetImg.classList.add('scale-100');
            }, 10);
        }

        function closeZoom() {
            const modal = document.getElementById('image-zoom-modal');
            const targetImg = document.getElementById('zoomed-image-target');

            modal.classList.add('opacity-0');
            targetImg.classList.remove('scale-100');
            targetImg.classList.add('scale-95');

            setTimeout(() => { 
                modal.classList.add('hidden'); 
                modal.style.display = 'none'; 
            }, 300);
        }

        // Close on Escape Key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeZoom();
            }
        });

        function toggleSearch() {
            const overlay = document.getElementById('search-overlay');
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
                overlay.style.display = 'flex';
                setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
            } else {
                overlay.classList.add('opacity-0');
                setTimeout(() => { overlay.classList.add('hidden'); overlay.style.display = 'none'; }, 300);
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = message;
            toast.classList.remove('translate-x-full', 'opacity-0');
            setTimeout(() => { toast.classList.add('translate-x-full', 'opacity-0'); }, 3000);
        }

        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                const btn = this.querySelector('button');
                const originalContent = btn.innerHTML;
                
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...'; 

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => { if (response.ok) return response.text(); throw new Error('Err'); })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newCount = doc.querySelector('#cart-badge') ? doc.querySelector('#cart-badge').innerText.trim() : null;
                    if(newCount) {
                        document.querySelectorAll('#cart-badge, .md\\:hidden span').forEach(el => el.innerText = newCount);
                    }
                    showToast('Item added successfully!');
                })
                .catch(error => showToast('Something went wrong!'))
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                });
            });
        });
    </script>
</body>
</html>