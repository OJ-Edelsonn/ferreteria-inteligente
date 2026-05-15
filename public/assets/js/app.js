document.querySelectorAll('input[type="search"]').forEach((input) => {
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            input.value = '';
        }
    });
});
