<?php

declare(strict_types=1);
/**
 * 2025 Umarex-France
 * NOTICE DE LICENCE
 * Ce fichier source est la propriété exclusive de Umarex-France.
 * Il est strictement interdit de le copier, modifier, distribuer ou utiliser
 * sans l'autorisation écrite préalable de Umarex-France.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/*
 * Module UX Custom BackOffice
 *
 * Personnalise légèrement l'apparence du BackOffice (logo, couleurs, etc.)
 */
final class ux_custom_bo extends Module
{
    /*
     * Liste des hooks utilisés par le module
     */
    private const HOOKS = [
        'displayBackOfficeHeader',
    ];
    // ------------

    /**
     * Constructeur du module
     */
    public function __construct()
    {
        $this->name          = 'ux_custom_bo';
        $this->displayName   = 'UX Custom BackOffice';
        $this->tab           = 'administration';
        $this->version       = '1.0.0';
        $this->author        = 'Umarex-France';
        $this->bootstrap     = true;
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName            = $this->trans('UX Custom BO', [], 'Modules.Ux_custom_bo.Admin');
        $this->description            = $this->trans('Personnalise légèrement le BackOffice.', [], 'Modules.Ux_custom_bo.Admin');
        $this->ps_versions_compliancy = [
            'min' => '9.0.0',
            'max' => _PS_VERSION_,
        ];
    }
    // ------------

    /**
     * Active le système de traduction moderne
     *
     * @return bool
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
    // ------------

    /**
     * Installation du module
     *
     * @return bool
     */
    public function install(): bool
    {
        return
            parent::install()
            && $this->registerHook(self::HOOKS);
    }
    // ------------

    /**
     * Désinstallation du module
     *
     * @return bool
     */
    public function uninstall(): bool
    {
        foreach (self::HOOKS as $hook) {
            $this->unregisterHook($hook);
        }

        return parent::uninstall();
    }
    // ------------

    /**
     * Injection du CSS dans le BackOffice via le hook displayBackOfficeHeader
     *
     * @return void
     */
    public function hookDisplayBackOfficeHeader(): void
    {
        $this->context->controller->addCSS(
            '/modules/' . $this->name . '/views/css/admin.css',
            'all'
        );
    }
    // ------------
}
