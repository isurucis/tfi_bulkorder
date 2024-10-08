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
                <a class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}">{l s='Bulk Order List' mod='quickproducttable'}</a>
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
        <div class="fmmpanel22" style="padding-top: 40px;">
            <input type="hidden" name="ajax_url" id="ajax_url" value="{$ajax_url|escape:'htmlall':'UTF-8'}">
            <div class="row">
                <div class="col-md-6 col-12 mb-lg-6">
                    <fieldset>
                        <legend>Option 1: Upload CSV to Purchase</legend>
                        <div class="col-lg-12" >
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div>
                                    <input type="file" name="quickcsv" class="csv_sku" />
                                </div>
                                <div style="padding: 5px;">
                                    <input style="float: left;" class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}" value="Upload CSV File" type="submit"/>
                                    
                                    <button id="downloadCSVFileButton" class="downloadcsvfile"><span class="arrow-sign">»</span>{l s='Download a sample CSV file' mod='quickproducttable'}</button>
                                    
                                    <!-- p id="downloadcsvfile" class="downloadcsvfile"><a href="{$base_url|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/sample.csv"><span class="arrow-sign">»</span>{l s='Download a sample CSV file' mod='quickproducttable'}</a></p -->
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                            
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-6 col-12 mb-lg-6">
                    <fieldset>
                        <legend>Option 2: Enter Item Number to Purchase</legend>
                        <div class="col-lg-12 ">
                            <textarea id="csv_sku" class="csv_sku" placeholder="{l s='Enter multiple reference, separate by new lines' mod='quickproducttable'}" style="height: 93px;"></textarea>
                            <p style="color:#000000;"><span style="font-style: italic; color: #727577;">Format</span>: reference,qty &nbsp;&nbsp; <span style="font-style: italic; color: #727577;">e.g 1</span>: 121567,30 &nbsp;&nbsp; <span style="font-style: italic; color: #727577;">e.g 2</span>: 112630,150</p>
                            <input class="btn btn-{$btn_clr|escape:'htmlall':'UTF-8'}"  onclick="textareaClick();" value="Add To Cart" type="submit"/>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    {/if}


<script type="text/javascript">
    $(document).ready(function () {
        //processes when the Download CSV File button is clicked.  If the browser can handle the
        //download archor attribute, the contents of the posting file Multi-Line field will be
        //downloaded in a csv file, if the browser can't handle the attribute, the user will be
        //alerted and recommended to try another browser
        $('#downloadCSVFileButton').click(function () {
            var textFile = "{$base_url|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/sample.csv"; //$('.postingFile textarea').val();
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textFile));
            element.setAttribute('download', '{$base_url|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/sample.csv');
            element.style.display = 'none';
            if (typeof element.download != "undefined") {
                //browser has support - process the download
                document.body.appendChild(element);
                element.click();
                document.body.removeChild(element);
            }
            else {
                //browser does not support - alert the user
                alert('This functionality is not supported by the current browser, recommend trying with Google Chrome instead.  (http://caniuse.com/#feat=download)');
            }
        });
    });
</script>


{/block}

