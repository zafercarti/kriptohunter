    <!-- FOOTER -->
    <footer style="background: #0F1A2F; border-top: 1px solid rgba(255,255,255,0.1); padding: 40px 0; margin-top: 60px;">
        <div style="max-width: 1440px; margin: 0 auto; padding: 0 32px; text-align: center;">
            <p style="color: #8B9BB4; margin-bottom: 10px;">&copy; 2024 Kriptohunter.com - Tüm hakları saklıdır</p>
            <p style="color: #4A5A72; font-size: 13px;">İçerikler yakında yüklenecektir</p>
        </div>
    </footer>

    <!-- BASİT JAVASCRIPT -->
    <script>
        // Saat güncelleme
        function updateClock() {
            const clock = document.getElementById('live-clock');
            if (clock) {
                const now = new Date();
                clock.querySelector('span').textContent = 
                    now.getHours().toString().padStart(2,'0') + ':' + 
                    now.getMinutes().toString().padStart(2,'0');
            }
        }
        setInterval(updateClock, 1000);
        
        // Mobil menü
        document.querySelector('.mobile-menu-btn')?.addEventListener('click', function() {
            document.querySelector('.premium-nav').classList.toggle('active');
        });
    </script>
</body>
</html>