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
        $arr_data['list_book'] = array();
        $no = 0;
        while($row = $result->fetchArray())
        {
            $no++;
            $arr_data['list_product'][$no]['id_id'] = $row['id_id'];    
            $arr_data['list_product'][$no]['rm_id'] = $row['rm_id'];    
            $arr_data['list_product'][$no]['rm_name'] = $row['rm_name'];    
            $arr_data['list_product'][$no]['qty'] = $row['qty'];    
            $arr_data['list_product'][$no]['price'] = $row['price'];    
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
                                    <span id="info__tot__qty"></span>
                                </th>
                                <th>
                                    <span id="info__tot__total"></span>
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
            *
        from
            invoice
        where
            book_id = '".$g_book_id."'
        order by
            created_at DESC
    ";
    //$result = $db->query($query);    
//    
//    while($row = $result->fetchArray())
//    {
//        $arr_data['list_invoice'][$row['invoice_date']][$row['invoice_id']]['title'] = 'INV/'.$row['book_id'].'/'.date('Ymd',$row['created_at']).'/'.$row['restaurant_id'].'/'.$row['invoice_id'];    
//    }
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
    }
    
    if($g_sb_id > 0)
    {
        
        
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
        $arr_data['list_book'] = array();
        $no = 0;
        while($row = $result->fetchArray())
        {
            $no++;
            $arr_data['list_product'][$no]['id_id'] = $row['id_id'];    
            $arr_data['list_product'][$no]['rm_id'] = $row['rm_id'];    
            $arr_data['list_product'][$no]['rm_name'] = $row['rm_name'];    
            $arr_data['list_product'][$no]['qty'] = $row['qty'];    
            $arr_data['list_product'][$no]['price'] = $row['price'];    
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
            <a href="<?=APP_URL.'?page=invoice&book_id='.$g_book_id?>">
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
       
        <form method="post" target="iframe_post" action="<?=APP_URL?>?page=invoice_add_edit" accept-charset="utf-8">
            <div class="row">
                <div class="col-12 col-lg-12">
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
                                    $js = '
                                        document.getElementById(\'inv__item\').innerHTML = \''.$val['total'].'\';
                                        document.getElementById(\'inv__tax\').innerHTML = \''.$val['tax_amount'].'\';
                                        document.getElementById(\'inv__discount\').innerHTML = \''.$val['discount_amount'].'\';
                                        document.getElementById(\'inv__delivery\').innerHTML = \''.$val['delivery_amount'].'\';
                                        document.getElementById(\'inv__other\').innerHTML = \''.$val['other_amount'].'\';
                                        document.getElementById(\'inv__total\').innerHTML = \''.($val['total']+$val['tax_amount']-$val['discount_amount']+$val['delivery_amount']+$val['other_amount']).'\';
                                    ';
                                ?>
                                    <option onclick="<?=$js?>" value="<?=$invoice_id?>"<?=isset($data_split_bill) && $data_split_bill['invoice_id'] == $invoice_id ? ' selected' : ''?>><?=$val['title']?></option>
                                <?php
                                } 
                                echo '</optgroup>';   
                            }
                                
                        }
                        ?>
                    </select>
                    
                    <table>
                        <tr>
                            <th colspan="2">Invoice</th>
                            <td align="right">
                                <span id="inv__item"></span>
                            </td>
                            <td align="right">
                                &nbsp;
                            </td>
                            <td align="right">
                                <span id="inv__tax"></span>
                            </td>
                            <td align="right">
                                <span id="inv__discount"></span>
                            </td>
                            <td align="right">
                                <span id="inv__delivery"></span>
                            </td>
                            <td align="right">
                                <span id="inv__other"></span>
                            </td>
                            <td align="right">
                                &nbsp;
                            </td>
                            <td align="right">
                                <span id="inv__total"></span>
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
                                <span id="info__tot__person"></span>
                            </th>
                            <th>
                                <span id="info__tot__items"></span>
                            </th>
                            <th>
                                <span id="info__tot__items_percent"></span>
                            </th>
                            <th>
                                <span id="info__tot__tax"></span>
                            </th>
                            <th>
                                <span id="info__tot__discount"></span>
                            </th>
                            <th>
                                <span id="info__tot__delivery"></span>
                            </th>
                            <th>
                                <span id="info__tot__other"></span>
                            </th>
                            <th>
                                <span id="info__tot__adjustment"></span>
                            </th>
                            <th>
                                <span id="info__tot__total"></span>
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
                                                    <option value="<?=$person_id?>"<?=isset($arr_data['list_save_sb'][$x]['person_id']) ? ' selected' : ''?>><?=$val['name']?></option>
                                                <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <button id="input__<?=$x?>__items_amount"><?=isset($arr_data['list_save_sb'][$x]['items_amount']) ? $arr_data['list_save_sb'][$x]['items_amount'] : 0?></button>
                                    <input type="hidden" id="input__<?=$x?>__items_amount" value="<?=isset($arr_data['list_save_sb'][$x]['items_amount']) ? $arr_data['list_save_sb'][$x]['items_amount'] : ''?>">   
                                    <input type="hidden" id="input__<?=$x?>__items_amount_panel_tgg" value="0">
                                    <div id="input__<?=$x?>__items_amount_panel" style="display:none;">
                                        
                                    </div>
                                </td>
                                <td>
                                    <input class="text-right" type="text" name="product_list[<?=$x?>][qty]" id="input__<?=$x?>__qty" value="<?=isset($arr_data['list_product'][$x]['qty']) ? $arr_data['list_product'][$x]['qty'] : ''?>">
                                </td>
                                <td>
                                    <input class="text-right" type="text" name="product_list[<?=$x?>][price]" id="input__<?=$x?>__price" value="<?=isset($arr_data['list_product'][$x]['price']) ? $arr_data['list_product'][$x]['price'] : ''?>">
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