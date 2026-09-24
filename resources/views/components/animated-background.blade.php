{{--
    Campus Interactive Network Constellation (Plexus) Background
    AMIK Taruna Probolinggo
    High-Tech, Crisp, GPU 60 FPS HTML5 Canvas Engine
    Interactive to mouse cursor & Touch, Zero-click interference (pointer-events: none)
--}}
<canvas id="campus-plexus-canvas" class="pointer-events-none fixed inset-0 z-0" aria-hidden="true"></canvas>

<script>
(function() {
    // Avoid double initialization if loaded multiple times
    if (window.__amikPlexusInitialized) return;
    window.__amikPlexusInitialized = true;

    const canvas = document.getElementById('campus-plexus-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: true });
    if (!ctx) return;

    let width = 0;
    let height = 0;
    let dpr = 1;
    let animationFrameId = null;
    let isVisible = true;

    // Mouse tracking
    const mouse = {
        x: null,
        y: null,
        radius: 180
    };

    window.addEventListener('mousemove', function(e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    }, { passive: true });

    window.addEventListener('mouseleave', function() {
        mouse.x = null;
        mouse.y = null;
    }, { passive: true });

    window.addEventListener('touchmove', function(e) {
        if (e.touches.length > 0) {
            mouse.x = e.touches[0].clientX;
            mouse.y = e.touches[0].clientY;
        }
    }, { passive: true });

    window.addEventListener('touchend', function() {
        mouse.x = null;
        mouse.y = null;
    }, { passive: true });

    // Particle class - bolder and more vibrant
    class Particle {
        constructor() {
            this.init();
        }

        init() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            // Smooth natural drift velocity
            const speed = 0.35 + Math.random() * 0.55;
            const angle = Math.random() * Math.PI * 2;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed;
            // Bolder, thicker node radius: 2.6px - 4.8px
            this.radius = Math.random() * 2.2 + 2.6;
            // 85% radiant campus emerald / green, 15% radiant gold accent
            const isGold = Math.random() < 0.15;
            this.color = isGold ? '#fbbf24' : (Math.random() < 0.5 ? '#4ade80' : '#22c55e');
            this.baseAlpha = Math.random() * 0.15 + 0.85; // 0.85 - 1.0 (radiant & solid)
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

            // Mouse proximity gentle reaction
            if (mouse.x !== null && mouse.y !== null) {
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
            ctx.shadowBlur = 12;
            ctx.shadowColor = this.color;
            ctx.fill();
        }
    }

    let particles = [];

    function setupCanvas() {
        dpr = window.devicePixelRatio || 1;
        width = window.innerWidth;
        height = window.innerHeight;

        canvas.width = Math.floor(width * dpr);
        canvas.height = Math.floor(height * dpr);
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';

        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr, dpr);

        // Density scaled to screen dimensions
        const count = Math.min(95, Math.max(40, Math.floor((width * height) / 14000)));
        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(new Particle());
        }
    }

    // Connect particles with bolder network constellation lines
    function drawConnections() {
        const connectionDistance = width < 768 ? 105 : 140;
        const mouseConnectionDist = 175;

        for (let i = 0; i < particles.length; i++) {
            const p1 = particles[i];

            // Connect to nearby particles
            for (let j = i + 1; j < particles.length; j++) {
                const p2 = particles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const dist = Math.hypot(dx, dy);

                if (dist < connectionDistance) {
                    const alpha = (1 - dist / connectionDistance) * 0.70;
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.strokeStyle = '#4ade80';
                    ctx.globalAlpha = alpha;
                    ctx.lineWidth = 1.9;
                    ctx.shadowBlur = 4;
                    ctx.shadowColor = '#22c55e';
                    ctx.stroke();
                }
            }

            // Connect to mouse cursor if within range
            if (mouse.x !== null && mouse.y !== null) {
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
        }, 150);
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
        // Render one static frame
        setupCanvas();
        for (let i = 0; i < particles.length; i++) particles[i].draw();
        drawConnections();
        return;
    }

    setupCanvas();
    animationFrameId = requestAnimationFrame(animate);
})();
</script>
