{{--
    Campus Interactive Network Constellation (Plexus) Background
    AMIK Taruna Probolinggo
    Ultra-Smooth High Refresh Rate (60-120 FPS) GPU HTML5 Canvas Engine
    Optimized: Zero shadowBlur overhead, squared distance checking, scroll-aware throttling
--}}
<canvas id="campus-plexus-canvas" class="pointer-events-none fixed inset-0 z-0" style="will-change: transform; transform: translateZ(0); contain: strict;" aria-hidden="true"></canvas>

<script>
(function() {
    // Avoid double initialization if loaded multiple times
    if (window.__amikPlexusInitialized) return;
    window.__amikPlexusInitialized = true;

    const canvas = document.getElementById('campus-plexus-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: true, desynchronized: true });
    if (!ctx) return;

    // Detect mobile device
    const isMobile = window.innerWidth < 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    let width = 0;
    let height = 0;
    let dpr = 1;
    let animationFrameId = null;
    let isVisible = true;
    let isScrolling = false;
    let scrollTimeout = null;
    let lastTime = performance.now();

    // Mouse tracking (desktop only)
    const mouse = {
        x: null,
        y: null,
        radius: 140,
        radiusSq: 140 * 140
    };

    if (!isMobile) {
        window.addEventListener('mousemove', function(e) {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        }, { passive: true });

        window.addEventListener('mouseleave', function() {
            mouse.x = null;
            mouse.y = null;
        }, { passive: true });
    }

    // Scroll throttle: lighten canvas load during active touch/mouse scrolling for 120Hz smooth scroll
    window.addEventListener('scroll', function() {
        isScrolling = true;
        if (scrollTimeout) clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            isScrolling = false;
        }, 100);
    }, { passive: true });

    // Particle class
    class Particle {
        constructor() {
            this.init();
        }

        init() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            // Smooth natural drift velocity
            const speed = isMobile ? (0.2 + Math.random() * 0.3) : (0.3 + Math.random() * 0.45);
            const angle = Math.random() * Math.PI * 2;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed;
            // Node radius
            this.radius = isMobile ? (Math.random() * 1.4 + 1.8) : (Math.random() * 1.8 + 2.2);
            // 85% radiant emerald/green, 15% radiant gold accent
            const isGold = Math.random() < 0.15;
            this.color = isGold ? '#fbbf24' : (Math.random() < 0.5 ? '#4ade80' : '#22c55e');
            this.baseAlpha = isMobile ? (Math.random() * 0.2 + 0.6) : (Math.random() * 0.15 + 0.8);
        }

        update(dt) {
            this.x += this.vx * dt;
            this.y += this.vy * dt;

            // Bounce smoothly off boundaries
            if (this.x < 0) {
                this.x = 0;
                this.vx = -this.vx;
            } else if (this.x > width) {
                this.x = width;
                this.vx = -this.vx;
            }

            if (this.y < 0) {
                this.y = 0;
                this.vy = -this.vy;
            } else if (this.y > height) {
                this.y = height;
                this.vy = -this.vy;
            }

            // Mouse proximity reaction (desktop only, skip when mouse is off-screen)
            if (!isMobile && mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const distSq = dx * dx + dy * dy;
                if (distSq < mouse.radiusSq && distSq > 1) {
                    const dist = Math.sqrt(distSq);
                    const force = (1 - dist / mouse.radius) * 0.04;
                    this.x -= (dx / dist) * force * 12 * dt;
                    this.y -= (dy / dist) * force * 12 * dt;
                }
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.baseAlpha;
            ctx.fill();
        }
    }

    let particles = [];
    let connectionDistance = 110;
    let connectionDistanceSq = 110 * 110;
    let mouseConnectionDist = 140;
    let mouseConnectionDistSq = 140 * 140;

    function setupCanvas() {
        // Cap DPR to 1.5 max: prevents rendering 4x-9x redundant pixels on 4K/retina displays
        dpr = isMobile ? 1 : Math.min(window.devicePixelRatio || 1, 1.5);
        width = window.innerWidth;
        height = window.innerHeight;

        canvas.width = Math.floor(width * dpr);
        canvas.height = Math.floor(height * dpr);
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';

        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr, dpr);

        connectionDistance = isMobile ? 80 : (width < 1024 ? 95 : 125);
        connectionDistanceSq = connectionDistance * connectionDistance;
        mouseConnectionDist = 140;
        mouseConnectionDistSq = 140 * 140;

        // Density scaled for smooth 60-120 FPS
        const count = isMobile
            ? Math.min(22, Math.max(14, Math.floor((width * height) / 32000)))
            : Math.min(55, Math.max(30, Math.floor((width * height) / 18000)));

        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(new Particle());
        }
    }

    // Connect particles with network constellation lines (Optimized $O(1)$ squared distance)
    function drawConnections() {
        // If aggressively scrolling on low-power devices, skip dense line math to protect scroll refresh rate
        if (isScrolling && isMobile) return;

        const pLen = particles.length;
        ctx.strokeStyle = '#4ade80';
        ctx.lineWidth = isMobile ? 0.9 : 1.3;

        for (let i = 0; i < pLen; i++) {
            const p1 = particles[i];

            // Connect to nearby particles
            for (let j = i + 1; j < pLen; j++) {
                const p2 = particles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const distSq = dx * dx + dy * dy;

                // Fast squared distance rejection
                if (distSq < connectionDistanceSq) {
                    const dist = Math.sqrt(distSq);
                    const alpha = (1 - dist / connectionDistance) * (isMobile ? 0.40 : 0.60);
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.globalAlpha = alpha;
                    ctx.stroke();
                }
            }

            // Connect to mouse cursor (desktop only)
            if (!isMobile && mouse.x !== null && mouse.y !== null) {
                const mdx = p1.x - mouse.x;
                const mdy = p1.y - mouse.y;
                const mDistSq = mdx * mdx + mdy * mdy;

                if (mDistSq < mouseConnectionDistSq) {
                    const mDist = Math.sqrt(mDistSq);
                    const mAlpha = (1 - mDist / mouseConnectionDist) * 0.85;
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.globalAlpha = mAlpha;
                    ctx.stroke();
                }
            }
        }
    }

    function animate(currentTime) {
        if (!isVisible) return;

        // Delta-time normalization: 1.0 at 60fps, 0.5 at 120fps
        const delta = Math.min((currentTime - lastTime) / 16.667, 2.5) || 1.0;
        lastTime = currentTime;

        ctx.clearRect(0, 0, width, height);

        // Update & draw particles
        const pLen = particles.length;
        for (let i = 0; i < pLen; i++) {
            particles[i].update(delta);
            particles[i].draw();
        }

        // Draw connections with zero shadowBlur overhead
        drawConnections();

        ctx.globalAlpha = 1.0;

        animationFrameId = requestAnimationFrame(animate);
    }

    // Debounced resize handler
    let resizeTimer = null;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            setupCanvas();
        }, 150);
    }, { passive: true });

    // Page visibility to pause when inactive (save battery / CPU)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            isVisible = false;
            if (animationFrameId) cancelAnimationFrame(animationFrameId);
        } else {
            isVisible = true;
            lastTime = performance.now();
            animationFrameId = requestAnimationFrame(animate);
        }
    });

    // Check prefers-reduced-motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (prefersReducedMotion.matches) {
        setupCanvas();
        for (let i = 0; i < particles.length; i++) particles[i].draw();
        drawConnections();
        return;
    }

    function startCanvas() {
        setupCanvas();
        lastTime = performance.now();
        animationFrameId = requestAnimationFrame(animate);
    }

    if (typeof window !== 'undefined' && 'requestIdleCallback' in window) {
        window.requestIdleCallback(startCanvas, { timeout: 600 });
    } else {
        setTimeout(startCanvas, 100);
    }
})();
</script>
