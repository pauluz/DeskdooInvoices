// pZ: te same metody dla invoices i dla quotes

        var labels, mapped;

        // pZ: uzupełnia tablice wynikami z POST json z listą produktów
        $.post("<?php echo site_url('products/ajax/modal_product_lookups_json'); ?>", {}, function(data) {
            labels = [];
            mapped = {};

            $.each(data, function (i, item) {
                var query_label = item.ProductName + ' (cena: ' + item.ProductFormatPrice + ')';

                // mapping object
                mapped[query_label] = item;
                labels.push(query_label);
            });

        }, 'json');

        var typeahead_object = {
            source: function (query, process) {
                process(labels);
                this.source = labels;
            },
            updater: function (query_label) {
                var item = mapped[query_label];

                var id_str = this.$element[0].id;
                var id = id_str.substr(id_str.lastIndexOf('_') + 1);

                $('#typeahead_price_' + id).val(item.ProductPrice);

                if ($('#typeahead_quantity_' + id).val() == '') {
                    $('#typeahead_quantity_' + id).val('1');
                }

                return item.ProductName;
            }
        };

        $("input[name='item_name']").typeahead(typeahead_object);

        $('.typeahead_button').click(function () {
            var kl = $(this).parent().$('input');
            console.log(kl);
        });

        $('.btn_add_product').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('products/ajax/modal_product_lookups'); ?>/" + Math.floor(Math.random() * 1000));
        });

        var add_row_function = function () {
            var id = Math.round(Math.random()*999999);
            var new_row = $('#new_row').clone().removeAttr('id').attr('id', 'row_'+id);
            new_row.find('.btn_delete_row').click(function () {
                $('#row_'+id).remove();
            });
            new_row.appendTo('#item_table').addClass('item').show();

            // pZ: ustawiam nowe indywidualne ID
            new_row.find('#typeahead_name_new').attr('id', 'typeahead_name_'+id);;
            new_row.find('#typeahead_price_new').attr('id', 'typeahead_price_'+id);;
            new_row.find('#typeahead_quantity_new').attr('id', 'typeahead_quantity_'+id);;

            new_row.find("input[name='item_name']").typeahead(typeahead_object);

            return false;
        };

        $('.btn_add_row').click(add_row_function);

// pZ: koniec 'add_product_and_row.js'
