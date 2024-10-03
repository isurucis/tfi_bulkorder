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
    
    {extends file=$layout}
    {block name='content'}
    
    <script src="{$jQuery_path|escape:'htmlall':'UTF-8'}"></script>
    <script src="{$inview|escape:'htmlall':'UTF-8'}"></script>
    <input type="hidden" id="noofrow" name="noofrow" value="{$noofrow|escape:'htmlall':'UTF-8'}">
    <input type="hidden" id="page_no" name="page_no" value="2">
    <input type="hidden" name="product_type" id="product_type" value="{$product_type|escape:'htmlall':'UTF-8'}">
    <input type="hidden" name="def_currency" id="def_currency" value="$">
    {if $in_ary == true}
    <!-- h1 class="quickhead csvhead">{$head_name_{$id_lang}|escape:'htmlall':'UTF-8'}</h1 -->
    <div class="csvhead">
        <h1 class="col-sm-4 quickhead " style="margin-bottom: 0px; padding-bottom: 0px; text-align: left; float: left;">{$head_name_{$id_lang}|escape:'htmlall':'UTF-8'}</h1>
        <div class="col-sm-8" style="margin-bottom: 0px; padding-bottom: 0px; text-align: right; float: right;">
            {if isset($catTree)}
                <select  name="select_fmm_cat" id="select_fmm_cat" class="custom-select " style="width: auto;">
                    <!-- option value="0" selected="selected">{" (Select a Family)"|escape:'htmlall':'UTF-8'}</option -->
                    {foreach from=$catTree['children'] item=tree}
                        <option value="{$tree['id']|escape:'htmlall':'UTF-8'}">{$tree['name']|escape:'htmlall':'UTF-8'}{" (Select a Family)"|escape:'htmlall':'UTF-8'}</option>
                        {foreach from=$tree['children'] item=tree2}
                            <option value="{$tree2['id']|escape:'htmlall':'UTF-8'}">{$tree['name']|escape:'htmlall':'UTF-8'}&emsp;‣&emsp;{$tree2['name']|escape:'htmlall':'UTF-8'}</option>
                            {foreach from=$tree2['children'] item=tree3}
                                <option value="{$tree3['id']|escape:'htmlall':'UTF-8'}">{$tree['name']|escape:'htmlall':'UTF-8'}&emsp;‣&emsp;{$tree2['name']|escape:'htmlall':'UTF-8'}&emsp;‣&emsp;&emsp;{$tree3['name']|escape:'htmlall':'UTF-8'}</option>
                            {/foreach}
                        {/foreach}
                    {/foreach}
                </select>
            {/if}
            <select  name="select_fmm_country" id="select_fmm_country" class="custom-select " style="width: auto;">
                <option value="0">All Country</option>
            </select>
            <select  name="select_fmm_view" id="select_fmm_view" class="custom-select " style="width: auto;">
                <option value="0">All</option>
                <option value="1">Stock Available</option>
                <option value="2">Out of Stock</option>
            </select>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="box-border-bottom col-lg-12">
        <!-- div class="col-lg-1 col-xs-12 top_buttons">
            <p style="padding-top: 8px;font-weight: bolder;">{l s='Filters:' mod='quickproducttable'}</p>
        </div -->
    
        
        {if isset($catTree)}
            <!-- div class=" top_buttons">
                <select  name="select_fmm_cat" id="select_fmm_cat" class="custom-select ">
                    <option value="0" selected="selected">{" (Select a Family)"|escape:'htmlall':'UTF-8'}</option>
                    {foreach from=$catTree['children'] item=tree}
                        <option value="{$tree['id']|escape:'htmlall':'UTF-8'}">{$tree['name']|escape:'htmlall':'UTF-8'}{" (Select a Family)"|escape:'htmlall':'UTF-8'}</option>
                        {foreach from=$tree['children'] item=tree2}
                            <option value="{$tree2['id']|escape:'htmlall':'UTF-8'}">{$tree['name']|escape:'htmlall':'UTF-8'}&emsp;‣&emsp;{$tree2['name']|escape:'htmlall':'UTF-8'}</option>
                            {foreach from=$tree2['children'] item=tree3}
                                <option value="{$tree3['id']|escape:'htmlall':'UTF-8'}">{$tree['name']|escape:'htmlall':'UTF-8'}&emsp;‣&emsp;{$tree2['name']|escape:'htmlall':'UTF-8'}&emsp;‣&emsp;&emsp;{$tree3['name']|escape:'htmlall':'UTF-8'}</option>
                            {/foreach}
                        {/foreach}
                    {/foreach}
                </select>
            </div -->
        {/if}
        
    
        {if $all_enable == 1}
            <div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=all">{l s='All' mod='quickproducttable'}</a>
            </div>
        {/if}
        {if $new_enable == 1}
            <div class=" top_buttons" >
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=new">{l s='New' mod='quickproducttable'}</a>
            </div>
        {/if}
        {if $best_enable == 1}
            <div class=" top_buttons" >
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=best">{l s='Best Sellers' mod='quickproducttable'}</a>
            </div>
        {/if}
        
        {if $sale_enable == 1}
            <div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=sale">{l s='Specials' mod='quickproducttable'}</a>
            </div>
        {/if}
    
        {if $advance_enable == 1}
            <div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=advance">{l s='Advance Search' mod='quickproducttable'}</a>
            </div>
        {/if}
    
        {if $csv_enable == 1}
            <div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=csv">{l s='Upload your List' mod='quickproducttable'}</a>
            </div>
        {/if}
    
        <div class=" top_buttons_right" >
        <button class="btn btn-primary" id="clear-button" onclick="fmmClear();">Clear</button>
        </div>

        <div class=" top_buttons_right" >
            <a class="btn btn-primary" href="{$cart_url|escape:'htmlall':'UTF-8'}?action=show">{l s='View Cart' mod='quickproducttable'}</a>
        </div>
        <div class=" top_buttons_right" >
            <button class="btn btn-primary" onclick="fmmAddAllCart();" >{l s='Add To Cart' mod='quickproducttable'}</button>
        </div>
        <div style="clear: both;"></div>
    </div>
    
    
    <input type="hidden" id="cart_url" value="{$cart_url|escape:'htmlall':'UTF-8'}?action=show">
    <input type="hidden" name="ajax_url" id="ajax_url" value="{$ajax_url|escape:'htmlall':'UTF-8'}">
    <table id="fmm_table" class="display nowrap table-responsive-full">
            <thead>
                <tr>
                    <th class='grid_th_column1'><div>{l s='' mod='quickproducttable'}</div></th>
                    <th class='grid_th_column2'><div>{l s='SKU' mod='quickproducttable'}</div></th>
                    <th class='grid_th_column3'><div>{l s='Name' mod='quickproducttable'}</div></th>
    
                    <th class='grid_th_column3'><div>{l s='Family' mod='quickproducttable'}</div></th>
                    
                    <th class='grid_th_column4'><div>{l s='Size' mod='quickproducttable'}</div></th>
                    
                    <th class='grid_th_column4'><div>MOQ<br />(Price)</div></th>
                    <th class='grid_th_column4'><div>Case Qty<br />(Price)</div></th>
                    <th class='grid_th_column4'><!--<div>Qty/<br />Box</div>-->
                    <div>Stock</div>
                    </th>
    
                    <!-- th class='grid_th_column5'><div>{l s='Price' mod='quickproducttable'}</div></th -->
                    <th class='grid_th_column6'><div>Qty<br />(In Cases)</div></th>
                    <th class='grid_th_column7'><!--<div>{l s='' mod='quickproducttable'}
                        <div class="form-group-checkbox">
                            <input type="checkbox" id="chkal" name="fmm_check" class="fmm_check" data-toggle="toggle"  data-size="xs">
                            <label for="chkal" class="selection-button-checkbox">&nbsp;</label>
                        </div>-->
                    </th>
                </tr>
            </thead>
            <tbody id="fmm_table_body">
                {assign var="total_val" value="0.00"}
                {assign var="array_str_main" value=""}
                {assign var="array_str_sub" value=""}

                {foreach from=$all_products item=product name=product}
                    {assign var="asgn_moq_qnty" value="0"}
                    {assign var="asgn_case_qnty" value="0"}

                    {assign var="asgn_moq_price" value="0.00"}
                    {assign var="asgn_case_price" value="0.00"}
                    <tr class="row_tr_item_full">
                        <td>
                            <div class="grid_td_column1">
                                <img class="quickorder_item_image" src="{$product.cover_image_url|escape:'htmlall':'UTF-8'}">
                            </div>
                        </td>
                        <td><div class="grid_td_column2">{$product.reference|escape:'htmlall':'UTF-8'}</div></td>
                        <td>
                            <div class="grid_td_column3">
                                <!-- div class="quickorder_itemname">
                                    <a href="{$product.link|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a>
                                </div -->
        
                                <div class="quickorder_itemname">
                                <a href="{$product.link|escape:'htmlall':'UTF-8'}" class="pdp_open_popup" 
                                pdp_url="{$product.link|escape:'htmlall':'UTF-8'}" 
                                title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a></div>
                                
        
                                <div>
                                    <div class="quickorder_scientificname">
                                        {foreach from=$product.features item=feature name=features}
                                            {if $feature.id_feature == 3}
                                                {$feature.value|escape:'htmlall':'UTF-8'}
                                            {/if}
                                        {foreachelse}
                                        {/foreach}
                                    </div>
        
                                    <div class="quickorder_country">
                                        {foreach from=$product.features item=feature name=features}
                                            {if $feature.id_feature ==9}
                                            <div class="quickorder_country11">
                                            {$feature.value|escape:'htmlall':'UTF-8'}
                                            </div>
                                            {/if}
                                        {foreachelse}
                                        {/foreach}
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
        
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
        
                                
                            </div>
                        </td>
                        
                        <td><div class="grid_td_column_group">{$product.category_name|escape:'htmlall':'UTF-8'}</div></td>
        
                        <td data-label="Size">
                            <div class="grid_td_column4">
                                {foreach from=$product.features item=feature name=features}
                                    {if $feature.id_feature == 4}
                                        {assign var=itemsize value={$feature.value|escape:'htmlall':'UTF-8'}}
                                        {assign var=itemsizesplit value=" "|explode:$itemsize}
                                        {assign var=itemsizesplitcount value={$itemsizesplit|count}}
                                        {assign var=loopnum value=0}
                                        {assign var=itemsizenew value=""}
                                        {assign var=itemsizenew2 value=""}
                                            {foreach $itemsizesplit as $itemsizesplit1}
                                                {assign var=loopnum value=$loopnum+1}
                                                {if $loopnum < $itemsizesplitcount }
                                                {$itemsizenew = $itemsizenew|cat:$itemsizesplit1|cat:" "}
                                                {/if}
                                            {/foreach}
                                            <div class="size-number">{$itemsizenew}</div>
                                            <div class="size-type">{$itemsizesplit[{$itemsizesplitcount-1}]}</div>
                                        <!-- span>
                                        {*$feature.value|escape:'htmlall':'UTF-8'*}<br />{*$itemsizesplitcount*}
                                        </span -->
                                    {/if}
                                {/foreach}
                            </div>
                        </td>
                        
                        
                        <td data-label="MOQ (Price)">
                            <div class="moqs_cases1">
                                <label class="moq_case_1">
                                    <!-- input type="radio" name="moq_case-input-001" class="moq_case-input" checked="checked" -->
                                    <input type="radio" 
                                    id="qty_moq_{$product.id_product|escape:'htmlall':'UTF-8'}" 
                                    name="qty_qty_{$product.id_product|escape:'htmlall':'UTF-8'}" 
                                    value="moq" class="moq_case-input" checked="checked"/>
                                    <div class="moq_case-box">By MOQ</div>
                                </label>
                            </div>
                            <div class="grid_td_column4">
                                {if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}
                                    {$product.product_attribute_minimal_quantity}
                                    {$asgn_moq_qnty = {$product.product_attribute_minimal_quantity}}
                                {else}
                                    {$product.minimal_quantity}
                                    {$asgn_moq_qnty = {$product.minimal_quantity}}
                                {/if}
                                -
                                {if $product.reduction > 0}
                                    <div class="ml-2 price price--regular2" style="">WAS&nbsp;<span class="price--regular">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_old_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price_without_reduction|number_format:2}</span></span></div>
                                    <div class="ml-2 price price--discounted" style="">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span></div>
                                    {$asgn_moq_price = {$product.price|number_format:2}}
                                {else}
                                    {$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span>
                                    {$asgn_moq_price = {$product.price|number_format:2}}
                                {/if}
                                <!-- input type="radio" id="qty_moq_{$product.id_product|escape:'htmlall':'UTF-8'}" name="qty_qty_{$product.id_product|escape:'htmlall':'UTF-8'}" value="moq" checked/ -->
                            </div>
                        </td>
        
                        <td data-label="Case Qty (Price)">
                            <div class="moqs_cases2">
                                <label class="moq_case_2">
                                    <!-- input type="radio" name="moq_case-input-001" class="moq_case-input" -->
                                    <input type="radio" 
                                    id="qty_case_{$product.id_product|escape:'htmlall':'UTF-8'}" 
                                    name="qty_qty_{$product.id_product|escape:'htmlall':'UTF-8'}" 
                                    value="case" class="moq_case-input" />
                                    <div class="moq_case-box">By CASE</div>
                                </label>
                            </div>
                            <div class="grid_td_column4">
                                {foreach from=$product.features item=feature name=features}
                                    {if $feature.id_feature == 8}
                                    <span>
                                        {intval($feature.value)/4}
                                        {$asgn_case_qnty = {intval($feature.value)/4}}
                                    </span>
                                    {/if}
                                {foreachelse}
                                {/foreach}
                                {if $product.reduction > 0}
                                    <div class="ml-2 price price--regular2" style="">WAS&nbsp;<span class="price--regular">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_old_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price_without_reduction|number_format:2}</span></span></div>
                                    <div class="ml-2 price price--discounted" style="">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span></div>
                                    {$asgn_case_price = {$product.price|number_format:2}}
                                {else}
                                    {$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price*0.8|number_format:2}</span>
                                    {$asgn_case_price = {$product.price*0.8|number_format:2}}
                                {/if}
                                <!-- input type="radio" id="qty_case_{$product.id_product|escape:'htmlall':'UTF-8'}" name="qty_qty_{$product.id_product|escape:'htmlall':'UTF-8'}" value="case" / -->
                            </div>
                        </td>
        
                        <td data-label="Qty per Box">
                            <div class="grid_td_column4">
                                <!--{foreach from=$product.features item=feature name=features}
                                    {if $feature.id_feature == 8}
                                    <span>
                                    {$feature.value|escape:'htmlall':'UTF-8'}
                                    </span>
                                    {/if}
                                {foreachelse}
                                {/foreach}-->
                                {$product.quantity}
                            </div>
                        </td>
        
                        <!-- td data-label="Price">
                            <div class="grid_td_column5">
                                {if $product.reduction > 0}
                                    <div class="ml-2 price price--regular2" style="">WAS&nbsp;<span class="price--regular">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_old_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price_without_reduction|number_format:2}</span></span></div>
                                    <div class="ml-2 price price--discounted" style="">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span></div>
                                {else}
                                    {$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span>
                                {/if}
                                <div id="row_price_{$product.id_product|escape:'htmlall':'UTF-8'}" style="border: dotted 1px #333333;padding: 2px; display: block;"></div>
                            </div>
                        </td -->
                        
                        <td data-label="Quantity">
                            <div class="col-lg-2 grid_td_column6">
                                {if $product.quantity > $product.minimal_quantity}
                                <div class="number" id="number">
                                    <span class="btn minus-bulkorder">−</span>
                                    <input class="qty_id-bulkorder form-control input-qty input-qty-disable" id="quantity_{$product.id_product|escape:'htmlall':'UTF-8'}" type="text"
                                    value="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
                                    min="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
                                    moq_price="{$product.price|number_format:2}"
                                    {if $product.reduction > 0}
                                        case_price="{$product.price|number_format:2}"
                                    {else}
                                        case_price="{$product.price*0.8|number_format:2}"
                                    {/if}
                                    stk="{$product.quantity}"
                                    row_id="{$product.id_product|escape:'htmlall':'UTF-8'}"
                                    readonly="readonly"/>
                                    <span class="btn plus-bulkorder">+</span>
                                </div>
                                
                                <table class="row_tbl_price_box_amount" style="">
                                    <tr style="background: none; border: none;">
                                        <td style="border: none;"><div class="price_box_calc" id="price_box_calc_{$product.id_product|escape:'htmlall':'UTF-8'}" >0 Cases</div></td>
                                        <td style="border: none;"><div class="price_box_amount row_amount_disable" id="price_box_amount_{$product.id_product|escape:'htmlall':'UTF-8'}" >{$product.default_currency_sign|escape:'htmlall':'UTF-8'}0.00</div></td>
                                    </tr>
                                </table>
                                <!-- div class="price_box_calc" id="price_box_calc_{$product.id_product|escape:'htmlall':'UTF-8'}">0 Case</div -->
                                {else}
                                <a class="btn btn-info" href="https://mediumturquoise-cheetah-573749.hostingersite.com/fmmquick?product_type=sale">Notify Me</a>
                                {/if}
                            </div>
                        </td>
                        
                        <td data-label="Add to Cart">
                            <div class="grid_td_column7">
                                {if $product.quantity > $product.minimal_quantity}
                                    <input type="hidden" name="group" id="group_{$product.id_product|escape:'htmlall':'UTF-8'}" value="{$group_count|escape:'htmlall':'UTF-8'}">
                                    {*<button class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" onclick="fmmAddCart({$product.id_product|escape:'htmlall':'UTF-8'}, {$group_count|escape:'htmlall':'UTF-8'});" >{l s='🧺' mod='quickproducttable'}</button>*}
                                    {*<input type="checkbox"  id="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" name="fmm_check" class="fmm_check" value="{$product.id_product|escape:'htmlall':'UTF-8'}">*}
            
                                    <div class="form-group-checkbox">
                                        <input type="checkbox" id="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" name="fmm_check" class="fmm_check" value="{$product.id_product|escape:'htmlall':'UTF-8'}">
                                        <label for="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" class="selection-button-checkbox">&nbsp;</label>
                                    </div>
                                {/if}
                            </div>
                        </td>
                    </tr>
                    {$array_str_sub = $array_str_sub|cat:{$product.id_product|escape:'htmlall':'UTF-8'}|cat:"|,"|cat:$asgn_moq_qnty|cat:"|,"|cat:$asgn_moq_price|cat:"|,"|cat:$asgn_case_qnty|cat:"|,"|cat:$asgn_case_price|cat:"||"}
                {/foreach}
            </tbody>
            <tfoot>
                <tr>
                    <th class='grid_th_column1'><div>{l s='' mod='quickproducttable'}</div></th>
                    <th class='grid_th_column2'><div>{l s='SKU' mod='quickproducttable'}</div></th>
                    <th class='grid_th_column3'><div>{l s='Name' mod='quickproducttable'}</div></th>
    
                    <th class='grid_th_column3'><div>{l s='Family' mod='quickproducttable'}</div></th>
                    
                    <th class='grid_th_column4'><div>{l s='Size' mod='quickproducttable'}</div></th>
                    
                    <th class='grid_th_column4'><div>MOQ<br />(Price)</div></th>
                    <th class='grid_th_column4'><div>Case Qty<br />(Price)</div></th>
                    <th class='grid_th_column4'><!--<div>Qty/<br />Box</div>-->
                    <div>Stock</div>
                    </th>
    
                    <!-- th class='grid_th_column5'><div>{l s='Price' mod='quickproducttable'}</div></th -->
                    <th class='grid_th_column6'><div>Qty<br />(In Cases)</div></th>
                    <th class='grid_th_column7'><!--<div>{l s='' mod='quickproducttable'}
                        <!-- div class="form-group-checkbox">
                            <input type="checkbox" id="chkal" name="fmm_check" class="fmm_check" data-toggle="toggle"  data-size="xs">
                            <label for="chkal" class="selection-button-checkbox">&nbsp;</label>
                        </div>-->
                    </th>
                </tr>
            </tfoot>
        </table>

        <!-- div class="debug-console" id="debug-console">{*$array_str_sub*}</div -->
        
        {if $ajax_load}
        <input type="hidden" id="pageno" value="1">
        <span style="text-align: center;display: flow-root;">
            <img id="loader" src="{$base_url}modules/quickproducttable/views/img/loading.svg">
        </span>
        {/if}
    
    
        <!-- div class="col-lg-12 col-xs-12 top_buttons" >
            <a class="btn btn-primary" href="{$cart_url|escape:'htmlall':'UTF-8'}?action=show">{l s='View Cart' mod='quickproducttable'}</a>
            <button class="btn btn-primary" onclick="fmmAddAllCart();" >{l s='Add To Cart' mod='quickproducttable'}</button>
        </div -->
    
        {if $ajax_load}
        <script type="text/javascript">
                    
            $('#loader').on('inview', function(event, isInView) {
    
                if (isInView) {
                    var lastItem = $('#fmm_table_body tr').length;
                    var ajax_url = $("#ajax_url").val();
                    var noofrow = $("#noofrow").val();
                    var product_type = $("#product_type").val();
                    var old_page = $("#page_no").val();
                    if (!old_page) {
                        old_page = 1;
                    }
                    $.ajax({
                        type: 'POST',
                        url: ajax_url,
                        data: {
                            lastItem: lastItem ,ajax:1,noofrow:noofrow, product_type:product_type, old_page:old_page, action: 'productChangeLength'
                        },
                        success: function(response){
                            if (response != 2) {
                                var b = 1;
                                var new_page = parseInt(old_page, 10) + parseInt(b, 10);
                                $('#fmm_table_body').append(response);
                                $('#page_no').val(new_page);
    
                            } else {                     
                                $("#loader").hide();
                            }
                        }
    
                    });
    
                }
            });
        </script>
        <style type="text/css">
            .btn-primary {
                font-size: small;
            }
        </style>
        {/if}
    
        <script type="text/javascript">
            // Initialize checkedItems array from localStorage or an empty array
            let checkedItems = JSON.parse(localStorage.getItem('checkedItems')) || [];

            let itemlist_all = [];
            
            
            function stringArrayConvert() {
                /*let array_str_sub = "{*$array_str_sub|escape:'html'*}";
                const array_str_sub1 = array_str_sub.split("||").pop();
                console.log("A1 :"+array_str_sub1[0]);
                console.log("A2 :"+array_str_sub1[parseInt(array_str_sub1.length)]);
                if( parseInt(array_str_sub1.length) > 0 ) {
                    for( var a=0; a < parseInt(array_str_sub1.length); a++ ) {
                        let itemeach_array = [];
                        let itemeach = array_str_sub1[a].split("|,");
                        if( parseInt(itemeach.length) > 0 ) {
                            itemeach_array = {
                                id : itemeach[0],
                                moq_qnty : itemeach[1],
                                moq_price : itemeach[2],
                                case_qnty : itemeach[3],
                                case_price : itemeach[4]
                            }
                            itemlist_all.push(itemeach_array);
                        }
                        
                    }
                }
                console.log("Total item list : "+itemlist_all.length);
                //calculateTotalAmount();
                */
            }

            // Function to clear all selections and quantity values
            function fmmClear() {
                checkedItems = [];
                localStorage.removeItem('checkedItems');
                var checkboxes = document.querySelectorAll('.fmm_check');
                
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    var closestTr = checkbox.closest('tr');
                    if (closestTr) {
                        closestTr.classList.remove('dataTable-highlight');
                    }
                });
    
                // Clear all quantity input fields
                var qtyInputs = document.querySelectorAll('.input-qty');
                qtyInputs.forEach(function(input) {
                    input.value = input.getAttribute('min');  // Clear the value
                });

                calculateTotalAmount();
            }
    
            // Function to update localStorage with both checkbox and quantity
            function toggleLocalStorage(itemId, checked, qty, moq_case, itemprice) {
                const existingIndex = checkedItems.findIndex(item => item.id === itemId);
    
                if (checked && existingIndex === -1) {
                    // Add new item with checkbox state and quantity
                    checkedItems.push({ id: itemId, qty: qty, by:moq_case, price:itemprice });
                } else if (!checked && existingIndex !== -1) {
                    // Remove item if unchecked
                    checkedItems.splice(existingIndex, 1);
                } else if (checked && existingIndex !== -1) {
                    // Update quantity if item is already in the list
                    checkedItems[existingIndex].qty = qty;
                    checkedItems[existingIndex].by = moq_case;
                    checkedItems[existingIndex].price = itemprice;
                }
    
                localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
                calculateTotalAmount();
            }
    
            // Handle checkbox click events
            $("input[type=checkbox]").click(function () {
                if ($(this).closest("tr").hasClass("head")) return;
    
                var qtyInput = $(this).closest('tr').find('.input-qty');
                var qtyValue = qtyInput.val();  // Get the quantity value
                var moq_case = $("input[name='qty_qty_" + $(this).val() + "']:checked").val();    // moq | case
                var moq_price   = qtyInput.attr('moq_price');
                var case_price  = qtyInput.attr('case_price');
                var itemprice = (moq_case == "moq") ? moq_price : case_price;
                //console.log("itemprice : "+itemprice);
                if ($(this).is(":checked")) {
                    $(this).closest("tr").addClass("dataTable-highlight");
                    $(this).closest(".selection-button-checkbox").addClass('selected');
                    $(this).closest('tr').find('.input-qty').removeClass('input-qty-disable');
                    $(this).closest('tr').find('.input-qty').addClass('input-qty-enable');

                    $(this).closest('tr').find('.price_box_amount').removeClass('row_amount_disable');
                    $(this).closest('tr').find('.price_box_amount').addClass('row_amount_enable');
                } else {
                    $(this).closest("tr").removeClass("dataTable-highlight");
                    $(this).closest(".selection-button-checkbox").removeClass('selected');
                    $(this).closest('tr').find('.input-qty').removeClass('input-qty-enable');
                    $(this).closest('tr').find('.input-qty').addClass('input-qty-disable');

                    $(this).closest('tr').find('.price_box_amount').removeClass('row_amount_enable');
                    $(this).closest('tr').find('.price_box_amount').addClass('row_amount_disable');
                }

                toggleLocalStorage($(this).val(), $(this).is(":checked"), qtyValue, moq_case, itemprice);
            });

            

            /*
            document.querySelectorAll('.input-qty').forEach(function(qtyInput) {
                // Add an event listener to handle changes in the quantity input
                qtyInput.addEventListener('input', function() {
                    // Get the quantity value
                    let qtyValue = parseInt(qtyInput.value, 10);
                    
                    // Get the minimum value (from the min attribute or default to 1 if not set)
                    let minValue = parseInt(qtyInput.getAttribute('min'), 10) || 1;
            
                    // Calculate the number of cases
                    let numberOfCases = qtyValue / minValue;
            
                    // Get the corresponding price_box_calc div based on the input's id
                    let priceBoxCalc = document.querySelector('#price_box_calc_' + qtyInput.id.split('_')[1]);
                    
                    if (priceBoxCalc) {
                        // Update the price_box_calc div with the calculated number of cases
                        priceBoxCalc.innerText = numberOfCases + ' Case' + (numberOfCases > 1 ? 's' : '');
    
                    }
                });
            });
            */
            // Handle "Select All" button click event
            $("#chkal").click(function () {
                if ($(this).hasClass("all-selected")) {
                    $(this).removeClass("all-selected");
                    $("input[type=checkbox]").each(function () {
                        $(this).closest(".selection-button-checkbox").removeClass('selected');
                        $(this).closest("tr").removeClass("dataTable-highlight");
                        $(this).attr("checked", false);
                    });
                } else {
                    $(this).addClass("all-selected");
                    $("input[type=checkbox]").each(function () {
                        $(this).closest(".selection-button-checkbox").addClass('selected');
                        if ($(this).attr("id") != "chkal") $(this).closest("tr").addClass("dataTable-highlight");
                        $(this).attr("checked", true);
                    });
                }
            });
    
            // Update the case value based on quantity input
            function updateCaseValue(qtyInput) {
                let minValue = parseInt(qtyInput.attr('min'));
                let quantityValue = parseInt(qtyInput.val());
                let boxqty = Math.floor((minValue*20)/4);
                var number = qtyInput.attr('id').split('_')[1]
                //Console.log(boxqty);
                //let numberOfCases = Math.floor(quantityValue / minValue); // Calculate number of cases
                let numberOfCases = Math.floor(quantityValue / boxqty); 
                let priceBoxCalc = $('#price_box_calc_' + qtyInput.attr('id').split('_')[1]);
        
                // Update the case value in the UI
                priceBoxCalc.text(numberOfCases + ' Case' + (numberOfCases > 1 ? 's' : ''));
                if(numberOfCases>=1){
                    $('input[name="qty_qty_' + number + '"][value="case"]').prop('checked', true);
                }
            }
    
            // Function to check checkboxes and set quantity values based on localStorage data
            function checkCheckboxes() {
                var checkboxes = document.querySelectorAll('.fmm_check');
    
                checkboxes.forEach(function(checkbox) {
                    const itemData = checkedItems.find(item => item.id === checkbox.value);
                    if (itemData) {
                        checkbox.checked = true;
                        var closestTr = checkbox.closest('tr');
                        if (closestTr) {
                            closestTr.classList.add('dataTable-highlight');
                        }
    
                        // Set the quantity value
                        var qtyInput = closestTr.querySelector('.input-qty');
                        
                        if (qtyInput) {
                            var stock = parseInt(qtyInput.getAttribute('stk'));;
                            var minValue = parseInt(qtyInput.getAttribute('min'));
                            if(stock >= itemData.qty){
                                qtyInput.value = itemData.qty;
                            }else{
                                qtyInput.value = minValue;
                            }
                            updateCaseValue($(qtyInput));
                        }
                    }
                });
            }
    
            // Load checkboxes and quantities on page load
            checkCheckboxes();

            function calculateTotalAmount() {
                var total_amount = "0.00";
                var currencysign = "{$product.default_currency_sign|escape:'htmlall':'UTF-8'}";
          
                checkedItems.forEach(function(storeItem) {
                    //const adda          = itemlist_all.findIndex(itemlist => itemlist.id === storeItem.id);

                    const strg_id       = storeItem.id;
                    const strg_qty      = storeItem.qty;
                    const strg_by       = storeItem.by;
                    const strg_price    = storeItem.price;

                    var itemsubprice    = "0.00";
                    console.log("ID : "+strg_id+", qty : "+strg_qty+", by : "+strg_by+", price : "+strg_price);
                    
                    //if( strg_by == "moq" ) {
                    //    itemsubprice = parseFloat(parseInt(strg_qty)*parseFloat(itemlist_all[adda].moq_price)).toFixed(2);
                    //    total_amount = parseFloat(parseFloat(total_amount)+parseFloat(itemsubprice)).toFixed(2);
                    //} else {
                    //    itemsubprice = parseFloat(parseInt(strg_qty)*parseFloat(itemlist_all[adda].case_price)).toFixed(2);
                    //    total_amount = parseFloat(parseFloat(total_amount)+parseFloat(itemsubprice)).toFixed(2);
                    //}

                    itemsubprice = parseFloat(parseInt(strg_qty)*parseFloat(strg_price)).toFixed(2);
                    total_amount = parseFloat(parseFloat(total_amount)+parseFloat(itemsubprice)).toFixed(2);

                    console.log("itemsubprice : "+itemsubprice);
                    console.log("total_amount : "+total_amount);
                });
                console.log("TOTAL AMOUNT : "+currencysign+parseFloat(total_amount).toFixed(2));
                $("#spn_total_amount_disp").html(currencysign+parseFloat(total_amount).toFixed(2));
            }

            function totalAmount_OLD() {
                //spn_total_amount_disp
                var total_amount = "0.00";
                var qtyInputs = document.querySelectorAll('.input-qty');
                var currencysign = "{$product.default_currency_sign|escape:'htmlall':'UTF-8'}";
                qtyInputs.forEach(function(input) {
                    let row_amount      = "0.00";
                    let now_qty         = input.value;
                    let row_id          = input.getAttribute('row_id');
                    let moq_price       = parseFloat(input.getAttribute('moq_price'), 10) || "0.00";
                    let case_price      = parseFloat(input.getAttribute('case_price'), 10) || "0.00";
                    let moq_case        = $("input[name='qty_qty_" + row_id + "']:checked").val();    // moq | case

                    row_amount          = ( moq_case == "moq" ) ? parseFloat(parseFloat(moq_price)*now_qty, 10) || "0.00" : parseFloat(parseFloat(case_price)*now_qty, 10) || "0.00";
                    //console.log("11 now_qty : "+now_qty+"\nmoq_price : "+moq_price+"\ncase_price : "+case_price+"\nmoq_case : "+moq_case+"\nrow_amount : "+currencysign+row_amount);

                    //$("#price_box_amount_"+row_id).html(currencysign+parseFloat(row_amount).toFixed(2));

                    let group_count_val = $("#group_"+row_id).val();
                    console.log("group_count_val : "+group_count_val);
                    if( $("#"+row_id+"_"+group_count_val).is(":checked")) {
                        total_amount = parseFloat(total_amount)+parseFloat(row_amount);
                        //console.log("Check box :"+row_id+"_"+group_count_val);
                        //$("#price_box_amount_"+row_id).removeClass('row_amount_disable');
                        //$("#price_box_amount_"+row_id).addClass('row_amount_enable');

                        //$("#quantity_"+row_id).removeClass('input-qty-disable');
                        //$("#quantity_"+row_id).addClass('input-qty-enable');
                    }
                });

                $("#spn_total_amount_disp").html(currencysign+parseFloat(total_amount).toFixed(2));
            }
            
            function calculateRowAmount(mode) {
                var qtyInputs = document.querySelectorAll('.input-qty');
                var currencysign = "{$product.default_currency_sign|escape:'htmlall':'UTF-8'}";
                if( mode == "0" ) {
                    qtyInputs.forEach(function(input) {
                        let row_amount      = "0.00";
                        let now_qty         = input.value;
                        let row_id          = input.getAttribute('row_id');
                        let moq_price       = parseFloat(input.getAttribute('moq_price'), 10) || "0.00";
                        let case_price      = parseFloat(input.getAttribute('case_price'), 10) || "0.00";
                        let moq_case        = $("input[name='qty_qty_" + row_id + "']:checked").val();    // moq | case

                        row_amount          = ( moq_case == "moq" ) ? parseFloat(parseFloat(moq_price)*now_qty, 10) || "0.00" : parseFloat(parseFloat(case_price)*now_qty, 10) || "0.00";
                        $("#price_box_amount_"+row_id).html(currencysign+parseFloat(row_amount).toFixed(2));

                        let group_count_val = $("#group_"+row_id).val();
                        if( $("#"+row_id+"_"+group_count_val).is(":checked")) {
                            $("#price_box_amount_"+row_id).removeClass('row_amount_disable');
                            $("#price_box_amount_"+row_id).addClass('row_amount_enable');

                            $("#quantity_"+row_id).removeClass('input-qty-disable');
                            $("#quantity_"+row_id).addClass('input-qty-enable');
                        }
                    });
                } else {
                    let row_amount      = "0.00";
                    let now_qty         = $("#quantity_"+mode).val();
                    let now_group       = $("#group_"+mode).val();
                    let row_id          = mode; //mode.getAttribute('row_id');
                    let moq_price       = parseFloat($("#quantity_"+mode).attr('moq_price'), 10) || "0.00";          // parseFloat(mode.getAttribute('moq_price'), 10) || "0.00";
                    let case_price      = parseFloat($("#quantity_"+mode).attr('case_price'), 10) || "0.00";          // parseFloat(mode.getAttribute('case_price'), 10) || "0.00";
                    let moq_case        = $("input[name='qty_qty_" + row_id + "']:checked").val();    // moq | case

                    row_amount          = ( moq_case == "moq" ) ? parseFloat(parseFloat(moq_price)*now_qty, 10) || "0.00" : parseFloat(parseFloat(case_price)*now_qty, 10) || "0.00";
                    var itemprice       = (moq_case == "moq") ? moq_price : case_price;
                    $("#price_box_amount_"+row_id).html(currencysign+parseFloat(row_amount).toFixed(2));

                    toggleLocalStorage(row_id, $("#"+mode+"_"+now_group).is(":checked"), now_qty, moq_case, itemprice);
                }
                calculateTotalAmount();  // Calculate the Total Amount
            }
            calculateRowAmount(0); // Default
            
            //stringArrayConvert();   // convert the items list string into array chunks

        </script>
    {/if}
    {/block}
    
    