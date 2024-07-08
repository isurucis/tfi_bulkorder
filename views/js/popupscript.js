/**
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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

 (function()
{
  var defaultOptions = {
    ele: "body",
    type: "info",
    offset:
    {
      from: "top",
      amount: 20
    },
    align: "right",
    width: 350,
    delay: 3000,
    allow_dismiss: true,
    stackup_spacing: 10
  };

  $.simplyToast = function(type, message, options)
  {
    var $alert, css, offsetAmount;

    options = $.extend({}, defaultOptions, options);

    $alert = $('<div class="simply-toast alert alert-' + type + '"></div>');

    if (options.allow_dismiss)
    {
      $alert.append("<span class=\"close\" data-dismiss=\"alert\">&times;</span>");
    }

    $alert.append(message);

    if (options.top_offset)
    {
      options.offset = {
        from: "top",
        amount: options.top_offset
      };
    }
    
    offsetAmount = options.offset.amount;
    $(".simply-toast").each(function()
    {
      return offsetAmount = Math.max(offsetAmount, parseInt($(this).css(options.offset.from)) + $(this).outerHeight() + options.stackup_spacing);
    });

    css = {
      "position": (options.ele === "body" ? "fixed" : "absolute"),
      "margin": 0,
      "z-index": "9999",
      "display": "none"
    };

    css[options.offset.from] = offsetAmount + "px";

    $alert.css(css);
    
    if (options.width !== "auto")
    {
      $alert.css("width", options.width + "px");
    }

    $(options.ele).append($alert);

    switch (options.align)
    {
      case "center":
        $alert.css(
        {
          "left": "50%",
          "margin-left": "-" + ($alert.outerWidth() / 2) + "px"
        });
        break;
      case "left":
        $alert.css("left", "20px");
        break;
      default:
        $alert.css("right", "20px");
    }
    
    $alert.fadeIn();

    function removeAlert()
    {
      $alert.fadeOut(function()
      {
        return $alert.remove();
      });
    }

    if (options.delay > 0)
    {
      setTimeout(removeAlert, options.delay);
    }

    $alert.find("[data-dismiss=\"alert\"]").click(removeAlert);

    return $alert;
  };
})();