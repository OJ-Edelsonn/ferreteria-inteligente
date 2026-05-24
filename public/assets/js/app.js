document.querySelectorAll('input[type="search"]').forEach((input) => {
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            input.value = '';
        }
    });
});

(() => {
    const products = window.quoteProducts;

    if (!Array.isArray(products)) {
        return;
    }

    const productMap = new Map(products.map((product) => [Number(product.id), product]));
    const cart = new Map();
    const searchInput = document.getElementById('quoteSearch');
    const categorySelect = document.getElementById('quoteCategory');
    const productList = document.getElementById('quoteProductList');
    const quoteItems = document.getElementById('quoteItems');
    const quoteTotal = document.getElementById('quoteTotal');
    const quoteForm = document.getElementById('quoteForm');

    function money(value) {
        return Number(value || 0).toFixed(2);
    }

    function filterProducts() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        const category = categorySelect?.value || '';

        productList?.querySelectorAll('.quote-product').forEach((card) => {
            const matchesText = card.dataset.name.includes(query);
            const matchesCategory = category === '' || card.dataset.category === category;
            card.style.display = matchesText && matchesCategory ? 'grid' : 'none';
        });
    }

    function addProduct(id) {
        const product = productMap.get(Number(id));

        if (!product) {
            return;
        }

        const current = cart.get(product.id) || { ...product, cantidad: 0 };
        if (current.cantidad < product.stock) {
            current.cantidad += 1;
        }
        cart.set(product.id, current);
        renderCart();
    }

    function changeQuantity(id, delta) {
        const item = cart.get(Number(id));

        if (!item) {
            return;
        }

        item.cantidad += delta;

        if (item.cantidad <= 0) {
            cart.delete(Number(id));
        } else {
            item.cantidad = Math.min(item.cantidad, item.stock);
            cart.set(Number(id), item);
        }

        renderCart();
    }

    function renderCart() {
        const items = Array.from(cart.values());
        const total = items.reduce((sum, item) => sum + item.precio * item.cantidad, 0);

        quoteTotal.textContent = money(total);

        if (items.length === 0) {
            quoteItems.innerHTML = '<p class="text-secondary mb-0">Agrega productos para calcular un total estimado.</p>';
            return;
        }

        quoteItems.innerHTML = items.map((item) => `
            <div class="quote-item">
                <div>
                    <strong>${item.nombre}</strong>
                    <span>S/ ${money(item.precio)} x ${item.cantidad}</span>
                </div>
                <div class="quote-item-actions">
                    <button type="button" data-qty="${item.id}" data-delta="-1">-</button>
                    <span>${item.cantidad}</span>
                    <button type="button" data-qty="${item.id}" data-delta="1">+</button>
                </div>
            </div>
        `).join('');
    }

    productList?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-add]');
        if (button) {
            addProduct(button.dataset.add);
        }
    });

    quoteItems?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-qty]');
        if (button) {
            changeQuantity(button.dataset.qty, Number(button.dataset.delta));
        }
    });

    searchInput?.addEventListener('input', filterProducts);
    categorySelect?.addEventListener('change', filterProducts);

    quoteForm?.addEventListener('submit', (event) => {
        event.preventDefault();

        const items = Array.from(cart.values());
        if (items.length === 0) {
            alert('Agrega al menos un producto para enviar la cotización.');
            return;
        }

        const name = document.getElementById('clientName').value.trim();
        const phone = document.getElementById('clientPhone').value.trim();
        const note = document.getElementById('clientNote').value.trim();
        const total = items.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
        const lines = items.map((item) => `- ${item.nombre} x ${item.cantidad}: S/ ${money(item.precio * item.cantidad)}`);
        const text = [
            `Hola, soy ${name} (${phone}). Quiero cotizar estos productos en J&S Ferretería:`,
            ...lines,
            `Total estimado: S/ ${money(total)}`,
            note ? `Comentario: ${note}` : '',
            'Por favor confirmar disponibilidad y entrega.'
        ].filter(Boolean).join('\n');

        window.open(`https://wa.me/${window.quoteWhatsapp}?text=${encodeURIComponent(text)}`, '_blank', 'noopener');
    });

    if (window.preselectedProduct) {
        addProduct(Number(window.preselectedProduct));
    }
})();
