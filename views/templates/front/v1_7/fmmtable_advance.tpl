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
{if $in_ary == true}
<h1 class="quickhead csvhead">{$head_name_{$id_lang}|escape:'htmlall':'UTF-8'}</h1>
<div class="border col-lg-10 ">
    <div class="col-lg-1 col-xs-12 top_buttons">
        <p style="padding-top: 8px;font-weight: bolder;">{l s='Filters:' mod='quickproducttable'}</p>
        
    </div>
    {if $new_enable == 1}
    <div class="col-lg-2 col-xs-12 top_buttons" >
        <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=new">{l s='New Products' mod='quickproducttable'}</a>
    </div>
    {/if}
    {if $best_enable == 1}
    <div class="col-lg-2 col-xs-12 top_buttons" >
        <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=best">{l s='Best Sales' mod='quickproducttable'}</a>
    </div>
    {/if}
    {if $all_enable == 1}
    <div class="col-lg-2 col-xs-12 top_buttons">
        <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=all">{l s='All Products' mod='quickproducttable'}</a>
    </div>
    {/if}
    {if $sale_enable == 1}
    <div class="col-lg-2 col-xs-12 top_buttons">
        <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=sale">{l s='Prices Drop' mod='quickproducttable'}</a>
    </div>
    {/if}

    {if $advance_enable == 1}
    <div class="col-lg-3 col-xs-12 top_buttons">
        <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=advance">{l s='Advance Search' mod='quickproducttable'}</a>
    </div>
    {/if}
</div>
{if $csv_enable == 1}
<div class="col-lg-2 col-xs-12 top_buttons">
    <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=csv">{l s='Add In Bulk' mod='quickproducttable'}</a>
</div>
{/if}
    <div class="clearfix"></div>
      {if $tree_enable == 1}
           <div class="col-lg-4 fmmpanelcat">

            <label>{l s='Check All' mod='quickproducttable'}</label>
            <input type="checkbox" data-toggle="toggle" id="cal" data-size="xs">

            <div class="clearfix"></div>
            <div style="margin-top: 5px;">
            <input type="checkbox" class="tree" id="tree_{$catTree['id']|escape:'htmlall':'UTF-8'}" value="{$catTree['id']|escape:'htmlall':'UTF-8'}">
            {$catTree['name']|escape:'htmlall':'UTF-8'}
            <br>
            {foreach from=$catTree['children'] item=tree}
              <span style="margin-left:10px;">
                <input type="checkbox" class="tree" id="tree_{$tree['id']|escape:'htmlall':'UTF-8'}" value="{$tree['id']|escape:'htmlall':'UTF-8'}">
                {$tree['name']|escape:'htmlall':'UTF-8'}
              </span>
              <br>
              {foreach from=$tree['children'] item=tree2}
              <span style="margin-left:30px;">
              <input type="checkbox" class="tree" id="tree_{$tree2['id']|escape:'htmlall':'UTF-8'}" value="{$tree2['id']|escape:'htmlall':'UTF-8'}">
                {$tree2['name']|escape:'htmlall':'UTF-8'}
              </span>
              <br>
              {/foreach}
            {/foreach}
            </div>
           </div>
           {/if}
            <div class="col-lg-8 fmm_head">
                <div id="instantsearchfmm">
                    <input type="text" placeholder="Example: Blue shirt" onkeyup="getRelProducts(this);">

            <div id="rel_holder"></div>


          <div id="rel_holder_temp">
            <ul>
                  {if (!empty($products))}
                  {foreach from=$products item=product}
                  <li id="row_{$product->id|escape:'htmlall':'UTF-8'}" class="media"><div class="media-left"><img src="{$link->getImageLink($product->link_rewrite, $product->id_image, 'home_default')|escape:'htmlall':'UTF-8'}" class="media-object image"></div><div class="media-body media-middle"><span class="label">{$product->name|escape:'htmlall':'UTF-8'}&nbsp;(ID:{$product->id|escape:'htmlall':'UTF-8'})</span><i onclick="relDropThis(this);" class="material-icons delete">clear</i></div><input type="hidden" value="{$product->id|escape:'htmlall':'UTF-8'}" name="related_products[]"></li>
                  {/foreach}
                  {/if}
              </ul>
              <div class="clearfix"></div>
            </div>
            </div>

                </div>
                <div class="clearfix"></div>
            </div>
    <div class="clearfix"></div>
    <input type="hidden" name="ajax_url" id="ajax_url" value="{$ajax_url|escape:'htmlall':'UTF-8'}">
</div>

<div class="col-lg-12 col-xs-12 top_buttons" >
     <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$cart_url|escape:'htmlall':'UTF-8'}?action=show">{l s='View Cart' mod='quickproducttable'}</a>
</div>


{/if}
{/block}


