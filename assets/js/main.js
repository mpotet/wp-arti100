/**
 * Arti100 — main.js
 * Vanilla JS — Header sticky, avant/après slider, menu mobile, compteurs, Calendly
 */

'use strict';

/* =========================================================
   1. DOM Ready
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {
	arti100HeaderSticky();
	arti100MobileMenu();
	arti100BeforeAfterSliders();
	arti100CounterAnimation();
	arti100ScrollAnimations();
	arti100CalendlyLinks();
	arti100ContactFormSuccess();
	arti100SmoothScrollAnchors();
});

/* =========================================================
   2. HEADER STICKY — shadow on scroll
   ========================================================= */
function arti100HeaderSticky() {
	const header = document.getElementById('masthead');
	if (!header) return;

	let lastScroll = 0;
	window.addEventListener('scroll', function () {
		const current = window.scrollY;
		if (current > 80) {
			header.classList.add('scrolled');
		} else {
			header.classList.remove('scrolled');
		}
		lastScroll = current;
	}, { passive: true });
}

/* =========================================================
   3. MOBILE MENU
   ========================================================= */
function arti100MobileMenu() {
	const toggle = document.getElementById('menu-toggle');
	const nav    = document.getElementById('site-navigation');
	const body   = document.body;

	if (!toggle || !nav) return;

	toggle.addEventListener('click', function () {
		const isOpen = nav.classList.toggle('is-open');
		toggle.classList.toggle('is-active', isOpen);
		toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		body.classList.toggle('menu-open', isOpen);
	});

	// Fermer au clic en dehors
	document.addEventListener('click', function (e) {
		if (!nav.contains(e.target) && !toggle.contains(e.target)) {
			nav.classList.remove('is-open');
			toggle.classList.remove('is-active');
			toggle.setAttribute('aria-expanded', 'false');
			body.classList.remove('menu-open');
		}
	});

	// Fermer sur Escape
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			nav.classList.remove('is-open');
			toggle.classList.remove('is-active');
			toggle.setAttribute('aria-expanded', 'false');
			body.classList.remove('menu-open');
		}
	});

	// Fermer au clic sur un lien ancre (#)
	nav.querySelectorAll('a[href^="#"]').forEach(function (link) {
		link.addEventListener('click', function () {
			nav.classList.remove('is-open');
			toggle.classList.remove('is-active');
			toggle.setAttribute('aria-expanded', 'false');
			body.classList.remove('menu-open');
		});
	});
}

/* =========================================================
   4. AVANT / APRÈS SLIDER
   ========================================================= */
function arti100BeforeAfterSliders() {
	document.querySelectorAll('.ba-slider').forEach(function (slider) {
		const apres  = slider.querySelector('.ba-apres');
		const handle = slider.querySelector('.ba-handle');
		if (!apres || !handle) return;

		let isDragging = false;
		let currentPct = 50;

		function setClip(pct) {
			currentPct = Math.max(0, Math.min(100, pct));
			apres.style.clipPath = 'inset(0 0 0 ' + currentPct + '%)';
			handle.style.left    = currentPct + '%';
			handle.setAttribute('aria-valuenow', Math.round(currentPct));
		}

		function getPercent(clientX) {
			const rect = slider.getBoundingClientRect();
			const x    = clientX - rect.left;
			return (x / rect.width) * 100;
		}

		// Mouse
		handle.addEventListener('mousedown', function (e) {
			e.preventDefault();
			isDragging = true;
		});
		window.addEventListener('mousemove', function (e) {
			if (!isDragging) return;
			setClip(getPercent(e.clientX));
		});
		window.addEventListener('mouseup', function () { isDragging = false; });

		// Touch
		handle.addEventListener('touchstart', function (e) {
			e.preventDefault();
			isDragging = true;
		}, { passive: false });
		window.addEventListener('touchmove', function (e) {
			if (!isDragging) return;
			setClip(getPercent(e.touches[0].clientX));
		}, { passive: true });
		window.addEventListener('touchend', function () { isDragging = false; });

		// Keyboard accessibility
		handle.addEventListener('keydown', function (e) {
			const step = e.shiftKey ? 10 : 1;
			if (e.key === 'ArrowLeft')  { e.preventDefault(); setClip(currentPct - step); }
			if (e.key === 'ArrowRight') { e.preventDefault(); setClip(currentPct + step); }
		});

		// Initialisation
		setClip(50);
	});
}

/* =========================================================
   5. COMPTEURS ANIMÉS (hero stats)
   ========================================================= */
function arti100CounterAnimation() {
	const stats = document.querySelectorAll('.hero-stat[data-count]');
	if (!stats.length) return;

	const observer = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (!entry.isIntersecting) return;
			const el     = entry.target;
			const target = parseInt(el.dataset.count, 10);
			const suffix = el.dataset.suffix || '';
			const numEl  = el.querySelector('.stat-number');
			if (!numEl) return;

			let start = 0;
			const duration = 1800;
			const startTime = performance.now();

			function update(timestamp) {
				const progress = Math.min((timestamp - startTime) / duration, 1);
				const ease     = 1 - Math.pow(1 - progress, 3); // cubic ease-out
				start = Math.round(ease * target);
				numEl.textContent = start + suffix;
				if (progress < 1) requestAnimationFrame(update);
			}
			requestAnimationFrame(update);
			observer.unobserve(el);
		});
	}, { threshold: 0.5 });

	stats.forEach(function (stat) { observer.observe(stat); });
}

/* =========================================================
   6. SCROLL ANIMATIONS (fade-in-up)
   ========================================================= */
function arti100ScrollAnimations() {
	const animatables = document.querySelectorAll(
		'.service-card, .portfolio-item, .team-card, .testimonial-card, .trust-item'
	);
	if (!animatables.length) return;

	// Ajouter style CSS
	const style = document.createElement('style');
	style.textContent = `
		.arti100-animate { opacity: 0; transform: translateY(24px); transition: opacity .5s ease, transform .5s ease; }
		.arti100-animate.in-view { opacity: 1; transform: translateY(0); }
	`;
	document.head.appendChild(style);

	animatables.forEach(function (el, i) {
		el.classList.add('arti100-animate');
		el.style.transitionDelay = (i % 4 * 80) + 'ms';
	});

	const io = new IntersectionObserver(function (entries) {
		entries.forEach(function (entry) {
			if (entry.isIntersecting) {
				entry.target.classList.add('in-view');
				io.unobserve(entry.target);
			}
		});
	}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

	animatables.forEach(function (el) { io.observe(el); });
}

/* =========================================================
   7. CALENDLY — popup au clic
   ========================================================= */
function arti100CalendlyLinks() {
	const links = document.querySelectorAll('.js-calendly[data-calendly]');
	if (!links.length) return;

	links.forEach(function (link) {
		link.addEventListener('click', function (e) {
			const url = link.dataset.calendly;
			if (!url) return;

			// Si Calendly widget est disponible, l'utiliser en popup
			if (window.Calendly) {
				e.preventDefault();
				window.Calendly.initPopupWidget({ url: url });
			}
			// Sinon, le href normal fonctionne (lien direct)
		});
	});

	// Injecter le script Calendly si pas déjà là
	if (!document.getElementById('calendly-script')) {
		const sc = document.createElement('script');
		sc.id  = 'calendly-script';
		sc.src = 'https://assets.calendly.com/assets/external/widget.js';
		sc.async = true;
		document.head.appendChild(sc);

		const css = document.createElement('link');
		css.rel  = 'stylesheet';
		css.href = 'https://assets.calendly.com/assets/external/widget.css';
		document.head.appendChild(css);
	}
}

/* =========================================================
   8. FORMULAIRE CONTACT — message succès
   ========================================================= */
function arti100ContactFormSuccess() {
	const params = new URLSearchParams(window.location.search);
	if (params.get('devis') === 'envoye') {
		// Créer notification
		const notice = document.createElement('div');
		notice.setAttribute('role', 'alert');
		notice.style.cssText = `
			position:fixed; top:80px; right:1.5rem; z-index:9999;
			background:#1a7a1a; color:#fff; padding:1rem 1.5rem;
			border-radius:10px; box-shadow:0 4px 16px rgba(0,0,0,.2);
			max-width:340px; animation:slideIn .3s ease;
		`;
		notice.innerHTML = `
			<strong>✅ Demande envoyée !</strong><br>
			<small>Nous vous recontacterons dans les plus brefs délais.</small>
		`;
		document.body.appendChild(notice);
		setTimeout(function () { notice.remove(); }, 6000);

		// Nettoyer URL
		history.replaceState(null, '', window.location.pathname);

		// Scroll vers contact
		const contactSection = document.getElementById('contact');
		if (contactSection) contactSection.scrollIntoView({ behavior: 'smooth' });
	}
}

/* =========================================================
   9. SMOOTH SCROLL — ancres
   ========================================================= */
function arti100SmoothScrollAnchors() {
	document.querySelectorAll('a[href^="#"]').forEach(function (link) {
		link.addEventListener('click', function (e) {
			const id = link.getAttribute('href').substring(1);
			if (!id) return;
			const target = document.getElementById(id);
			if (!target) return;

			e.preventDefault();
			const headerH = document.getElementById('masthead');
			const offset  = headerH ? headerH.offsetHeight + 20 : 80;
			const top     = target.getBoundingClientRect().top + window.scrollY - offset;
			window.scrollTo({ top: top, behavior: 'smooth' });
		});
	});
}

/* =========================================================
   10. HEADER — style scrolled
   ========================================================= */
(function injectHeaderScrollStyle() {
	const s = document.createElement('style');
	s.textContent = `.site-header.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,.12); }`;
	document.head.appendChild(s);
})();
