<script type='text/javascript'>
    var sender_currency;
    var reciever_currency;
    $(function() {
        $('sender_currency').change(function() {
            var selected = $(this).find('option:selected');
            var sender_currency = selected.data('rate');
        });
    });
    $(function() {
        $('reciever_currency').change(function() {
            var selected = $(this).find('option:selected');
            var reciever_currency = selected.data('rate');
        });
    });


    $(document).ready(function() {
        var float = {{ Js::from(config('app.Floating-Point')) }};
        var baseCurrency = {{ Js::from(config('app.Base-Currency')) }};





        $('#amount').hide();
        $('#submit_button').hide();
        $('#progress').hide();
        $('#sent_amount').hide();
        $('#rate').hide();
        $('#details').hide();
        $('#form_element').hide();

        var switchStatus = true;
        $("#switch1").on('change', function() {
            if ($(this).is(':checked')) {
                switchStatus = $(this).is(':checked');

            } else {
                switchStatus = $(this).is(':checked');

            }
        });

        var rate2 = 0;

        $('#amount_sent_label').text("Amount To Sent in " + {{ Js::from($user_currency) }});
        $('#amount_receive_label').text("Amount To Receive in " + rate2);

        // Department Change
        $('#amount_sent_btn').click(function() {

            //var sender_currency_rate=$('#sender_currency').val();
            let element_sender = document.getElementById("sender_currency");
            let sender_currency_rate = element_sender.options[element_sender.selectedIndex]
                .getAttribute("data-rate");
            let sender_perc = element_sender.options[element_sender.selectedIndex]
                .getAttribute("data-charges");


            let sender_currency = element_sender.options[element_sender.selectedIndex]
                .getAttribute("value");
            let element_receiver = document.getElementById("receiver_currency");
            let receiver_currency_rate = element_receiver.options[element_receiver.selectedIndex]
                .getAttribute("data-rate");
            let receiver_currency = element_receiver.options[element_receiver.selectedIndex]
                .getAttribute("value");
            let receiver_perc = element_receiver.options[element_receiver.selectedIndex]
                .getAttribute("data-charges");
            var currencyRate = (1 / sender_currency_rate) * receiver_currency_rate;


            var currencyRate = (1 / sender_currency_rate) * receiver_currency_rate;
            var currency = $('#amount_sent').val();
            var amount = currency.replace(/[$,]+/g, "");
            var perc = receiver_perc;
            var total = 0;
            var totalRW = 0;
            var fee = 0;
            var receivable_amount = 0;
            var feeRW = 0;
            var sentAmount = 0;

            if ({{ Js::from($pricing_plan) }} == 'percentage') {
                if (switchStatus == true) {
                    fee = parseFloat(amount * (perc / 100)).toFixed(2);
                    feeRW = fee / sender_currency_rate;
                    total = parseFloat(amount).toFixed(2);
                    totalRW = total / sender_currency_rate;
                    sentAmount = total - fee;
                    $('#feeRW').text("Transfer Fee in " + baseCurrency + ": " + formatMoney(parseFloat(
                        feeRW).toFixed(2)));
                    $('#totalRW').text("Transfer amount in " + baseCurrency + " : " + formatMoney(
                        parseFloat(totalRW).toFixed(2)));
                    $('#total_amount_with_fee').text("Transfer amount + Fee in " + sender_currency +
                        ": " + formatMoney(total));
                    $('#recievable_amount').text("Recievable amount in " + receiver_currency + " : " +
                        formatMoney(parseFloat(sentAmount * currencyRate).toFixed(2)));

                    $('#charges').text("Transfer Fee in " + sender_currency + ": " + formatMoney(
                        parseFloat(fee).toFixed(2)));
                    $('#charges_h').val(fee);
                    $('#charges_rw').val(feeRW);
                    $('#amount_rw_currency').val(totalRW);
                    $('#total_amount_local').text("Sent Amount: in " + sender_currency + ": " +
                        formatMoney(parseFloat(sentAmount).toFixed(2)));


                } else {
                    fee = parseFloat(amount) * parseFloat(perc) / (100);
                    sentAmount = parseFloat(amount).toFixed(2);

                    total = eval(sentAmount) + eval(fee);

                    totalRW = total / sender_currency_rate;
                    feeRW = fee / sender_currency_rate;

                    $('#feeRW').text("Transfer Fee in " + baseCurrency + ": " + formatMoney(parseFloat(
                        feeRW).toFixed(2)));
                    $('#totalRW').text("Transfer amount in " + baseCurrency + " : " + formatMoney(
                        parseFloat(totalRW).toFixed(2)));
                    $('#total_amount_with_fee').text("Transfer amount + Fee in " + sender_currency +
                        ": " + formatMoney(parseFloat(total).toFixed(2)));
                    $('#recievable_amount').text("Recievable amount in " + receiver_currency + " : " +
                        formatMoney(parseFloat(sentAmount * currencyRate).toFixed(2)));

                    $('#charges').text("Transfer Fee in " + sender_currency + ": " + formatMoney(
                        parseFloat(fee).toFixed(2)));
                    $('#charges_h').val(parseFloat(fee).toFixed(2));
                    $('#amount_rw_currency').val(totalRW);
                    $('#charges_rw').val(feeRW);
                    $('#total_amount_local').text("Sent Amount: in " + sender_currency + ":" +
                        formatMoney(sentAmount));




                }
            } else {

                $.each({{ Js::from($flate_rates) }}, function() {

                    if (switchStatus == true) {
                        total = parseFloat(amount);
                        if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent')
                            .val() <= this.to_amount) {
                            $('#charges').val("Transfer Fee: " + parseFloat(this.charges_amount)
                                .toFixed(2));
                            $('#charges_h').val(this.charges_amount);
                            $('#total_amount_local').text("Total amount: " + parseFloat(total)
                                .toFixed(2));
                        } else {
                            $('#charges').val("");
                            $('#charges_h').val("");
                            $('#total_amount_local').text("");
                        }
                    } else {
                        total = parseFloat(this.charges_amount) + parseFloat(amount);
                        if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent')
                            .val() <= this.to_amount) {
                            $('#charges').val("Transfer Fee: " + parseFloat(this.charges_amount)
                                .toFixed(2));
                            $('#charges_h').val(parseFloat(this.charges_amount));
                            $('#total_amount_local').text("Total amount: " + parseFloat(total)
                                .toFixed(2));
                        } else {
                            $('#charges').val("");
                            $('#charges_h').val("");
                            $('#total_amount_local').text("");
                        }
                    }


                });
            }
            $('#amount_receive').val(formatMoney(parseFloat(sentAmount * currencyRate).toFixed(2)));
            $('#amount_local_currency_id').val(parseFloat(total));
            $('#amount_foregn_currency_id').val(parseFloat(sentAmount * currencyRate).toFixed(2));
        });

        $('#amount_receive_btn').click(function() {

            //var sender_currency_rate=$('#sender_currency').val();
            let element_sender = document.getElementById("sender_currency");
            let sender_currency_rate = element_sender.options[element_sender.selectedIndex]
                .getAttribute("data-rate");
            let sender_perc = element_sender.options[element_sender.selectedIndex]
                .getAttribute("data-charges");


            let sender_currency = element_sender.options[element_sender.selectedIndex]
                .getAttribute("value");
            let element_receiver = document.getElementById("receiver_currency");
            let receiver_currency_rate = element_receiver.options[element_receiver.selectedIndex]
                .getAttribute("data-rate");
            let receiver_currency = element_receiver.options[element_receiver.selectedIndex]
                .getAttribute("value");
            let receiver_perc = element_receiver.options[element_receiver.selectedIndex]
                .getAttribute("data-charges");
            var currencyRate = (1 / sender_currency_rate) * receiver_currency_rate;


            var currency = $('#amount_receive').val();
            var amount = currency.replace(/[$,]+/g, "");

            var perc = receiver_perc;
            var total = 0;
            var totalLocal = 0;
            var totalRW = 0;
            var fee = 0;
            var feeRW = 0;
            var feeLocal = 0;
            var receivable_amount = 0;
            var sentAmount = 0;


            if ({{ Js::from($pricing_plan) }} == 'percentage') {
                if (switchStatus == true) {
                    //fee = parseFloat(amount *(1+ (perc / 100))).toFixed(2);

                    total = parseFloat(amount / ((100 - perc) / 100)).toFixed(5);

                    totalLocal = total / currencyRate;
                    totalRW = total / sender_currency_rate;
                    fee = total * (perc / 100);
                    feeLocal = fee / currencyRate;
                    sentAmount = totalLocal;

                    totalRW = totalLocal / sender_currency_rate;
                    feeRW = feeLocal / sender_currency_rate;
                    receivable_amount = parseFloat(amount).toFixed(2);

                    $('#feeRW').text("Transfer Fee in " + baseCurrency + ": " + formatMoney(parseFloat(
                        feeRW).toFixed(2)));
                    $('#totalRW').text("Transfer amount in " + baseCurrency + " : " + formatMoney(
                        parseFloat(totalRW).toFixed(2)));
                    $('#total_amount_with_fee').text("Transfer amount + fee in " + sender_currency +
                        ": " + formatMoney(parseFloat(totalLocal).toFixed(2)));
                    $('#recievable_amount').text("Recievable amount in " + receiver_currency + " : " +
                        formatMoney(parseFloat(amount).toFixed(2)));


                    $('#charges').text("Transfer Fee in " + sender_currency + ": " + formatMoney(
                        parseFloat(feeLocal).toFixed(2)));
                    $('#charges_h').val(feeLocal);
                    $('#charges_rw').val(feeRW);
                    $('#amount_rw_currency').val(totalRW);
                    $('#total_amount_local').text("Sent Amount: in " + sender_currency + ":" +
                        formatMoney(parseFloat(sentAmount - feeLocal).toFixed(2)));
                } else {

                    fee = parseFloat(amount * (perc / (100 - perc)));
                    feeLocal = fee / currencyRate;
                    total = parseFloat(amount) + fee;
                    totalLocal = total / currencyRate;
                    totalRW = totalLocal / sender_currency_rate;

                    feeRW = feeLocal / sender_currency_rate;
                    sentAmount = totalLocal - feeLocal;

                    totalRW = totalLocal / sender_currency_rate;
                    feeRW = feeLocal / sender_currency_rate;

                    receivable_amount = parseFloat(amount).toFixed(2);

                    $('#feeRW').text("Transfer Fee in " + baseCurrency + ": " + formatMoney(parseFloat(
                        feeRW).toFixed(2)));
                    $('#totalRW').text("Transfer amount in " + baseCurrency + " : " + formatMoney(
                        parseFloat(totalRW).toFixed(2)));
                    $('#total_amount_with_fee').text("Transfer amount + fee : in " + sender_currency +
                        ": " + formatMoney(parseFloat(totalLocal).toFixed(2)));
                    $('#recievable_amount').text("Recievable amount in " + receiver_currency + " : " +
                        formatMoney(parseFloat(amount).toFixed(2)));

                    $('#charges').text("Transfer Fee in " + sender_currency + ": " + formatMoney(
                        parseFloat(feeLocal).toFixed(2)));
                    $('#charges_h').val(parseFloat(feeLocal).toFixed(2));
                    $('#charges_rw').val(feeRW);
                    $('#amount_rw_currency').val(totalRW + feeRW);
                    $('#total_amount_local').text("Sent Amount: in " + sender_currency + ":" +
                        formatMoney(parseFloat(sentAmount).toFixed(2)));
                }
            } else {

                $.each({{ Js::from($flate_rates) }}, function() {

                    if (switchStatus == true) {
                        total = parseFloat(amount);
                        if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent')
                            .val() <= this.to_amount) {
                            $('#charges').val("Transfer Fee: " + parseFloat(this.charges_amount)
                                .toFixed(2));
                            $('#charges_h').val(this.charges_amount);
                            $('#total_amount_local').text("Total amount: " + parseFloat(total)
                                .toFixed(2));
                        } else {
                            $('#charges').val("");
                            $('#charges_h').val("");
                            $('#total_amount_local').text("");
                        }
                    } else {
                        total = parseFloat(this.charges_amount) + parseFloat(amount);
                        if ($('#amount_sent').val() >= this.from_amount && $('#amount_sent')
                            .val() <= this.to_amount) {
                            $('#charges').val("Transfer Fee: " + parseFloat(this.charges_amount)
                                .toFixed(2));
                            $('#charges_h').val(parseFloat(this.charges_amount));
                            $('#total_amount_local').text("Total amount: " + parseFloat(total)
                                .toFixed(2));
                        } else {
                            $('#charges').val("");
                            $('#charges_h').val("");
                            $('#total_amount_local').text("");
                        }
                    }


                });
            }
            $('#amount_sent').val(formatMoney(parseFloat(sentAmount).toFixed(2)));
            $('#amount_local_currency_id').val(parseFloat(totalLocal).toFixed(2));
            $('#amount_foregn_currency_id').val(parseFloat(receivable_amount).toFixed(2));
        });



        $("#find-user").click(function() {
            $('#progress').show();
            var phone = $('#phone').val();
            var currency = "";
            var name = "";


            $.ajax({
                url: "{{ route('send.find') }}",
                type: "GET",
                dataType: 'json',
                data: {
                    'mobile_number': phone
                },
                success: function(dataResult) {
                    var resultData = dataResult.data;
                    var rate = dataResult.rate;
                    var i = 1;
                    var currency = "";

                    $.each(resultData, function(index, row) {
                        $('#names').text("Names: " + row.first_name + " " + row
                            .last_name);
                        $('#email').text("Email: " + row.email);
                        $('#address').text("Address: " + row.address);
                        $('#currency').text("Currency: " + row.currency_name);
                        $('#country').text("Country: " + row.country);
                        rate2 = row.currency_ratio;
                        currency = row.currency_name;
                        var name = row.first_name;
                        $('#names_id').val(row.first_name + " " + row.last_name);
                        $('#email_id').val(row.email);
                        $('#currency_id').val(row.currency_name);
                        $('#receiver_id').val(dataResult.user_id);
                        $('#phone_id').val(row.mobile_number);
                        $('#address_id').val(row.address);
                    })
                    if ($('#phone_id').val() == "") {
                        alert("Receiver not found, please verify number and try again");
                    } else {
                        $('#progress').hide();
                        $('#form_element').show();
                        $('#submit_button').show();
                        $('#details').show();
                        $('#amount_sent_label').text("Amount To Sent in " +
                            {{ Js::from($user_currency) }});
                        $('#amount_receive_label').text("Amount To Receive in " + currency);
                    }

                },
                error: function(xhr, status, error) {
                    $('#progress').hide();
                    alert("Error: please verfy number and try agian");
                }

            })
        });

        $('#discount').keypress(function() {

            //var sender_currency_rate=$('#sender_currency').val();
            var fee = $('#charges_rw').val();
            var feeLocal = $("#charges_h").val();
            var discount = $('#discount').val();

            var amount_foregn_currency = $('#amount_foregn_currency_id').val();
            var totalLocal = $('#amount_local_currency_id').val();
            var totalRW = $('#amount_rw_currency').val();



            var discountAmountLoacal = feeLocal * discount / 100;
            var discountAmount = fee * discount / 100;

            fee = fee - discountAmount;
            $('#charges_rw').val(fee);
            feeLocal = feeLocal - discountAmountLoacal;
            $("#charges_h").val(feeLocal);




            alert(fee + "-" + feeLocal);

            $('#feeRW').text("Transfer Fee in " + baseCurrency + ": " + formatMoney(parseFloat(fee)
                .toFixed(2)));
            //$('#total_amount_with_fee').text("Transfer amount + fee : in "+sender_currency+": " + formatMoney(parseFloat(totalLocal).toFixed(2)));
            //$('#charges').text("Transfer Fee in "+sender_currency+ ": " + formatMoney(parseFloat(feeLocal).toFixed(2)));
            //$('#charges_h').val(parseFloat(feeLocal).toFixed(2));
            //$('#charges_rw').val(fee);
            //$('#amount_rw_currency').val(totalRW + feeLocal);

        });





    });

    function modal() {
        var amount_local = $('#amount_local_currency_id').val();
        var amount_foreign = $('#amount_foregn_currency_id').val();
        $("#amount_local").text(amount_local);
        $("#amount_foreign").text(amount_foreign);

        var method = $('#payment').val();
        $("#method").text(method);

        var details = $('#description').val();
        $("#details_h").text(details);

        var sender_names = {{ Js::from($request->names) }};
        $("#sender_names").text(sender_names);
        var receiver_names = $('#names_id').val();
        $("#receiver_names").text(receiver_names);


        $('#confirm-modal').modal('show');

    }

    function closeModal() {
        $('#confirm-modal').modal('hide');

    }



    $("input[data-type='currency']").on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") {
            return;
        }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }

    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign +
                (j ? i.substr(0, j) + thousands : '') +
                i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
                (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log(e)
        }
    };

    $('#submit').click(function() {
        alert("are sure you want to submit ??");
        $('#sendForm').submit();
    });
</script>
