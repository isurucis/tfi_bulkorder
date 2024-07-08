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
{if isset($confirmation) AND $confirmation == 1}
<div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
        <div class="alert-text">
            <p>{l s='Successful update' mod='quickproducttable'}</p>
        </div>
</div>
{/if}
<div class="well private_shop_container">
    <div class="toolbarBox pageTitle">
        <h3 class="tab panel-heading">&nbsp;<img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/shop.png"/> {l s='Quick Order' mod='quickproducttable'}</h3>
    </div>
    <div class="col-lg-2 " id="private-shop">
     	<div class="productTabs">
    		<ul class="tab">
    			<li class="tab-row">
    				<a class="private_tab_page selected" id="quickproducttable_link_settings" href="javascript:displayFmmTab('settings');">{l s='General Settings' mod='quickproducttable'}</a>
    			</li>
                <li class="tab-row">
                    <a class="private_tab_page selected" id="quickproducttable_link_group" href="javascript:displayFmmTab('group');">{l s='Group Access' mod='quickproducttable'}</a>
                </li>
                <li class="tab-row">
                    <a class="private_tab_page selected" id="quickproducttable_link_design" href="javascript:displayFmmTab('design');">{l s='Design' mod='quickproducttable'}</a>
                </li>
    		</ul>
    	</div>
    </div>

    <!-- Tab Content -->
    <form action="" name="quickproducttable_form" id="quickproducttable_form" method="post" enctype="multipart/form-data" class="col-lg-10 panel form-horizontal">
        <input type="hidden" id="currentFormTab" name="currentFormTab" value="settings" />
        <div id="quickproducttable_settings" class="private_tab tab-pane">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/config.png"/> {l s='General Settings' mod='quickproducttable'}</h3><div class="separation"></div>
            {include file="../admin/settings.tpl"}
        </div>
        <div id="quickproducttable_group" class="private_tab tab-pane">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/config.png"/> {l s='Group Access' mod='quickproducttable'}</h3><div class="separation"></div>
            {include file="../admin/group.tpl"}
        </div>
        <div id="quickproducttable_design" class="private_tab tab-pane">
            <h3 class="tab"><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/quickproducttable/views/img/config.png"/> {l s='Design' mod='quickproducttable'}</h3><div class="separation"></div>
            {include file="../admin/design.tpl"}
        </div>
        <div class="separation"></div>

         <div class="panel-footer">
                <button class="btn btn-default pull-right" name="saveQuickConfiguration" type="submit">
                    <i class="process-icon-save"></i>
                    {l s='Save' mod='quickproducttable'}
                </button>
            </div>
      
    </form>
   <div class="clearfix"></div>
</div>

<br></br>
<div class="clearfix"></div>

<script type="text/javascript">
$(document).ready(function(){
   //$('#currentFormTab').val('general');
   displayFmmTab('settings');
})
function displayFmmTab(tab)
{
    $('.private_tab').hide();
    $('.private_tab_page').removeClass('selected');
    $('#quickproducttable_' + tab).show();
    $('#quickproducttable_link_' + tab).addClass('selected');
    $('#currentFormTab').val(tab);
}
</script>