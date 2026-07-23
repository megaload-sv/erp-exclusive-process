(() => {
    'use strict';

    class TraceOpsTableContextMenu {
        constructor(container) {
            this.container = container;
            this.tableId = container.dataset.tableId || 'enterprise-table';
            this.menu = container.querySelector(`[data-table-context-menu][data-table-target="${CSS.escape(this.tableId)}"]`);
            this.activeRow = null;

            if (!this.menu) {
                return;
            }

            this.bindEvents();
        }

        bindEvents() {
            this.container.addEventListener('contextmenu', (event) => {
                const row = event.target instanceof Element ? event.target.closest('[data-table-row]') : null;
                if (!(row instanceof HTMLTableRowElement) || row.hidden) {
                    return;
                }

                event.preventDefault();
                this.open(row, event.clientX, event.clientY);
            });

            this.container.addEventListener('keydown', (event) => {
                const row = event.target instanceof Element ? event.target.closest('[data-table-row]') : null;

                if (event.key === 'Escape' && !this.menu.hidden) {
                    event.preventDefault();
                    this.close(true);
                    return;
                }

                if (!(row instanceof HTMLTableRowElement)) {
                    return;
                }

                if ((event.shiftKey && event.key === 'F10') || event.key === 'ContextMenu') {
                    event.preventDefault();
                    const rect = row.getBoundingClientRect();
                    this.open(row, rect.left + Math.min(rect.width / 2, 160), rect.top + Math.min(rect.height, 40));
                }
            });

            this.menu.addEventListener('click', (event) => {
                const action = event.target instanceof Element ? event.target.closest('[data-context-action]') : null;
                if (!(action instanceof HTMLButtonElement) || action.disabled || !this.activeRow) {
                    return;
                }

                const rowId = this.activeRow.dataset.rowId || '';
                const actionKey = action.dataset.contextAction || '';
                const hrefTemplate = action.dataset.contextHref || '';
                const href = hrefTemplate.replaceAll('{id}', encodeURIComponent(rowId));

                this.container.dispatchEvent(new CustomEvent('traceops:table-context-action', {
                    bubbles: true,
                    detail: { tableId: this.tableId, rowId, action: actionKey, href, row: this.activeRow },
                }));

                this.close(false);

                if (href) {
                    window.location.assign(href);
                }
            });

            document.addEventListener('pointerdown', (event) => {
                if (!this.menu.hidden && event.target instanceof Node && !this.menu.contains(event.target)) {
                    this.close(false);
                }
            });

            window.addEventListener('resize', () => this.close(false));
            window.addEventListener('scroll', () => this.close(false), true);
        }

        open(row, x, y) {
            this.close(false);
            this.activeRow = row;
            row.classList.add('has-context-menu');
            row.setAttribute('aria-expanded', 'true');

            this.menu.hidden = false;
            this.menu.style.left = '0px';
            this.menu.style.top = '0px';

            const rect = this.menu.getBoundingClientRect();
            const margin = 8;
            const left = Math.max(margin, Math.min(x, window.innerWidth - rect.width - margin));
            const top = Math.max(margin, Math.min(y, window.innerHeight - rect.height - margin));

            this.menu.style.left = `${left}px`;
            this.menu.style.top = `${top}px`;

            const firstAction = this.menu.querySelector('[data-context-action]:not(:disabled)');
            if (firstAction instanceof HTMLButtonElement) {
                firstAction.focus({ preventScroll: true });
            }
        }

        close(restoreFocus) {
            if (!this.menu || this.menu.hidden) {
                return;
            }

            this.menu.hidden = true;
            this.menu.style.left = '';
            this.menu.style.top = '';

            if (this.activeRow) {
                this.activeRow.classList.remove('has-context-menu');
                this.activeRow.removeAttribute('aria-expanded');
                if (restoreFocus) {
                    this.activeRow.focus({ preventScroll: true });
                }
            }

            this.activeRow = null;
        }
    }

    document.querySelectorAll('[data-table-container]').forEach((container) => {
        new TraceOpsTableContextMenu(container);
    });
})();
