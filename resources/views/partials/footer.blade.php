<footer class="site-footer">
    <div class="site-footer-inner">
        <div class="site-footer-brand">
            <a class="footer-brand-lockup" href="{{ route('home') }}" aria-label="Pixel Code - Inicio">
                <span class="brand-symbol" aria-hidden="true"><span>&lt;</span><span>/</span><span>&gt;</span></span>
                <span>Pixel Code</span>
            </a>
            <p>Construimos el futuro con software.</p>
            <a class="footer-whatsapp-link" href="https://wa.me/51989971620" target="_blank" rel="noopener noreferrer">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.3a8.5 8.5 0 0 1-12.6 7.4L3.5 20l1.4-4.2A8.5 8.5 0 1 1 20.5 11.3Z"></path><path d="M8.6 8.2c.2-.3.4-.3.7-.3h.4c.2 0 .4.1.5.4l.6 1.4c.1.2.1.4 0 .6l-.4.5c-.1.2-.2.3 0 .5.3.5 1.2 1.8 2.8 2.5.2.1.4.1.5-.1l.6-.7c.1-.2.3-.2.5-.1l1.4.7c.2.1.3.3.2.5-.1.5-.5 1.1-.9 1.3-.4.2-1 .3-1.7.1-.7-.2-2.1-.8-3.4-2.1-1.1-1.1-1.8-2.4-2-3.1-.2-.7-.1-1.5.2-2.1Z"></path></svg>
                +51 989 971 620
            </a>
        </div>

        <div class="site-footer-contact">
            <div class="footer-socials" aria-label="Redes y contacto">
                <a href="https://wa.me/51989971620" target="_blank" rel="noopener noreferrer" aria-label="Contactar por WhatsApp" title="Contactar por WhatsApp">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.3a8.5 8.5 0 0 1-12.6 7.4L3.5 20l1.4-4.2A8.5 8.5 0 1 1 20.5 11.3Z"></path><path d="M8.6 8.2c.2-.3.4-.3.7-.3h.4c.2 0 .4.1.5.4l.6 1.4c.1.2.1.4 0 .6l-.4.5c-.1.2-.2.3 0 .5.3.5 1.2 1.8 2.8 2.5.2.1.4.1.5-.1l.6-.7c.1-.2.3-.2.5-.1l1.4.7c.2.1.3.3.2.5-.1.5-.5 1.1-.9 1.3-.4.2-1 .3-1.7.1-.7-.2-2.1-.8-3.4-2.1-1.1-1.1-1.8-2.4-2-3.1-.2-.7-.1-1.5.2-2.1Z"></path></svg>
                </a>
                <a href="{{ route('contacto') }}" aria-label="Ver información de contacto" title="Información de contacto">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m4 7 8 6 8-6"></path></svg>
                </a>
            </div>
            <p>Asesoría personalizada para cada proyecto.</p>
        </div>

        <div class="site-footer-legal">
            <p>&copy; {{ date('Y') }} Pixel Code</p>
            <p>Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
