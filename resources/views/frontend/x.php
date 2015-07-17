<div class='goods-page'>
    <div class='goods-data clearfix'>
        <div class='table-wrapper-responsive'>
            <table summary='Shopping cart'>
                <tr>
                    <th class='goods-page-image'>Image</th>
                    <th class='goods-page-description'>Description</th>
                    <th class='goods-page-quantity'>Quantity</th>
                    <th class='goods-page-price'>Unit price</th>
                    <th class='goods-page-total' colspan='2'>Total</th>
                </tr>
                <?php foreach($sessionOrder as $sessionOrder) : ?>
                    <tr>
                        <td class='goods-page-image'>
                            <a href='#'><img src='../../assets/frontend/pages/img/products/model4.jpg' alt='Berry Lace Dress'></a>
                        </td>
                        <td class='goods-page-description'>
                            <h3><a href='#'><?php echo $sessionOrder['product_id']; ?></a></h3>
                            <p><strong>Style</strong><?php echo $sessionOrder['color_id']; ?></p>
                            <em>More info is here</em>
                        </td>
                        <td class='goods-page-quantity'>
                            <div class='product-quantity'>
                                <input id='product-quantity2' type='text' value='<?php echo $sessionOrder['number']; ?>' readonly class='form-control input-sm'>
                            </div>
                        </td>
                        <td class='goods-page-price'>
                            <strong><span>$</span><?php echo $sessionOrder['size_id']; ?></strong>
                        </td>
                        <td class='goods-page-total'>
                            <strong><span>$</span><?php echo ($sessionOrder['number']*$sessionOrder['size_id']); ?></strong>
                        </td>
                        <td class='del-goods-col'>
                            <a class='del-goods' href='<?php echo url('cart').'/del/$sessionOrder[size_id]' ;?>'>&nbsp;</a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>
        </div>

        <div class='shopping-total'>
            <ul>
                <li>
                    <em>Sub total</em>
                    <strong class='price'><span>$</span>47.00</strong>
                </li>
                <li>
                    <em>Shipping cost</em>
                    <strong class='price'><span>$</span>3.00</strong>
                </li>
                <li class='shopping-total-price'>
                    <em>Total</em>
                    <strong class='price'><span>$</span>50.00</strong>
                </li>
            </ul>
        </div>
    </div>
    <button class='btn btn-default' type='button'><a href='<?php echo url('/'); ?>'> Continue shopping </a> <i class='fa fa-shopping-cart'></i></button>

    <button class='btn btn-primary' type='submit'>Checkout <i class='fa fa-check'></i></button>
    <a class='btn btn-default' style='margin-left: 10px;' href='<?php echo url('cart/deleteall');?>'>Delete cart </a>
</div>