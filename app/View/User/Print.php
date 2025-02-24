<!doctype html>
<html lang="<?php echo $this->setting['language']; ?>" dir="<?php echo $this->setting['direction']; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice_<?php echo $transaction['id']; ?></title>
    <style>
        .invoice-box {
            max-width: 634px;
            margin: auto;
            padding: 10px 0;
            border: 0px solid #ccc;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 10px 0;
            vertical-align: middle;
            text-align: right;
        }

        .invoice-box table tr td:first-child {
            text-align: left;
        }

        .invoice-box table tr.header table {
            padding-bottom: 0px;
        }

        .invoice-box table tr.heading td {
            border-bottom: 1px solid #ccc;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 0px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total tr td {
            padding: 4px 0;
            text-align: right;
        }
    </style>
</head>

<body <?php echo !empty($_GET['print']) ? 'onload="window.print()"' : null; ?>>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="header">
                <td>
                    <h2><?php echo isset($setting['site_name']) ? $setting['site_name'] : null; ?></h2>
                </td>
                <td><br>
                    Invoice Number: <?php echo $transaction['id']; ?><br>
                    Invoice Date: <?php echo date($this->setting['date_format'], strtotime($transaction['created'])); ?>
                </td>
            </tr>
            <tr class="header">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <b>Invoice From:</b><br>
                                <?php echo !empty($setting['site_address']) ? nl2br($setting['site_address']) : null; ?><br>
                            </td>
                            <td>
                                <b>Invoice To:</b><br>
                                <?php echo $user['name']; ?><br>
                                <?php echo $user['billing_address']; ?><br>
                                <?php echo $user['billing_city'] . ' ' . $user['billing_postal']; ?><br>
                                <?php echo $user['billing_state'] . ', ' . $user['billing_country']; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Payment Method: <?php echo $transaction['method']; ?></td>
                <td>Payment Status: <?php echo $transaction['payment_status'] == 1 ? 'Paid' : ($transaction['payment_status'] == 2 ? "Pending" : "Unpaid"); ?></td>
            </tr>
            <tr class="heading">
                <td>Item summary</td>
                <td style="min-width: 60px;">Amount</td>
            </tr>
            <tr class="item">
                <td><?php echo $plan['name'] . ': ' . $plan['title']; ?></td>
                <td><?php echo $this->price($transaction['amount'] - $transaction['tax']); ?></td>
            </tr>
            <tr class="total">
                <td colspan="4">
                    <table style="width: 260px; margin-left: auto;">
                        <tr>
                            <td>Subtotal</td>
                            <td><?php echo $this->price($transaction['amount'] - $transaction['tax']); ?></td>
                        </tr>
                        <tr>
                            <td>Tax amount</td>
                            <td><?php echo $this->price($transaction['tax']); ?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="border-top: 1px solid #999">Total (<?php echo $transaction['currency']; ?>)</td>
                            <td style="border-top: 1px solid #999"><?php echo $this->price($transaction['amount']); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>