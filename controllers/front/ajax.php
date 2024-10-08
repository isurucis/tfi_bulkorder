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

class QuickProductTableAjaxModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        $this->name = 'quickproducttable';
        parent::__construct();
        $this->context = Context::getContext();
        $this->display_column_left = false;
    }
    public function init()
    {
        parent::init();
        $this->ajax = (bool) Tools::getValue('ajax');
    }

    public function displayAjaxProductChangeAttr()
    {
        $id_product = (int) Tools::getValue('id_product');
        $id_attributes = Tools::getValue('group_aray');
        if (!is_array($id_attributes)) {
            $id_attributes = array();
            array_push($id_attributes, 0);
        }
        $id_product_attribute = Db::getInstance()->getValue('
        SELECT pac.`id_product_attribute`
        FROM `' . _DB_PREFIX_ . 'product_attribute_combination` pac
        INNER JOIN `' . _DB_PREFIX_ . 'product_attribute` pa ON pa.id_product_attribute = pac.id_product_attribute
        WHERE id_product = ' . (int) $id_product . ' AND id_attribute IN (' . implode(',', $id_attributes) . ')
        GROUP BY id_product_attribute
        HAVING COUNT(id_product) = ' . count($id_attributes));
        $price = Product::getPriceStatic($id_product, true, $id_product_attribute);
        // $id_lang = $this->context->language->id;
        // $id_shop = $this->context->shop->id;
        // $image_id = Image::getBestImageAttribute($id_shop, $id_lang, $id_product, $id_product_attribute);
        // $image_id = $image_id['id_image'];
        // $image = new Image($image_id);
        // $image_url = _PS_BASE_URL_ . _THEME_PROD_DIR_ . $image->getExistingImgPath() . ".jpg";
        // dump($image_url);
        $price = number_format($price, 2);
        $this->ajaxDie($price);
    }
    
    public function displayAjaxProductAddToCart()
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

        $id_product = (int) Tools::getValue('id_product');
        $qty = (int) Tools::getValue('qty');
        $id_attributes = Tools::getValue('group_aray');
        if (!is_array($id_attributes)) {
            $id_attributes = array();
            array_push($id_attributes, 0);
        }

        $id_product_attribute = Db::getInstance()->getValue('
        SELECT pac.`id_product_attribute`
        FROM `' . _DB_PREFIX_ . 'product_attribute_combination` pac
        INNER JOIN `' . _DB_PREFIX_ . 'product_attribute` pa ON pa.id_product_attribute = pac.id_product_attribute
        WHERE id_product = ' . (int) $id_product . ' AND id_attribute IN (' . implode(',', $id_attributes) . ')
        GROUP BY id_product_attribute
        HAVING COUNT(id_product) = ' . count($id_attributes));
        
        if (!$id_product_attribute && $id_attributes[0] > 0) {
            $this->ajaxDie(111);
        }
        $cart = new Cart($id_cart);
        $this->ajaxDie($cart->updateQty($qty, $id_product, $id_product_attribute));
    }

    public function displayAjaxProductAddToCartOne()
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
        $id_product = (int) Tools::getValue('id_product');
        $qty = (int) Tools::getValue('qty');
        $id_product_attribute = Tools::getValue('id_attr');

        $cart = new Cart($id_cart);
        

        $this->ajaxDie($cart->updateQty($qty, $id_product, $id_product_attribute));
    }

    public function displayAjaxGetSearchProducts()
    {
        $this->getSearchProducts();
        die();
    }

    protected function getSearchProducts()
    {
        $query = Tools::getValue('q', false);

        if (!$query || $query == '' || Tools::strlen($query) < 1) {
            die(json_encode($this->l('Found Nothing.')));
        }

        if ($pos = strpos($query, ' (ref:')) {
            $query = Tools::substr($query, 0, $pos);
        }

        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }

        $c_sql = new DbQuery();
        $c_sql->select('id_product');
        $c_sql->from('product_attribute');
        $combination_p = Db::getInstance()->executeS($c_sql);
        $combination_p = $combination_p;
        $dummy_arr = array();

        $excludeIds = implode(',', $dummy_arr);
        // Excluding downloadable products from packs because download from pack is not supported
        $forceJson = Tools::getValue('forceJson', false);
        $disableCombination = Tools::getValue('disableCombination', false);
        $excludeVirtuals = (bool) Tools::getValue('excludeVirtuals', true);
        $exclude_packs = (bool) Tools::getValue('exclude_packs', true);

        // $enable_pro = FmmBookingProductsModel::getAllEnableId();
        $enable_pro = 0;
        $context = Context::getContext();

        $category = Tools::getValue('cat');

        if (!$category) {
            $cat_sql = new DbQuery();
            $cat_sql->select('id_category');
            $cat_sql->from('category');
            $all_categories = Db::getInstance()->executeS($cat_sql);
            $all_category = array();
            foreach ($all_categories as $value) {
                array_push($all_category, $value['id_category']);
            }

            $category = implode(",", $all_category);
        }

        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, p.`price`, pl.`name`,
        image_shop.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
                FROM `' . _DB_PREFIX_ . 'product` p
                ' . Shop::addSqlAssociation('product', 'p') . '
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = '
        . (int) $context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
                    ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' .
        (int) $context->shop->id . ')
                LEFT JOIN `' . _DB_PREFIX_ .
                'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = ' .
        (int) $context->language->id . ')
                WHERE p.id_product NOT IN (' . $enable_pro . ') AND p.id_category_default IN (' . $category . ')
                AND (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\')' .
            (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
            ($excludeVirtuals ? 'AND NOT EXISTS (SELECT 1 FROM `' . _DB_PREFIX_ .
            'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
            ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
            ' GROUP BY p.id_product';

        $items = Db::getInstance()->executeS($sql);

        if ($items && ($disableCombination || $excludeIds)) {
            $results = array();
            foreach ($items as $item) {
                if (!$forceJson) {
                    $item['name'] = str_replace('|', '&#124;', $item['name']);
                    $results[] = trim($item['name']) . (!empty($item['reference']) ?
                        ' (ref: ' . $item['reference'] . ')' : '') . '|' . (int) $item['id_product'];
                } else {
                    $cover = Product::getCover($item['id_product']);
                    $results[] = array(
                        'id' => $item['id_product'],
                        'price' => $item['price'],
                        'name' => $item['name'] .
                        (!empty($item['reference']) ? ' (ref: ' . $item['reference'] . ')' : ''),
                        'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                        'image' => str_replace(
                            'http://',
                            Tools::getShopProtocol(),
                            $context->link->getImageLink(
                                $item['link_rewrite'],
                                (($item['id_image']) ? $item['id_image'] : $cover['id_image']),
                                $this->getFormatedName('home')
                            )
                        ),
                    );
                }
            }

            if (!$forceJson) {
                echo implode("\n", $results);
            } else {
                echo json_encode($results);
            }
        } elseif ($items) {
            // packs
            $results = array();
            foreach ($items as $item) {
                // check if product have combination
                if (Combination::isFeatureActive() && $item['cache_default_attribute']) {
                    $sql = 'SELECT
                    pa.`id_product_attribute`, pa.`reference`,pa.`price`, ag.`id_attribute_group`, pai.`id_image`,
                    agl.`name` AS group_name, al.`name` AS attribute_name,
                                a.`id_attribute`
                            FROM `' . _DB_PREFIX_ . 'product_attribute` pa
                            ' . Shop::addSqlAssociation('product_attribute', 'pa') . '
                            LEFT JOIN `' .
                            _DB_PREFIX_ . 'product_attribute_combination` pac ON pac.`id_product_attribute`
                            = pa.`id_product_attribute`
                            LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON a.`id_attribute` = pac.`id_attribute`
                            LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group` ag ON ag.`id_attribute_group` =
                            a.`id_attribute_group`
                            LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` al ON (a.`id_attribute` =
                             al.`id_attribute` AND al.`id_lang` = '
                    . (int) $context->language->id . ')
                            LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group_lang` agl ON (ag.`id_attribute_group` =
                                agl.`id_attribute_group` AND agl.`id_lang` = ' .
                    (int) $context->language->id . ')
                            LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_image` pai ON pai.`id_product_attribute` =
                            pa.`id_product_attribute`
                            WHERE pa.`id_product` = ' . (int) $item['id_product'] . '
                            GROUP BY pa.`id_product_attribute`, ag.`id_attribute_group`
                            ORDER BY pa.`id_product_attribute`';

                    $combinations = Db::getInstance()->executeS($sql);

                    if (!empty($combinations)) {
                        foreach ($combinations as $combination) {
                            $cover = Product::getCover($item['id_product']);
                            $results[$combination['id_product_attribute']]['id'] =
                                $item['id_product'];

                            $results[$combination['id_product_attribute']]['price'] =
                                $item['price'];

                            $results[$combination['id_product_attribute']]['id_product_attribute'] =
                                $combination['id_product_attribute'];
                            !empty($results[$combination['id_product_attribute']]['name']) ?
                            $results[$combination['id_product_attribute']]['name'] .=
                            ' ' . $combination['group_name'] . '-' . $combination['attribute_name']
                            : $results[$combination['id_product_attribute']]['name'] =
                                $item['name'] . ' ' . $combination['group_name'] . '-' . $combination['attribute_name'];
                            if (!empty($combination['reference'])) {
                                $results[$combination['id_product_attribute']]['ref'] =
                                    $combination['reference'];
                            } else {
                                $results[$combination['id_product_attribute']]['ref'] =
                                !empty($item['reference']) ? $item['reference'] : '';
                            }
                            if (empty($results[$combination['id_product_attribute']]['image'])) {
                                $results[$combination['id_product_attribute']]['image'] = str_replace(
                                    'http://',
                                    Tools::getShopProtocol(),
                                    $context->link->getImageLink(
                                        $item['link_rewrite'],
                                        (($combination['id_image']) ? $combination['id_image'] : $cover['id_image']),
                                        $this->getFormatedName('home')
                                    )
                                );
                            }
                        }
                    } else {
                        $results[] = array(
                            'id' => $item['id_product'],
                            'name' => $item['name'],
                            'price' => $item['price'],
                            'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                            'image' => str_replace(
                                'http://',
                                Tools::getShopProtocol(),
                                $context->link->getImageLink(
                                    $item['link_rewrite'],
                                    $item['id_image'],
                                    $this->getFormatedName('home')
                                )
                            ),
                        );
                    }
                } else {
                    $results[] = array(
                        'id' => $item['id_product'],
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                        'image' => str_replace(
                            'http://',
                            Tools::getShopProtocol(),
                            $context->link->getImageLink(
                                $item['link_rewrite'],
                                $item['id_image'],
                                $this->getFormatedName('home')
                            )
                        ),
                    );
                }
            }
            echo json_encode(array_values($results));
        } else {
            echo json_encode(array());
        }
    }

    public function displayAjaxProductChangeCategory()
    {
        $old_page =0;
        $lastItem =0;
        $product_type = Tools::getValue('product_type');
        $id_language = $this->context->language->id;
        $page_number = 0;
        $page_number = $page_number;
        $nb_products = null;
        $nb_products = $nb_products;
        $count = false;
        $order_by = 'id_product';
        $order_way = 'ASC';
        $start_no = 0;  // 1
        $limit = 999;
        $id_category = Tools::getValue('id_category');
        $id_country = Tools::getValue('id_country');
        $id_view = Tools::getValue('id_view');
        $only_active = true;
        $beginning = false;
        $ending = false;

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

        if ($product_type == 'all') {
            $all_products = $this->getAllPro(
                $id_language,
                $start_no,
                $limit,
                $order_by,
                $order_way,
                $id_category,
                $id_country,
                $id_view,
                $only_active
            );
            $all_products = Product::getProductsProperties($id_language, $all_products);
        } elseif ($product_type == 'best') {
            $all_products = ProductSale::getBestSales(
                $id_language,
                $old_page,
                $limit,
                null,
                $order_way
            );
            $all_products = $this->getExtraFields($all_products);
        } elseif ($product_type == 'new') {
            $all_products = Product::getNewProducts(
                $id_language,
                $old_page,
                $limit,
                $count,
                $order_by,
                $order_way
            );
            $all_products = $this->getExtraFieldsNew($all_products);
        } elseif ($product_type == 'sale') {
            $all_products = Product::getPricesDrop(
                $id_language,
                $lastItem,
                $limit,
                $count,
                $order_by,
                $order_way,
                $beginning,
                $ending
            );
            $all_products = $this->getExtraFields($all_products);
        }



        $all_products = $this->getProductDetails($all_products, $id_language);

        if ($product_type != 'all') {
            $final_array = array();
            foreach ($all_products as $key => $value) {
                if ($value['id_category_default'] == $id_category) {
                    $final_array[] = $value;
                }   
            }
        }
        

        
        if ($product_type != 'all') {
            $this->context->smarty->assign('all_products', $final_array);
        } else {
            $this->context->smarty->assign('all_products', $all_products);
        }
        
        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('btn_clr', $btn_clr);
        if (_PS_VERSION_ < 1.7) {
            $output =  $this->context->smarty->fetch(
                _PS_MODULE_DIR_ .'quickproducttable/views/templates/front/v1_6/ajax.tpl'
            );
        } else {
            $output =  $this->context->smarty->fetch(
                _PS_MODULE_DIR_ .'quickproducttable/views/templates/front/v1_7/ajax.tpl'
            );
        }
        echo $output;

    }
    
    public function getFormatedName($name)
    {
        $theme_name = Context::getContext()->shop->theme_name;
        $name_without_theme_name = str_replace(array('_' . $theme_name, $theme_name . '_'), '', $name);
        //check if the theme name is already in $name if yes only return $name
        if (strstr($name, $theme_name) && ImageType::getByNameNType($name, 'products')) {
            return $name;
        } elseif (ImageType::getByNameNType($name_without_theme_name . '_' . $theme_name, 'products')) {
            return $name_without_theme_name . '_' . $theme_name;
        } elseif (ImageType::getByNameNType($theme_name . '_' . $name_without_theme_name, 'products')) {
            return $theme_name . '_' . $name_without_theme_name;
        } else {
            return $name_without_theme_name . '_default';
        }
    }

    public function displayAjaxProductSku()
    {
        $texta = Tools::getValue('texta');
        $texta = explode("\n", $texta);
        $count = 0;
        foreach ($texta as $line) {
            $row = explode(",", $line);
            $reference = $row[0];

            if (isset($row[2])) {
                $attr = $row[2];
            } else {
                $attr = null;
            }
            if (isset($row[1])) {
                $qty = $row[1];
            } else {
                $qty = 1;
            }
            $sql = new DbQuery();
            $sql->select('id_product');
            $sql->from('product');
            $sql->where('reference = "' . $reference . '"');
            $id_product = Db::getInstance()->getValue($sql);

            if ($id_product && $qty && $reference) {
                $result = $this->addToCart($id_product, $qty, $attr);
                if ($result) {
                    $count = $count + 1;
                }
            }
        }
        echo json_encode($count);
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

    public function displayAjaxProductChangeLength()
    {
        $lastItem = Tools::getValue('lastItem');
        $noofrow = Tools::getValue('noofrow');
        $product_type = Tools::getValue('product_type');
        $old_page = Tools::getValue('old_page');
        $id_language = $this->context->language->id;
        $page_number = 0;
        $page_number = $page_number;
        $nb_products = null;
        $nb_products = $nb_products;
        $count = false;
        $order_by = 'id_product';
        $order_way = 'ASC';
        $start_no = $lastItem;
        $limit = $noofrow;
        $id_category = false;
        $only_active = true;
        $beginning = false;
        $ending = false;
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
                $old_page,
                $limit,
                null,
                $order_way
            );
            $all_products = $this->getExtraFields($all_products);
        } elseif ($product_type == 'new') {
            $all_products = Product::getNewProducts(
                $id_language,
                $old_page,
                $limit,
                $count,
                $order_by,
                $order_way
            );
            $all_products = $this->getExtraFieldsNew($all_products);
        } elseif ($product_type == 'sale') {
            $all_products = Product::getPricesDrop(
                $id_language,
                $lastItem,
                $limit,
                $count,
                $order_by,
                $order_way,
                $beginning,
                $ending
            );
            $all_products = $this->getExtraFields($all_products);
        }

        
        $all_products = $this->getProductDetails($all_products, $id_language);
        if (!$all_products) {
            echo 2;
            exit();
        }
        $this->context->smarty->assign('all_products', $all_products);
        $btn_clr = Configuration::get('FMMQUICK_COLOR');
        $this->context->smarty->assign('btn_clr', $btn_clr);
        if (_PS_VERSION_ < 1.7) {
            $output =  $this->context->smarty->fetch(
                _PS_MODULE_DIR_ .'quickproducttable/views/templates/front/v1_6/ajax.tpl'
            );
        } else {
            $output =  $this->context->smarty->fetch(
                _PS_MODULE_DIR_ .'quickproducttable/views/templates/front/v1_7/ajax.tpl'
            );
        }
        

        echo $output;
    }

    public function getAllPro(
        $id_lang,
        $start,
        $limit,
        $order_by,
        $order_way,
        $id_category = false,
        $id_country = "0",
        $id_view = "0",
        $only_active = false
    ) {
        $only_active = true;
        $context = Context::getContext();
        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

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
                LEFT JOIN `' . _DB_PREFIX_ . 'supplier` s ON (s.`id_supplier` = p.`id_supplier`)
                LEFT JOIN `' . _DB_PREFIX_ . 'feature_product` fp ON (p.`id_product` = fp.`id_product`)' .
        ($id_category ? 'LEFT JOIN `' . _DB_PREFIX_ .
            'category_product` c ON (c.`id_product` = p.`id_product`)' : '') . '
                WHERE pl.`id_lang` = ' . (int) $id_lang .
        ($id_category ? ' AND c.`id_category` = ' . (int) $id_category : '') .
        ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '') .
        ($only_active ? ' AND product_shop.`active` = 1' : '') .
        ($id_country!="0" ? ' AND fp.`id_feature_value` = '. $id_country : '') . 
            ' GROUP BY p.id_product  
            ORDER BY ' . (isset($order_by_prefix) ? pSQL($order_by_prefix) . '.' : '') .
        '`' . pSQL($order_by) . '` ' . pSQL($order_way) .
            ($limit > 0 ? ' LIMIT ' . (int) $start . ',' . (int) $limit : '');
        $rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        //echo $sql;

        $category = new Category($id_category);

        //$rq = $category->getProducts($this->context->language->id, $start,$limit);
        
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
        //$rq['sqlquery'] = $sql;
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

    public function makeArray($groups, $colors, $combination)
    {
        return array(
            'groups' => $groups,
            'colors' => $colors,
            'combinations' => $combination,
        );
    }

    public function getExtraFieldsNew($all_products)
    {
        if (empty($all_products)) {
            return $all_products = null;
        }
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
}
