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
    <!-- h1 class="quickhead csvhead">{$head_name_{$id_lang}|escape:'htmlall':'UTF-8'}</h1 -->
    <div class="csvhead">
        <h1 class="col-sm-4 quickhead " style="margin-bottom: 0px; padding-bottom: 0px; text-align: left; float: left;">{$head_name_{$id_lang}|escape:'htmlall':'UTF-8'}</h1>
        <div class="col-sm-8" style="margin-bottom: 0px; padding-bottom: 0px; text-align: right; float: right;">
            <span class="csvhead-sub">{l s='Add Products Using CSV' mod='quickproducttable'}</span>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="box-border-bottom col-lg-12">
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
        {*if $best_enable == 1*}
            <!-- div class=" top_buttons" >
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=best">{l s='Best Sellers' mod='quickproducttable'}</a>
            </div -->
        {*/if*}
        
        {if $sale_enable == 1}
            <div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=sale">{l s='Specials' mod='quickproducttable'}</a>
            </div>
        {/if}
    
        {*if $advance_enable == 1*}
            <!-- div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=advance">{l s='Advance Search' mod='quickproducttable'}</a>
            </div -->
        {*/if*}
    
        {if $csv_enable == 1}
            <div class=" top_buttons">
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}?product_type=csv">{l s='Upload your List' mod='quickproducttable'}</a>
            </div>
        {/if}
        <div style="clear: both;"></div>
    </div>


    {if isset($count) AND $count > 0}
        <div class="alert alert-success" role="alert" style="margin-top: 20px;">
            {$count|escape:'htmlall':'UTF-8'}{l s=' Products Successfully Added' mod='quickproducttable'}
        </div>
    {/if}


    {if $in_ary == true}
        <div class="fmmpanel">
            <input type="hidden" name="ajax_url" id="ajax_url" value="{$ajax_url|escape:'htmlall':'UTF-8'}">
            <div class="row">
                <div class="col-md-6 col-6 mb-lg-6">
                    <fieldset>
                        <legend>Option 1: Upload CSV to Purchase</legend>
                        <div><p id="downloadcsvfile"><a href="{$base_url|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/sample.csv">{l s='Download a sample CSV file' mod='quickproducttable'}</a></p></div>

                        <div class="col-lg-12" style="margin-top: 40px;">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="csv_sku">
                                    <input type="file" name="quickcsv" />
                                </div>
                                <input class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" value="Submit" type="submit"/>
                            </form>
                            
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-6 col-6 mb-lg-6">
                    <fieldset>
                        <legend>Option 2: Enter Item Number to Purchase</legend>
                        <div><p>{l s='Format: reference,qty,attribute' mod='quickproducttable'}</p></div>
                        <div class="col-lg-12 center">
                            <textarea id="csv_sku" placeholder="{l s='Enter multiple reference, separate by new lines' mod='quickproducttable'}" style="height: 93px;"></textarea>
                            <p>{l s='e.g demo_1,2,1' mod='quickproducttable'}</p>
                            <p>{l s='e.g demo_10,5' mod='quickproducttable'}</p>
                            <input class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}"  onclick="textareaClick();" value="Add To Cart" type="submit"/>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    {/if}

{/block}

