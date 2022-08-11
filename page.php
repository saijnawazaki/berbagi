<?php
defined('APP_PATH') OR exit('No direct script access allowed');

if($page == 'fatal_error')
{
?>
    <div class="container">
        <h1>Fatal Error</h1>
    </div>
<?php    
}
elseif($page == 'login')
{
?>
    <div class="container">
        <form method="post" action="<?=APP_URL?>?page=login" accept-charset="utf-8">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="border-1 bc-muted p-2 br-2 mt-2">
                        <label>Username</label>
                        <input type="text" name="username" value="">
                        <label>Password</label>
                        <input type="password" name="password" value="">
                        <hr>
                        <input type="submit" name="login" class="bg-primary color-white" value="Login">
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <img src="<?=APP_URL?>/assets/anjing.jpg" style="width: 210px;" class="mt-2">
                </div>
            </div>
        </form>
    </div>
<?php    
}
elseif($page == 'home')
{
?>
    <div class="container">
        <h1>Home</h1>
        <hr>
        <div class="row">
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=book'?>">
                    <div class="bg-light p-3 br-2 mb-3">
                        <h1>Book</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=restaurant'?>">
                    <div class="bg-light p-3 br-2 mb-3">
                        <h1>Restaurant</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=person'?>">
                    <div class="bg-light p-3 br-2 mb-3">
                        <h1>Person</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php    
}
elseif($page == 'book')
{
    $arr_data['list_book'] = array();
    $query = "
        select
            *
        from
            book
        where
            user_id = '".$ses['user_id']."'
        order by
            created_at DESC
    ";
    //echo "<pre>$query</pre>";
    $result = $db->query($query);    
    
    while($row = $result->fetchArray())
    {
        $arr_data['list_book'][$row['book_id']]['title'] = $row['book_title'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=home'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                Book
            </a>
        </h1>
        <hr>
        <div class="text-right">
            <a href="<?=APP_URL.'?page=book_add_edit&book_id=0'?>" class="button bg-success color-white">New</a>
        </div>
        <div class="row">
            <?php
                if(count($arr_data['list_book']) == 0)
                {
                ?>
                    <div class="col-12 text-center">
                        No Data
                    </div>
                <?php
                }
                else
                {
                    foreach($arr_data['list_book'] as $book_id => $val)
                    {
                    ?>
                        <div class="col-6 col-lg-2 text-center mb-3">
                            <a href="<?=APP_URL.'?page=book_details&book_id='.$book_id?>" class="color-black">
                                <div class="bg-light br-2" style="height: 200px;">
                                    
                                </div>
                                <?=$val['title']?>
                                <div>
                                    <small>
                                        <a href="<?=APP_URL.'?page=book_add_edit&book_id='.$book_id?>">Edit</a>
                                    </small>
                                </div>
                            </a>
                        </div>
                    <?php    
                    }
                    
                }
            ?>
            
            
        </div>
    </div>
<?php    
}
elseif($page == 'book_add_edit')
{
    $g_book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_book_id)) 
    {
        die('Book ID Invalid');        
    }
    
    if($g_book_id > 0)
    {
        $query = "
            select
                *
            from
                book
            where
                book_id = '".$_GET['book_id']."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
        if($data['user_id'] != $ses['user_id'])
        {
            die('Book not yours!');    
        }
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=book'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            Book
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Add / Edit
        </h1>
        <hr>
        <div class="row">
            <div class="col-12 col-lg-4">
                <form method="post" action="<?=APP_URL?>?page=book_add_edit&book_id=<?=$g_book_id?>" accept-charset="utf-8">
                    <label>Book Title</label>
                    <input type="text" name="book_title" value="<?=isset($data['book_title']) ? $data['book_title'] : ''?>">
                    <hr>
                    <input type="hidden" name="book_id" value="<?=$g_book_id?>">
                    <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                </form>   
            </div>
            
        </div>
    </div>
<?php    
}
elseif($page == 'book_details')
{
    $g_book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_book_id)) 
    {
        die('Book ID Invalid');        
    }
    
    if($g_book_id > 0)
    {
        $query = "
            select
                *
            from
                book
            where
                book_id = '".$g_book_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
        if($data['user_id'] != $ses['user_id'])
        {
            die('Book not yours!');    
        }
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=book'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            Book
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            <?=isset($data['book_title']) ? $data['book_title'] : ''?>
        </h1>
        <hr>
        <div class="row">
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=invoice&book_id='.$g_book_id?>">
                    <div class="bg-light p-3 br-2">
                        <h1>Invoice</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=split_bill&book_id='.$g_book_id?>">
                    <div class="bg-light p-3 br-2">
                        <h1>Split Bill</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=payment&book_id='.$g_book_id?>">
                    <div class="bg-light p-3 br-2">
                        <h1>Payment</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=summary&book_id='.$g_book_id?>">
                    <div class="bg-light p-3 br-2">
                        <h1>Summary</h1>
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php    
}
elseif($page == 'invoice')
{
    $g_book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_book_id)) 
    {
        die('Book ID Invalid');        
    }
    
    if($g_book_id > 0)
    {
        $query = "
            select
                *
            from
                book
            where
                book_id = '".$g_book_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
        if($data['user_id'] != $ses['user_id'])
        {
            die('Book not yours!');    
        }
    }
    
    $arr_data['list_invoice'] = array();
    $query = "
        select
            *
        from
            invoice
        where
            book_id = '".$g_book_id."'
        order by
            created_at DESC
    ";
    $result = $db->query($query);    
    
    while($row = $result->fetchArray())
    {
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['title'] = 'INV/'.$row['book_id'].'/'.date('Ymd',$row['created_at']).'/'.$row['restaurant_id'].'/'.$row['invoice_id'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=book_details&book_id='.$g_book_id?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                <?=isset($data['book_title']) ? $data['book_title'] : ''?>
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Invoice
        </h1>
        <hr>
        <div class="text-right">
            <a href="<?=APP_URL.'?page=invoice_add_edit&book_id='.$g_book_id.'&invoice_id=0'?>" class="button bg-success color-white">New</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($arr_data['list_invoice']) == 0)
                    {
                    ?>
                        <tr>
                            <td colspan="100">No Data</td>
                        </tr> 
                    <?php
                    }
                    else
                    {
                        foreach($arr_data['list_invoice'] as $invoice_date => $val)
                        {
                            $invoice_date_show = date('d-m-Y',$invoice_date);
                            foreach($arr_data['list_invoice'][$invoice_date] as $invoice_id => $val)
                            {
                            ?>
                                <tr>
                                    <td><?=$invoice_date_show?></td>
                                    <td><?=$val['title']?> </td>
                                    <td>
                                        <a class="button bg-warning" href="<?=APP_URL.'?page=invoice_add_edit&book_id='.$g_book_id.'&invoice_id='.$invoice_id?>">Edit</a>
                                        <a target="_blank" class="button" href="<?=APP_URL.'?page=invoice_add_edit&book_id='.$g_book_id.'&invoice_id='.$invoice_id?>">Split Bill</a>
                                    </td>
                                </tr>
                            <?php
                                $invoice_date_show = '';    
                            }    
                        }
                            
                        
                    }
                ?>
            </tbody>  
        </table>
        
    </div>
<?php    
}
elseif($page == 'invoice_add_edit')
{
    $g_book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    $g_invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : 0;
    
    if(! preg_match('/^[0-9]*$/', $g_book_id)) 
    {
        die('Book ID Invalid');        
    }
    
    if(! preg_match('/^[0-9]*$/', $g_invoice_id)) 
    {
        die('Invoice ID Invalid');        
    }
    
    if($g_book_id > 0)
    {
        $query = "
            select
                *
            from
                book
            where
                book_id = '".$_GET['book_id']."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
        if($data['user_id'] != $ses['user_id'])
        {
            die('Book not yours!');    
        }
    }
    
    if($g_invoice_id > 0)
    {
        $query = "
            select
                *
            from
                invoice
            where
                invoice_id = '".$g_invoice_id."'
        ";
        $result = $db->query($query);    
        $data_invoice = $result->fetchArray();
        
        //load details
        $query = "
            select
                *
            from
                invoice_details
            inner join
                restaurant_menu
                on restaurant_menu.rm_id = invoice_details.rm_id
            where
                invoice_details.invoice_id = '".$g_invoice_id."'
            order by
                restaurant_menu.rm_name ASC
        ";
        $result = $db->query($query);
        $arr_data['list_product'] = array();
        $arr_data['list_product_tot']['qty'] = 0;
        $arr_data['list_product_tot']['total'] = 0;
        $no = 0;
        while($row = $result->fetchArray())
        {
            $no++;
            $arr_data['list_product'][$no]['id_id'] = $row['id_id'];    
            $arr_data['list_product'][$no]['rm_id'] = $row['rm_id'];    
            $arr_data['list_product'][$no]['rm_name'] = $row['rm_name'];    
            $arr_data['list_product'][$no]['qty'] = $row['qty'];    
            $arr_data['list_product'][$no]['price'] = $row['price'];

            $arr_data['list_product_tot']['qty'] += $row['qty'];    
            $arr_data['list_product_tot']['total'] += $row['qty']*$row['price'];    
        }
    }
    
    //load Res
    $query = "
        select
            *
        from
            restaurant
        order by
            restaurant.restaurant_name ASC
    ";
    $result = $db->query($query);
    $arr_data['list_book'] = array();
    while($row = $result->fetchArray())
    {
        $arr_data['list_restaurant'][$row['restaurant_id']]['name'] = $row['restaurant_name'];    
    }

    //load Platform
    $query = "
        select
            *
        from
            platform
        order by
            platform.platform_name ASC
    ";
    $result = $db->query($query);
    $arr_data['list_platform'] = array();
    while($row = $result->fetchArray())
    {
        $arr_data['list_platform'][$row['platform_id']]['name'] = $row['platform_name'];    
    }

    if(isset($data_invoice) && $data_invoice['restaurant_id'] > 0)
    {
        $query = "
            select
                *
            from
                restaurant_menu
            where
                restaurant_id = '".$data_invoice['restaurant_id']."'
            order by
                rm_name
        ";
        $result = $db->query($query);
        $arr_data['list_rm'] = array();
        while($row = $result->fetchArray())
        {
            $arr_data['list_rm'][$row['rm_id']]['name'] = $row['rm_name'];    
        }
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=invoice&book_id='.$g_book_id?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                Invoice
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Add / Edit
        </h1>
        <hr>
       
        <form method="post" target="iframe_post" action="<?=APP_URL?>?page=invoice_add_edit" accept-charset="utf-8">
            <div class="row">
                <div class="col-12 col-lg-4">
                        <label>Invoice Date</label>
                        <input type="date" name="invoice_date" value="<?=isset($data_invoice['invoice_date']) ? date('Y-m-d',$data_invoice['invoice_date']) : date('Y-m-d')?>">
                        <label>Restaurant</label>
                        <select id="restaurant_id" name="restaurant_id" onchange="getData({page:'getSelectRestaurantMenuByRestaurantID',restaurantID: this.value,targetSelect:document.getElementsByClassName('select__product')})">
                            <option value="0">-</option>
                            <?php
                            if(count($arr_data['list_restaurant']) > 0)
                            {
                                foreach($arr_data['list_restaurant'] as $restaurant_id => $val)
                                {
                                ?>
                                    <option value="<?=$restaurant_id?>"<?=$data_invoice['restaurant_id'] == $restaurant_id ? ' selected' : ''?>><?=$val['name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <div>
                            <button type="button" onchange="getData({page:'getSelectRestaurantMenuByRestaurantID',restaurantID: document.getElementById('restaurant_id').value,targetSelect:document.getElementsByClassName('select__product')})">Refresh</button>
                            <button type="button" onclick="window.open('<?=APP_URL?>?page=restaurant_menu&restaurant_id='+document.getElementById('restaurant_id').value, '_blank')">Menu</button>
                        </div>    
                                
                        <label>Platform</label>
                        <select name="platform_id">
                            <option value="0">-</option>
                            <?php
                            if(count($arr_data['list_platform']) > 0)
                            {
                                foreach($arr_data['list_platform'] as $platform_id => $val)
                                {
                                ?>
                                    <option value="<?=$platform_id?>"<?=$data_invoice['platform_id'] == $platform_id ? ' selected' : ''?>><?=$val['name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <label>Tax</label>
                        <input class="text-right" type="text" name="tax_amount" value="<?=isset($data_invoice['tax_amount']) && $data_invoice['tax_amount'] != 0 ? $data_invoice['tax_amount'] : ''?>">
                        <label>Discount</label>
                        <input class="text-right" type="text" name="discount_amount" value="<?=isset($data_invoice['discount_amount']) && $data_invoice['discount_amount'] != 0 ? $data_invoice['discount_amount'] : ''?>">
                        <label>Delivery</label>
                        <input class="text-right" type="text" name="delivery_amount" value="<?=isset($data_invoice['delivery_amount']) && $data_invoice['delivery_amount'] != 0 ? $data_invoice['delivery_amount'] : ''?>">
                        
                        <label>Other</label>
                        <input class="text-right" type="text" name="other_amount" value="<?=isset($data_invoice['other_amount']) && $data_invoice['other_amount'] != 0 ? $data_invoice['other_amount'] : ''?>">
                        <label>Adjustment</label>
                        <input class="text-right" type="text" name="adjustment_amount" value="<?=isset($data_invoice['adjustment_amount']) && $data_invoice['adjustment_amount'] != 0 ? $data_invoice['adjustment_amount'] : ''?>">
                        
                       
                    </div>
                    <div class="col-12 col-lg-8">
                        <h3>Product List</h3>
                        <hr>
                        <table>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Product</th>
                                <th>Qty</th>
                                <th rowspan="2">Price</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <th>
                                    <span id="info__tot__qty"><?=isset($arr_data['list_product_tot']['qty']) ? $arr_data['list_product_tot']['qty'] : ''?></span>
                                </th>
                                <th>
                                    <span id="info__tot__total"><?=isset($arr_data['list_product_tot']['total']) ? $arr_data['list_product_tot']['total'] : ''?></span>
                                </th>
                            </tr>
                            <?php
                            for($x = 1; $x <= 10; $x++)
                            {
                            ?>
                                <tr>
                                    <td><?=$x?></td>
                                    <td>
                                        <?php
                                            $js_tot = '
                                                let data_list = document.getElementsByClassName(\'select__product\');
                                                let tot_qty = 0;
                                                let tot_total = 0;
                                                for(let x = 0; x < data_list.length; x++)
                                                {
                                                    let id = data_list[x].id;
                                                    let exp_id = id.split(\'__\');
                                                    tot_qty += Number(document.getElementById(\'input__\'+exp_id[1]+\'__qty\').value);
                                                    tot_total += Number(document.getElementById(\'input__\'+exp_id[1]+\'__totalhid\').value);
                                                }

                                                document.getElementById(\'info__tot__qty\').innerHTML = tot_qty;
                                                document.getElementById(\'info__tot__total\').innerHTML = tot_total;
                                            ';
                                            $js_calc = '
                                                let res = Number(document.getElementById(\'input__'.$x.'__price\').value) * Number(document.getElementById(\'input__'.$x.'__qty\').value);
                                                document.getElementById(\'input__'.$x.'__total\').innerHTML = res;
                                                document.getElementById(\'input__'.$x.'__totalhid\').value = res;
                                                '.$js_tot.'
                                            ';
                                            $js = '
                                                if(this.value == 0)
                                                {
                                                    document.getElementById(\'input__'.$x.'__price\').value = \'\';
                                                    document.getElementById(\'input__'.$x.'__qty\').value = \'\';
                                                    document.getElementById(\'input__'.$x.'__total\').innerHTML = \'\';
                                                }
                                                else
                                                {
                                                    if(Number(document.getElementById(\'input__'.$x.'__price\').value) == 0)
                                                    {
                                                        document.getElementById(\'input__'.$x.'__price\').value = this.options[this.selectedIndex].getAttribute(\'data-price\');    
                                                    }
                                                }
                                                '.$js_calc.'    
                                            ';
                                        ?>
                                        <select onchange="<?=$js?>" class="select__product" name="product_list[<?=$x?>][product_id]" id="input__<?=$x?>__product_id">
                                            <option value="0">-</option>
                                            <?php
                                                if(isset($arr_data['list_rm']) &&count($arr_data['list_rm']) > 0)
                                                {
                                                    foreach($arr_data['list_rm'] as $rm_id => $val)
                                                    {
                                                    ?>
                                                        <option value="<?=$rm_id?>"<?=isset($arr_data['list_product'][$x]['rm_id']) ? ' selected' : ''?>><?=$val['name']?></option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input onkeyup="<?=$js_calc?>" class="text-right" type="text" name="product_list[<?=$x?>][qty]" id="input__<?=$x?>__qty" value="<?=isset($arr_data['list_product'][$x]['qty']) ? $arr_data['list_product'][$x]['qty'] : ''?>">
                                    </td>
                                    <td>
                                        <input onkeyup="<?=$js_calc?>" class="text-right" type="text" name="product_list[<?=$x?>][price]" id="input__<?=$x?>__price" value="<?=isset($arr_data['list_product'][$x]['price']) ? $arr_data['list_product'][$x]['price'] : ''?>">
                                    </td>
                                        
                                    <td>
                                        <span id="input__<?=$x?>__total"><?=isset($arr_data['list_product'][$x]['qty']) && isset($arr_data['list_product'][$x]['price']) ? $arr_data['list_product'][$x]['qty']*$arr_data['list_product'][$x]['price'] : ''?></span>
                                        <input type="hidden" id="input__<?=$x?>__totalhid" value="<?=isset($arr_data['list_product'][$x]['qty']) && isset($arr_data['list_product'][$x]['price']) ? $arr_data['list_product'][$x]['qty']*$arr_data['list_product'][$x]['price'] : ''?>">   
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                </div>
                <div class="col-12 col-lg-12">
                    <hr>
                    <input type="hidden" name="book_id" value="<?=$g_book_id?>">
                    <input type="hidden" name="invoice_id" value="<?=$g_invoice_id?>">
                    <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                </div>
            </div>    
        </form>
        <iframe style="width:100%;" class="border-1" name="iframe_post" src=""></iframe>
    </div>
<?php    
}
elseif($page == 'restaurant')
{
    $arr_data['list_restaurant'] = array();
    $query = "
        select
            *
        from
            restaurant
        order by
            created_at DESC
    ";
    //echo "<pre>$query</pre>";
    $result = $db->query($query) or die('ERROR|WQIEHQUIWEHUIQWHEUQWE');    
    
    while($row = $result->fetchArray())
    {
        $arr_data['list_restaurant'][$row['restaurant_id']]['title'] = $row['restaurant_name'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=home'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                Restaurant
            </a>
        </h1>
        <hr>
        <div class="text-right">
            <a href="<?=APP_URL.'?page=restaurant_add_edit&restaurant_id=0'?>" class="button bg-success color-white">New</a>
        </div>
        <div class="row">
            <?php
                if(count($arr_data['list_restaurant']) == 0)
                {
                ?>
                    <div class="col-12 text-center">
                        No Data
                    </div>
                <?php
                }
                else
                {
                    foreach($arr_data['list_restaurant'] as $restaurant_id => $val)
                    {
                    ?>
                        <div class="col-6 col-lg-2 text-center mb-3">
                            <a href="<?=APP_URL.'?page=restaurant_menu&restaurant_id='.$restaurant_id?>" class="color-black">
                                <div class="bg-light br-2" style="height: 200px;">
                                    
                                </div>
                                <?=$val['title']?>
                                <div>
                                    <small>
                                        <a href="<?=APP_URL.'?page=restaurant_add_edit&restaurant_id='.$restaurant_id?>">Edit</a>
                                    </small>
                                </div>
                            </a>
                        </div>
                    <?php    
                    }
                    
                }
            ?>
            
            
        </div>
    </div>
<?php    
}
elseif($page == 'restaurant_add_edit')
{
    $g_restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_restaurant_id)) 
    {
        die('Restaurant ID Invalid');        
    }
    
    if($g_restaurant_id > 0)
    {
        $query = "
            select
                *
            from
                restaurant
            where
                restaurant_id = '".$g_restaurant_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=restaurant'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            Restaurant
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Add / Edit
        </h1>
        <hr>
        <div class="row">
            <div class="col-12 col-lg-4">
                <form method="post" action="<?=APP_URL?>?page=restaurant_add_edit&restaurant_id=<?=$g_restaurant_id?>" accept-charset="utf-8">
                    <label>Restaurant Name</label>
                    <input type="text" name="restaurant_name" value="<?=isset($data['restaurant_name']) ? $data['restaurant_name'] : ''?>">
                    <hr>
                    <input type="hidden" name="restaurant_id" value="<?=$g_restaurant_id?>">
                    <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                </form>   
            </div>
            
        </div>
    </div>
<?php    
}
elseif($page == 'restaurant_menu')
{
    $g_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_id)) 
    {
        die('ID Invalid');        
    }
    
    if($g_id > 0)
    {
        $query = "
            select
                *
            from
                restaurant
            where
                restaurant_id = '".$g_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
    }
    
    $arr_data['list'] = array();
    $query = "
        select
            *
        from
            restaurant_menu
        where
            restaurant_id = '".$g_id."'
        order by
            created_at DESC
    ";
    //echo "<pre>$query</pre>";
    $result = $db->query($query) or die('ERROR|WQIEHQUIWEHUIQWHEUQWE');    
    
    while($row = $result->fetchArray())
    {
        $arr_data['list'][$row['rm_id']]['name'] = $row['rm_name'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=restaurant'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                <?=$data['restaurant_name']?>
            </a>
        </h1>
        <hr>
        <div class="text-right">
            <a href="<?=APP_URL.'?page=restaurant_menu_add_edit&restaurant_id='.$g_id.'&rm_id=0'?>" class="button bg-success color-white">New</a>
        </div>
        <div class="row">
            <?php
                if(count($arr_data['list']) == 0)
                {
                ?>
                    <div class="col-12 text-center">
                        No Data
                    </div>
                <?php
                }
                else
                {
                    foreach($arr_data['list'] as $id => $val)
                    {
                    ?>
                        <div class="col-6 col-lg-2 text-center mb-3">
                            <div class="bg-light br-2" style="height: 200px;">
                                
                            </div>
                            <?=$val['name']?>
                            <div>
                                <small>
                                    <a href="<?=APP_URL.'?page=restaurant_menu_add_edit&restaurant_id='.$g_id.'&rm_id='.$id?>">Edit</a>
                                </small>
                            </div>
                        </div>
                    <?php    
                    }
                    
                }
            ?>
            
            
        </div>
    </div>
<?php    
}
elseif($page == 'restaurant_menu_add_edit')
{
    $g_restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_restaurant_id)) 
    {
        die('Restaurant ID Invalid');        
    }
    
    $g_rm_id = isset($_GET['rm_id']) ? $_GET['rm_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_restaurant_id)) 
    {
        die('Restaurant Menu ID Invalid');        
    }
    $rm_tag = '';    
        
    if($g_restaurant_id > 0)
    {
        $query = "
            select
                *
            from
                restaurant
            where
                restaurant_id = '".$g_restaurant_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
    }
    
    if($g_rm_id > 0)
    {
        $query = "
            select
                *
            from
                restaurant_menu
            where
                rm_id = '".$g_rm_id."'
        ";
        $result = $db->query($query);    
        $data_menu = $result->fetchArray();
        
        $query = "
            select
                tag.tag_id,
                tag.tag_name
            from
                restaurant_menu_tag
            inner join
                tag
                on tag.tag_id = restaurant_menu_tag.tag_id  
            where
                restaurant_menu_tag.rm_id = '".$g_rm_id."'
            order by
                tag.tag_name
        ";
        $result = $db->query($query) or die('ERROR!|WQUIEHQWUIEHUQWE');
        $rm_tag = '';
        while($row = $result->fetchArray())
        {
            if($rm_tag != '')
            {
                $rm_tag .= ',';
            }
            $rm_tag .= $row['tag_name'];     
        }
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=restaurant_menu&restaurant_id='.$g_restaurant_id?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
                <?=$data['restaurant_name']?>
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Menu
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            <?=$g_rm_id > 0 ? 'Edit #'.$g_rm_id : 'Add'?>
        </h1>
        <hr>
        <div class="row">
            <div class="col-12 col-lg-4">
                <form method="post" action="<?=APP_URL?>?page=restaurant_menu_add_edit" accept-charset="utf-8">
                    <label>Restaurant Menu Name</label>
                    <input type="text" name="rm_name" value="<?=isset($data_menu['rm_name']) ? $data_menu['rm_name'] : ''?>">
                    <label>Restaurant Menu Category Tag</label>
                    <br><small class="color-muted">Spare with ",", for now</small>
                    <input type="text" name="rm_tag" value="<?=$rm_tag?>">
                    <hr>
                    <input type="hidden" name="restaurant_id" value="<?=$g_restaurant_id?>">
                    <input type="hidden" name="rm_id" value="<?=$g_rm_id?>">
                    <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                </form>   
            </div>
            
        </div>
    </div>
<?php    
}
elseif($page == 'person')
{
    $arr_data['list'] = array();
    $query = "
        select
            *
        from
            person
        order by
            created_at DESC
    ";
    //echo "<pre>$query</pre>";
    $result = $db->query($query) or die('ERROR|WQIEHQUIWEHUIQWHEUQWE');    
    
    while($row = $result->fetchArray())
    {
        $arr_data['list'][$row['person_id']]['name'] = $row['person_name'];    
        $arr_data['list'][$row['person_id']]['initial_name'] = $row['initial_name'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=home'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                Person
            </a>
        </h1>
        <hr>
        <div class="text-right">
            <a href="<?=APP_URL.'?page=person_add_edit&person_id=0'?>" class="button bg-success color-white">New</a>
        </div>
        <div class="row">
            <?php
                if(count($arr_data['list']) == 0)
                {
                ?>
                    <div class="col-12 text-center">
                        No Data
                    </div>
                <?php
                }
                else
                {
                    foreach($arr_data['list'] as $id => $val)
                    {
                    ?>
                        <div class="col-6 col-lg-2 text-center mb-3">
                            <div class="bg-light br-2" style="height: 200px;">
                                
                            </div>
                            <?=$val['name']?>
                            <div>
                                <small>
                                    <a href="<?=APP_URL.'?page=person_add_edit&person_id='.$id?>">Edit</a>
                                </small>
                            </div>
                        </div>
                    <?php    
                    }
                    
                }
            ?>
            
            
        </div>
    </div>
<?php    
}
elseif($page == 'person_add_edit')
{
    $g_id = isset($_GET['person_id']) ? $_GET['person_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_id)) 
    {
        die('ID Invalid');        
    }
    
    if($g_id > 0)
    {
        $query = "
            select
                *
            from
                person
            where
                person_id = '".$g_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=person'?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
                Person
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Add / Edit
        </h1>
        <hr>
        <div class="row">
            <div class="col-12 col-lg-4">
                <form method="post" action="<?=APP_URL?>?page=person_add_edit" accept-charset="utf-8">
                    <label>Full Name</label>
                    <input type="text" name="person_name" value="<?=isset($data['person_name']) ? $data['person_name'] : ''?>">
                    <label>Initial Name</label>
                    <input type="text" name="initial_name" value="<?=isset($data['initial_name']) ? $data['initial_name'] : ''?>">
                    <hr>
                    <input type="hidden" name="person_id" value="<?=$g_id?>">
                    <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                </form>   
            </div>
            
        </div>
    </div>
<?php    
}
elseif($page == 'split_bill')
{
    $g_book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    if(! preg_match('/^[0-9]*$/', $g_book_id)) 
    {
        die('Book ID Invalid');        
    }
    
    if($g_book_id > 0)
    {
        $query = "
            select
                *
            from
                book
            where
                book_id = '".$g_book_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
        if($data['user_id'] != $ses['user_id'])
        {
            die('Book not yours!');    
        }
    }
    
    $arr_data['list_invoice'] = array();
    $query = "
        select
            split_bill.*,
            invoice.book_id,
            invoice.created_at as inv_created_at,
            invoice.restaurant_id,
            invoice.invoice_date
        from
            split_bill
        inner join
            invoice
            on invoice.invoice_id = split_bill.invoice_id
            and invoice.book_id = '".$g_book_id."'
        order by
            split_bill.created_at DESC
    ";
    $result = $db->query($query);    
   
    while($row = $result->fetchArray())
    {
        $arr_data['list_invoice'][$row['created_at']][$row['sb_id']]['inv_code'] = 'INV/'.$row['book_id'].'/'.date('Ymd',$row['inv_created_at']).'/'.$row['restaurant_id'].'/'.$row['invoice_id'];    
        $arr_data['list_invoice'][$row['created_at']][$row['sb_id']]['sb_code'] = 'SB/'.$row['book_id'].'/'.date('Ymd',$row['inv_created_at']).'/'.$row['restaurant_id'].'/'.$row['invoice_id'].'/'.$row['sb_id'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=book_details&book_id='.$g_book_id?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                <?=isset($data['book_title']) ? $data['book_title'] : ''?>
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Split Bill
        </h1>
        <hr>
        <div class="text-right">
            <a href="<?=APP_URL.'?page=split_bill_add_edit&book_id='.$g_book_id.'&sb_id=0'?>" class="button bg-success color-white">New</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Split Bill ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($arr_data['list_invoice']) == 0)
                    {
                    ?>
                        <tr>
                            <td colspan="100">No Data</td>
                        </tr> 
                    <?php
                    }
                    else
                    {
                        foreach($arr_data['list_invoice'] as $invoice_date => $val)
                        {
                            $invoice_date_show = date('d-m-Y',$invoice_date);
                            foreach($arr_data['list_invoice'][$invoice_date] as $invoice_id => $val)
                            {
                            ?>
                                <tr>
                                    <td><?=$invoice_date_show?></td>
                                    <td><?=$val['inv_code']?> </td>
                                    <td><?=$val['sb_code']?> </td>
                                    <td>
                                        <a class="button bg-warning" href="<?=APP_URL.'?page=split_bill_add_edit&book_id='.$g_book_id.'&sb_id='.$invoice_id?>">Edit</a>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $invoice_date_show = '';    
                            }    
                        }
                            
                        
                    }
                ?>
            </tbody>  
        </table>
        
    </div>
<?php    
}
elseif($page == 'split_bill_add_edit')
{
    $g_book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    $g_sb_id = isset($_GET['sb_id']) ? $_GET['sb_id'] : 0;
    
    if(! preg_match('/^[0-9]*$/', $g_book_id)) 
    {
        die('Book ID Invalid');        
    }
    
    if(! preg_match('/^[0-9]*$/', $g_sb_id)) 
    {
        die('SB ID Invalid');        
    }
    
    if($g_book_id > 0)
    {
        $query = "
            select
                *
            from
                book
            where
                book_id = '".$g_book_id."'
        ";
        $result = $db->query($query);    
        $data = $result->fetchArray();
        
        if($data['user_id'] != $ses['user_id'])
        {
            die('Book not yours!');    
        }
    }

    $arr_data['list_invoice'] = array();
    $query = "
        select
            invoice.*,
            res_details.total
        from
            invoice
        inner join
        (
            select
                invoice_id,
                SUM(qty*price) as total
            from
                invoice_details
            group by
                invoice_id
        ) as res_details
        on res_details.invoice_id = invoice.invoice_id
        where
            invoice.book_id = '".$g_book_id."'
        order by
            invoice.created_at DESC
    ";
    $result = $db->query($query);    

    while($row = $result->fetchArray())
    {
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['title'] = 'INV/'.$row['book_id'].'/'.date('Ymd',$row['created_at']).'/'.$row['restaurant_id'].'/'.$row['invoice_id'];    
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['tax_amount'] = $row['tax_amount'];    
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['discount_amount'] = $row['discount_amount'];    
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['delivery_amount'] = $row['delivery_amount'];    
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['other_amount'] = $row['other_amount'];    
        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['total'] = $row['total'];

        $arr_data['list_invoice_only'][$row['invoice_id']]['tax_amount'] = $row['tax_amount'];    
        $arr_data['list_invoice_only'][$row['invoice_id']]['discount_amount'] = $row['discount_amount'];    
        $arr_data['list_invoice_only'][$row['invoice_id']]['delivery_amount'] = $row['delivery_amount'];    
        $arr_data['list_invoice_only'][$row['invoice_id']]['other_amount'] = $row['other_amount'];    
        $arr_data['list_invoice_only'][$row['invoice_id']]['item_amount'] = 0;    
        $arr_data['list_invoice_only'][$row['invoice_id']]['total'] = $row['total'];   
    }
    
    //load details
    $arr_data['list_invoice_details'] = array();
    $query = "
        select
            invoice_details.*,
            restaurant_menu.rm_name
        from
            invoice_details
        inner join
            invoice
            on invoice.invoice_id = invoice_details.invoice_id 
            and invoice.book_id = '".$g_book_id."'
        inner join
            restaurant_menu
            on restaurant_menu.rm_id = invoice_details.rm_id 
        order by
            restaurant_menu.rm_name ASC
    ";
    $result = $db->query($query);    

    while($row = $result->fetchArray())
    {
        $arr_data['list_invoice_details'][$row['invoice_id']][$row['rm_id']]['name'] = $row['rm_name'];    
        $arr_data['list_invoice_details'][$row['invoice_id']][$row['rm_id']]['qty'] = $row['qty'];    
        $arr_data['list_invoice_details'][$row['invoice_id']][$row['rm_id']]['price'] = $row['price'];

        $arr_data['list_invoice_only'][$row['invoice_id']]['item_amount'] += $row['qty']*$row['price'];    
    }
    
    if($g_sb_id > 0)
    {
        //load header
        $query = "
            select
                *
            from
                split_bill
            where
                split_bill.sb_id = '".$g_sb_id."'
        ";
        $result = $db->query($query);
        $arr_data['list_sb_header'] = array();
        while($row = $result->fetchArray())
        {
            $arr_data['list_sb_header']['invoice_id'] = $row['invoice_id'];  
            $arr_data['list_sb_header']['sb_date'] = $row['sb_date']; 
        }
        
        //load details
        $query = "
            select
                split_bill_details.*,
                person.person_name
            from
                split_bill_details
            inner join
                person
                on person.person_id = split_bill_details.person_id 
            where
                split_bill_details.sb_id = '".$g_sb_id."'
            order by
                person.person_name ASC
        ";
        $result = $db->query($query);
        $arr_data['list_sb_details'] = array();
        $no = 0;
        $arr_data['list_sb_header']['item_amount'] = 0;
        $arr_data['list_sb_header']['tax_amount'] = 0;
        $arr_data['list_sb_header']['discount_amount'] = 0;
        $arr_data['list_sb_header']['delivery_amount'] = 0;
        $arr_data['list_sb_header']['other_amount'] = 0;
        $arr_data['list_sb_header']['adjustment_amount'] = 0;
        $arr_data['list_sb_header']['person'] = 0;
        while($row = $result->fetchArray())
        {
            $no++;
            $arr_data['list_sb_details'][$no]['person_id'] = $row['person_id'];  
            $arr_data['list_sb_details'][$no]['person_name'] = $row['person_name'];  
            $arr_data['list_sb_details'][$no]['item_amount'] = $row['item_amount'];  
            $arr_data['list_sb_details'][$no]['tax_amount'] = $row['tax_amount'];  
            $arr_data['list_sb_details'][$no]['discount_amount'] = $row['discount_amount'];  
            $arr_data['list_sb_details'][$no]['delivery_amount'] = $row['delivery_amount'];  
            $arr_data['list_sb_details'][$no]['other_amount'] = $row['other_amount'];  
            $arr_data['list_sb_details'][$no]['adjustment_amount'] = $row['adjustment_amount'];  
            $arr_data['list_sb_details'][$no]['remarks'] = $row['remarks']; 
            $arr_data['list_sb_header']['item_amount'] += $row['item_amount'];
            $arr_data['list_sb_header']['tax_amount'] += $row['tax_amount'];
            $arr_data['list_sb_header']['discount_amount'] += $row['discount_amount'];
            $arr_data['list_sb_header']['delivery_amount'] += $row['delivery_amount'];
            $arr_data['list_sb_header']['other_amount'] += $row['other_amount'];
            $arr_data['list_sb_header']['adjustment_amount'] += $row['adjustment_amount']; 
            $arr_data['list_sb_header']['person'] += 1; 
        }
    }
   
    //load person
    $query = "
        select
            *
        from
            person
        order by
            person_name ASC
    ";
    $result = $db->query($query);
    $arr_data['list_person'] = array();
    while($row = $result->fetchArray())
    {
        $arr_data['list_person'][$row['person_id']]['name'] = $row['initial_name'].' - '.$row['person_name'];    
    }
?>
    <div class="container">
        <h1>
            <a href="<?=APP_URL.'?page=split_bill&book_id='.$g_book_id?>">
                <svg id="i-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M20 30 L8 16 20 2" />
                </svg>
            
                Split Bill
            </a>
            <svg id="i-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M12 30 L24 16 12 2" />
            </svg>
            Add / Edit
        </h1>
        <hr>
       
        <form method="post" target="iframe_post" action="<?=APP_URL?>?page=split_bill_add_edit" accept-charset="utf-8">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <button type="button" onclick="reCalc()">ReCalc</button>
                    <hr>
                    <label>Invoice</label>
                    <select id="invoice_id" name="invoice_id">
                        <option value="0">-</option>
                        <?php
                        if(count($arr_data['list_invoice']) > 0)
                        {
                            foreach($arr_data['list_invoice'] as $invoice_date => $val)
                            {
                                echo '<optgroup label="'.date('d-m-Y',$invoice_date).'">';
                                foreach($arr_data['list_invoice'][$invoice_date] as $invoice_id => $val)
                                {
                                    $list_menu = '';
                                    
                                    foreach($arr_data['list_invoice_details'][$invoice_id] as $rm_id => $value)
                                    {
                                        $list_menu .= '<tr>';
                                        $list_menu .= '<td>'.$value['name'].'</td>';
                                        $list_menu .= '<td align=right>'.$value['qty'].'<br><input size=1 id=inputsub__##__qty type=text value=1><button type=button onclick=panel_menu_qty(##,'.($value['price']).');>PER</button></td>';
                                        $list_menu .= '<td align=right>'.$value['price'].'<br><button type=button onclick=panel_menu(##,'.($value['price']).');>Once</button></td>';
                                        $list_menu .= '<td align=center>'.($value['qty']*$value['price']).'<br><button type=button onclick=panel_menu(##,'.($value['qty']*$value['price']).');>ALL</button></td>';
                                        $list_menu .= '</tr>';     
                                    }
                                    
                                    if($list_menu != '')
                                    {
                                        $list_menu = '<table><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>'.$list_menu.'</table>';
                                    }
                                    
                                    $js = '
                                        document.getElementById(\'inv__item\').innerHTML = \''.$val['total'].'\';
                                        document.getElementById(\'inv__item_hid\').value = \''.$val['total'].'\';
                                        document.getElementById(\'inv__tax\').innerHTML = \''.$val['tax_amount'].'\';
                                        document.getElementById(\'inv__tax_hid\').value = \''.$val['tax_amount'].'\';
                                        document.getElementById(\'inv__discount\').innerHTML = \''.$val['discount_amount'].'\';
                                        document.getElementById(\'inv__discount_hid\').value = \''.$val['discount_amount'].'\';
                                        document.getElementById(\'inv__delivery\').innerHTML = \''.$val['delivery_amount'].'\';
                                        document.getElementById(\'inv__delivery_hid\').value = \''.$val['delivery_amount'].'\';
                                        document.getElementById(\'inv__other\').innerHTML = \''.$val['other_amount'].'\';
                                        document.getElementById(\'inv__other_hid\').value = \''.$val['other_amount'].'\';
                                        document.getElementById(\'inv__total\').innerHTML = \''.($val['total']+$val['tax_amount']-$val['discount_amount']+$val['delivery_amount']+$val['other_amount']).'\';
                                        document.getElementById(\'inv__total_hid\').value = \''.($val['total']+$val['tax_amount']-$val['discount_amount']+$val['delivery_amount']+$val['other_amount']).'\';
                                        
                                        let dl = document.getElementsByClassName(\'panel__menu\');
                                        for(let x = 0; x < dl.length; x++)
                                        {
                                            let id = dl[x].id;
                                            let id_split = id.split(\'__\')
                                            dl[x].innerHTML = (\''.$list_menu.'\').replaceAll(\'##\',id_split[1]);
                                        }
                                    ';
                                ?>
                                    <option onclick="<?=$js?>" value="<?=$invoice_id?>"<?=isset($arr_data['list_sb_header']) && $arr_data['list_sb_header']['invoice_id'] == $invoice_id ? ' selected' : ''?>><?=$val['title']?></option>
                                <?php
                                } 
                                echo '</optgroup>';   
                            }
                                
                        }
                        ?>
                    </select>
                    <label>Split Bill Date</label>
                    <input type="date" name="sb_date" value="<?=isset($arr_data['list_sb_header']['sb_date']) ? date('Y-m-d',$arr_data['list_sb_header']['sb_date']) : date('Y-m-d')?>">
                        
                    <table>
                        <tr>
                            <th colspan="2">Invoice</th>
                            <td align="right">
                                <span id="inv__item"><?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount'] : ''?></span>
                                <input type="hidden" id="inv__item_hid" value="<?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount'] : ''?>">
                            </td>
                            <td align="right">
                                &nbsp;
                            </td>
                            <td align="right">
                                <span id="inv__tax"><?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['tax_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['tax_amount'] : ''?></span>
                                <input type="hidden" id="inv__tax_hid" value="<?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['tax_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['tax_amount'] : ''?>">
                            </td>
                            <td align="right">
                                <span id="inv__discount"><?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['discount_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['discount_amount'] : ''?></span>
                                <input type="hidden" id="inv__discount_hid" value="<?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['discount_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['discount_amount'] : ''?>">
                            </td>
                            <td align="right">
                                <span id="inv__delivery"><?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['delivery_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['delivery_amount'] : ''?></span>
                                <input type="hidden" id="inv__delivery_hid" value="<?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['delivery_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['delivery_amount'] : ''?>">
                            </td>
                            <td align="right">
                                <span id="inv__other"><?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['other_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['other_amount'] : ''?></span>
                                <input type="hidden" id="inv__other_hid" value="<?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['other_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['other_amount'] : ''?>">
                            </td>
                            <td align="right">
                                &nbsp;
                            </td>
                            <td align="right">
                                <span id="inv__total"><?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount']+$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['tax_amount']-$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['discount_amount']+$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['delivery_amount']+$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['other_amount'] : ''?></span>
                                <input type="hidden" id="inv__total_hid" value="<?=$arr_data['list_sb_header']['invoice_id'] && isset($arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount']) ? $arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['item_amount']+$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['tax_amount']-$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['discount_amount']+$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['delivery_amount']+$arr_data['list_invoice_only'][$arr_data['list_sb_header']['invoice_id']]['other_amount'] : ''?>">
                            </td>
                            <td align="right">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <th rowspan="2">No</th>
                            <th>Person</th>
                            <th>Items</th>
                            <th>Items %</th>
                            <th>Tax / Items %</th>
                            <th>Discount / Items %</th>
                            <th>Delivery / Total Person</th>
                            <th>Other / Items %</th>
                            <th>Adjustment</th>
                            <th>Total</th>
                            <th rowspan="2">Remarks</th>
                        </tr>
                        <tr>
                            <th>
                                <span id="info__tot__person"><?=isset($arr_data['list_sb_header']['person']) ? $arr_data['list_sb_header']['person'] : ''?></span>
                                <input type="hidden" id="info__tot__person_hid" value="<?=isset($arr_data['list_sb_header']['person']) ? $arr_data['list_sb_header']['person'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__items"><?=isset($arr_data['list_sb_header']['item_amount']) ? $arr_data['list_sb_header']['item_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__items_hid" value="<?=isset($arr_data['list_sb_header']['item_amount']) ? $arr_data['list_sb_header']['item_amount'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__items_percent"><?=isset($arr_data['list_sb_header']['item_amount']) ? $arr_data['list_sb_header']['item_amount']/$arr_data['list_sb_header']['item_amount']*100 : ''?></span>
                                <input type="hidden" id="info__tot__items_percent_hid" value="<?=isset($arr_data['list_sb_header']['item_amount']) ? $arr_data['list_sb_header']['item_amount']/$arr_data['list_sb_header']['item_amount']*100 : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__tax"><?=isset($arr_data['list_sb_header']['tax_amount']) ? $arr_data['list_sb_header']['tax_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__tax_hid" value="<?=isset($arr_data['list_sb_header']['tax_amount']) ? $arr_data['list_sb_header']['tax_amount'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__discount"><?=isset($arr_data['list_sb_header']['discount_amount']) ? $arr_data['list_sb_header']['discount_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__discount_hid" value="<?=isset($arr_data['list_sb_header']['discount_amount']) ? $arr_data['list_sb_header']['discount_amount'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__delivery"><?=isset($arr_data['list_sb_header']['delivery_amount']) ? $arr_data['list_sb_header']['delivery_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__delivery_hid" value="<?=isset($arr_data['list_sb_header']['delivery_amount']) ? $arr_data['list_sb_header']['delivery_amount'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__other"><?=isset($arr_data['list_sb_header']['other_amount']) ? $arr_data['list_sb_header']['other_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__other_hid" value="<?=isset($arr_data['list_sb_header']['other_amount']) ? $arr_data['list_sb_header']['other_amount'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__adjustment"><?=isset($arr_data['list_sb_header']['adjustment_amount']) ? $arr_data['list_sb_header']['adjustment_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__adjustment_hid" value="<?=isset($arr_data['list_sb_header']['adjustment_amount']) ? $arr_data['list_sb_header']['adjustment_amount'] : ''?>">
                            </th>
                            <th>
                                <span id="info__tot__total"><?=isset($arr_data['list_sb_header']['item_amount']) ? $arr_data['list_sb_header']['item_amount']+$arr_data['list_sb_header']['tax_amount']-$arr_data['list_sb_header']['discount_amount']+$arr_data['list_sb_header']['delivery_amount']+$arr_data['list_sb_header']['other_amount']+$arr_data['list_sb_header']['adjustment_amount'] : ''?></span>
                                <input type="hidden" id="info__tot__total_hid" value="<?=isset($arr_data['list_sb_header']['item_amount']) ? $arr_data['list_sb_header']['item_amount']+$arr_data['list_sb_header']['tax_amount']-$arr_data['list_sb_header']['discount_amount']+$arr_data['list_sb_header']['delivery_amount']+$arr_data['list_sb_header']['other_amount']+$arr_data['list_sb_header']['adjustment_amount'] : ''?>">
                            </th>
                        </tr>
                        <?php
                        for($x = 1; $x <= 10; $x++)
                        {
                        ?>
                            <tr>
                                <td><?=$x?></td>
                                <td>
                                    <select onchange="<?=$js?>" class="select__person" name="sb_list[<?=$x?>][person_id]" id="input__<?=$x?>__person_id">
                                        <option value="0">-</option>
                                        <?php
                                            if(isset($arr_data['list_person']) && count($arr_data['list_person']) > 0)
                                            {
                                                foreach($arr_data['list_person'] as $person_id => $val)
                                                {
                                                ?>
                                                    <option value="<?=$person_id?>"<?=isset($arr_data['list_sb_details'][$x]['person_id']) && $arr_data['list_sb_details'][$x]['person_id'] == $person_id ? ' selected' : ''?>><?=$val['name']?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <?php
                                        $js = '
                                            if(Number(document.getElementById(\'input__'.$x.'__items_amount_panel_tgg\').value) == 0)
                                            {
                                                document.getElementById(\'input__'.$x.'__items_amount_panel\').style.display = \'\';
                                                document.getElementById(\'input__'.$x.'__items_amount_panel_tgg\').value = 1;       
                                            }
                                            else
                                            {
                                                document.getElementById(\'input__'.$x.'__items_amount_panel\').style.display = \'none\';
                                                document.getElementById(\'input__'.$x.'__items_amount_panel_tgg\').value = 0;
                                            }
                                        ';
                                        
                                        $js_set = '
                                            document.getElementById(\'input__'.$x.'__items_amount\').value = document.getElementById(\'input__'.$x.'__items_amount_calc\').value; 
                                            document.getElementById(\'input__'.$x.'__items_amount_show\').innerHTML = document.getElementById(\'input__'.$x.'__items_amount_calc\').value; 
                                            document.getElementById(\'input__'.$x.'__items_amount_panel\').style.display = \'none\';
                                            document.getElementById(\'input__'.$x.'__items_amount_panel_tgg\').value = 0;
                                        ';
                                    ?>
                                    <button onclick="<?=$js?>" type="button" id="input__<?=$x?>__items_amount_show"><?=isset($arr_data['list_sb_details'][$x]['item_amount']) ? $arr_data['list_sb_details'][$x]['item_amount'] : 0?></button>
                                    <input class="data__loop" type="hidden" name="sb_list[<?=$x?>][items]" id="input__<?=$x?>__items_amount" value="<?=isset($arr_data['list_sb_details'][$x]['item_amount']) ? $arr_data['list_sb_details'][$x]['item_amount'] : ''?>">   
                                    <input type="hidden" id="input__<?=$x?>__items_amount_panel_tgg" value="0">
                                    <div id="input__<?=$x?>__items_amount_panel" class="position-absolute bg-light-lighten" style="display:none;;">
                                        <div class="panel__menu" id="input__<?=$x?>__items_amount_panel_sub"></div>
                                        <select id="input__<?=$x?>__items_amount_calc_mode">
                                            <option value="+">+ ADD</option>
                                            <option value="=">= SET</option>
                                            <option value="-">- MENUS</option>
                                        </select>
                                        <input type="text" id="input__<?=$x?>__items_amount_calc" value="">
                                        <button type="button" id="input__<?=$x?>__items_amount_calc_but" onclick="<?=$js_set?>">SET</button>    
                                    </div>
                                </td>
                                <td>
                                    <span id="input__<?=$x?>__items_percent"><?=isset($arr_data['list_sb_details'][$x]['item_amount']) ? $arr_data['list_sb_details'][$x]['item_amount']/$arr_data['list_sb_header']['item_amount']*100 : ''?></span>
                                    <input type="hidden" id="input__<?=$x?>__items_percent_hid" name="sb_list[<?=$x?>][items_percent]" value="<?=isset($arr_data['list_sb_details'][$x]['item_amount']) ? $arr_data['list_sb_details'][$x]['item_amount']/$arr_data['list_sb_header']['item_amount']*100 : ''?>">
                                </td>
                                <td>
                                    <span id="input__<?=$x?>__items_tax"><?=isset($arr_data['list_sb_details'][$x]['tax_amount']) ? $arr_data['list_sb_details'][$x]['tax_amount'] : ''?></span>
                                    <input type="hidden" id="input__<?=$x?>__items_tax_hid" name="sb_list[<?=$x?>][tax]" value="<?=isset($arr_data['list_sb_details'][$x]['tax_amount']) ? $arr_data['list_sb_details'][$x]['tax_amount'] : ''?>">
                                </td>
                                <td>
                                    <span id="input__<?=$x?>__items_discount"><?=isset($arr_data['list_sb_details'][$x]['discount_amount']) ? $arr_data['list_sb_details'][$x]['discount_amount'] : ''?></span>
                                    <input type="hidden" id="input__<?=$x?>__items_discount_hid" name="sb_list[<?=$x?>][discount]" value="<?=isset($arr_data['list_sb_details'][$x]['discount_amount']) ? $arr_data['list_sb_details'][$x]['discount_amount'] : ''?>">
                                </td>
                                <td>
                                    <span id="input__<?=$x?>__items_delivery"><?=isset($arr_data['list_sb_details'][$x]['delivery_amount']) ? $arr_data['list_sb_details'][$x]['delivery_amount'] : ''?></span>
                                    <input type="hidden" id="input__<?=$x?>__items_delivery_hid" name="sb_list[<?=$x?>][delivery]" value="<?=isset($arr_data['list_sb_details'][$x]['delivery_amount']) ? $arr_data['list_sb_details'][$x]['delivery_amount'] : ''?>">
                                </td>
                                <td>
                                    <span id="input__<?=$x?>__items_other"><?=isset($arr_data['list_sb_details'][$x]['other_amount']) ? $arr_data['list_sb_details'][$x]['other_amount'] : ''?></span>
                                    <input type="hidden" id="input__<?=$x?>__items_other_hid" name="sb_list[<?=$x?>][other]" value="<?=isset($arr_data['list_sb_details'][$x]['other_amount']) ? $arr_data['list_sb_details'][$x]['other_amount'] : ''?>">
                                </td>
                                <td>
                                    <input type="text" id="input__<?=$x?>__items_adjustment" name="sb_list[<?=$x?>][adjustment]" value="<?=isset($arr_data['list_sb_details'][$x]['adjustment_amount']) ? $arr_data['list_sb_details'][$x]['adjustment_amount'] : ''?>">
                                </td>
                                <td>
                                    <span id="input__<?=$x?>__items_total"><?=isset($arr_data['list_sb_details'][$x]['item_amount']) ? $arr_data['list_sb_details'][$x]['item_amount']+$arr_data['list_sb_details'][$x]['tax_amount']-$arr_data['list_sb_details'][$x]['discount_amount']+$arr_data['list_sb_details'][$x]['delivery_amount']+$arr_data['list_sb_details'][$x]['other_amount']+$arr_data['list_sb_details'][$x]['adjustment_amount'] : ''?></span>
                                    <input type="hidden" id="input__<?=$x?>__items_total_hid" name="sb_list[<?=$x?>][total]" value="<?=isset($arr_data['list_sb_details'][$x]['item_amount']) ? $arr_data['list_sb_details'][$x]['item_amount']+$arr_data['list_sb_details'][$x]['tax_amount']-$arr_data['list_sb_details'][$x]['discount_amount']+$arr_data['list_sb_details'][$x]['delivery_amount']+$arr_data['list_sb_details'][$x]['other_amount']+$arr_data['list_sb_details'][$x]['adjustment_amount'] : ''?>">
                                </td>
                                <td>
                                    <textarea id="input__<?=$x?>__items_remarks" name="sb_list[<?=$x?>][remarks]"><?=isset($arr_data['list_sb_details'][$x]['remarks']) ? $arr_data['list_sb_details'][$x]['remarks'] : ''?></textarea>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                        
                </div>
                <div class="col-12 col-lg-12">
                    <hr>
                    <input type="hidden" name="book_id" value="<?=$g_book_id?>">
                    <input type="hidden" name="sb_id" value="<?=$g_sb_id?>">
                    <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                </div>
            </div>    
        </form>
        <iframe style="width:100%;" class="border-1" name="iframe_post" src=""></iframe>
        <script>
            function panel_menu(count, val)
            {
                let mode = document.getElementById('input__'+count+'__items_amount_calc_mode').value;
                let final_val = val;
                 
                if(mode == '=')
                {
                    document.getElementById('input__'+count+'__items_amount_calc').value = Number(final_val);    
                }
                else if(mode == '+')
                {
                    document.getElementById('input__'+count+'__items_amount_calc').value = Number(document.getElementById('input__'+count+'__items_amount_calc').value) + Number(final_val);    
                }
                else if(mode == '-')
                {
                    document.getElementById('input__'+count+'__items_amount_calc').value = Number(document.getElementById('input__'+count+'__items_amount_calc').value) - Number(final_val);    
                }
                    
            }
            
            function panel_menu_qty(count, val)
            {
                let mode = document.getElementById('input__'+count+'__items_amount_calc_mode').value;
                let qty_sub = document.getElementById('inputsub__'+count+'__qty').value;
                
                let final_val = qty_sub*val;
                 
                if(mode == '=')
                {
                    document.getElementById('input__'+count+'__items_amount_calc').value = Number(final_val);    
                }
                else if(mode == '+')
                {
                    document.getElementById('input__'+count+'__items_amount_calc').value = Number(document.getElementById('input__'+count+'__items_amount_calc').value) + Number(final_val);    
                }
                else if(mode == '-')
                {
                    document.getElementById('input__'+count+'__items_amount_calc').value = Number(document.getElementById('input__'+count+'__items_amount_calc').value) - Number(final_val);    
                }
            }

            function reCalc()
            {
                let dl = document.getElementsByClassName('data__loop');

                let tot_item = 0;
                let tot_person = 0;
                for(let x = 0; x < dl.length; x++)
                {
                    var user_item = Number(dl[x].value);
                    
                    if(user_item > 0)
                    {
                        tot_item += user_item;
                        tot_person ++;
                    }
                }

                document.getElementById('info__tot__person').innerHTML = tot_person; 
                document.getElementById('info__tot__person_hid').value = tot_person; 
                document.getElementById('info__tot__items').innerHTML = tot_item; 
                document.getElementById('info__tot__items_hid').value = tot_item; 

                let sub_tot_user_item_percent = 0;
                let sub_tot_user_tax = 0;
                let sub_tot_user_discount = 0;
                let sub_tot_user_delivery = 0;
                let sub_tot_user_other = 0;
                let sub_tot_user_adjustment = 0;
                let sub_tot_user_total = 0;

                //loop 2
                for(let x = 0; x < dl.length; x++)
                {
                    var user_item = Number(dl[x].value);
                    var user_id = dl[x].id;
                    var exp_user_id = user_id.split('__');
                    var no = exp_user_id[1];
                    var inv_tax = Number(document.getElementById('inv__tax_hid').value);
                    var inv_discount = Number(document.getElementById('inv__discount_hid').value);
                    var inv_delivery = Number(document.getElementById('inv__delivery_hid').value);
                    var inv_other = Number(document.getElementById('inv__other_hid').value);

                    if(user_item > 0)
                    {
                        let user_item_percent = Number((user_item/tot_item*100).toFixed(2));
                        let user_tax = Number(((user_item_percent/100)*inv_tax).toFixed(2)); 
                        let user_discount = Number(((user_item_percent/100)*inv_discount).toFixed(2)); 
                        let user_delivery = Number((inv_delivery/tot_person).toFixed(2)); 
                        let user_other = Number(((user_item_percent/100)*inv_other).toFixed(2));
                        let user_adjustment = Number((Number(document.getElementById('input__'+no+'__items_adjustment').value)).toFixed(2));
                        let user_total = Number((user_item+user_tax-user_discount+user_delivery+user_other+user_adjustment).toFixed(2)); 

                        sub_tot_user_item_percent += user_item_percent; 
                        sub_tot_user_tax += user_tax; 
                        sub_tot_user_discount += user_discount; 
                        sub_tot_user_delivery += user_delivery; 
                        sub_tot_user_other += user_other; 
                        sub_tot_user_adjustment += user_adjustment;
                        sub_tot_user_total += user_total; 

                        document.getElementById('input__'+no+'__items_percent').innerHTML = user_item_percent;
                        document.getElementById('input__'+no+'__items_percent_hid').value = user_item_percent;

                        //tax
                        document.getElementById('input__'+no+'__items_tax').innerHTML = user_tax;
                        document.getElementById('input__'+no+'__items_tax_hid').value = user_tax;

                        //discount
                        document.getElementById('input__'+no+'__items_discount').innerHTML = user_discount;
                        document.getElementById('input__'+no+'__items_discount_hid').value = user_discount;

                        //Delivery
                        document.getElementById('input__'+no+'__items_delivery').innerHTML = user_delivery;
                        document.getElementById('input__'+no+'__items_delivery_hid').value = user_delivery;

                        //Other
                        document.getElementById('input__'+no+'__items_other').innerHTML = user_other;
                        document.getElementById('input__'+no+'__items_other_hid').value = user_other;

                        //Total
                        document.getElementById('input__'+no+'__items_total').innerHTML = user_total;
                        document.getElementById('input__'+no+'__items_total_hid').value = user_total;
                    }
                }

                document.getElementById('info__tot__items_percent').innerHTML = sub_tot_user_item_percent; 
                document.getElementById('info__tot__items_percent_hid').value = sub_tot_user_item_percent;
                document.getElementById('info__tot__tax').innerHTML = sub_tot_user_tax; 
                document.getElementById('info__tot__tax_hid').value = sub_tot_user_tax;
                document.getElementById('info__tot__discount').innerHTML = sub_tot_user_discount; 
                document.getElementById('info__tot__discount_hid').value = sub_tot_user_discount;
                document.getElementById('info__tot__delivery').innerHTML = sub_tot_user_delivery; 
                document.getElementById('info__tot__delivery_hid').value = sub_tot_user_delivery;
                document.getElementById('info__tot__other').innerHTML = sub_tot_user_other; 
                document.getElementById('info__tot__other_hid').value = sub_tot_user_other;
                document.getElementById('info__tot__adjustment').innerHTML = sub_tot_user_adjustment; 
                document.getElementById('info__tot__adjustment_hid').value = sub_tot_user_adjustment;
                document.getElementById('info__tot__total').innerHTML = sub_tot_user_total; 
                document.getElementById('info__tot__total_hid').value = sub_tot_user_total;
            }
        </script>
    </div>
<?php    
}