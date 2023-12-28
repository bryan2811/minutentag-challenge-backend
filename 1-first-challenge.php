<?php

/**
 * Processes an order, updating product quantities based on external input.
 *
 * @param array $p   The primary product information.
 * @param array $o   The order data containing items.
 * @param array $ext External modifications for product quantities.
 *
 * @return array Processed list of items with updated quantities.
 */
function processOrder($p, $o, $ext) {
    $items = [];
    $specialProductFound = false;
    $customDeleteFlag = false;

    // Mapping external quantities by product ID.
    $externalProductQuantities = [];
    foreach ($ext as $e) {
        $externalProductQuantities[$e['price']['id']] = $e['qty'];
    }

    // Processing each item in the order.
    foreach ($o['items']['data'] as $item) {
        $product = ['id' => $item['id']];

        // Update quantity or mark for deletion based on external input.
        if (isset($externalProductQuantities[$item['price']['id']])) {
            $qty = $externalProductQuantities[$item['price']['id']];
            if ($qty < 1) {
                $product['deleted'] = true;
            } else {
                $product['qty'] = $qty;
            }
            unset($externalProductQuantities[$item['price']['id']]);
        } else if ($item['price']['id'] == $p['id']) {
            $specialProductFound = true;
        } else {
            $product['deleted'] = true;
            $customDeleteFlag = true;
        }

        $items[] = $product;
    }

    // Add primary product if not found in order.
    if (!$specialProductFound) {
        $items[] = ['id' => $p['id'], 'qty' => 1];
    }

    // Adding remaining external products with positive quantity.
    foreach ($externalProductQuantities as $id => $qty) {
        if ($qty < 1) continue;
        $items[] = ['id' => $id, 'qty' => $qty];
    }

    return $items;
}

// Test data
$p = ['id' => 101];
$o = ['items' => ['data' => [['id' => 101, 'price' => ['id' => 501]]]]];
$ext = [['price' => ['id' => 501], 'qty' => 2]];

$result = processOrder($p, $o, $ext);
print_r($result);
?>
