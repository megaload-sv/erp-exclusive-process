<?php

/**
 * Deliberately incomplete and malformed configurations.
 *
 * This catalog section acts as a visual smoke test: every component must
 * normalize optional input and render without PHP warnings or fatal errors.
 */
?>
<div class="to-catalog-grid" aria-label="Pruebas de robustez de componentes">
    <article class="to-card">
        <header class="to-card__header">
            <h3>Acciones y estados</h3>
        </header>
        <div class="to-card__body">
            <div class="to-component-preview">
                <?= view('components/ui/button', []) ?>
                <?= view('components/ui/button', ['label' => 'Variante inválida', 'variant' => 'unknown']) ?>
                <?= view('components/ui/badge', []) ?>
                <?= view('components/ui/badge', ['label' => 'Fallback', 'variant' => 'unknown']) ?>
            </div>
        </div>
    </article>

    <article class="to-card">
        <header class="to-card__header">
            <h3>Campos incompletos</h3>
        </header>
        <div class="to-card__body">
            <div class="to-form">
                <?= view('components/ui/input', ['name' => 'hardening_input']) ?>
                <?= view('components/ui/textarea', ['name' => 'hardening_textarea', 'rows' => 0]) ?>
                <?= view('components/ui/select', [
                    'name' => 'hardening_select',
                    'options' => ['valid' => 'Opción válida', 'invalid' => ['ignored']],
                ]) ?>
            </div>
        </div>
    </article>

    <article class="to-card">
        <header class="to-card__header">
            <h3>Controles incompletos</h3>
        </header>
        <div class="to-card__body">
            <div class="to-form">
                <?= view('components/ui/checkbox', ['name' => 'hardening_checkbox']) ?>
                <?= view('components/ui/radio-group', [
                    'name' => 'hardening_radio',
                    'options' => ['safe' => 'Opción segura', 'invalid' => ['ignored']],
                ]) ?>
                <?= view('components/ui/switch', ['name' => 'hardening_switch']) ?>
            </div>
        </div>
    </article>
</div>
