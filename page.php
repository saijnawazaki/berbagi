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
                    <img src="<?=ASSETS_PATH?>anjing.jpg" style="width: 210px;" class="mt-2">
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
                    <div class="bg-light p-3 br-2">
                        <h1>Book</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=restaurant'?>">
                    <div class="bg-light p-3 br-2">
                        <h1>Restaurant</h1>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?=APP_URL.'?page=person'?>">
                    <div class="bg-light p-3 br-2">
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
    //$result = $db->query($query);    
    
    //while($row = $result->fetchArray())
    //{
    //    $arr_data['list_book'][$row['book_id']]['title'] = $row['book_title'];    
    //}
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
       
        <form method="post" action="<?=APP_URL?>?page=book_add_edit&book_id=<?=$g_book_id?>" accept-charset="utf-8">
            <div class="row">
                <div class="col-12 col-lg-4">
                        <label>Invoice Date</label>
                        <input type="date" name="invoice_date" value="<?=isset($data_invoice['invoice_date']) ? date('Y-m-d',$data_invoice['invoice_date']) : date('Y-m-d')?>">
                        <label>Restaurant</label>
                        <select>
                            <option value="0">-</option>
                        </select>
                        <label>Tax</label>
                        <input class="text-right" type="text" name="tax_amount" value="<?=isset($data_invoice['tax_amount']) ? $data['tax_amount'] : ''?>">
                        <label>Discount</label>
                        <input class="text-right" type="text" name="discount_amount" value="<?=isset($data_invoice['discount_amount']) ? $data['discount_amount'] : ''?>">
                        <label>Delivery</label>
                        <input class="text-right" type="text" name="delivery_amount" value="<?=isset($data_invoice['delivery_amount']) ? $data['delivery_amount'] : ''?>">
                        <label>Adjustment</label>
                        <input class="text-right" type="text" name="adjustment_amount" value="<?=isset($data_invoice['adjustment_amount']) ? $data['adjustment_amount'] : ''?>">
                        <label>Other</label>
                        <input class="text-right" type="text" name="other_amount" value="<?=isset($data_invoice['other_amount']) ? $data['other_amount'] : ''?>">
                        
                        <hr>
                        <input type="hidden" name="book_id" value="<?=$g_book_id?>">
                        <input type="hidden" name="invoice_id" value="<?=$g_invoice_id?>">
                        <input type="submit" name="submit" class="bg-primary color-white" value="Submit">
                       
                    </div>
                    <div class="col-12 col-lg-8">
                        <h3>Product List</h3>
                        <hr>
                        <table>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            <?php
                            for($x = 1; $x <= 10; $x++)
                            {
                            ?>
                                <tr>
                                    <td><?=$x?></td>
                                    <td>
                                        <select>
                                            <option value="0">-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="text-right" type="text">
                                    </td>
                                    <td>
                                        <input class="text-right" type="text">
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                </div>
            </div>    
        </form>
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
                restaurant_menu_tag.rmt_id,
                restaurant_menu_tag.rmt_name
            from
                restaurant_menu_tag_assign
            inner join
                restaurant_menu_tag
                on restaurant_menu_tag.rmt_id = restaurant_menu_tag_assign.rmt_id  
            where
                restaurant_menu_tag_assign.rm_id = '".$g_rm_id."'
            order by
                restaurant_menu_tag.rmt_name
        ";
        $result = $db->query($query) or die('ERROR!|WQUIEHQWUIEHUQWE');
        while($row = $result->fetchArray())
        {
            $rm_tag .= $row['rmt_name'].';';     
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
                <form method="post" action="<?=APP_URL?>?page=restaurant_add_edit&restaurant_id=<?=$g_restaurant_id?>" accept-charset="utf-8">
                    <label>Restaurant Menu Name</label>
                    <input type="text" name="rm_name" value="<?=isset($data_menu['rm_name']) ? $data_menu['rm_name'] : ''?>">
                    <label>Restaurant Menu Category Tag</label>
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