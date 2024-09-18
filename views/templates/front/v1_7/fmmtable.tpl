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

{if $in_ary == true}
<h1 class="quickhead csvhead">{$head_name_{$id_lang}|escape:'htmlall':'UTF-8'}</h1>
<div class="box-border-bottom col-lg-12">
    <!-- div class="col-lg-1 col-xs-12 top_buttons">
        <p style="padding-top: 8px;font-weight: bolder;">{l s='Filters:' mod='quickproducttable'}</p>
    </div -->

    
    {if isset($catTree)}
        <div class=" top_buttons">
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
        </div>
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



<input type="hidden" name="ajax_url" id="ajax_url" value="{$ajax_url|escape:'htmlall':'UTF-8'}">
<table id="fmm_table" class="display nowrap table-responsive-full">
        <thead>
            <tr>
                <th class='grid_th_column1'><div>{l s='' mod='quickproducttable'}</div></th>
                <th class='grid_th_column2'><div>{l s='SKU' mod='quickproducttable'}</div></th>
                <th class='grid_th_column3'><div>{l s='Name' mod='quickproducttable'}</div></th>

                <th class='grid_th_column3'><div>{l s='Family' mod='quickproducttable'}</div></th>
                
                <th class='grid_th_column4'><div>{l s='Size' mod='quickproducttable'}</div></th>
                
                <th class='grid_th_column4'><div>{l s='Bag/ Box' mod='quickproducttable'}</div></th>
                <th class='grid_th_column4'><div>{l s='Qty/ Bag' mod='quickproducttable'}</div></th>
                <th class='grid_th_column4'><div>{l s='Qty/ Box' mod='quickproducttable'}</div></th>

                <th class='grid_th_column5'><div>{l s='Price' mod='quickproducttable'}</div></th>
                <th class='grid_th_column6'><div>{l s='Qty (In Cases)' mod='quickproducttable'}</div></th>
                <th class='grid_th_column7'><!--<div>{l s='' mod='quickproducttable'}
                    <div class="form-group-checkbox">
                        <input type="checkbox" id="chkal" name="fmm_check" class="fmm_check" data-toggle="toggle"  data-size="xs">
                        <label for="chkal" class="selection-button-checkbox">&nbsp;</label>
                    </div>-->
                </th>
            </tr>
        </thead>
        <tbody id="fmm_table_body">
        
          {foreach from=$all_products item=product name=product}

            <tr>
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
                            <span>
                            {$feature.value|escape:'htmlall':'UTF-8'}
                            </span>
                            {/if}
                        {foreachelse}
                        {/foreach}
                    </div>
                </td>
                
                
                <td data-label="Bag per Box">
                    <div class="grid_td_column4">
                        {foreach from=$product.features item=feature name=features}
                            {if $feature.id_feature == 6}
                            <span>
                            {$feature.value|escape:'htmlall':'UTF-8'}
                            </span>
                            {/if}
                        {foreachelse}
                        {/foreach}
                    </div>
                </td>

                <td data-label="Qty per Bag">
                    <div class="grid_td_column4">
                        {foreach from=$product.features item=feature name=features}
                            {if $feature.id_feature == 7}
                            <span>
                            {$feature.value|escape:'htmlall':'UTF-8'}
                            </span>
                            {/if}
                        {foreachelse}
                        {/foreach}
                    </div>
                </td>

                <td data-label="Qty per Box">
                    <div class="grid_td_column4">
                        {foreach from=$product.features item=feature name=features}
                            {if $feature.id_feature == 8}
                            <span>
                            {$feature.value|escape:'htmlall':'UTF-8'}
                            </span>
                            {/if}
                        {foreachelse}
                        {/foreach}
                    </div>
                </td>

                <td data-label="Price">
                    <div class="grid_td_column5">
                        {if $product.reduction > 0}
                            <div class="ml-2 price price--regular2" style="">WAS&nbsp;<span class="price--regular">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_old_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price_without_reduction|number_format:2}</span></span></div>
                            <div class="ml-2 price price--discounted" style="">{$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span></div>
                        {else}
                            {$product.default_currency_sign|escape:'htmlall':'UTF-8'}<span id="price_{$product.id_product|escape:'htmlall':'UTF-8'}">{$product.price|number_format:2}</span>
                        {/if}
                        
                    </div>
                </td>
                
                <td data-label="Quantity">
                    <div class="col-lg-2 grid_td_column6">
                        <div class="number" id="number">
                            <span class="btn minus-bulkorder">−</span>
                            <input class="qty_id-bulkorder form-control input-qty" id="quantity_{$product.id_product|escape:'htmlall':'UTF-8'}" type="text"
                            value="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
                            min="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity != ''}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
                            />
                            <span class="btn plus-bulkorder">+</span>
                        </div>
                        <div class="price_box_calc" id="price_box_calc_{$product.id_product|escape:'htmlall':'UTF-8'}">1 Case</div>
                    </div>
                </td>
                
                <td data-label="Add to Cart">
                    <div class="grid_td_column7">
                        <input type="hidden" name="group" id="group_{$product.id_product|escape:'htmlall':'UTF-8'}" value="{$group_count|escape:'htmlall':'UTF-8'}">
                        {*<button class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" onclick="fmmAddCart({$product.id_product|escape:'htmlall':'UTF-8'}, {$group_count|escape:'htmlall':'UTF-8'});" >{l s='🧺' mod='quickproducttable'}</button>*}
                        {*<input type="checkbox"  id="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" name="fmm_check" class="fmm_check" value="{$product.id_product|escape:'htmlall':'UTF-8'}">*}

                        <div class="form-group-checkbox">
                            <input type="checkbox" id="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" name="fmm_check" class="fmm_check" value="{$product.id_product|escape:'htmlall':'UTF-8'}">
                            <label for="{$product.id_product|escape:'htmlall':'UTF-8'}_{$group_count|escape:'htmlall':'UTF-8'}" class="selection-button-checkbox">&nbsp;</label>
                        </div>
                    </div>
                </td>
            </tr>
            {/foreach}
        </tbody>
        <tfoot>
            <tr>
                <th class='grid_th_column1'><div>{l s='' mod='quickproducttable'}</div></th>
                <th class='grid_th_column2'><div>{l s='SKU' mod='quickproducttable'}</div></th>
                <th class='grid_th_column3'><div>{l s='Name' mod='quickproducttable'}</div></th>

                <th class='grid_th_column3'><div>{l s='Family' mod='quickproducttable'}</div></th>
                
                <th class='grid_th_column4'><div>{l s='Size' mod='quickproducttable'}</div></th>
             
                <th class='grid_th_column4'><div>{l s='Bag/Box' mod='quickproducttable'}</div></th>
                <th class='grid_th_column4'><div>{l s='Qty/Bag' mod='quickproducttable'}</div></th>
                <th class='grid_th_column4'><div>{l s='Qty/Box' mod='quickproducttable'}</div></th>

                <th class='grid_th_column5'><div>{l s='Price' mod='quickproducttable'}</div></th>
                <th class='grid_th_column6'><div>{l s='Qty (In Cases)' mod='quickproducttable'}</div></th>
                <th class='grid_th_column7'><!--div>{l s='' mod='quickproducttable'}
                    <<div class="form-group-checkbox">
                        <input type="checkbox" id="chkal" name="fmm_check" class="fmm_check" data-toggle="toggle"  data-size="xs">
                        <label for="chkal" class="selection-button-checkbox">&nbsp;</label>
                    </div>-->
                </th>
            </tr>
        </tfoot>
    </table>
    {if $ajax_load}
    <input type="hidden" id="pageno" value="1">
    <span style="text-align: center;display: flow-root;">
        <img id="loader" src="{$base_url}modules/quickproducttable/views/img/loading.svg">
    </span>
    {/if}


    <div class="col-lg-12 col-xs-12 top_buttons" >
        <a class="btn btn-primary" href="{$cart_url|escape:'htmlall':'UTF-8'}?action=show">{l s='View Cart' mod='quickproducttable'}</a>
        <button class="btn btn-primary" onclick="fmmAddAllCart();" >{l s='Add To Cart' mod='quickproducttable'}</button>
    </div>

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
        let checkedItems = JSON.parse(localStorage.getItem('checkedItems')) || [];

        function fmmClear(){
            checkedItems = [];
            localStorage.removeItem('checkedItems');
            var checkboxes = document.querySelectorAll('.fmm_check');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                var closestTr = checkbox.closest('tr');
                if (closestTr) {
                    closestTr.classList.remove('dataTable-highlight');  // Remove class when unchecked
                }
            });
        }

        function toggleLocalStorage(itemId, checked) {
            //alert("test");
          const existingIndex = checkedItems.indexOf(itemId);
    
          if (checked && existingIndex === -1) {
            checkedItems.push(itemId);
          } else if (!checked && existingIndex !== -1) {
            checkedItems.splice(existingIndex, 1);
          }
    
          localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
        }


        
        $('#select_fmm_cat').on('change', function() {
            var id_category = this.value;
            var ajax_url = $("#ajax_url").val();
            var product_type = $("#product_type").val();
            console.log("id_category : "+id_category+"\n ajax_url : "+ajax_url+"\n product_type : "+product_type+"\n action : productChangeCategory");
            $.ajax({
                type: 'POST',
                url: ajax_url,
                data: {
                    id_category: id_category ,ajax:1,product_type:product_type, action: 'productChangeCategory'
                },
                success: function(response){
                    if (response != 2) {
                        $('#fmm_table_body').html('');
                        $('#fmm_table_body').append(response);
                        $("#fmm_table_paginate").hide();
                        
                        $('#fmm_table').destroy();
                        //fmmDataTable.destroy();

                        //$('#fmm_table').DataTable({ 
                        //    "destroy": true, //use for reinitialize datatable
                        //});

                    } else {                               
                        $("#loader").hide();
                    }
                }, 
                complete: function() {
                    dataTableInit(3);
                }
            
            });
        });
        

        //$(function() {
            //$('td:last-child input').change(function() {
            /*$('td:last-child input').on('change', function() {
                console.log("Hello");
                $(this).closest('tr').toggleClass("dataTable-highlight", this.checked);
            });*/
        //});

        $("input[type=checkbox]").click(function () {
            if ($(this).closest("tr").hasClass("head")) return;
            if ($(this).is(":checked")) {
                $(this).closest("tr").addClass("dataTable-highlight");
                $(this).closest(".selection-button-checkbox").addClass('selected');
            } else {
                $(this).closest("tr").removeClass("dataTable-highlight");
                $(this).closest(".selection-button-checkbox").removeClass('selected');
            }
            toggleLocalStorage($(this).val(), $(this).is(":checked"));
        });
        $("#chkal").click(function () {
            if ($(this).hasClass("all-selected")) {
                $(this).removeClass("all-selected");
                $("input[type=checkbox]").each(function () {
                    $(this).closest(".selection-button-checkbox").removeClass('selected');
                    $(this).closest("tr").removeClass("dataTable-highlight");
                    $(this).attr("checked", false);
                })
            } else {
                $(this).addClass("all-selected");
                $("input[type=checkbox]").each(function () {
                    $(this).closest(".selection-button-checkbox").addClass('selected');
                    if ($(this).attr("id") != "chkal") $(this).closest("tr").addClass("dataTable-highlight");
                    $(this).attr("checked", true);
                })
            }
        });

        function checkCheckboxes(condition) {
            var checkboxes = document.querySelectorAll('.fmm_check');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkedItems.includes(checkbox.value);
                var closestTr = checkbox.closest('tr');
                if (closestTr) {
                    if (checkbox.checked) {
                        closestTr.classList.add('dataTable-highlight');  // Add class when checked
                    }
                }
            });
        }
        
        checkCheckboxes(true);  // This will check all checkboxes
    /*
        $('.pdp_open_popup').on('click', function(event) {
            event.preventDefault();
            var pdp_url = $(this).attr("pdp_url"); //get form action url
            console.log("pdp_url : "+pdp_url);

            $.fancybox.open({
                closeClick: false, // prevents closing when clicking INSIDE fancybox 
                href: this.href,
                type: "ajax",
                openEffect: 'none',
                closeEffect: 'none',
                autoSize: false,
                width: "40%",
                height: "auto",
                helpers: {
                    overlay: { closeClick: false } // prevents closing when clicking OUTSIDE fancybox 
                },
                ajax: {
                    type: "POST",
                    dataType: "json",
                    data: {
                        ajax: true,
                        action: 'openPrefixesDialog',
                    }
                }
            });
            
        });
    */
    </script>
{/if}
{/block}

