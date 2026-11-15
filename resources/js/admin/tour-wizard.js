const slugify = (value) => value
    .toString()
    .normalize('NFKD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '')
    .replace(/-{2,}/g, '-');

export function initTourWizard() {
    document.querySelectorAll('[data-wizard]').forEach((wizard) => {
        const form = wizard.closest('form');

        if (!form) {
            return;
        }

        const steps = [...wizard.querySelectorAll('[data-wizard-step]')];
        const gotoButtons = [...wizard.querySelectorAll('[data-wizard-goto]')];
        const backButton = wizard.querySelector('[data-wizard-back]');
        const nextButton = wizard.querySelector('[data-wizard-next]');
        const saveButton = wizard.querySelector('[data-wizard-save]');
        const progress = wizard.querySelector('[data-wizard-progress]');
        const counter = wizard.querySelector('[data-wizard-counter]');
        const total = steps.length;

        if (total === 0) {
            return;
        }

        let current = Number.parseInt(wizard.dataset.initialStep ?? '1', 10);

        if (!Number.isFinite(current) || current < 1 || current > total) {
            current = 1;
        }

        const setDisplay = (element, visible) => {
            if (element) {
                element.style.display = visible ? 'inline-flex' : 'none';
            }
        };

        const show = (step, options = {}) => {
            current = Math.min(Math.max(step, 1), total);

            steps.forEach((section, index) => {
                section.classList.toggle('hidden', index !== current - 1);
            });

            gotoButtons.forEach((button, index) => {
                const number = index + 1;

                button.dataset.state = number < current ? 'complete' : number === current ? 'current' : 'upcoming';
            });

            if (progress) {
                progress.style.width = `${(current / total) * 100}%`;
            }

            if (counter) {
                counter.textContent = `Step ${current} of ${total}`;
            }

            setDisplay(backButton, current > 1);
            setDisplay(nextButton, current < total);
            setDisplay(saveButton, current === total);

            if (options.scroll !== false) {
                wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        const stepFields = (step) => [...steps[step - 1].querySelectorAll('input, select, textarea')]
            .filter((field) => !field.disabled && field.type !== 'hidden');

        const firstInvalidField = () => {
            for (let index = 0; index < steps.length; index += 1) {
                const field = stepFields(index + 1).find((candidate) => !candidate.checkValidity());

                if (field) {
                    return { step: index + 1, field };
                }
            }

            return null;
        };

        const validateCurrentStep = () => {
            const field = stepFields(current).find((candidate) => !candidate.checkValidity());

            if (!field) {
                return true;
            }

            field.reportValidity();
            field.focus();

            return false;
        };

        nextButton?.addEventListener('click', () => {
            if (validateCurrentStep()) {
                show(current + 1);
            }
        });

        backButton?.addEventListener('click', () => show(current - 1));

        gotoButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const step = Number.parseInt(button.dataset.wizardGoto ?? '', 10);

                if (Number.isFinite(step)) {
                    show(step);
                }
            });
        });

        wizard.querySelectorAll('[data-wizard-error-step]').forEach((button) => {
            button.addEventListener('click', () => {
                const step = Number.parseInt(button.dataset.wizardErrorStep ?? '1', 10);
                show(Number.isFinite(step) ? step : 1);

                const fieldName = button.dataset.wizardErrorField;

                if (!fieldName) {
                    return;
                }

                const field = form.querySelector(`[name="${fieldName}"]`);
                field?.focus();
                field?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        form.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter' || event.target.tagName === 'TEXTAREA') {
                return;
            }

            if (event.target.closest('button, a')) {
                return;
            }

            if (current < total) {
                event.preventDefault();

                if (validateCurrentStep()) {
                    show(current + 1);
                }
            }
        });

        form.addEventListener('submit', (event) => {
            const invalid = firstInvalidField();

            if (!invalid) {
                return;
            }

            event.preventDefault();
            show(invalid.step);
            invalid.field.reportValidity();
            invalid.field.focus();
        });

        const nameInput = form.querySelector('[name="name"]');
        const slugInput = form.querySelector('[name="slug"]');

        if (nameInput && slugInput) {
            let manualSlug = slugInput.value.trim() !== '';

            slugInput.addEventListener('input', () => {
                manualSlug = slugInput.value.trim() !== '';
            });

            nameInput.addEventListener('input', () => {
                if (!manualSlug) {
                    slugInput.value = slugify(nameInput.value);
                }
            });
        }

        show(current, { scroll: false });
    });
}
