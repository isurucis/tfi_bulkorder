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

require_once _PS_MODULE_DIR_ . 'quickproducttable/lib/CSVReader.php';
require_once _PS_MODULE_DIR_ . 'quickproducttable/lib/Csv.php';
class QuickProductTableFmmQuickModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        if (isset($_FILES['quickcsv'])) {
            $this->readCsv();
            return 0;
        }
        $id_category = Tools::getValue('id_category');
        if (!$id_category) {
            $id_category = false;
        }
        $product_type = Tools::getValue('product_type');
        if (!($product_type == 'all' ||
            $product_type == 'best' ||
            $product_type == 'sale' ||
            $product_type == 'advance' ||
            $product_type == 'csv' ||
            $product_type == 'download' ||
            $product_type == 'new')
        ) {
            $product_type = 'all';
        }

        if ($product_type == 'advance') {
            $this->advanceSearch();
            return 0;
        }
        if ($product_type == 'csv') {
            $this->quickcsv();
            return 0;
        }
        $id_language = $this->context->language->id;
        $page_number = 0;
        $nb_products = null;
        $count = false;
        $order_by = 'id_product';
        $order_way = 'ASC';
        $start_no = 0;
        $limit = '18446744073709551615';
        $only_active = true;
        $beginning = false;
        $ending = false;

        if ($product_type == 'all') {
            $all_products = $this->getAllPro(
                $id_language,
                $start_no,
                $limit,
                $order_by,
                $order_way,
                $id_category,
                $only_active
            );
            $all_products = Product::getProductsProperties($id_language, $all_products);
        } elseif ($product_type == 'best') {
            $all_products = ProductSale::getBestSales(
                $id_language,
                $page_number,
                $nb_products,
                null,
                $order_way
            );
            $all_products = $this->getExtraFields($all_products);
        } elseif ($product_type == 'new') {
            $all_products = Product::getNewProducts(
                $id_language,
                $page_number,
                $nb_products,
                $count,
                $order_by,
                $order_way
            );
            $all_products = $this->getExtraFieldsNew($all_products);
        } elseif ($product_type == 'sale') {
            $all_products = Product::getPricesDrop(
                $id_language,
                $page_number,
                $nb_products,
                $count,
                $order_by,
                $order_way,
                $beginning,
                $ending
            );
            $all_products = $this->getExtraFields($all_products);
        }
        $all_products = $this->getProductDetails($all_products, $id_language);

        $ajax_url = $this->context->link->getModuleLink(
            'quickproducttable',
            'ajax',
            array('token' => md5(_COOKIE_KEY_))
        );
        $noofrow = (int) Configuration::get('FMMNOOFROW');
        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('ajax_url', $ajax_url);
        $lang = $this->context->language->id;
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        $cart_url = $this->context->link->getPageLink('cart', true, null);
        $this->context->smarty->assign('cart_url', $cart_url);

        $order_url = $this->context->link->getPageLink('order', true, null);
        $this->context->smarty->assign('order_url', $order_url);

        $this->context->smarty->assign('all_products', $all_products);
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        
        $this->context->smarty->assign('base_url', $base_url);
        $this->context->smarty->assign('noofrow', $noofrow);
        $this->context->smarty->assign('btn_clr', $btn_clr);
        $this->context->smarty->assign('route_name', $route_name);

        $quickgroupBox = Configuration::get('quickgroupBox');
        $arry = explode(',', $quickgroupBox);
        $current_grp = $this->context->customer->id_default_group;
        $in_ary = in_array($current_grp, $arry);

        $this->context->smarty->assign('in_ary', $in_ary);

        $quick_enable = Configuration::get('FMMQUICK_ENABLE');
        $new_enable = Configuration::get('FMMQUICKNEW_ENABLE');
        $best_enable = Configuration::get('FMMQUICKBEST_ENABLE');
        $all_enable = Configuration::get('FMMQUICKALL_ENABLE');
        $sale_enable = Configuration::get('FMMQUICKSALE_ENABLE');
        $advance_enable = Configuration::get('FMMQUICKADVANCE_ENABLE');
        $tree_enable = Configuration::get('FMMQUICKTREE_ENABLE');
        $csv_enable = Configuration::get('FMMQUICKCSV_ENABLE');
        $this->context->smarty->assign('quick_enable', $quick_enable);
        $this->context->smarty->assign('new_enable', $new_enable);
        $this->context->smarty->assign('best_enable', $best_enable);
        $this->context->smarty->assign('sale_enable', $sale_enable);
        $this->context->smarty->assign('advance_enable', $advance_enable);
        $this->context->smarty->assign('all_enable', $all_enable);
        $this->context->smarty->assign('tree_enable', $tree_enable);
        $this->context->smarty->assign('csv_enable', $csv_enable);
        $id_lang = $this->context->language->id;
        $this->context->smarty->assign('id_lang', $id_lang);
        
        $jquery_array = array();
        if (_PS_VERSION_ >= '8.0') {
            $folder = _PS_JS_DIR_ . 'jquery/';
            $component = '3.4.1';
            $file = 'jquery-' . $component . '.min.js';

            $jq_path = Media::getJSPath($folder . $file);
            $jquery_array[] = $jq_path;
            $this->context->smarty->assign([
                'jQuery_path' => $jquery_array[0],
            ]);
        } else {
            $jQuery_path = Media::getJqueryPath(_PS_JQUERY_VERSION_);
            if (is_array($jQuery_path) && isset($jQuery_path[0])) {
                $jQuery_path = $jQuery_path[0];
            }
            $this->context->smarty->assign(array('jQuery_path' => $jQuery_path));
        }



        $this->context->smarty->assign('product_type', $product_type);
        $this->context->smarty->assign('inview', $this->path . 'views/js/inview.js');

        foreach (Language::getLanguages() as $lang) {
            $head_name = Configuration::get('FMMQUICK_HEADNAME_' . (int) $lang['id_lang']);
            $this->context->smarty->assign('head_name_' . (int) $lang['id_lang'], $head_name);
        }
        $ajax_load = Configuration::get('FMMQUICKAJAX_ENABLE');
        
        $this->context->smarty->assign('ajax_load', $ajax_load);
        if (true == Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $this->setTemplate(
                'module:' . $this->module->name . '/views/templates/front/v1_7/fmmtable.tpl'
            );
        } else {
            return $this->setTemplate('v1_6/fmmtable.tpl');
        }
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->path = __PS_BASE_URI__.'modules/quickproducttable/';
        $page_name = Dispatcher::getInstance()->getController();
        if ($page_name == 'fmmquick') {
            $this->context->controller->addJS($this->path.'views/js/jquery.dataTables.min.js');
            $this->context->controller->addJS($this->path.'views/js/dataTables.rowReorder.min.js');
        
            $this->context->controller->addCSS($this->path . '/views/css/rowReorder.dataTables.min.css');
            $this->context->controller->addCSS($this->path . '/views/css/responsive.dataTables.min.css');
            $this->context->controller->addCSS($this->path . '/views/css/jquery.dataTables.min.css');
        }
    }

    public function getExtraFieldsNew($all_products)
    {
        if (empty($all_products)) {
            return $all_products = null;
        }

        $id_lang_default = $this->context->language->id;
        $range = '';
        $depth = Configuration::get('BLOCK_CATEG_MAX_DEPTH');

        $id_result = array();
        $parent_cat = array();
        $record = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite, c.active
            FROM `' . _DB_PREFIX_ . 'category` c
            INNER JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` =
                cl.`id_category` AND cl.`id_lang` = ' .
            (int) $id_lang_default . Shop::addSqlRestrictionOnLang('cl') . ')
            INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (cs.`id_category` =
                c.`id_category` AND cs.`id_shop` = ' . (int) $this->context->shop->id . ')
            WHERE (c.`active` = 1 OR c.`id_category` = ' .
            (int) Configuration::get('PS_HOME_CATEGORY') . ')
            AND c.`id_category` != ' . (int) Configuration::get('PS_ROOT_CATEGORY') . '
            ' . ((int) $depth != 0 ? ' AND `level_depth` <= ' . (int) $depth : '') . '
            ' . $range . '
            AND c.id_category IN (
                SELECT id_category
                FROM `' . _DB_PREFIX_ . 'category_group`
                WHERE `id_group` IN (' .
            pSQL(implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id))) . ')
            )
            ORDER BY `level_depth` ASC, ' .
            (Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`') . ' ' .
            (Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));

        foreach ($record as &$row) {
            $parent_cat[$row['id_parent']][] = &$row;
            $id_result[$row['id_category']] = &$row;
        }
        $category = new Category((int) Configuration::get('PS_HOME_CATEGORY'), $id_lang_default);
        $catTree = $this->categoriesTree(
            $parent_cat,
            $id_result,
            $depth,
            ($category ? $category->id : null)
        );
        $this->context->smarty->assign('catTree', $catTree);

        $imagesArray = array();
        $feat = array();

        foreach ($all_products as $k => $value) {
            foreach ($value['features'] as $key_fe => $value_fe) {
                $key_fe = $key_fe;
                $feat[] = $value_fe;
            }
            $all_products[$k]['features'] = $feat;

            unset($imagesArray);
            $id_product = $value['id_product'];
            $id_language = $this->context->language->id;
            $p = new Product($value['id_product'], false, $id_language);

            $id_image = Product::getCover($id_product);

            $image = new Image($id_image['id_image']);
            $cover = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
            $all_products[$k]['cover_image_url'] = $cover;
            $temp_images = $p->getImages((int) $this->context->language->id);

            foreach ($temp_images as $key => $we) {
                $key = $key;
                $image = new Image($we['id_image']);
                $image_url = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
                $imagesArray[] = $image_url;
            }

            $link = new Link();
            $url = $link->getProductLink($id_product);
            if (_PS_VERSION_ < 1.7) {
                $image_type = ImageType::getFormatedName('small');
            } else {
                $image_type = ImageType::getFormattedName('small');
            }
            //$image_type = ImageType::getFormattedName('small');
            $finalimg = $link->getImageLink(
                isset($p->link_rewrite) ? $p->link_rewrite : $p->name,
                (int) $id_image['id_image'],
                $image_type
            );
            $protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
            $all_products[$k]['cover_image_url'] = $protocol_link . $finalimg;

            if (empty($imagesArray)) {
                $imagesArray = '';
            }
            $stock_status = StockAvailable::outOfStock($id_product);
            $default_stock = Configuration::get('PS_ORDER_OUT_OF_STOCK');
            $default_stock = $default_stock;
            if ($stock_status == 2) {
                $stock_status = Configuration::get('PS_ORDER_OUT_OF_STOCK');
            }
            $all_products[$k]['order_status'] = $stock_status;
            $all_products[$k]['images_link'] = $imagesArray;
            $all_products[$k]['url'] = $url;
            $all_products[$k]['default_currency_sign'] = $this->context->currency->sign;
            $all_products[$k]['default_currency_iso_code'] = $this->context->currency->iso_code;
            $all_products[$k]['default_currency_name'] = $this->context->currency->name;
        }
        return $all_products;
    }

    public function getExtraFields($all_products)
    {
        if (empty($all_products)) {
            return $all_products = null;
        }

        $id_lang_default = $this->context->language->id;
        $range = '';
        $depth = Configuration::get('BLOCK_CATEG_MAX_DEPTH');

        $id_result = array();
        $parent_cat = array();
        $record = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite, c.active
            FROM `' . _DB_PREFIX_ . 'category` c
            INNER JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` =
                cl.`id_category` AND cl.`id_lang` = ' .
            (int) $id_lang_default . Shop::addSqlRestrictionOnLang('cl') . ')
            INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (cs.`id_category` =
                c.`id_category` AND cs.`id_shop` = ' . (int) $this->context->shop->id . ')
            WHERE (c.`active` = 1 OR c.`id_category` = ' .
            (int) Configuration::get('PS_HOME_CATEGORY') . ')
            AND c.`id_category` != ' . (int) Configuration::get('PS_ROOT_CATEGORY') . '
            ' . ((int) $depth != 0 ? ' AND `level_depth` <= ' . (int) $depth : '') . '
            ' . $range . '
            AND c.id_category IN (
                SELECT id_category
                FROM `' . _DB_PREFIX_ . 'category_group`
                WHERE `id_group` IN (' .
            pSQL(implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id))) . ')
            )
            ORDER BY `level_depth` ASC, ' .
            (Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`') . ' ' .
            (Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));

        foreach ($record as &$row) {
            $parent_cat[$row['id_parent']][] = &$row;
            $id_result[$row['id_category']] = &$row;
        }
        $category = new Category((int) Configuration::get('PS_HOME_CATEGORY'), $id_lang_default);
        $catTree = $this->categoriesTree(
            $parent_cat,
            $id_result,
            $depth,
            ($category ? $category->id : null)
        );
        $this->context->smarty->assign('catTree', $catTree);

        $imagesArray = array();
        
        foreach ($all_products as $k => $value) {
            unset($imagesArray);
            $id_product = $value['id_product'];
            $id_language = $this->context->language->id;
            $p = new Product($value['id_product'], false, $id_language);

            $id_image = Product::getCover($id_product);
            $image = new Image($id_image['id_image']);
            $cover = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
            $all_products[$k]['cover_image_url'] = $cover;
            $temp_images = $p->getImages((int) $this->context->language->id);

            foreach ($temp_images as $key => $we) {
                $key = $key;
                $image = new Image($we['id_image']);
                $image_url = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
                $imagesArray[] = $image_url;
            }

            $link = new Link();
            $url = $link->getProductLink($id_product);
            if (empty($imagesArray)) {
                $imagesArray = '';
            }
            if (_PS_VERSION_ < 1.7) {
                $image_type = ImageType::getFormatedName('small');
            } else {
                $image_type = ImageType::getFormattedName('small');
            }
            //$image_type = ImageType::getFormattedName('small');
            $finalimg = $link->getImageLink(
                isset($p->link_rewrite) ? $p->link_rewrite : $p->name,
                (int) $id_image['id_image'],
                $image_type
            );
            $protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
            $all_products[$k]['cover_image_url'] = $protocol_link . $finalimg;

            $stock_status = StockAvailable::outOfStock($id_product);
            // $p_qty = StockAvailable::getQuantityAvailableByProduct($id_product);
            // if ($p_qty < 1) {
            $default_stock = Configuration::get('PS_ORDER_OUT_OF_STOCK');
            $default_stock = $default_stock;
            if ($stock_status == 2) {
                $stock_status = Configuration::get('PS_ORDER_OUT_OF_STOCK');
            }
            $all_products[$k]['order_status'] = $stock_status;
            $all_products[$k]['images_link'] = $imagesArray;
            $all_products[$k]['url'] = $url;
            $all_products[$k]['default_currency_sign'] = $this->context->currency->sign;
            $all_products[$k]['default_currency_iso_code'] = $this->context->currency->iso_code;
            $all_products[$k]['default_currency_name'] = $this->context->currency->name;
        }
        return $all_products;
    }

    public function getAllPro(
        $id_lang,
        $start,
        $limit,
        $order_by,
        $order_way,
        $id_category = false,
        $only_active = false
    ) {
        $only_active = true;
        $context = Context::getContext();
        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        $id_lang_default = $this->context->language->id;
        $range = '';
        $depth = Configuration::get('BLOCK_CATEG_MAX_DEPTH');

        $id_result = array();
        $parent_cat = array();
        $record = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite, c.active
            FROM `' . _DB_PREFIX_ . 'category` c
            INNER JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` =
                cl.`id_category` AND cl.`id_lang` = ' .
            (int) $id_lang_default . Shop::addSqlRestrictionOnLang('cl') . ')
            INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (cs.`id_category` =
                c.`id_category` AND cs.`id_shop` = ' . (int) $this->context->shop->id . ')
            WHERE (c.`active` = 1 OR c.`id_category` = ' .
            (int) Configuration::get('PS_HOME_CATEGORY') . ')
            AND c.`id_category` != ' . (int) Configuration::get('PS_ROOT_CATEGORY') . '
            ' . ((int) $depth != 0 ? ' AND `level_depth` <= ' . (int) $depth : '') . '
            ' . $range . '
            AND c.id_category IN (
                SELECT id_category
                FROM `' . _DB_PREFIX_ . 'category_group`
                WHERE `id_group` IN (' .
            pSQL(implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id))) . ')
            )
            ORDER BY `level_depth` ASC, ' .
            (Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`') . ' ' .
            (Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));

        foreach ($record as &$row) {
            $parent_cat[$row['id_parent']][] = &$row;
            $id_result[$row['id_category']] = &$row;
        }
        $category = new Category((int) Configuration::get('PS_HOME_CATEGORY'), $id_lang_default);
        $catTree = $this->categoriesTree(
            $parent_cat,
            $id_result,
            $depth,
            ($category ? $category->id : null)
        );

        $this->context->smarty->assign('catTree', $catTree);


        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }
        if ($order_by == 'id_product' ||
            $order_by == 'price' ||
            $order_by == 'date_add' ||
            $order_by == 'date_upd') {
            $order_by_prefix = 'p';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        } elseif ($order_by == 'position') {
            $order_by_prefix = 'c';
        }
        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }
        $sql = 'SELECT p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name
                FROM `' . _DB_PREFIX_ . 'product` p
                ' . Shop::addSqlAssociation('product', 'p') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` ' .
        Shop::addSqlRestrictionOnLang('pl') . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
                LEFT JOIN `' . _DB_PREFIX_ . 'supplier` s ON (s.`id_supplier` = p.`id_supplier`)' .
        ($id_category ? 'LEFT JOIN `' . _DB_PREFIX_ .
            'category_product` c ON (c.`id_product` = p.`id_product`)' : '') . '
                WHERE pl.`id_lang` = ' . (int) $id_lang .
        ($id_category ? ' AND c.`id_category` = ' . (int) $id_category : '') .
        ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') .
        ($only_active ? ' AND product_shop.`active` = 1' : '') . '
                ORDER BY ' . (isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') .
        '`' . pSQL($order_by) . '` ' . pSQL($order_way) .
            ($limit > 0 ? ' LIMIT ' . (int) $start . ',' . (int) $limit : '');
        $rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($order_by == 'price') {
            Tools::orderbyPrice($rq, $order_way);
        }
        foreach ($rq as &$row) {
            $row = Product::getTaxesInformations($row);
        }
        

        $imagesArray = array();
        foreach ($rq as $k => $value) {
            unset($imagesArray);
            $id_product = $value['id_product'];
            $id_language = $this->context->language->id;
            $p = new Product($value['id_product'], false, $id_language);

            $id_image = Product::getCover($id_product);
            $image = new Image($id_image['id_image']);
            $cover = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
            $rq[$k]['cover_image_url'] = $cover;
            $temp_images = $p->getImages((int) $this->context->language->id);

            foreach ($temp_images as $key => $we) {
                $key = $key;
                $image = new Image($we['id_image']);
                $image_url = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
                $imagesArray[] = $image_url;
            }

            $link = new Link();
            $url = $link->getProductLink($id_product);
            if (_PS_VERSION_ < 1.7) {
                $image_type = ImageType::getFormatedName('small');
            } else {
                $image_type = ImageType::getFormattedName('small');
            }
            //$image_type = ImageType::getFormattedName('small');
            $finalimg = $link->getImageLink(
                isset($p->link_rewrite) ? $p->link_rewrite : $p->name,
                (int) $id_image['id_image'],
                $image_type
            );
            $protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
            $rq[$k]['cover_image_url'] = $protocol_link . $finalimg;

            if (empty($imagesArray)) {
                $imagesArray = '';
            }
            $stock_status = StockAvailable::outOfStock($id_product);
            $default_stock = Configuration::get('PS_ORDER_OUT_OF_STOCK');
            $default_stock = $default_stock;
            if ($stock_status == 2) {
                $stock_status = Configuration::get('PS_ORDER_OUT_OF_STOCK');
            }
            // $p_qty = StockAvailable::getQuantityAvailableByProduct($id_product);
            // if ($p_qty < 1) {

            $rq[$k]['order_status'] = $stock_status;
            $rq[$k]['images_link'] = $imagesArray;
            $rq[$k]['url'] = $url;
            $rq[$k]['default_currency_sign'] = $this->context->currency->sign;
            $rq[$k]['default_currency_iso_code'] = $this->context->currency->iso_code;
            $rq[$k]['default_currency_name'] = $this->context->currency->name;
        }

        return $rq;
    }

    public function getProductDetails($all_products, $id_language)
    {
        if (!$all_products) {
            return;
        }
        foreach ($all_products as $k => $value) {
            $combination = array();
            $id_product = $value['id_product'];
            //$p = new Product($id_product);
            $attributes_options = array();
            $attributes = $this->getAttrGroup($id_product, $id_language);
            if ($attributes['groups'] != null) {
                $key_index = 0;
                foreach ($attributes['groups'] as $id_group => $g_k_value) {
                    $item = array();
                    $attributes_options[$key_index]['name'] = $g_k_value['name'];
                    $attributes_options[$key_index]['group_id'] = $id_group;
                    foreach ($g_k_value['attributes'] as $key => $attributes_items) {
                        if ($g_k_value['group_type'] != 'color') {
                            $item[] = array(
                                'name' => $g_k_value['name'],
                                'id' => $key,
                                'value' => $attributes_items,
                            );
                        } else {
                            $color_code = '';
                            if (isset($attributes['colors'][$key]['value'])) {
                                $color_code = $attributes['colors'][$key]['value'];
                            }
                            $item[] = array(
                                'name' => $g_k_value['name'],
                                'id' => $key,
                                'value' => $attributes_items,
                                'code' => $color_code,
                            );
                        }
                    }
                    $attributes_options[$key_index]['values'] = $item;
                    $key_index++;
                }
            }
            if ($attributes['combinations'] != null) {
                $key_index = 0;
                foreach ($attributes['combinations'] as $id_attributs => $attribuuts) {
                    $combination[$key_index]['quantity'] = $attribuuts['quantity'];
                    $combination[$key_index]['price'] = $attribuuts['price'];
                    $combination[$key_index]['id_product_attribute'] = $id_attributs;
                    $listing_attr = '';

                    foreach ($attribuuts['attributes'] as $id_attribute) {
                        $listing_attr .= (int) $id_attribute . '_';
                    }
                    $combination[$key_index]['combination_code'] = $listing_attr;
                    $key_index++;
                }
            }

            $all_products[$k]['combinations'] = $combination;
            $all_products[$k]['options'] = $attributes_options;
        }

        return $all_products;
    }

    public function getAttrGroup($id_product, $id_language)
    {
        $group = array();
        $p = new Product($id_product);
        $color = array();
        $combination = array();
        $groups_attr = $p->getAttributesGroups($id_language);
        $return = $this->getProductKeyVal($color, $group, $combination, $groups_attr, $p);
        return $return;
    }

    public function makeArray($groups, $colors, $combination)
    {
        return array(
            'groups' => $groups,
            'colors' => $colors,
            'combinations' => $combination,
        );
    }

    public function getProductKeyVal($colors, $groups, $combination, $groups_attr, $p)
    {
        if (is_array($groups_attr) && $groups_attr) {
            foreach ($groups_attr as $key) {
                if (!isset($groups[$key['id_attribute_group']])) {
                    $groups[$key['id_attribute_group']] = array(
                        'group_name' => $key['group_name'],
                        'default' => -1,
                        'group_type' => $key['group_type'],
                        'name' => $key['group_name'],
                    );
                }
                if (isset($key['is_color_group'])
                    && $key['is_color_group']
                    && (isset($key['attribute_color']) && $key['attribute_color'])
                    || (file_exists(_PS_COL_IMG_DIR_ . $key['id_attribute'] . '.jpg'))) {
                    $colors[$key['id_attribute']]['name'] = $key['attribute_name'];
                    $colors[$key['id_attribute']]['value'] = $key['attribute_color'];

                    if (!isset($colors[$key['id_attribute']]['attributes_quantity'])) {
                        $colors[$key['id_attribute']]['attributes_quantity'] = 0;
                    }
                    $colors[$key['id_attribute']]['attributes_quantity'] =
                    $colors[$key['id_attribute']]['attributes_quantity'] + (int) $key['quantity'];
                }
                $combination[$key['id_product_attribute']]['attributes'][] =
                (int) $key['id_attribute'];

                $priceDisplay = Product::getTaxCalculationMethod(0);
                if (!$priceDisplay || $priceDisplay == 2) {
                    $combination_price = $p->getPrice(true, $key['id_product_attribute']);
                } else {
                    $combination_price = $p->getPrice(false, $key['id_product_attribute']);
                }

                $g_attr = $key['id_attribute_group'];

                $groups[$g_attr]['attributes'][$key['id_attribute']] = $key['attribute_name'];
                if ($key['default_on'] && $groups[$key['id_attribute_group']]['default'] == -1) {
                    $groups[$key['id_attribute_group']]['default'] = (int) $key['id_attribute'];
                }
                if (!isset($groups[$key['id_attribute_group']]['attributes_quantity'][$key['id_attribute']])) {
                    $groups[$key['id_attribute_group']]['attributes_quantity'][$key['id_attribute']] = 0;
                }
                $attr_idd = $key['id_attribute_group'];
                $groups[$attr_idd]['attributes_quantity'][$key['id_attribute']] =
                $groups[$attr_idd]['attributes_quantity'][$key['id_attribute']] + (int) $key['quantity'];

                $combination[$key['id_product_attribute']]['quantity'] = (int) $key['quantity'];
                $combination[$key['id_product_attribute']]['price'] = $combination_price;
                $combination[$key['id_product_attribute']]['minimal_quantity'] = (int) $key['minimal_quantity'];
            }
        }
        $array = $this->makeArray($groups, $colors, $combination);
        return $array;
    }

    public function advanceSearch()
    {
        if (!(int) Tools::getValue('id_language')) {
            $id_lang_default = $this->context->language->id;
        } else {
            $id_lang_default = Tools::getValue('id_language');
        }
        if ((int) Tools::getValue('id_currency')) {
            $id_currency = 1;
            $result = Currency::getCurrency($id_currency);

            $currency_obj = new Currency($id_currency);

            $this->context->currency->id = $id_currency;
            $this->context->currency->name = $result['name'];
            $this->context->currency->iso_code = $result['iso_code'];
            $this->context->currency->sign = $currency_obj->sign;
        }
        $range = '';
        $depth = Configuration::get('BLOCK_CATEG_MAX_DEPTH');

        $id_result = array();
        $parent_cat = array();
        $record = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite, c.active
            FROM `' . _DB_PREFIX_ . 'category` c
            INNER JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` =
                cl.`id_category` AND cl.`id_lang` = ' .
            (int) $id_lang_default . Shop::addSqlRestrictionOnLang('cl') . ')
            INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (cs.`id_category` =
                c.`id_category` AND cs.`id_shop` = ' . (int) $this->context->shop->id . ')
            WHERE (c.`active` = 1 OR c.`id_category` = ' .
            (int) Configuration::get('PS_HOME_CATEGORY') . ')
            AND c.`id_category` != ' . (int) Configuration::get('PS_ROOT_CATEGORY') . '
            ' . ((int) $depth != 0 ? ' AND `level_depth` <= ' . (int) $depth : '') . '
            ' . $range . '
            AND c.id_category IN (
                SELECT id_category
                FROM `' . _DB_PREFIX_ . 'category_group`
                WHERE `id_group` IN (' .
            pSQL(implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id))) . ')
            )
            ORDER BY `level_depth` ASC, ' .
            (Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`') . ' ' .
            (Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));

        foreach ($record as &$row) {
            $parent_cat[$row['id_parent']][] = &$row;
            $id_result[$row['id_category']] = &$row;
        }
        $id_lang_default = $this->context->language->id;
        $category = new Category((int) Configuration::get('PS_HOME_CATEGORY'), $id_lang_default);
        $catTree = $this->categoriesTree(
            $parent_cat,
            $id_result,
            $depth,
            ($category ? $category->id : null)
        );
        $this->context->smarty->assign('catTree', $catTree);

        $ajax_url = $this->context->link->getModuleLink(
            'quickproducttable',
            'ajax',
            array('token' => md5(_COOKIE_KEY_))
        );

        $this->context->smarty->assign('ajax_url', $ajax_url);

        $order_url = $this->context->link->getPageLink('order', true, null);
        $this->context->smarty->assign('order_url', $order_url);
        $cart_url = $this->context->link->getPageLink('cart', true, null);

        $this->context->smarty->assign('cart_url', $cart_url);
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        $this->context->smarty->assign('base_url', $base_url);
        $lang = $this->context->language->id;
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        $this->context->smarty->assign('route_name', $route_name);

        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('btn_clr', $btn_clr);

        $quickgroupBox = Configuration::get('quickgroupBox');
        $arry = explode(',', $quickgroupBox);
        $current_grp = $this->context->customer->id_default_group;
        $in_ary = in_array($current_grp, $arry);
        $this->context->smarty->assign('in_ary', $in_ary);

        $quick_enable = Configuration::get('FMMQUICK_ENABLE');
        $new_enable = Configuration::get('FMMQUICKNEW_ENABLE');
        $best_enable = Configuration::get('FMMQUICKBEST_ENABLE');
        $all_enable = Configuration::get('FMMQUICKALL_ENABLE');
        $sale_enable = Configuration::get('FMMQUICKSALE_ENABLE');
        $advance_enable = Configuration::get('FMMQUICKADVANCE_ENABLE');
        $tree_enable = Configuration::get('FMMQUICKTREE_ENABLE');
        $csv_enable = Configuration::get('FMMQUICKCSV_ENABLE');
        $this->context->smarty->assign('quick_enable', $quick_enable);
        $this->context->smarty->assign('new_enable', $new_enable);
        $this->context->smarty->assign('best_enable', $best_enable);
        $this->context->smarty->assign('sale_enable', $sale_enable);
        $this->context->smarty->assign('advance_enable', $advance_enable);
        $this->context->smarty->assign('all_enable', $all_enable);
        $this->context->smarty->assign('tree_enable', $tree_enable);
        $this->context->smarty->assign('csv_enable', $csv_enable);
        $id_lang = $this->context->language->id;
        $this->context->smarty->assign('id_lang', $id_lang);
        foreach (Language::getLanguages() as $lang) {
            $head_name = Configuration::get('FMMQUICK_HEADNAME_' . (int) $lang['id_lang']);
            $this->context->smarty->assign('head_name_' . (int) $lang['id_lang'], $head_name);
        }

        if (true == Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $this->setTemplate(
                'module:' . $this->module->name . '/views/templates/front/v1_7/fmmtable_advance.tpl'
            );
        } else {
            return $this->setTemplate('v1_6/fmmtable_advance.tpl');
        }
    }

    public function categoriesTree($parent_cat, $id_result, $depth, $id_category = null, $currentDepth = 0)
    {
        if (is_null($id_category)) {
            $id_category = $this->context->shop->getCategory();
        }
        $childs = array();
        if (isset($parent_cat[$id_category]) &&
            count($parent_cat[$id_category]) &&
            ($depth == 0 || $currentDepth < $depth)) {
            foreach ($parent_cat[$id_category] as $subcate) {
                $childs[] = $this->categoriesTree(
                    $parent_cat,
                    $id_result,
                    $depth,
                    $subcate['id_category'],
                    $currentDepth + 1
                );
            }
        }
        if (isset($id_result[$id_category])) {
            $name = $id_result[$id_category]['name'];
            $desc = $id_result[$id_category]['description'];
            $link = $this->context->link->getCategoryLink($id_category, $id_result[$id_category]['link_rewrite']);
            $image = $this->context->link->getCatImageLink(
                $id_result[$id_category]['link_rewrite'],
                $id_category
            );
        } else {
            $link = $name = $desc = $image = '';
        }

        $return = array(
            'id' => $id_category,
            'name' => $name,
            'desc' => $desc,
            'link' => $link,
            'image' => $image,
            'children' => $childs,
        );
        return $return;
    }

    public function quickcsv()
    {
        $quickgroupBox = Configuration::get('quickgroupBox');
        $arry = explode(',', $quickgroupBox);
        $current_grp = $this->context->customer->id_default_group;
        $in_ary = in_array($current_grp, $arry);
        $this->context->smarty->assign('in_ary', $in_ary);

        $quick_enable = Configuration::get('FMMQUICK_ENABLE');
        $new_enable = Configuration::get('FMMQUICKNEW_ENABLE');
        $best_enable = Configuration::get('FMMQUICKBEST_ENABLE');
        $all_enable = Configuration::get('FMMQUICKALL_ENABLE');
        $sale_enable = Configuration::get('FMMQUICKSALE_ENABLE');
        $advance_enable = Configuration::get('FMMQUICKADVANCE_ENABLE');
        $tree_enable = Configuration::get('FMMQUICKTREE_ENABLE');
        $csv_enable = Configuration::get('FMMQUICKCSV_ENABLE');
        $this->context->smarty->assign('quick_enable', $quick_enable);
        $this->context->smarty->assign('new_enable', $new_enable);
        $this->context->smarty->assign('best_enable', $best_enable);
        $this->context->smarty->assign('sale_enable', $sale_enable);
        $this->context->smarty->assign('advance_enable', $advance_enable);
        $this->context->smarty->assign('all_enable', $all_enable);
        $this->context->smarty->assign('csv_enable', $csv_enable);
        $this->context->smarty->assign('tree_enable', $tree_enable);

        $ajax_url = $this->context->link->getModuleLink(
            'quickproducttable',
            'ajax',
            array('token' => md5(_COOKIE_KEY_))
        );

        $this->context->smarty->assign('ajax_url', $ajax_url);

        $order_url = $this->context->link->getPageLink('order', true, null);
        $this->context->smarty->assign('order_url', $order_url);
        $cart_url = $this->context->link->getPageLink('cart', true, null);

        $this->context->smarty->assign('cart_url', $cart_url);
        $base_url = Tools::getHttpHost(true) . __PS_BASE_URI__;
        $this->context->smarty->assign('base_url', $base_url);
        $lang = $this->context->language->id;
        $route_name = Configuration::get('FMMQUICK_ROUTENAME_' . (int) $lang);
        $this->context->smarty->assign('route_name', $route_name);

        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('btn_clr', $btn_clr);

        foreach (Language::getLanguages() as $lang) {
            $head_name = Configuration::get('FMMQUICK_HEADNAME_' . (int) $lang['id_lang']);
            $this->context->smarty->assign('head_name_' . (int) $lang['id_lang'], $head_name);
        }
        $id_lang = $this->context->language->id;
        $this->context->smarty->assign('id_lang', $id_lang);
        if (true == Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $this->setTemplate(
                'module:' . $this->module->name . '/views/templates/front/v1_7/csv.tpl'
            );
        } else {
            return $this->setTemplate('v1_6/csv.tpl');
        }
    }

    public function readCsv()
    {
        $path = $_FILES['quickcsv']['name'];

        $file_tmp = $_FILES['quickcsv']['tmp_name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $count = 0;
        if (Tools::strtolower($ext) == 'csv') {
            move_uploaded_file($file_tmp, _PS_MODULE_DIR_ . "quickproducttable/csv/" . $path);
            $csvPath = _PS_MODULE_DIR_ . "quickproducttable/csv/" . $path;
            $csv = new Varien_File_Csv();
            $data = $csv->getData($csvPath);
            $csv = CsvReader::get($csvPath);
            $data = $csv->get_contents();
            foreach ($data as $key) {
                $reference = $key[0];
                $sql = new DbQuery();
                $sql->select('id_product');
                $sql->from('product');
                $sql->where('reference = "' . $reference . '"');
                $id_product = Db::getInstance()->getValue($sql);
                $qty = (int) $key[1];
                if (!$qty) {
                    $qty = 1;
                }
                $attr = $key[2];
                if (!$attr) {
                    $attr = null;
                }
                if ($id_product && $qty) {
                    $result = $this->addToCart($id_product, $qty, $attr);
                    if ($result) {
                        $count = $count + 1;
                    }
                }
            }
            unlink($csvPath);
        }
        $this->context->smarty->assign('count', $count);
        $this->quickcsv();
    }

    public function addToCart($id_product, $qty, $id_product_attribute)
    {
        $id_cart = $this->context->cart->id;

        if (!$id_cart) {
            $this->context->cart->id_currency = $this->context->currency->id;
            $this->context->cart->add();
            if ($this->context->cart->id) {
                $this->context->cookie->id_cart = (int) $this->context->cart->id;
                $id_cart = (int) $this->context->cart->id;
            }
        }

        $cart = new Cart($id_cart);
        $cart->updateQty($qty, $id_product, $id_product_attribute);

        return $cart->add();
    }
}
