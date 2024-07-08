<?php
/**
* Marketplace
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
*  @author    FME Modules
*  @copyright 2020 fmemodules All right reserved
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  @category  FMM Modules
*  @package   Related Products
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_1_3($module)
{
    $module = $module;
    $context = Context::getContext();
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
    Configuration::deleteByName('quickgroupBox');

    Configuration::updateValue(
        'quickgroupBox',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKCSV_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICK_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKNEW_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKBEST_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKALL_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKSALE_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKADVANCE_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKTREE_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKHOOK1_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKHOOK2_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICKAJAX_ENABLE',
        1,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMNOOFROW',
        10,
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    Configuration::updateValue(
        'FMMQUICK_COLOR',
        'info',
        false,
        $context->shop->id_shop_group,
        $context->shop->id
    );
    
    return true;
}
