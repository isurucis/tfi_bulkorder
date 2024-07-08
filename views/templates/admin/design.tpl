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

<div class="row col-lg-1"></div>
<div class="form-group row col-lg-6">
   <label for="example-text-input" class="col-lg-12 col-form-label">{l s='Button Bootstrap Class' mod='quickproducttable'}</label>
   <div class="col-lg-10">

         <select  name="FMMQUICK_COLOR" id="FMMQUICK_COLOR">

          <option value="primary" {if isset($quick_color) && $quick_color && $quick_color == 'primary'}selected="selected"{/if}>Primary</option>
          <option value="secondary" {if isset($quick_color) && $quick_color && $quick_color == 'secondary'}selected="selected"{/if}>Secondary</option>
          <option value="success" {if isset($quick_color) && $quick_color && $quick_color == 'success'}selected="selected"{/if}>Success</option>
          <option value="danger" {if isset($quick_color) && $quick_color && $quick_color == 'danger'}selected="selected"{/if}>Danger</option>

          <option value="warning" {if isset($quick_color) && $quick_color && $quick_color == 'warning'}selected="selected"{/if}>Warning</option>
          <option value="info" {if isset($quick_color) && $quick_color && $quick_color == 'info'}selected="selected"{/if}>Info</option>
          <option value="light" {if isset($quick_color) && $quick_color && $quick_color == 'light'}selected="selected"{/if}>Light</option>
          <option value="dark" {if isset($quick_color) && $quick_color && $quick_color == 'dark'}selected="selected"{/if}>Dark</option>
        </select> 

   </div>
</div>

<div class="row col-lg-2"></div>

<div class="clearfix"></div>
<div class="row col-lg-1"></div>


<div class="form-group row col-lg-6">
   <label for="example-text-input" class="col-lg-12 col-form-label">{l s='Rows Per Page' mod='quickproducttable'}</label>
   <div class="col-lg-10">
     <input type="number" class="form-control" min="1" value="{if isset($noofrow)}{$noofrow|escape:'htmlall':'UTF-8'}{/if}" name="FMMNOOFROW" id="FMMNOOFROW">
   </div>
</div>

<div class="row col-lg-2"></div>

<div class="clearfix"></div>
