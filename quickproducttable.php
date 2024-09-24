<?php
/**
 * 2007-2022 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2022 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Quickproducttable extends Module
{
    protected $config_form = false;
    public function __construct()
    {
        $this->name = 'quickproducttable';
        $this->tab = 'front_office_features';
        $this->version = '1.2.0';
        $this->author = 'FMM Modules';
        $this->need_instance = 1;

        $this->bootstrap = true;
        $this->controllers = array('fmmquick');
        parent::__construct();
        $this->module_key = '2a018763e6126b8733a3a3f96e4848e8';
        $this->author_address = '0xcC5e76A6182fa47eD831E43d80Cd0985a14BB095';
        $this->displayName = $this->l('Quick Product Table');
        $this->description = $this->l('list your products in a fully searchable and sortable table view for shopping.');

        $this->confirmUninstall = $this->l('Are You Sure?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        Configuration::updateValue(
            'quickgroupBox',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKCSV_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICK_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKNEW_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKBEST_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKALL_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKSALE_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKADVANCE_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKTREE_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKHOOK1_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKHOOK2_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICKAJAX_ENABLE',
            1,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMNOOFROW',
            10,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        Configuration::updateValue(
            'FMMQUICK_COLOR',
            'info',
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        return parent::install() &&
        $this->registerHook('header') &&
        $this->registerHook('leftColumn') &&
        $this->registerHook('rightColumn') &&
        $this->registerHook('displayBackOfficeHeader') &&
        $this->registerHook('ModuleRoutes');
    }

    public function uninstall()
    {
        Configuration::deleteByName('FMMQUICK_COLOR');
        Configuration::deleteByName('FMMQUICK_ENABLE');
        Configuration::deleteByName('FMMQUICKNEW_ENABLE');
        Configuration::deleteByName('FMMQUICKBEST_ENABLE');
        Configuration::deleteByName('FMMQUICKALL_ENABLE');
        Configuration::deleteByName('FMMQUICKSALE_ENABLE');
        Configuration::deleteByName('FMMQUICKADVANCE_ENABLE');
        Configuration::deleteByName('FMMQUICKTREE_ENABLE');
        Configuration::deleteByName('FMMQUICKCSV_ENABLE');
        Configuration::deleteByName('FMMNOOFROW');
        Configuration::deleteByName('FMMQUICKHOOK1_ENABLE');
        Configuration::deleteByName('FMMQUICKHOOK2_ENABLE');
        Configuration::deleteByName('FMMQUICKAJAX_ENABLE');
        return parent::uninstall();
    }

    public function updateMeta()
    {
        foreach (Language::getLanguages() as $lang) {
            $route = 'fmmquick';
            Configuration::updateValue(
                'FMMQUICK_ROUTENAME_' . (int) $lang['id_lang'],
                $route,
                false,
                $this->context->shop->id_shop_group,
                $this->context->shop->id
            );
            $meta = Meta::getMetaByPage('module-quickproducttable-fmmquick', (int) $lang['id_lang']);
            $id_meta = $meta['id_meta'];
            $fmm_url = new Meta($id_meta, (int) $lang['id_lang']);
            $url = $route;
            if (Validate::isLinkRewrite($url)) {
                $fmm_url->url_rewrite = $url;
                $fmm_url->update();
            }
        }
    }
    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */

        if (((bool) Tools::isSubmit('saveQuickConfiguration')) == true) {
            $this->postProcess();
            $this->context->smarty->assign('confirmation', 1);
        }
        $this->setVariable();

        $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

        return $output;
    }

    public function setVariable()
    {
        $quick_enable = Configuration::get(
            'FMMQUICK_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $quick_color = Configuration::get(
            'FMMQUICK_COLOR',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $new_enable = Configuration::get(
            'FMMQUICKNEW_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $best_enable = Configuration::get(
            'FMMQUICKBEST_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $all_enable = Configuration::get(
            'FMMQUICKALL_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $sale_enable = Configuration::get(
            'FMMQUICKSALE_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $advance_enable = Configuration::get(
            'FMMQUICKADVANCE_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $tree_enable = Configuration::get(
            'FMMQUICKTREE_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $csv_enable = Configuration::get(
            'FMMQUICKCSV_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $hook1_enable = Configuration::get(
            'FMMQUICKHOOK1_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $hook2_enable = Configuration::get(
            'FMMQUICKHOOK2_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $ajax_load = Configuration::get(
            'FMMQUICKAJAX_ENABLE',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
        $noofrow = Configuration::get(
            'FMMNOOFROW',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $groups = Group::getGroups($this->context->language->id, true);
        foreach (Language::getLanguages() as $lang) {
            $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang['id_lang']);
            $this->context->smarty->assign('route_name_' . (int) $lang['id_lang'], $route_name);
        }

        foreach (Language::getLanguages() as $lang) {
            $head_name = Configuration::get('FMMQUICK_HEADNAME_' . (int) $lang['id_lang']);
            $this->context->smarty->assign('head_name_' . (int) $lang['id_lang'], $head_name);
        }

        $approval_states = (Configuration::get(
            'quickgroupBox',
            null,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        ) ? explode(
            ',',
            Configuration::get('quickgroupBox', null, $this->context->shop->id_shop_group, $this->context->shop->id)
        ) : '');
        foreach ($groups as $key => $value) {
            $groups[$key]['select'] = 0;
            if (!isset($approval_states[$key])) {
                $approval_states[$key] = "0";
            }
            foreach ($approval_states as $sate) {
                if ($sate == $value['id_group']) {
                    $groups[$key]['select'] = 1;
                }
            }
        }
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        $this->context->smarty->assign('base_url', $base_url);
        $lang = $this->context->language->id;
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        $this->context->smarty->assign('route_name', $route_name);

        $this->context->smarty->assign('languages', $this->context->controller->getLanguages());
        $this->context->smarty->assign('defaultFormLanguage', (int) $this->context->employee->id_lang);
        $this->context->smarty->assign('quick_enable', $quick_enable);
        $this->context->smarty->assign('quick_color', $quick_color);
        $this->context->smarty->assign('groups', $groups);
        $this->context->smarty->assign('approval_states', $approval_states);
        $this->context->smarty->assign('new_enable', $new_enable);
        $this->context->smarty->assign('best_enable', $best_enable);
        $this->context->smarty->assign('all_enable', $all_enable);
        $this->context->smarty->assign('sale_enable', $sale_enable);
        $this->context->smarty->assign('advance_enable', $advance_enable);
        $this->context->smarty->assign('tree_enable', $tree_enable);
        $this->context->smarty->assign('csv_enable', $csv_enable);
        $this->context->smarty->assign('hook1_enable', $hook1_enable);
        $this->context->smarty->assign('hook2_enable', $hook2_enable);
        $this->context->smarty->assign('ajax_load', $ajax_load);
        $this->context->smarty->assign('noofrow', $noofrow);
        $this->context->smarty->assign('version', _PS_VERSION_);
        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign(
            'settings',
            _PS_MODULE_DIR_ . 'quickproducttable/views/templates/admin/settings.tpl'
        );
    }
    /**
     * Save form data.
     */
    protected function postProcess()
    {
        foreach (Language::getLanguages() as $lang) {
            $route = Tools::getValue('route_name_' . (int) $lang['id_lang']);
            if (!$route) {
                $route = 'fmmquick';
            }
            Configuration::updateValue(
                'FMMQUICK_ROUTENAME_' . (int) $lang['id_lang'],
                $route,
                false,
                $this->context->shop->id_shop_group,
                $this->context->shop->id
            );
            $meta = Meta::getMetaByPage('module-quickproducttable-fmmquick', (int) $lang['id_lang']);
            $id_meta = $meta['id_meta'];
            $fmm_url = new Meta($id_meta, (int) $lang['id_lang']);
            $url = Tools::getValue('route_name_' . (int) $lang['id_lang']);
            if (Validate::isLinkRewrite($url)) {
                $fmm_url->url_rewrite = $url;
                $fmm_url->update();
            }
        }

        foreach (Language::getLanguages() as $lang) {
            $route = Tools::getValue('head_name_' . (int) $lang['id_lang']);
            Configuration::updateValue(
                'FMMQUICK_HEADNAME_' . (int) $lang['id_lang'],
                pSQL($route),
                false,
                $this->context->shop->id_shop_group,
                $this->context->shop->id
            );
        }

        $approval_states = (Tools::getValue('groupBox')) ? implode(',', Tools::getValue('groupBox')) : '';
        Configuration::updateValue(
            'quickgroupBox',
            $approval_states,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $quick_enable = Tools::getValue('FMMQUICK_ENABLE');
        Configuration::updateValue(
            'FMMQUICK_ENABLE',
            (int) $quick_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $quick_color = Tools::getValue('FMMQUICK_COLOR');
        Configuration::updateValue(
            'FMMQUICK_COLOR',
            (string)$quick_color,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $new_enable = Tools::getValue('FMMQUICKNEW_ENABLE');
        Configuration::updateValue(
            'FMMQUICKNEW_ENABLE',
            (int) $new_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $best_enable = Tools::getValue('FMMQUICKBEST_ENABLE');
        Configuration::updateValue(
            'FMMQUICKBEST_ENABLE',
            (int) $best_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $all_enable = Tools::getValue('FMMQUICKALL_ENABLE');
        Configuration::updateValue(
            'FMMQUICKALL_ENABLE',
            (int) $all_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $sale_enable = Tools::getValue('FMMQUICKSALE_ENABLE');
        Configuration::updateValue(
            'FMMQUICKSALE_ENABLE',
            (int) $sale_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $advance_enable = Tools::getValue('FMMQUICKADVANCE_ENABLE');
        Configuration::updateValue(
            'FMMQUICKADVANCE_ENABLE',
            (int) $advance_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $tree_enable = Tools::getValue('FMMQUICKTREE_ENABLE');
        Configuration::updateValue(
            'FMMQUICKTREE_ENABLE',
            (int) $tree_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $csv_enable = Tools::getValue('FMMQUICKCSV_ENABLE');
        Configuration::updateValue(
            'FMMQUICKCSV_ENABLE',
            (int) $csv_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $hook2_enable = Tools::getValue('FMMQUICKHOOK2_ENABLE');
        Configuration::updateValue(
            'FMMQUICKHOOK2_ENABLE',
            (int) $hook2_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $ajax_load = Tools::getValue('FMMQUICKAJAX_ENABLE');
        Configuration::updateValue(
            'FMMQUICKAJAX_ENABLE',
            (int) $ajax_load,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $hook1_enable = Tools::getValue('FMMQUICKHOOK1_ENABLE');
        Configuration::updateValue(
            'FMMQUICKHOOK1_ENABLE',
            (int) $hook1_enable,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );

        $noofrow = Tools::getValue('FMMNOOFROW');
        Configuration::updateValue(
            'FMMNOOFROW',
            (int) $noofrow,
            false,
            $this->context->shop->id_shop_group,
            $this->context->shop->id
        );
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    public function hookLeftColumn()
    {
        $id_category = Tools::getValue('id_category');
        $hook1enable = Configuration::get('FMMQUICKHOOK1_ENABLE');
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        $this->context->smarty->assign('base_url', $base_url);
        $lang = $this->context->language->id;
        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('btn_clr', $btn_clr);
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        $this->context->smarty->assign('route_name', $route_name);
        $this->context->smarty->assign('id_category', $id_category);

        if ($hook1enable) {
            return $this->display(__FILE__, 'fmmhook.tpl');
        }
    }

    public function hookRightColumn()
    {
        $hook1enable = Configuration::get('FMMQUICKHOOK2_ENABLE');
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        $this->context->smarty->assign('base_url', $base_url);
        $lang = $this->context->language->id;
        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('btn_clr', $btn_clr);
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        $this->context->smarty->assign('route_name', $route_name);
        if ($hook1enable) {
            return $this->display(__FILE__, 'fmmhook.tpl');
        }
    }
    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $noofrow = (int) Configuration::get('FMMNOOFROW');
        if ($noofrow) {
            Media::addJsDef(array('noofrow' => $noofrow));
        } else {
            Media::addJsDef(array('noofrow' => 10));
        }
        $page_name = Dispatcher::getInstance()->getController();
        if ($page_name == 'fmmquick') {
            $this->context->controller->addJS($this->_path . '/views/js/front.js');
            $this->context->controller->addJS($this->_path . '/views/js/popupscript.js');
            $this->context->controller->addCSS($this->_path . '/views/css/front.css');
            //$this->context->controller->addCSS('https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap.css');
        }
    }

    public function hookModuleRoutes()
    {
        $lang = $this->context->language->id;
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        if ($route_name == '') {
            $route_name = 'fmmquick';
        }
        return array(
            'module-' . $this->name . '-fmmquick' => array(
                'controller' => 'fmmquick',
                'rule' => $route_name,
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => $this->name,
                ),
            ),
        );
    }
}
