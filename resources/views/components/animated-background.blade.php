{{--
    Campus Interactive Network Constellation (Plexus) Background
    AMIK Taruna Probolinggo
    High-Tech, Crisp, GPU 60 FPS HTML5 Canvas Engine
    Interactive to mouse cursor & Touch, Zero-click interference (pointer-events: none)
--}}
<canvas id="campus-plexus-canvas" class="pointer-events-none fixed inset-0 z-0" style="will-change: transform; transform: translateZ(0); contain: strict;" aria-hidden="true"></canvas>

<script>
(function() {
    // Avoid double initialization if loaded multiple times
    if (window.__amikPlexusInitialized) return;
    window.__amikPlexusInitialized = true;

    const canvas = document.getElementById('campus-plexus-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: true });
    if (!ctx) return;

    // Detect mobile device (Android / iOS / small screen)
    const isMobile = window.innerWidth < 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    let width = 0;
    let height = 0;
    let dpr = 1;
    let animationFrameId = null;
    let isVisible = true;

    // Mouse tracking (only on desktop/mouse devices)
    const mouse = {
        x: null,
        y: null,
        radius: 160
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

    // Particle class
    class Particle {
        constructor() {
            this.init();
        }

        init() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            // Smooth natural drift velocity
            const speed = isMobile ? (0.2 + Math.random() * 0.35) : (0.35 + Math.random() * 0.55);
            const angle = Math.random() * Math.PI * 2;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed;
            // Node radius
            this.radius = isMobile ? (Math.random() * 1.5 + 2.0) : (Math.random() * 2.2 + 2.6);
            // 85% radiant campus emerald / green, 15% radiant gold accent
            const isGold = Math.random() < 0.15;
            this.color = isGold ? '#fbbf24' : (Math.random() < 0.5 ? '#4ade80' : '#22c55e');
            this.baseAlpha = isMobile ? (Math.random() * 0.2 + 0.65) : (Math.random() * 0.15 + 0.85);
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

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

            // Mouse proximity reaction (desktop only)
            if (!isMobile && mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.hypot(dx, dy);
                if (dist < mouse.radius && dist > 1) {
                    const force = (1 - dist / mouse.radius) * 0.04;
                    this.x -= (dx / dist) * force * 15;
                    this.y -= (dy / dist) * force * 15;
                }
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.baseAlpha;
            // Turn off shadowBlur on mobile for massive GPU 60 FPS boost
            if (!isMobile) {
                ctx.shadowBlur = 12;
                ctx.shadowColor = this.color;
            }
            ctx.fill();
        }
    }

    let particles = [];

    function setupCanvas() {
        // Mobile uses DPR 1 to prevent rendering 4x redundant pixels on high-res AMOLED
        dpr = isMobile ? 1 : Math.min(window.devicePixelRatio || 1, 2);
        width = window.innerWidth;
        height = window.innerHeight;

        canvas.width = Math.floor(width * dpr);
        canvas.height = Math.floor(height * dpr);
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';

        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr, dpr);

        // Density scaled: 24 particles on mobile vs 75 on desktop
        const count = isMobile
            ? Math.min(26, Math.max(16, Math.floor((width * height) / 28000)))
            : Math.min(85, Math.max(40, Math.floor((width * height) / 14000)));

        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(new Particle());
        }
    }

    // Connect particles with network constellation lines
    function drawConnections() {
        const connectionDistance = isMobile ? 85 : (width < 1024 ? 110 : 140);
        const mouseConnectionDist = 160;

        for (let i = 0; i < particles.length; i++) {
            const p1 = particles[i];

            // Connect to nearby particles
            for (let j = i + 1; j < particles.length; j++) {
                const p2 = particles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const dist = Math.hypot(dx, dy);

                if (dist < connectionDistance) {
                    const alpha = (1 - dist / connectionDistance) * (isMobile ? 0.45 : 0.70);
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.strokeStyle = '#4ade80';
                    ctx.globalAlpha = alpha;
                    ctx.lineWidth = isMobile ? 1.0 : 1.9;
                    if (!isMobile) {
                        ctx.shadowBlur = 4;
                        ctx.shadowColor = '#22c55e';
                    }
                    ctx.stroke();
                }
            }

            // Connect to mouse cursor (desktop only)
            if (!isMobile && mouse.x !== null && mouse.y !== null) {
                const mdx = p1.x - mouse.x;
                const mdy = p1.y - mouse.y;
                const mdist = Math.hypot(mdx, mdy);

                if (mdist < mouseConnectionDist) {
                    const mAlpha = (1 - mdist / mouseConnectionDist) * 0.90;
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.strokeStyle = '#86efac';
                    ctx.globalAlpha = mAlpha;
                    ctx.lineWidth = 2.4;
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = '#4ade80';
                    ctx.stroke();
                }
            }
        }
    }

    function animate() {
        if (!isVisible) return;

        ctx.clearRect(0, 0, width, height);

        // Update & draw particles
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }

        // Draw connections
        drawConnections();

        ctx.globalAlpha = 1.0;
        ctx.shadowBlur = 0;

        animationFrameId = requestAnimationFrame(animate);
    }

    // Debounced resize handler
    let resizeTimer = null;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            setupCanvas();
        }, 200);
    }, { passive: true });

    // Page visibility to pause when inactive (save battery / CPU)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            isVisible = false;
            if (animationFrameId) cancelAnimationFrame(animationFrameId);
        } else {
            isVisible = true;
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

    setupCanvas();
    animationFrameId = requestAnimationFrame(animate);
})();
</script>
