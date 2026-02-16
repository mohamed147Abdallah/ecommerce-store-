<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Bag - MyStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Lenis for Smooth & Heavy Scrolling -->
    <script src="https://unpkg.com/lenis@1.1.2/dist/lenis.min.js"></script>
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
        
        /* Lenis Recommended CSS */
        html.lenis, html.lenis body {
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
        
        .fade-out {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Classes for Scroll Reveal */
        .scroll-hidden {
            opacity: 0;
            transform: translateY(40px) scale(0.95); /* Start lower and slightly smaller */
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .scroll-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

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
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs uppercase tracking-widest text-white">Update</h4>
                <p class="text-[10px] text-gray-400 uppercase tracking-wide" id="toast-message">Cart updated</p>
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
                <a href="{{ route('cart.index') }}" class="relative group cursor-pointer text-white">
                    <span id="cart-badge" class="absolute -top-2 -right-2 bg-white text-black text-[9px] font-bold w-4 h-4 flex items-center justify-center">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                    <i class="fas fa-shopping-bag text-xl group-hover:text-blue-400 transition"></i>
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

            <!-- Background Gradient (Subtle) -->
            <div class="fixed inset-0 z-[-1] pointer-events-none">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-900/10 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-900/5 rounded-full blur-[100px]"></div>
            </div>

            <div class="flex-1 max-w-[1600px] mx-auto w-full px-6 md:px-16 py-12 md:py-24">
                
                <!-- Page Header -->
                <div class="flex items-end justify-between border-b border-white/10 pb-8 mb-12 animate-entry delay-100">
                    <div>
                        <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter mb-2 leading-none">Your <br>Bag</h1>
                    </div>
                    <div class="hidden md:block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Total Items: <span id="header-count" class="text-white">{{ count(session('cart', [])) }}</span>
                    </div>
                </div>

                <!-- Empty State (Hidden by default if items exist) -->
                <div id="empty-cart-message" class="{{ session('cart') && count(session('cart')) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-32 border border-dashed border-white/10 bg-[#0a0a0a] rounded-3xl animate-entry delay-200">
                    <div class="w-24 h-24 bg-neutral-900 border border-white/5 flex items-center justify-center mb-6 text-gray-700 rounded-full">
                        <i class="fas fa-shopping-bag text-4xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-2 uppercase tracking-wide">Your bag is empty</h3>
                    <p class="text-gray-500 text-xs mb-10 uppercase tracking-widest">Looks like you haven't made a choice yet.</p>
                    <a href="{{ route('products.index') }}" class="bg-white text-black px-10 py-4 text-xs font-black uppercase tracking-widest hover:bg-gray-200 rounded-full transition-all duration-300">
                        Start Shopping
                    </a>
                </div>

                @if(session('cart') && count(session('cart')) > 0)
                    <div id="cart-content" class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                        
                        <!-- Left Column: Products List -->
                        <div id="cart-items-container" class="lg:col-span-8 space-y-6">
                            @foreach(session('cart') as $id => $details)
                                <!-- ADDED: scroll-hidden class for initial state -->
                                <div id="cart-row-{{ $id }}" class="scroll-hidden group relative flex flex-col sm:flex-row bg-[#0a0a0a] border border-white/10 rounded-3xl overflow-hidden hover:border-white/30 transition-all duration-300" data-price="{{ $details['price'] }}">
                                    
                                    <!-- Image -->
                                    <div class="w-full sm:w-48 h-48 sm:h-auto relative overflow-hidden">
                                        <a href="{{ route('products.show', $id) }}" class="block w-full h-full">
                                            <img src="{{ $details['image'] ? asset('storage/'.$details['image']) : 'https://via.placeholder.com/150/171717/525252' }}" 
                                                 class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                                        </a>
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-1 p-6 sm:p-8 flex flex-col justify-between">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-1">
                                                    <a href="{{ route('products.show', $id) }}" class="hover:text-gray-300 transition-colors">{{ $details['name'] }}</a>
                                                </h3>
                                                <div class="text-[10px] text-gray-500 uppercase tracking-widest">${{ $details['price'] }} each</div>
                                            </div>
                                            
                                            <!-- Remove Button (AJAX) -->
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="ajax-cart-form" data-type="remove" data-id="{{ $id }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-500 transition">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="flex items-end justify-between mt-6">
                                            <!-- Quantity Controls (Rounded & AJAX) -->
                                            <div class="flex items-center gap-1 bg-white/5 rounded-full p-1 border border-white/10">
                                                <form action="{{ route('cart.decrease', $id) }}" method="POST" class="ajax-cart-form" data-type="decrease" data-id="{{ $id }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="w-8 h-8 rounded-full bg-black hover:bg-white hover:text-black text-white transition flex items-center justify-center">
                                                        <i class="fas fa-minus text-[10px]"></i>
                                                    </button>
                                                </form>
                                                
                                                <span id="qty-{{ $id }}" class="w-8 text-center font-bold text-white text-xs">{{ $details['quantity'] }}</span>
                                                
                                                <form action="{{ route('cart.add', $id) }}" method="POST" class="ajax-cart-form" data-type="increase" data-id="{{ $id }}">
                                                    @csrf
                                                    <button type="submit" class="w-8 h-8 rounded-full bg-white text-black hover:bg-gray-200 transition flex items-center justify-center">
                                                        <i class="fas fa-plus text-[10px]"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <div id="subtotal-{{ $id }}" class="text-2xl font-bold text-white tracking-tight">${{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Right Column: Order Summary (Sticky) -->
                        <div class="lg:col-span-4 animate-entry delay-300">
                            <div class="bg-[#0a0a0a] border border-white/10 rounded-3xl p-8 sticky top-6 shadow-2xl">
                                <h3 class="text-sm font-black text-white uppercase tracking-widest mb-8 border-b border-white/10 pb-4 flex justify-between items-center">
                                    Summary <span id="summary-count" class="text-gray-600 text-[10px]">{{ count(session('cart', [])) }} ITEMS</span>
                                </h3>
                                
                                <div class="space-y-4 mb-8">
                                    <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                                        <span class="text-gray-500">Subtotal</span>
                                        <span id="summary-subtotal" class="text-white">${{ number_format($total ?? 0, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                                        <span class="text-gray-500">Shipping</span>
                                        <span class="text-gray-500">Calculated later</span>
                                    </div>
                                    <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                                        <span class="text-gray-500">Tax</span>
                                        <span class="text-white">$0.00</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-end mb-8 pt-6 border-t border-white/10">
                                    <span class="text-sm font-black text-white uppercase tracking-widest">Total</span>
                                    <span id="summary-total" class="text-4xl font-black text-white tracking-tighter">${{ number_format($total ?? 0, 2) }}</span>
                                </div>

                                <button class="w-full bg-white text-black py-4 text-xs font-black uppercase tracking-[0.2em] hover:bg-gray-200 transition rounded-full flex items-center justify-center gap-3 group shadow-lg shadow-white/5">
                                    Checkout <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </button>
                                
                                <div class="mt-8 pt-6 border-t border-white/5 text-center">
                                    <p class="text-[9px] text-gray-600 uppercase tracking-widest mb-4">Secure Payment</p>
                                    <div class="flex justify-center gap-4 text-gray-500 text-xl">
                                        <i class="fab fa-cc-visa hover:text-white transition"></i>
                                        <i class="fab fa-cc-mastercard hover:text-white transition"></i>
                                        <i class="fab fa-cc-amex hover:text-white transition"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
            </div>

            <!-- Footer -->
            <footer class="border-t border-white/10 mt-auto bg-black pt-16 pb-32 md:pb-16 px-6 md:px-16 animate-entry delay-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                    <div class="max-w-xs">
                        <h4 class="text-2xl font-black text-white mb-6 tracking-tighter">MYSTORE.</h4>
                        <p class="text-gray-500 text-xs leading-loose">
                            Crafting the future of retail.
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
        // --- Lenis Init (Heavy Smooth Scroll) ---
        const lenis = new Lenis({
            duration: 1.2,
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

        // --- NEW: Scroll Reveal with Random Delay Logic ---
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Random delay between 0 and 400ms + fixed 250ms delay
                    const randomDelay = Math.random() * 400; 
                    
                    setTimeout(() => {
                        entry.target.classList.remove('scroll-hidden');
                        entry.target.classList.add('scroll-visible');
                    }, 250 + randomDelay);

                    // Once revealed, stop observing (optional, keep observing if you want repeat)
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        // Observe all cart rows
        document.querySelectorAll('.scroll-hidden').forEach(el => {
            revealObserver.observe(el);
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

        // SPA-Like Cart Logic (No Refresh)
        document.querySelectorAll('.ajax-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                const type = this.dataset.type; // remove, increase, decrease
                const id = this.dataset.id;
                const btn = this.querySelector('button');
                
                // Disable button temporarily to prevent double clicks
                btn.disabled = true;

                // Simulate API Request (In real Laravel, this fetches the route)
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => {
                    // For prototype, we assume success even without real backend logic
                    // In real app: if (response.ok) ...
                    return response.text(); 
                })
                .then(() => {
                    handleCartUpdate(type, id);
                    btn.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    // For prototype purposes, proceed even on error since we don't have backend
                    handleCartUpdate(type, id);
                    btn.disabled = false;
                });
            });
        });

        function handleCartUpdate(type, id) {
            const row = document.getElementById(`cart-row-${id}`);
            if (!row) return;

            const qtySpan = document.getElementById(`qty-${id}`);
            const itemSubtotalSpan = document.getElementById(`subtotal-${id}`);
            const price = parseFloat(row.dataset.price);
            let currentQty = parseInt(qtySpan.innerText);

            if (type === 'remove') {
                // Animate removal
                row.style.transition = "all 0.3s ease";
                row.style.opacity = "0";
                row.style.transform = "scale(0.95)";
                setTimeout(() => {
                    row.remove();
                    recalculateTotals();
                    checkEmptyCart();
                    showToast('Item removed');
                    // Update Lenis scroll after DOM change
                    lenis.resize();
                }, 300);
            } 
            else if (type === 'increase') {
                currentQty++;
                qtySpan.innerText = currentQty;
                itemSubtotalSpan.innerText = '$' + (price * currentQty).toFixed(2);
                recalculateTotals();
            } 
            else if (type === 'decrease') {
                if (currentQty > 1) {
                    currentQty--;
                    qtySpan.innerText = currentQty;
                    itemSubtotalSpan.innerText = '$' + (price * currentQty).toFixed(2);
                    recalculateTotals();
                } else {
                    // If qty is 1 and decrease is clicked, usually acts as remove or does nothing
                    // Here we will do nothing or could trigger remove
                }
            }
        }

        function recalculateTotals() {
            let total = 0;
            let itemCount = 0;
            
            document.querySelectorAll('[id^="cart-row-"]').forEach(row => {
                const id = row.id.replace('cart-row-', '');
                const qty = parseInt(document.getElementById(`qty-${id}`).innerText);
                const price = parseFloat(row.dataset.price);
                
                total += (price * qty);
                itemCount += 1; // Or += qty if you want total units
            });

            const formattedTotal = '$' + total.toFixed(2);
            
            // Update Summary
            document.getElementById('summary-subtotal').innerText = formattedTotal;
            document.getElementById('summary-total').innerText = formattedTotal;
            document.getElementById('summary-count').innerText = itemCount + ' ITEMS';
            
            // Update Header Count
            document.getElementById('header-count').innerText = itemCount;
            
            // Update Navbar Badges
            document.querySelectorAll('#cart-badge, #mobile-cart-badge').forEach(el => {
                el.innerText = itemCount; // Note: simplified logic, usually sum of quantities
            });
        }

        function checkEmptyCart() {
            const rows = document.querySelectorAll('[id^="cart-row-"]');
            if (rows.length === 0) {
                document.getElementById('cart-content').classList.add('hidden');
                document.getElementById('empty-cart-message').classList.remove('hidden');
                document.getElementById('empty-cart-message').classList.add('flex');
                // Update Lenis scroll after DOM change
                lenis.resize();
            }
        }
    </script>
</body>
</html>