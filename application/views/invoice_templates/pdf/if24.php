<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/templates.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/custom.css">

        <style>
            .width-d { width: 100px; }
            .color-n { color: #888; font-size: 12px; }
            .color-n-b { color: #333; font-size: 16px; }
            .border-bottom-l {  border-color: #aaa; }
            .border-bottom-n {  border-color: #888; }
            .border-bottom-d {  border-color: #555; }
            .border-top-l {  border-color: #aaa; }
            .border-top-n {  border-color: #888; }
            .border-top-d {  border-color: #555; }
            .background-l { background-color: #bbb; }
            .company-name, .invoice-id { color: #333 !important; }
            tbody td { padding-bottom: 5px; text-align: right; }
            thead th { color: #555; padding-bottom: 5px; text-align: right; }
            thead td { text-align: right; }
            table td { vertical-align: top; }
            .naglowek { font-size: 12px; font-weight: bold; }
            .opis { font-size: 10px; font-style: italic; }
            .company-logo { vertical-align: top; margin-left: 15px; margin-top: 15px; }
            .balance_in_words { font-size: 10px; font-style: italic; }
            .podpisy { text-align: center; font-size: 10px; border-top-width: 1px; border-top-style: solid; border-color: #aaa; }
            .amount-vat { font-size: 10px; width: 50%; }
        </style>

    </head>
    <body>
    <div style="margin: auto; width: 900px">

        <div id="header">
            <table>
                <tr>
                    <td class="text-left" style="width:40%; vertical-align: top;">
                        <div class="company-logo">
                            <?php echo invoice_logo_pdf(); ?>
                        </div>
                    </td>
                    <td class="text-right" style="width:60%">
                        <div class="invoice-to">
                        <p class="naglowek">Sprzedawca:</p>
                        <h4 class="company-name"><?php echo $this->mdl_settings->setting('organization_name'); ?></h4>
                        <?php foreach(array('organization_street_address', 'organization_city') as $field): ?>
                            <?php $field_value = $this->mdl_settings->setting($field); ?>
                            <?php if (!empty($field_value)): ?>
                                <?php if ($field =='organization_city'): ?>
                                    <?php echo $this->mdl_settings->setting('organization_zip') ?> <?php echo $field_value; ?><br/>
                                <?php else: ?>
                                    <?php echo $field_value; ?><br/>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <br/>
                        <?php $field_value = $this->mdl_settings->setting('organization_nip'); ?>
                        <?php if (!empty($field_value)): ?>
                            <?php echo lang('organization_nip'); ?>: <?php echo $this->mdl_settings->setting('organization_country'); ?>&nbsp;<?php echo $field_value; ?><br/>
                        <?php endif; ?>
                        <?php $field_value = $this->mdl_settings->setting('organization_bank_account'); ?>
                        <?php if (!empty($field_value)): ?>
                            <?php echo lang('organization_bank_abbr'); ?>: <b><?php echo $field_value; ?></b><br/>
                        <?php endif; ?>
                        <br/>
                        <?php foreach(array('organization_phone' => 'organization_phone', 'organization_email' => 'organization_email', 'organization_web' => 'organization_web') as $lang => $field): ?>
                            <?php $field_value = $this->mdl_settings->setting($field); ?>
                            <?php if (!empty($field_value)): ?>
                                <?php echo lang($lang); ?>: <?php echo $field_value; ?><br/>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="seperator border-bottom-l"></div>

        <table>
            <tr>
                <td class="text-left">
                    <h2 class="invoice-id" style="margin-top: 10px">
                        <?php echo lang('invoice'); ?> <?php echo ($invoice->invoice_status_id == 1) ? 'Pro-Forma' : 'VAT'?>
                    </h2>
                </td>
                <td class="text-right">
                    <div class="invoice-details">
                        <table>
                            <tbody>
                            <tr>
                                <td class="color-n-b">Nr dokumentu:</td>
                                <td class="width-d color-n-b"><?php echo $invoice->invoice_number; ?></td>
                            </tr>
                            <tr>
                                <td class="color-n">Data wystawienia:</td>
                                <td class="width-d color-n"><?php echo date_from_mysql($invoice->invoice_date_created, TRUE); ?></td>
                            </tr>
                            <tr>
                                <td class="color-n">Termin zapłaty:</td>
                                <td class="width-d color-n"><?php echo date_from_mysql($invoice->invoice_date_due, TRUE); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
        <div class="seperator border-bottom-l"></div>

        <table>
            <tr>
                <td class="text-left">
                    <p class="naglowek">Nabywca:</p>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    <h4 class="company-name"><?php echo $invoice->client_name; ?></h4>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="text-left" width="40%">
                    <?php foreach(array('client_address_1', 'client_address_2', 'client_city', 'client_state', 'client_vat_id') as $field): ?>
                        <?php if (!empty($invoice->$field)): ?>
                            <?php if ($field =='client_city'): ?>
                                <?php echo $invoice->client_zip; ?> <?php echo $invoice->client_city; ?><br/>
                            <?php elseif ($field =='client_vat_id'): ?>
                                <?php echo lang('organization_nip'); ?>: <?php echo $invoice->client_country; ?>&nbsp;<?php echo $invoice->$field; ?><br/>
                            <?php else: ?>
                                <?php echo $invoice->$field; ?><br/>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php foreach(array('phone_abbr' => 'client_phone', 'mobile_abbr' => 'client_mobile', 'email' => 'client_email', 'web' => 'client_web') as $lang => $field): ?>
                        <?php if (!empty($invoice->$field)): ?>
                            <?php echo lang($lang); ?>: <?php echo $invoice->$field; ?><br/>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
        <div class="seperator border-bottom-l"></div>

        <?php // echo '<pre>'; var_dump($tax_subtotal); echo '</pre>'; die(' -pauluZ-195'); ?>

        <div class="invoice-items">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr class="border-bottom-d">
                        <th>Lp.</th>
                        <th>Produkt/Usługa</th>
                        <th>Ilość</th>
<!--                        <th>PKWiU</th>-->
                        <th>Cena&nbsp;netto</th>
                        <th>Rabat</th>
                        <th>VAT</th>
                        <th>Wartość&nbsp;netto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $lineCounter = 1; ?>
                    <?php foreach ($items as $item): ?>
                    <tr class="border-bottom-n <?php echo (($lineCounter % 2) ? 'background-l' : '') ?>">
                        <td><?php echo $lineCounter; ?>.</td>
                        <td style="text-align: left;"><?php echo $item->item_name; ?><br/>
                            <?php if (!empty($item->item_description)): ?><span class="opis">(<?php echo nl2br($item->item_description); ?>)</span><?php endif; ?>
                        </td>
                        <td><?php echo format_round_amount($item->item_quantity); ?></td>
<!--                        <td></td>-->
                        <td><?php echo format_currency($item->item_price); ?></td>
                        <td><?php echo format_currency($item->item_discount); ?></td>
                        <td><?php echo format_round_amount($item->item_tax_rate_percent); ?>%</td>
                        <td><?php echo format_currency($item->item_subtotal); ?><br/>
                            <span class="opis">(po rabacie: <?php echo format_currency($item->item_subtotal - $item->item_discount); ?>)</span>
                        </td>
                    </tr>
                    <?php $lineCounter++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table align="right">
                <tr class="border-bottom-d">
                    <td align="right">

            <table class="amount-vat">
                <thead>
                <tr class="border-bottom-d">
                    <th></th>
                    <th>VAT</th>
                    <th>Wartość&nbsp;netto</th>
                    <th>Kwota VAT</th>
                    <th>Wartość&nbsp;brutto</th>
                </tr>
                </thead>
                <tbody>
                <?php $lineCounter = 1; ?>
                <?php foreach ($tax_subtotal['total'] as $key => $tax): ?>
                    <tr class="<?php if ($lineCounter != count($tax_subtotal['total'])): ?>border-bottom-n<?php endif; ?>">
                        <th><?php if ($lineCounter == 1): ?>W tym:<?php endif; ?></th>
                        <td>
                            <span class="opis"><?php echo (empty($tax_rates[$key]['tax_rate_name']) ? 'n/p' : ($tax_rates[$key]['tax_rate_name'] . ' -')) ?></span>
                            <?php echo format_round_amount($tax_rates[$key]['tax_rate_percent']); ?>%

                        </td>
                        <td><?php echo format_currency($tax_subtotal['netto'][$key]); ?></td>
                        <td><?php echo format_currency($tax); ?></td>
                        <td><?php echo format_currency($tax_subtotal['brutto'][$key]); ?></td>
                    </tr>
                    <?php $lineCounter++; ?>
                <?php endforeach; ?>
<?php /*
                <tr>
                    <th>Suma:</th>
                    <td></td>
                    <td><?php echo format_currency(array_sum($tax_subtotal['netto'])); ?></td>
                    <td><?php echo format_currency(array_sum($tax_subtotal['total'])); ?></td>
                    <td><?php echo format_currency(array_sum($tax_subtotal['brutto'])); ?></td>
                </tr>
 */ ?>
                </tbody>
            </table>

                    </td>
                </tr>
            </table>
            <br/>
            <table class="amount-summary">
                <thead>
                <tr>
                    <th>Podsuma netto:</th>
                    <td style="width:100px"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
                </tr>
                <tr>
                    <td><?php echo lang('item_tax'); ?>:</td>
                    <td class="amount"><?php echo format_currency($invoice->invoice_item_tax_total); ?></td>
                </tr>
                <tr class="border-top-l amount-total">
                    <th>Wartość brutto:</th>
                    <td><?php echo format_currency($invoice->invoice_total); ?></td>
                </tr>
                </thead>
            </table>
            <table class="amount-summary">
                <thead>
                <tr>
                    <td style="width:100px">Zapłacone:</td>
                    <td style="text-align: left;"><?php echo format_currency($invoice->invoice_paid) ?> brutto</td>
                    <th>Pozostaje do zapłaty:</th>
                    <th style="width:100px"><?php echo format_currency($invoice->invoice_balance) ?></th>
                </tr>
                <tr>
                    <td colspan="4" class="balance_in_words"><?php echo (!empty($balance_in_words) ? $balance_in_words : '') ?></td>
                </tr>
                </thead>
            </table>
            <br/>
            <table>
                <tr>
                    <th style="text-align: center"><?php echo $invoice->user_name; ?></th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="podpisy">Podpis osoby uprawnionej do wystawienia faktury</td>
                    <td style="width:70px"></td>
                    <td class="podpisy">Data odbioru</td>
                    <td style="width:70px"></td>
                    <td class="podpisy">Podpis osoby upoważnionej do odbioru faktury</td>
                </tr>
            </table>
        </div>
    </div>
    </body>
</html>
