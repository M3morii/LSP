<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" {{ $attributes }} fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <!-- Keranjang Belanja Berkualitas Tinggi -->
    <defs>
        <linearGradient id="shopGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#4F46E5" />
            <stop offset="100%" stop-color="#7C3AED" />
        </linearGradient>
    </defs>
    
    <!-- Keranjang dengan Efek Bayangan -->
    <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
        <feDropShadow dx="0.5" dy="0.5" stdDeviation="0.5" flood-color="#000" flood-opacity="0.3"/>
    </filter>
    
    <!-- Keranjang Belanja dengan Gradien -->
    <circle cx="9" cy="21" r="1.2" fill="url(#shopGradient)" stroke="none"></circle>
    <circle cx="20" cy="21" r="1.2" fill="url(#shopGradient)" stroke="none"></circle>
    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" stroke="url(#shopGradient)" stroke-width="1.8" filter="url(#shadow)"></path>
    
</svg>