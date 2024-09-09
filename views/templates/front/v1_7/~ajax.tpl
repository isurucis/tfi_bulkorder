{*
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
*}

        {foreach from=$all_products item=product name=product}
            <tr>
                <td><a href="{$product.link|escape:'htmlall':'UTF-8'}"> <img src="{$product.cover_image_url|escape:'htmlall':'UTF-8'}"></a> </td>
                <td>{$product.reference|escape:'htmlall':'UTF-8'}</td>
                <td>
                    <a href="{$product.link|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a>
                    <div>
                    {assign var="group_count" value=0}
                    {foreach from=$product.options item=options name=options}
                        {$options.name|escape:'htmlall':'UTF-8'}
                        {assign var="group_count" value={$group_count|escape:'htmlall':'UTF-8'}+1}
                        
                        <select id="select_fmm" onchange="changeAttr({$product.id_product|escape:'htmlall':'UTF-8'}, {$group_count|escape:'htmlall':'UTF-8'})" class="fmm_option_{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}">
                            {foreach from=$options.values item=values name=values}

                                <option value="{$values.id|escape:'htmlall':'UTF-8'}">{$values.value|escape:'htmlall':'UTF-8'}</option>

                            {/foreach}
                        </select> 
                        
                    {/foreach}
                    </div>
                    {foreach from=$product.features item=feature name=features}
                    {if $feature.id_feature == 3}
                    <span>
                    {$feature.value|escape:'htmlall':'UTF-8'}
                    </span>
                    {/if}
                    {if $feature.id_feature ==9}
                    <span>
                    {$feature.value|escape:'htmlall':'UTF-8'}
                    </span>
                    {/if}
                    {foreachelse}
                    {/foreach}
                </td>
                
                <td data-label="Size">
                {foreach from=$product.features item=feature name=features}
                    {if $feature.id_feature == 4}
                    <span>
                    {$feature.value|escape:'htmlall':'UTF-8'}
                    </span>
                    {/if}
                {foreachelse}
                {/foreach}
                </td>
                
                
                <td data-label="Bag per Box">
                {foreach from=$product.features item=feature name=features}
                    {if $feature.id_feature == 6}
                    <span>
                    {$feature.value|escape:'htmlall':'UTF-8'}
                    </span>
                    {/if}
                {foreachelse}
                {/foreach}
                </td>

                <td data-label="Qty per Bag">
                {foreach from=$product.features item=feature name=features}
                    {if $feature.id_feature == 7}
                    <span>
                    {$feature.value|escape:'htmlall':'UTF-8'}
                    </span>
                    {/if}
                {foreachelse}
                {/foreach}
                </td>

                <td data-label="Qty per Box">
                {foreach from=$product.features item=feature name=features}
                    {if $feature.id_feature == 8}
                    <span>
                    {$feature.value|escape:'htmlall':'UTF-8'}
                    </span>
                    {/if}
                {foreachelse}
                {/foreach}
                </td>

                <td data-label="Price">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span></td>
                
                <td data-label="Quantity">
                    <div class="col-lg-2">
                        <div class="number" id="number">
                        <span class="btn minus">−</span>
                        <input class="qty_id form-control input-qty" id="quantity_{$product.id_product|escape:'htmlall':'UTF-8'}" type="text"
                        value="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
                        min="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
                         />
                        <span class="btn plus">+</span>
                        </div>
                    </div>
                </td>
                
                <td data-label="Add to Cart">
                    <input type="hidden" name="group" id="group_{$product.id_product|escape:'htmlall':'UTF-8'}" value="{$group_count|escape:'htmlall':'UTF-8'}">
                    {*<button class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" onclick="fmmAddCart({$product.id_product|escape:'htmlall':'UTF-8'}, {$group_count|escape:'htmlall':'UTF-8'});" >{l s='🧺' mod='quickproducttable'}</button>*}
                    <input type="checkbox"  id="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" name="fmm_check" class="fmm_check" value="{$product.id_product|escape:'htmlall':'UTF-8'}">
                </td>
            </tr>
        {/foreach}
