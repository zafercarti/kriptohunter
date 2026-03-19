// Header veri şeridi için veri çek
async function fetchDataStrip() {
    try {
        const response = await fetch('/api/header-data.php');
        const data = await response.json();
        updateDataStrip(data);
    } catch (error) {
        console.error('Data strip hatası:', error);
    }
}

// Data strip'i güncelle
function updateDataStrip(data) {
    const strip = document.getElementById('data-strip-items');
    if (!strip) return;

    const items = [];

    // USD/TRY
    if (data.USDTRY) {
        items.push(createStripItem('USD/TRY', data.USDTRY.c, data.USDTRY.cp));
    }

    // EUR/TRY
    if (data.EURTRY) {
        items.push(createStripItem('EUR/TRY', data.EURTRY.c, data.EURTRY.cp));
    }

    // GBP/TRY
    if (data.GBPTRY) {
        items.push(createStripItem('GBP/TRY', data.GBPTRY.c, data.GBPTRY.cp));
    }

    // ONS ALTIN
    if (data.XAUUSD) {
        items.push(createStripItem('ONS ALTIN', data.XAUUSD.c, data.XAUUSD.cp, '$', true));
    }

    // GRAM ALTIN
    if (data.GRAM_ALTIN) {
        items.push(createStripItem('GRAM ALTIN', data.GRAM_ALTIN.c, data.GRAM_ALTIN.cp, '₺'));
    }

    // GRAM GÜMÜŞ
    if (data.GRAM_GUMUS) {
        items.push(createStripItem('GRAM GÜMÜŞ', data.GRAM_GUMUS.c, data.GRAM_GUMUS.cp, '₺'));
    }

    // BRENT
    if (data.BRENT) {
        items.push(createStripItem('BRENT', data.BRENT.c, data.BRENT.cp, '$'));
    }

    strip.innerHTML = items.join('');
}

// Strip item oluştur
function createStripItem(symbol, price, change, currency = '', isUSD = false) {
    const priceNum = parseFloat(price).toFixed(2);
    const changeNum = parseFloat(change).toFixed(2);
    const changeClass = changeNum >= 0 ? 'positive' : 'negative';
    const changeSymbol = changeNum >= 0 ? '▲' : '▼';
    
    return `
        <div class="strip-item">
            <span class="item-symbol">${symbol}</span>
            <span class="item-value">${priceNum}${currency ? ' ' + currency : ''}</span>
            <span class="item-change ${changeClass}">${changeSymbol} ${Math.abs(changeNum)}%</span>
        </div>
    `;
}

// Saati güncelle
function updateClock() {
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        const now = new Date();
        timeElement.textContent = now.toLocaleTimeString('tr-TR', { hour12: false });
    }
}

// Sayfa yüklendiğinde
document.addEventListener('DOMContentLoaded', () => {
    fetchDataStrip();
    updateClock();
    
    // Her 10 saniyede verileri güncelle
    setInterval(() => {
        fetchDataStrip();
        updateClock();
    }, 10000);
    
    // Ana verileri çek
    fetchMarketData();
    setInterval(fetchMarketData, 30000);
});

// Manuel yenileme
document.querySelector('[data-refresh]')?.addEventListener('click', () => {
    fetchDataStrip();
    fetchMarketData();
});