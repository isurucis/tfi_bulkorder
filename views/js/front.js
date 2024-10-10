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

 function fmmAddAllCart(){
  let checkedItems = JSON.parse(localStorage.getItem('checkedItems')) || [];
  console.log("function : fmmAddAllCart, is called");
            var coun = 0;
            /*$.each($("input[name='fmm_check']:checked"), function(){
                var id_product = $(this).val();
                coun = 1;
                var qty = $("#quantity_"+id_product).val();
                var group_aray = [];
                var ajax_url = $("#ajax_url").val();
                var group = $("#group_"+id_product).val();
                if (group == 0) {

                } else {
                    var i;
                    for (i = 1; i <= group; i++) {
                      var group_id = $(".fmm_option_"+id_product+"_"+i).val();
                      group_aray.push(group_id);
                    }
                }
                $.ajax({
                        url: ajax_url,
                        method: "post",
                        data: {
                          id_product: id_product,qty: qty,group_aray: group_aray, ajax:1, action: 'productAddToCart' 
                        },
                        dataType: "json",
                        success: function(data) {
                        }
                    });
                
            });*/



            $.each(checkedItems, function(index, item){
              coun = 1;
              var id_product = item.id; // Assuming each item in localStorage has 'id_product'
              var qty = item.qty; // Assuming each item has 'qty'
              var group_aray = [];
              var ajax_url = $("#ajax_url").val(); // Get the ajax URL from the page
              var group = item.group || 0; // Assuming each item may have 'group' information, default to 0
          
              if (group != 0) {
                  // If the product has groups, retrieve each group option
                  for (var i = 1; i <= group; i++) {
                      var group_id = item["group_option_" + i]; // Assuming group options are stored in the item
                      group_aray.push(group_id);
                  }
              }
          
              // Perform the AJAX request to add the product to the cart
              $.ajax({
                  url: ajax_url,
                  method: "post",
                  data: {
                    id_product: id_product,
                    qty: qty,
                    group_aray: group_aray,
                    ajax: 1,
                    action: 'productAddToCart'
                  },
                  dataType: "json",
                  success: function(data) {
                      // Handle the response if needed
                    /*if (data.status === 'success') {
                        // Redirect to cart page or confirmation page on success
                        console.log('data.status:', data.status);
                        window.location.href = 'https://mediumturquoise-cheetah-573749.hostingersite.com/cart?action=show';
                    } else {
                        // Handle errors if the AJAX request fails (optional)
                        console.error('Error adding product to cart:', data.message);
                    }*/
                    window.location.reload(true);
                    //window.location.href = 'https://mediumturquoise-cheetah-573749.hostingersite.com/cart?action=show';
                  }
              });
          });

            if (coun == 1) {
                $('input:checkbox').removeAttr('checked'); 
                $.simplyToast('success', 'Products successfully added to your shopping cart');
            } else {
               $.simplyToast('warning', 'You need to select products first');
            }
 }
// Handle minus button click
$('#fmm_table').on('click', 'span.minus-bulkorder', function(e) {
  console.log("Event: minus, is called");
  var $input = $(this).parent().find('input');
  var id = $input.attr('id')
  var number = id.split("_")[1];
  var minValue = parseInt($input.attr('min'));
  var stock = parseInt($input.attr('stk'));
  let boxqty = Math.floor((minValue*20)/4);
  if($input.val()<=boxqty){
    var i = minValue < 1 ? 1 : minValue;
    $('input[name="qty_qty_' + number + '"][value="moq"]').prop('checked', true);
    

    
  }else{
    var i = boxqty;
    $('input[name="qty_qty_' + number + '"][value="case"]').prop('checked', true);
    

  }
  
  var count = parseInt($input.val()) - i;
  count = count < i ? i : count; // Ensure count is not less than minValue
  $input.val(count);
  $input.change(); // Trigger change event to update case value
  updateCaseValue($input); // Update case value after changing quantity
  return false;
});

// Handle plus button click
$('#fmm_table').on('click', 'span.plus-bulkorder', function(e) {
  console.log("Event: plus, is called");
  var $input = $(this).parent().find('input');
  var id = $input.attr('id')
  var number = id.split("_")[1];
  //alert(number);
  var minValue = parseInt($input.attr('min'));
  var stock = parseInt($input.attr('stk'));
  let boxqty = Math.floor((minValue*20)/4);
  //var i = minValue < 1 ? 1 : minValue;

  if($input.val()>=boxqty){
    var i = boxqty;
    $('input[name="qty_qty_' + number + '"][value="case"]').prop('checked', true);
    //$('input[name="qty_case_' + number + '"]').prop('disabled', true);
  }else{
    var i = minValue < 1 ? 1 : minValue;
    if($input.val()==(boxqty-minValue)){
      $('input[name="qty_qty_' + number + '"][value="case"]').prop('checked', true);
      //$('input[name="qty_case_' + number + '"]').prop('disabled', true);

    }else{
      $('input[name="qty_qty_' + number + '"][value="moq"]').prop('checked', true);
      //$('input[name="qty_case_' + number + '"]').prop('disabled', false);

    }

  }
  if(stock>=(parseInt($input.val()) + i)){
  $input.val(parseInt($input.val()) + i);
  }
  $input.change(); // Trigger change event to update case value
  updateCaseValue($input); // Update case value after changing quantity
  return false;
});

// Handle moq or case radio button change
$('#fmm_table').on('change', 'input[name^="qty_qty_"]', function() {
  // Get the name of the selected radio button
  var radioName = $(this).attr('name');  // e.g., qty_case_1
  
  // Extract the number from the name
  var number = radioName.split('_')[2];  // Get the number part, e.g., '1'
  var selection = $(this).val();
  var $input = $('input[id="quantity_' + number + '"]');

  var minValue = parseInt($input.attr('min'));
  var stock = parseInt($input.attr('stk'));
  let boxqty = Math.floor((minValue*20)/4);
  // Call your function and pass the selected number
  //alert(minValue); // Pass the number and selected value
  if(selection=='moq'){
    if($input.val()>=boxqty){
    $input.val(boxqty-minValue);
    }
  }else if(selection=='case'){
    if($input.val()<(boxqty)){
    $input.val(boxqty);
    }
  }
  updateCaseValue($input);
  calculateRowAmount(number); // update the row amount
});



// Update the case value based on quantity input
function updateCaseValue(qtyInput) {
  let minValue = parseInt(qtyInput.attr('min'));
  let quantityValue = parseInt(qtyInput.val());
  let numberOfCases = Math.floor(quantityValue / ((minValue*20)/4)); // Calculate number of cases
  let priceBoxCalc = $('#price_box_calc_' + qtyInput.attr('id').split('_')[1]);

  // Update the case value in the UI
  priceBoxCalc.text(numberOfCases + ' Case' + (numberOfCases > 1 ? 's' : ''));
}

// Trigger the update when the quantity input changes manually
$('#fmm_table').on('change', 'input.qty_id-bulkorder', function() {
  updateCaseValue($(this)); // Call updateCaseValue on change
  var itemid = $(this).attr('row_id');
  calculateRowAmount(itemid);
});

  function fmmAddCart(id, group){
    console.log("Function : fmmAddCart, is called");
        var id_product = id;
        var ajax_url = $("#ajax_url").val();
        var qty = $("#quantity_"+id).val();
        var isint = $.isNumeric(qty);
        var error = 0;
        if (qty <= 0 || isint != true) {
            var error = 1;
            $.simplyToast('warning', 'Product is Not Available with this Quantity');
        }
        var group_aray = [];
        if (group == 0) {

        } else {
            var i;
            for (i = 1; i <= group; i++) {
              var group_id = $(".fmm_option_"+id+"_"+i).val();
              group_aray.push(group_id);
            }
        }
        if (error == 0) {
            $.ajax({
                url: ajax_url,
                method: "post",
                data: {
                  id_product: id_product,qty: qty,group_aray: group_aray, ajax:1, action: 'productAddToCart' 
                },
                dataType: "json",
                success: function(data) {
                  if (data==1) {
                    $.simplyToast('success', 'Product successfully added to your shopping cart');
                  } else if(data == 111) {
                    $.simplyToast('warning', 'Product is Not Available with this combination');
                  } else {
                    $.simplyToast('warning', 'Product is Not Available with this Quantity');
                  }
                },
                error: function() { 
                    $.simplyToast('warning', 'Product is Not Available with this Quantity');
                } 
            });
        }
  }


function getRelProducts(e) {
  console.log("Function : getRelProducts, is called");
  var cat = [];
  $('input.tree:checkbox:checked').each(function () {
      cat.push($(this).val());
  });
  var ajax_url = $("#ajax_url").val();
  var search_q_val = $(e).val();
  //controller_url = controller_url+'&q='+search_q_val;
  if (typeof search_q_val !== 'undefined' && search_q_val) {
    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: ajax_url + '&q=' + search_q_val + '&ajax=1&action=getSearchProducts&forceJson=1&disableCombination=0&exclude_packs=0&excludeVirtuals=0&limit=1&cat='+cat,
      success: function(data)
      {
        var quicklink_list ='<li class="rel_breaker" onclick="relClearData();"><i class="material-icons">&#xE14C;</i></li>';
        $.each(data, function(index,value){
          if (typeof data[index]['id'] !== 'undefined')
            quicklink_list += '<li onclick="relSelectThis('+data[index]['id']+','+data[index]['id_product_attribute']+',\''+data[index]['name']+'\',\''+data[index]['image']+'\',\''+data[index]['price']+'\');"><img src="' + data[index]['image'] + '" width="60"> ' + data[index]['name'] + '</li>';
        });
        if (data.length == 0) {
          quicklink_list = '';
        }
        $('#rel_holder').html('<ul>'+quicklink_list+'</ul>');
      },
      error : function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(textStatus);
      }
    });
  }
  else {
    $('#rel_holder').html('');
  }
}

function relSelectThis(id, ipa, name, img, price) {
  console.log("Function : relSelectThis, is called");
  if (ipa === undefined) {
    ipa = 0;
  }
  if ($('#row_' + id + '_' + ipa).length > 0) {
    showErrorMessage(error_msg);
  } else {
      var draw_html = '<li id="row_' + id + '" class="media"><div class="media-left"><img src="'+img+'" class="media-object image"></div><div class="media-body media-middle"><span class="label">'+name+'&nbsp;(PRICE:'+Math.round(price)+')<i onclick="relDropThis(this);" class="material-icons delete">clear</i><i onclick="relAddThis('+id+','+ipa+');"class="material-icons">add_shopping_cart</i><label style="margin-left: 5%;margin-right: 10px;color: #b1aaaa;">QTY</label><input class="qty_id" id="qty_'+id+'" type="number" value="1"></span></div><input type="hidden" value="'+id+','+ipa+'" name="related_products[]"><input type="hidden" value="'+ipa+'"  name="attr_related_products[]"></li>'
      $('#rel_holder_temp ul').append(draw_html);
  }
}

function relClearData() {
  console.log("Function : relClearData, is called");
    $('#rel_holder').html('');
}
function relDropThis(e) {
  console.log("Function : relDropThis, is called");
    $(e).parent().parent().parent().remove();
}
function relAddThis(id_product,id_attr) {
  console.log("Function : relAddThis (id_product, id_attr), is called");
    var qty = $("#qty_"+id_product).val();
    var isint = $.isNumeric(qty);
    if (qty <= 0 || isint != true) {
            $.simplyToast('warning', 'Product is Not Available with this Quantity');
            return 0;
        }
    var ajax_url = $("#ajax_url").val();
    $.ajax({
                url: ajax_url,
                method: "post",
                data: {
                  id_product: id_product,qty: qty,id_attr: id_attr, ajax:1, action: 'productAddToCartOne' 
                },
                dataType: "json",
                success: function(data) {
                    $.simplyToast('success', 'Product successfully added to your shopping cart');
                    $("#row_"+id_product).remove();
                },
                error: function() { 
                    $.simplyToast('warning', 'Product is Not Available with this Quantity');
                } 
            });

}

function textareaClick() {
  console.log("Function : textareaClick, is called");
    var ajax_url = $("#ajax_url").val();
    var texta = $("#csv_sku").val();
    $.ajax({
        url: ajax_url,
        method: "post",
        data: {
            texta: texta, ajax:1, action: 'productSku' 
        },
        dataType: "json",
        success: function(data) {
            if (data>0) {
                $.simplyToast('success', 'Product successfully added to your shopping cart');
                $('#csv_sku').val("");
            } else {
                $.simplyToast('warning', 'Product Information is not valid');
            }
            
        }
    });
}

function downloadSampleCSV(filelocation, filename) {
  //alert("HYes22"); exit;
  var textFile = filename; //$('.postingFile textarea').val();
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(textFile));
  element.setAttribute("download", filelocation+filename);
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
}


$('#chkal').on( 'change', function() {
  console.log("Event : chkal, is called");
    if($(this).prop("checked") == true){
        $('input:checkbox').prop('checked',true);
    }else{
      $('input:checkbox').removeAttr('checked');
    }
  });
$('#chkal2').on( 'change', function() {
  console.log("Event : chkal2, is called");
    if($(this).prop("checked") == true){
        $('input:checkbox').prop('checked',true);
    }else{
      $('input:checkbox').removeAttr('checked');
    }
  });

function changeAttr(id, group) {
  console.log("Function : chkal2, is called");


        var id_product = id;
        var ajax_url = $("#ajax_url").val();
        var error = 0;
        var group_aray = [];
        if (group == 0) {

        } else {
            var i;
            for (i = 1; i <= group; i++) {
              var group_id = $(".fmm_option_"+id+"_"+i).val();
              group_aray.push(group_id);
            }
        }
        if (error == 0) {
            $.ajax({
                url: ajax_url,
                method: "post",
                data: {
                  id_product: id_product,group_aray: group_aray, ajax:1, action: 'productChangeAttr' 
                },
                dataType: "json",
                success: function(data) {
                    $("#price_"+id_product).text(data);
                }
            });
        }
}

 $('#cal').on( 'change', function() {
  console.log("Event : cal, is called");
    if($(this).prop("checked") == true){
        $('input:checkbox').prop('checked',true);
    }else{
      $('input:checkbox').removeAttr('checked');
    }
  });


$('div.dataTables_filter input').addClass('form-control');



$( document ).ready(function() {
  //dataTableInit(3);
    //var fmmDataTable = "";
    var def_currency = $("#def_currency").val();
    var groupColumn = 3;
    console.log("Event : DataTable - fmm_table, is called");

    var fmmDataTable = $('#fmm_table').DataTable({
      columnDefs: [{ visible: false, targets: groupColumn }],
      order: [[groupColumn, 'asc']],
      displayLength: 25,
      drawCallback: function (settings) {
        var api = this.api();
        var rows = api.rows({ page: 'current' }).nodes();
        var last = null;
 
        api.column(groupColumn, { page: 'current' })
            .data()
            .each(function (group, i) {
                if (last !== group) {
                    $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td colspan="9">' +
                                group +
                                '</td></tr>'
                        );
 
                    last = group;
                }
            });
      },
      rowReorder: {
          selector: 'td:nth-child(2)'
      },
      rowGroup: {
        dataSrc: groupColumn
      },
      "lengthChange": false,
      "info":     false,
      responsive: true,
      "pageLength": noofrow,
      orderCellsTop: true,
      fixedHeader: true,
      "serverSide": false,
      dom: "<'row'<'col-sm-5'p><'col-sm-4'f><'col-sm-3 topinbuttons'>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'p><'col-sm-4'><'col-sm-3 botinbuttons'>>",

    });


    // $("#fmm_table_paginate").hide();
    var content = '<i class="material-icons srcicon" tabindex="0" role="button">search</i>';
    $("#fmm_table_filter").append(content); 

   
    var botinbuttons22 = '<div class="col-lg-12 col-xs-12 top_buttons" >\
                          <a class="btn btn-primary" href="'+$("#cart_url").val()+'">View Cart</a>\
                          <button class="btn btn-primary" onclick="fmmAddAllCart();" >Add To Cart</button>\
                          </div>'
    var topinbuttons22 = '<div class="col-lg-12 col-xs-12 top_buttons div_total_amount" id="div_total_amount" >\
                            <span>Product Total </span>\
                            <span id="spn_total_amount_disp" class="spn_total_amount_disp">'+def_currency+'0.00</span>\
                            </div>';
    $(".topinbuttons").append(topinbuttons22);
    $(".botinbuttons").append(botinbuttons22);
    //<span> (+Shipping +Tax)</span>\

    $('.read-b2b-imagepopup').fancybox({
        'hideOnContentClick': false
    });
    

    var dataTableInit = function(groupColumn) {
      //var groupColumn = 3;
      console.log("Event : DataTable - fmm_table, is called");
      fmmDataTable = $('#fmm_table').DataTable({
        columnDefs: [{ visible: false, targets: groupColumn }],
        order: [[groupColumn, 'asc']],
        displayLength: 25,
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
         
            api.column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before(
                                '<tr class="group"><td colspan="9">' +
                                    group +
                                    '</td></tr>'
                            );
         
                        last = group;
                    }
                });
        },
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        rowGroup: {
          dataSrc: 'group'
        },
        "lengthChange": false,
        "info":     false,
        responsive: true,
        "pageLength": noofrow,
        orderCellsTop: true,
        fixedHeader: true,
        "serverSide": false,
        dom: "<'row'<'col-sm-5'p><'col-sm-4'f><'col-sm-3 topinbuttons'>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'p><'col-sm-4'><'col-sm-3 botinbuttons'>>",
      });
      // $("#fmm_table_paginate").hide();
      var content = '<i class="material-icons srcicon" tabindex="0" role="button">search</i>';
      $("#fmm_table_filter").append(content); 
    
    
      $('.read-b2b-imagepopup').fancybox({
          'hideOnContentClick': false
      });
    }

    //.............................................................
    $('#select_fmm_country').on('change', function() {
      dataTableChangeNew();
    });
    $('#select_fmm_view').on('change', function() {
      dataTableChangeNew();
    });
    $('#select_fmm_cat').on('change', function() {
      //var id_category = this.value;
      //var ajax_url = $("#ajax_url").val();
      //var product_type = $("#product_type").val();
      //console.log("id_category : "+id_category+"\n ajax_url : "+ajax_url+"\n product_type : "+product_type+"\n action : productChangeCategory");
      //var fmmDataTable = $('#fmm_table').DataTable();
      
      //fmmDataTable.clear();
      //fmmDataTable.destroy();
      //var fmmDataTable = $('#fmm_table').DataTable();
      dataTableChangeNew();
      /*
      var fmmDataTableId = '#fmm_table';

      $.ajax({
          type: 'POST',
          url: ajax_url,
          data: {
              id_category: id_category ,ajax:1,product_type:product_type, action: 'productChangeCategory'
          },
          beforeSend: function() {
            

            //2nd empty html
            //$(fmmDataTableId + " tbody").empty();
            //$(fmmDataTableId + " thead").empty();

            
          },
          success: function(response){
            console.log(response);

            // clear first
            if(fmmDataTable!=null){
              //fmmDataTable.clear();
              //fmmDataTable.destroy();
              //$(fmmDataTableId + " tbody").clear();
              //$(fmmDataTableId + " tbody").destroy();
              $(fmmDataTableId + " tbody").html('');

            }
            //$(fmmDataTableId + " tbody").append(response);
            if (response != 2) {
              console.log("Data Available");
                //$('#fmm_table_body').html('');
                //$('#fmm_table_body').append(response);
                //$("#fmm_table_paginate").hide();


                $(fmmDataTableId + " tbody").append(response);

                
                
                //fmmDataTable.clear();
                //fmmDataTable.add(response).draw();
                //fmmDataTable.destroy();
                //fmmDataTable = "";

                //$('#fmm_table').DataTable({ 
                //    "destroy": true, //use for reinitialize datatable
                //});

            } else {
                console.log("Data NOT Available");
                $("#loader").hide();
            }

            //3rd reCreate Datatable object
            fmmDataTable = $(fmmDataTableId).DataTable();
          }, 
          complete: function() {
            //dataTableInit(3);
            //var fmmDataTable = $('#fmm_table').DataTable();
          }
      
      });
      */
    });
    
    var dataTableChangeNew = function() {
      var id_category       = $('#select_fmm_cat').val(); //this.value;
      var id_country        = $('#select_fmm_country').val();   // countryid
      var id_view           = $('#select_fmm_view').val();  // 0=all |1=stock |2=outofstock

      var ajax_url          = $("#ajax_url").val();
      var product_type      = $("#product_type").val();   // all |new |sale |csv
      console.log("id_category : "+id_category+"\n id_country : "+id_country+"\n id_view : "+id_view+"\n ajax_url : "+ajax_url+"\n product_type : "+product_type+"\n action : productChangeCategory");
      //var fmmDataTable = $('#fmm_table').DataTable();
      
      //fmmDataTable.clear();
      //fmmDataTable.destroy();
      //var fmmDataTable = $('#fmm_table').DataTable();
      
      var fmmDataTableId = '#fmm_table';

      $.ajax({
          type: 'POST',
          url: ajax_url,
          data: {
              id_category: id_category , id_country: id_country, id_view: id_view, ajax:1, product_type: product_type, action: 'productChangeCategory'
          },
          beforeSend: function() { },
          success: function(response){
            console.log(response);

            // clear first
            if(fmmDataTable!=null){
              $(fmmDataTableId + " tbody").html('');
            }
            //$(fmmDataTableId + " tbody").append(response);
            if (response != 2) {
              console.log("Data Available");

              $(fmmDataTableId + " tbody").append(response);

            } else {
                console.log("Data NOT Available");
                $("#loader").hide();
            }

            //3rd reCreate Datatable object
            fmmDataTable = $(fmmDataTableId).DataTable();
          }, 
          complete: function() {
            dataTableInit(3);
            //var fmmDataTable = $('#fmm_table').DataTable();
          }
      
      });
    }
    //.............................................................


    $(document).on('click', '.notify-me-btn', function () {
        var productId = $(this).data('id-product'); // Get the product ID from data attribute
        //alert(productId);
        // Prompt the user for their email
        var email = prompt("Please enter your email to be notified for product ID: " + productId);

        if (email) {
            // Send an AJAX request to add the email to the notification list
            $.ajax({
                type: "POST",
                url: 'https://mediumturquoise-cheetah-573749.hostingersite.com/index.php?process=add&fc=module&module=ps_emailalerts&controller=actions', // Email Alerts module's actions.php
                data: {
                    process: 'add',
                    email: email,
                    id_product: productId
                },
                success: function (response) {
                    alert('You will be notified when product ' + productId + ' is back in stock.');
                },
                error: function () {
                    alert('There was an error processing your request. Please try again.');
                }
            });
        }
    });
});
