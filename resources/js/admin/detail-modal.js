export function initDetailModals() {
    const dialogs = [...document.querySelectorAll('dialog[data-modal]')];

    if (dialogs.length === 0) {
        return;
    }

    const loadingMarkup = new Map();

    dialogs.forEach((dialog) => {
        const body = dialog.querySelector('[data-modal-body]');

        if (body) {
            loadingMarkup.set(dialog, body.innerHTML);
        }
    });

    document.addEventListener('click', async (event) => {
        const closeTrigger = event.target.closest('[data-modal-close]');

        if (closeTrigger) {
            closeTrigger.closest('dialog')?.close();

            return;
        }

        const trigger = event.target.closest('[data-modal-url]');

        if (!trigger) {
            return;
        }

        const dialog = document.getElementById(trigger.dataset.modalTarget);

        if (!dialog) {
            return;
        }

        const body = dialog.querySelector('[data-modal-body]');
        const title = dialog.querySelector('[data-modal-title]');

        if (!body) {
            return;
        }

        event.preventDefault();

        body.innerHTML = loadingMarkup.get(dialog) ?? '';

        if (title) {
            title.textContent = trigger.dataset.modalTitle || 'Tour details';
        }

        dialog.dataset.requestId = String((Number(dialog.dataset.requestId) || 0) + 1);
        const requestId = dialog.dataset.requestId;

        if (!dialog.open) {
            dialog.showModal();
            document.body.classList.add('overflow-hidden');
        }

        try {
            const response = await fetch(trigger.dataset.modalUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'text/html',
                },
            });

            if (dialog.dataset.requestId !== requestId || !dialog.open) {
                return;
            }

            if (!response.ok) {
                throw new Error(`Request failed with status ${response.status}`);
            }

            body.innerHTML = await response.text();
        } catch {
            if (dialog.dataset.requestId !== requestId || !dialog.open) {
                return;
            }

            body.innerHTML = `
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Unable to load the tour details. Please close this dialog and try again.
                </div>
            `;
        }
    });

    dialogs.forEach((dialog) => {
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });

        dialog.addEventListener('close', () => {
            document.body.classList.remove('overflow-hidden');
        });
    });
}
