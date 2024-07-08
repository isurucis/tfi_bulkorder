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
<div class="row col-lg-2"></div>

<div class="col-lg-6 form-group margin-form">
	<label for="example-text-input" class="col-lg-12 col-form-label">{l s='Allow Groups' mod='quickproducttable'}</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="fixed-width-xs">
                            <span class="title_box">
							<input type="checkbox" name="checkme" id="checkme" onclick="checkDelBoxes(this.form, 'groupBox[]', this.checked)">
						</span>
                        </th>
                        <th class="fixed-width-xs"><span class="title_box">{l s='ID' mod='quickproducttable'}</span></th>
                        <th>
                            <span class="title_box">
							{l s='Group' mod='quickproducttable'}
						</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                	{foreach from=$groups item=group}
                    <tr>
                        <td>
                            <input type="checkbox" name="groupBox[]" class="groupBox" id="groupBox_{$group['id_group']|escape:'htmlall':'UTF-8'}" value="{$group['id_group']|escape:'htmlall':'UTF-8'}" {if {$group['select']} == 1} checked="checked" {/if} >
                        </td>
                        <td>{$group['id_group']|escape:'htmlall':'UTF-8'}</td>
                        <td>
                            <label for="groupBox_{$group['id_group']|escape:'htmlall':'UTF-8'}">{$group['name']|escape:'htmlall':'UTF-8'}</label>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
    </div>
    <div class="clearfix"></div>

<div class="row col-lg-2"></div>

