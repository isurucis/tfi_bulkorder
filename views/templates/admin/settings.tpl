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


<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Enable New Product' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKNEW_ENABLE" id="FMMQUICKNEW_ENABLE_on" value="1" {if isset($new_enable) AND isset($new_enable) AND $new_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKNEW_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKNEW_ENABLE" id="FMMQUICKNEW_ENABLE_off" value="0" {if isset($new_enable) AND isset($new_enable) AND $new_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKNEW_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Enable Best Sales' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKBEST_ENABLE" id="FMMQUICKBEST_ENABLE_on" value="1" {if isset($best_enable) AND isset($best_enable) AND $best_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKBEST_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKBEST_ENABLE" id="FMMQUICKBEST_ENABLE_off" value="0" {if isset($best_enable) AND isset($best_enable) AND $best_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKBEST_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Enable All Products' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKALL_ENABLE" id="FMMQUICKALL_ENABLE_on" value="1" {if isset($all_enable) AND isset($all_enable) AND $all_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKALL_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKALL_ENABLE" id="FMMQUICKALL_ENABLE_off" value="0" {if isset($all_enable) AND isset($all_enable) AND $all_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKALL_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>

<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Enable Prices Drop' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKSALE_ENABLE" id="FMMQUICKSALE_ENABLE_on" value="1" {if isset($sale_enable) AND isset($sale_enable) AND $sale_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKSALE_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKSALE_ENABLE" id="FMMQUICKSALE_ENABLE_off" value="0" {if isset($sale_enable) AND isset($sale_enable) AND $sale_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKSALE_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Enable Advance Search' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKADVANCE_ENABLE" id="FMMQUICKADVANCE_ENABLE_on" value="1" {if isset($advance_enable) AND isset($advance_enable) AND $advance_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKADVANCE_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKADVANCE_ENABLE" id="FMMQUICKADVANCE_ENABLE_off" value="0" {if isset($advance_enable) AND isset($advance_enable) AND $advance_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKADVANCE_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Display Category Tree' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKTREE_ENABLE" id="FMMQUICKTREE_ENABLE_on" value="1" {if isset($tree_enable) AND isset($tree_enable) AND $tree_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKTREE_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKTREE_ENABLE" id="FMMQUICKTREE_ENABLE_off" value="0" {if isset($tree_enable) AND isset($tree_enable) AND $tree_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKTREE_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>

<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Allow CSV' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKCSV_ENABLE" id="FMMQUICKCSV_ENABLE_on" value="1" {if isset($csv_enable) AND isset($csv_enable) AND $csv_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKCSV_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKCSV_ENABLE" id="FMMQUICKCSV_ENABLE_off" value="0" {if isset($csv_enable) AND isset($csv_enable) AND $csv_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKCSV_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Left Column Hook' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKHOOK1_ENABLE" id="FMMQUICKHOOK1_ENABLE_on" value="1" {if isset($hook1_enable) AND isset($hook1_enable) AND $hook1_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKHOOK1_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKHOOK1_ENABLE" id="FMMQUICKHOOK1_ENABLE_off" value="0" {if isset($hook1_enable) AND isset($hook1_enable) AND $hook1_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKHOOK1_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>

<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Right Column Hook' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKHOOK2_ENABLE" id="FMMQUICKHOOK2_ENABLE_on" value="1" {if isset($hook2_enable) AND isset($hook2_enable) AND $hook2_enable == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKHOOK2_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKHOOK2_ENABLE" id="FMMQUICKHOOK2_ENABLE_off" value="0" {if isset($hook2_enable) AND isset($hook2_enable) AND $hook2_enable == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKHOOK2_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Infinte Scrolling' mod='quickproducttable'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="FMMQUICKAJAX_ENABLE" id="FMMQUICKAJAX_ENABLE_on" value="1" {if isset($ajax_load) AND isset($ajax_load) AND $ajax_load == 1}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKAJAX_ENABLE_on">{l s='Yes' mod='quickproducttable'}</label>
			<input type="radio" name="FMMQUICKAJAX_ENABLE" id="FMMQUICKAJAX_ENABLE_off" value="0" {if isset($ajax_load) AND isset($ajax_load) AND $ajax_load == 0}checked="checked"{/if}/>
		<label class="t" for="FMMQUICKAJAX_ENABLE_off">{l s='No' mod='quickproducttable'}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>
<div class="clearfix"></div>

<div class="row col-lg-1"></div>

{foreach from=$languages item=language}
  {if $languages|count > 1}
      <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
  {/if}
  
<div class="form-group row col-lg-6">
   <label for="example-text-input" class="col-lg-12 col-form-label">{l s='Route name' mod='quickproducttable'}<a style="margin-left: 5px;" href="{$base_url|escape:'htmlall':'UTF-8'}{$route_name|escape:'htmlall':'UTF-8'}" target="_blank">{l s='Front Page (click here)' mod='quickproducttable'}</a></label>
   <div class="col-lg-10">
    
      <input class="form-control"  type="text" name="route_name_{$language.id_lang|escape:'htmlall':'UTF-8'}"  id="route_name_{$language.id_lang|escape:'htmlall':'UTF-8'}" value="{if !empty($route_name_{$language.id_lang})}{$route_name_{$language.id_lang}}{/if}" >
   </div>
   {if $languages|count > 1}
          <div class="col-lg-2">
              <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                  {$language.iso_code|escape:'htmlall':'UTF-8'}
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                  {foreach from=$languages item=lang}
                  <li><a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage({$lang.id_lang|escape:'javascript'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a></li>
                  {/foreach}
              </ul>
          </div>
      {/if}

</div>


{if $languages|count > 1}
      </div>
{/if}
{/foreach}
<div class="row col-lg-2"></div>
<div class="clearfix"></div>


<div class="row col-lg-1"></div>

{foreach from=$languages item=language}
  {if $languages|count > 1}
      <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
  {/if}
  
<div class="form-group row col-lg-6">
   <label for="example-text-input" class="col-lg-12 col-form-label">{l s='Page Heading' mod='quickproducttable'}</label>
   <div class="col-lg-10">
    
      <input class="form-control"  type="text" name="head_name_{$language.id_lang|escape:'htmlall':'UTF-8'}"  id="head_name_{$language.id_lang|escape:'htmlall':'UTF-8'}" value="{if !empty($head_name_{$language.id_lang})}{$head_name_{$language.id_lang}}{/if}" >
   </div>
   {if $languages|count > 1}
          <div class="col-lg-2">
              <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                  {$language.iso_code|escape:'htmlall':'UTF-8'}
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                  {foreach from=$languages item=lang}
                  <li><a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage({$lang.id_lang|escape:'javascript'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a></li>
                  {/foreach}
              </ul>
          </div>
      {/if}
</div>

{if $languages|count > 1}
      </div>
{/if}
{/foreach}
<div class="row col-lg-2"></div>


<div class="clearfix"></div>
