<?php
defined('APP_PATH') OR exit('No direct script access allowed');

if($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if($page == 'login')
    {
        if(isset($_POST['login']))
        {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $_SESSION['mess'] = '';
            
            if(! preg_match('/^[a-z0-9-_]{3,20}$/', $username)) 
            {
                $_SESSION['mess'] .= 'Username Invalid<br>';    
            }
            
            if($_SESSION['mess'] == '')
            {
                $query = "select * from user where username = '".$username."'";
                $result = $db->query($query);
                $data = $result->fetchArray();
                
                if(! $data)
                {
                    $_SESSION['mess'] .= 'Username / Password Invalid<br>';   
                }
                else
                {
                    if($data['status_id'] == 0)
                    {
                        $_SESSION['mess'] .= 'Account InActive<br>';
                    }
                    elseif($data['status_id'] == 1)
                    {
                        if(! password_verify($password, $data['password']))
                        {
                            $_SESSION['mess'] .= 'Username / Password Invalid<br>';     
                        }    
                    }
                }
                        
            }
            
            if($_SESSION['mess'] == '')
            {
                $_SESSION['ses_username'] = $username; 
                $_SESSION['ses_user_id'] = $data['user_id'];
                $_SESSION['ses_role_id'] = $data['role_id'];
                $_SESSION['ses_display_name'] = $data['display_name'];
                
                header('location: '.APP_URL.'?page=home');
            }
        }    
    }
    elseif($page == 'book_add_edit')
    {
        if(isset($_POST['submit']))
        {
            $title = isset($_POST['book_title']) ? $_POST['book_title'] : '';    
            $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
            $_SESSION['mess'] = '';
            if(! preg_match('/^[a-zA-Z0-9-_ ]{1,50}$/', $title)) 
            {
                $_SESSION['mess'] .= 'Title Invalid<br>';        
            }
            
            if(! preg_match('/^[0-9]*$/', $book_id)) 
            {
                $_SESSION['mess'] .= 'Book ID Invalid<br>';        
            }
            
            if($_SESSION['mess'] == '')
            {
                if($book_id == 0)
                {
                    //New
                    $query = "select max(book_id) as last_id from book";
                    $result = $db->query($query);
                    $data = $result->fetchArray();
                    $final_book_id = ((int) $data['last_id'])+1;
                    
                    $query = "
                        insert into
                            book
                            (
                                book_id,
                                book_title,
                                user_id,
                                created_at
                            )
                        values
                            (
                                '".$final_book_id."',
                                '".$title."',
                                '".$ses['user_id']."',
                                '".time()."'
                            )
                    ";
                }
                else
                {
                    $final_book_id = $book_id;
                    $query = "
                        UPDATE
                            book
                        SET
                            book_title = '".$title."'
                        WHERE
                            book_id = '".$final_book_id."'
                    ";
                }
                
                if($db->query($query))
                {
                    $_SESSION['mess'] .= 'Added Successfully';
                    header('location: '.APP_URL.'?page=book_add_edit&book_id='.$final_book_id); 
                }
                else
                {
                    $_SESSION['mess'] .= 'Added Failed';
                  
                }    
            }
                    
        }    
    }
    elseif($page == 'restaurant_add_edit')
    {
        if(isset($_POST['submit']))
        {
            $name = isset($_POST['restaurant_name']) ? $_POST['restaurant_name'] : '';    
            $restaurant_id = isset($_POST['restaurant_id']) ? $_POST['restaurant_id'] : '';
            $_SESSION['mess'] = '';
            if(! preg_match('/^[a-zA-Z0-9-_ ]{1,50}$/', $name)) 
            {
                $_SESSION['mess'] .= 'Name Invalid<br>';        
            }
            
            if(! preg_match('/^[0-9]*$/', $restaurant_id)) 
            {
                $_SESSION['mess'] .= 'Restaurant ID Invalid<br>';        
            }
            
            if($_SESSION['mess'] == '')
            {
                if($restaurant_id == 0)
                {
                    //New
                    $query = "select max(restaurant_id) as last_id from restaurant";
                    $result = $db->query($query);
                    $data = $result->fetchArray();
                    $final_restaurant_id = ((int) $data['last_id'])+1;
                    
                    $query = "
                        insert into
                            restaurant
                            (
                                restaurant_id,
                                restaurant_name,
                                created_by,
                                created_at,
                                modified_by,
                                modified_at
                            )
                        values
                            (
                                '".$final_restaurant_id."',
                                '".$name."',
                                '".$ses['user_id']."',
                                '".time()."',
                                0,
                                0
                            )
                    ";
                }
                else
                {
                    $final_restaurant_id = $restaurant_id;
                    $query = "
                        UPDATE
                            restaurant
                        SET
                            restaurant_name = '".$name."',
                            modified_by = '".$ses['user_id']."',
                            modified_at = '".time()."'
                        WHERE
                            restaurant_id = '".$final_restaurant_id."'
                    ";
                }
                
                if($db->query($query))
                {
                    $_SESSION['mess'] .= 'Added Successfully';
                    header('location: '.APP_URL.'?page=restaurant_add_edit&restaurant_id='.$final_restaurant_id); 
                }
                else
                {
                    $_SESSION['mess'] .= 'Added Failed';
                  
                }    
            }
                    
        }    
    }
    elseif($page == 'restaurant_menu_add_edit')
    {
        if(isset($_POST['submit']))
        {
            $name = isset($_POST['rm_name']) ? $_POST['rm_name'] : '';    
            $restaurant_id = isset($_POST['restaurant_id']) ? $_POST['restaurant_id'] : '';
            $rm_tag = isset($_POST['rm_tag']) ? $_POST['rm_tag'] : '';
            $rm_id = isset($_POST['rm_id']) ? $_POST['rm_id'] : '';
            $_SESSION['mess'] = '';
            if(! preg_match('/^[a-zA-Z0-9-_ ]{1,50}$/', $name)) 
            {
                $_SESSION['mess'] .= 'Name Invalid<br>';        
            }
            
            if(! preg_match('/^[0-9]*$/', $restaurant_id)) 
            {
                $_SESSION['mess'] .= 'Restaurant ID Invalid<br>';        
            }
            
            if(! preg_match('/^[0-9]*$/', $rm_id)) 
            {
                $_SESSION['mess'] .= 'RM ID Invalid<br>';        
            }
            
            $rm_tag = trim($rm_tag);
            if(trim($rm_tag) != '')
            {
                if(! preg_match('/^[a-z, ]{1,50}$/', $rm_tag)) 
                {
                    $_SESSION['mess'] .= 'Tags Invalid<br>';        
                }    
            }
                
            
            if($_SESSION['mess'] == '')
            {
                if($rm_id == 0)
                {
                    //New
                    $query = "select max(rm_id) as last_id from restaurant_menu";
                    $result = $db->query($query);
                    $data = $result->fetchArray();
                    $final_id = ((int) $data['last_id'])+1;
                    
                    $query = "
                        insert into
                            restaurant_menu
                            (
                                rm_id,
                                restaurant_id,
                                rm_name,
                                created_by,
                                created_at,
                                modified_by,
                                modified_at
                            )
                        values
                            (
                                '".$final_id."',
                                '".$restaurant_id."',
                                '".$name."',
                                '".$ses['user_id']."',
                                '".time()."',
                                0,
                                0
                            )
                    ";
                }
                else
                {
                    $final_id = $rm_id;
                    $query = "
                        UPDATE
                            restaurant_menu
                        SET
                            rm_name = '".$name."',
                            modified_by = '".$ses['user_id']."',
                            modified_at = '".time()."'
                        WHERE
                            rm_id = '".$final_id."'
                    ";
                }
                
                
                if($db->query($query))
                {
                    $query = "delete from restaurant_menu_tag where rm_id = '".$final_id."'";
                    if($db->query($query))
                    {
                        //ok
                    }
                    else
                    {
                        $_SESSION['mess'] .= 'Delete TAG Failed';   
                    }
                    
                    if($rm_tag != '')
                    {
                        $exp_tag = explode(',',$rm_tag);
                        
                        foreach($exp_tag as $tag)
                        {
                            $tag = trim($tag);
                            $tag = strtolower($tag);
                            $tag = preg_replace("/[^a-z ]/", "",$tag);
                                         
                            if($tag != '')
                            {
                                //check
                                $query = "
                                    select
                                        *
                                    from
                                        tag
                                    where
                                        tag_name = '".$tag."'
                                ";
                                $result = $db->query($query);
                                $data = $result->fetchArray();
                                
                                if((int) $data['tag_id'] == 0)
                                {
                                    $query = "select max(tag_id) as last_id from tag";
                                    $result = $db->query($query);
                                    $data = $result->fetchArray();
                                    $final_tag_id = ((int) $data['last_id'])+1;
                                    
                                    $query = "
                                        insert into
                                            tag
                                            (
                                                tag_id,
                                                tag_name,
                                                created_by,
                                                created_at
                                            )
                                         values
                                            (
                                                '".$final_tag_id."',
                                                '".$tag."',
                                                '".$ses['user_id']."',
                                                '".time()."'
                                            )    
                                    ";
                                    if($db->query($query))
                                    {
                                        //ok   
                                    }
                                    else
                                    {
                                        $_SESSION['mess'] .= 'Added TAG Failed';
                                    }
                                }
                                else
                                {
                                    $final_tag_id = (int) $data['tag_id'];
                                    
                                    $query = "
                                        insert into
                                            restaurant_menu_tag
                                            (
                                                rm_id,
                                                tag_id,
                                                created_by,
                                                created_at
                                            )
                                        values
                                            (
                                                '".$final_id."',
                                                '".$final_tag_id."',
                                                '".$ses['user_id']."',
                                                '".time()."'
                                            )
                                    ";
                                    
                                    if($db->query($query))
                                    {
                                        //ok   
                                    }
                                    else
                                    {
                                        $_SESSION['mess'] .= 'Assign TAG Failed';
                                    } 
                                }    
                            }
                            else
                            {
                                $_SESSION['mess'] .= 'Tag: '.$tag.' Invalid<br>';    
                            }    
                        }
                    }
                    
                    if($_SESSION['mess'] == '')
                    {
                        $_SESSION['mess'] .= 'Added Successfully';
                        header('location: '.APP_URL.'?page=restaurant_menu_add_edit&restaurant_id='.$restaurant_id.'&rm_id='.$final_id);    
                    }
                    else
                    {
                        $_SESSION['mess'] .= 'Added TAG Failed';   
                    }
                         
                }
                else
                {
                    $_SESSION['mess'] .= 'Added Failed';
                  
                } 
                
                
                   
            }
                    
        }    
    }
    elseif($page == 'person_add_edit')
    {
        if(isset($_POST['submit']))
        {
            $person_name = isset($_POST['person_name']) ? $_POST['person_name'] : '';    
            $initial_name = isset($_POST['initial_name']) ? $_POST['initial_name'] : '';    
            $person_id = isset($_POST['person_id']) ? $_POST['person_id'] : '';
            $_SESSION['mess'] = '';
            
            if(! preg_match('/^[a-zA-Z0-9-_ ]{1,50}$/', $person_name)) 
            {
                $_SESSION['mess'] .= 'Full Name Invalid<br>';        
            }
            
            if(! preg_match('/^[a-zA-Z0-9-_ ]{1,50}$/', $initial_name)) 
            {
                $_SESSION['mess'] .= 'Initial Name Invalid<br>';        
            }
            else
            {
                $initial_name = strtoupper($initial_name);    
            }
            
            if(! preg_match('/^[0-9]*$/', $person_id)) 
            {
                $_SESSION['mess'] .= 'Person ID Invalid<br>';        
            }
            
            if($_SESSION['mess'] == '')
            {
                if($person_id == 0)
                {
                    //New
                    $query = "select max(person_id) as last_id from person";
                    $result = $db->query($query);
                    $data = $result->fetchArray();
                    $final_id = ((int) $data['last_id'])+1;
                    
                    $query = "
                        insert into
                            person
                            (
                                person_id,
                                person_name,
                                initial_name,
                                status_id,
                                created_by,
                                created_at
                            )
                        values
                            (
                                '".$final_id."',
                                '".$person_name."',
                                '".$initial_name."',
                                '1',
                                '".$ses['user_id']."',
                                '".time()."'
                            )
                    ";
                }
                else
                {
                    $final_id = $person_id;
                    $query = "
                        UPDATE
                            person
                        SET
                            person_name = '".$person_name."',
                            initial_name = '".$initial_name."'
                        WHERE
                            person_id = '".$final_id."'
                    ";
                }
                
                if($db->query($query))
                {
                    $_SESSION['mess'] .= 'Added Successfully';
                    header('location: '.APP_URL.'?page=person_add_edit&person_id='.$final_id); 
                }
                else
                {
                    $_SESSION['mess'] .= 'Added Failed';
                  
                }    
            }
                    
        }    
    }
    elseif($page == 'invoice_add_edit')
    {
        if(isset($_POST['submit']))
        {
            $v_invoice_date = parsedate($_POST['invoice_date']);
            $v_restaurant_id = (int) $_POST['restaurant_id'];
            $v_platform_id = (int) $_POST['platform_id'];
            $v_tax_amount = (int) $_POST['tax_amount'];
            $v_discount_amount = (int) $_POST['discount_amount'];
            $v_delivery_amount = (int) $_POST['delivery_amount'];
            $v_other_amount = (int) $_POST['other_amount'];
            $v_adjustment_amount = (int) $_POST['adjustment_amount'];
            $v_book_id = (int) $_POST['book_id'];
            $v_invoice_id = (int) $_POST['invoice_id'];
            $product_list = $_POST['product_list'];
            $mess = '';

            if($v_invoice_date == 0)
            {
                $mess .= 'Invoice Date Invalid<br>';    
            }

            if($v_restaurant_id == 0)
            {
                $mess .= 'Restaurant Invalid<br>';    
            }

            if($v_book_id == 0)
            {
                $mess .= 'Book Invalid<br>';    
            }

            if($v_platform_id == 0)
            {
                $mess .= 'Platform Invalid<br>';    
            }

            if($mess == '')
            {
                if($v_invoice_id == 0)
                {
                    $query = "select max(invoice_id) as last_id from invoice";
                    $result = $db->query($query);
                    $data = $result->fetchArray();
                    $v_invoice_id = ((int) $data['last_id'])+1;
                    
                    $query = "
                        insert into
                            invoice
                            (
                                invoice_id,
                                book_id,
                                restaurant_id,
                                invoice_date,
                                tax_amount,
                                discount_amount,
                                delivery_amount,
                                adjustment_amount,
                                other_amount,
                                platform_id,
                                created_by,
                                created_at
                            )
                        values
                            (
                                '".$v_invoice_id."',
                                '".$v_book_id."',
                                '".$v_restaurant_id."',
                                '".$v_invoice_date."',
                                '".$v_tax_amount."',
                                '".$v_discount_amount."',
                                '".$v_delivery_amount."',
                                '".$v_adjustment_amount."',
                                '".$v_other_amount."',
                                '".$v_platform_id."',
                                '".$ses['user_id']."',
                                '".time()."'
                            )
                    ";    
                }
                else
                {
                    $query = "
                        update
                            invoice
                        set
                            restaurant_id = '".$v_restaurant_id."',   
                            invoice_date = '".$v_invoice_date."',   
                            tax_amount = '".$v_tax_amount."',   
                            discount_amount = '".$v_discount_amount."',   
                            delivery_amount = '".$v_delivery_amount."',   
                            adjustment_amount = '".$v_adjustment_amount."',   
                            other_amount = '".$v_other_amount."',   
                            platform_id = '".$v_platform_id."',  
                            created_by = '".$ses['user_id']."',   
                            created_at = '".time()."'
                        where
                            invoice_id = '".$v_invoice_id."' 
                    ";
                }

                if(! $db->query($query))
                {
                    $mess .= 'Failed Insert / Update Invoice<br>';
                }
            }

            if($mess == '')
            {
                $query = "
                    delete from invoice_details where invoice_id = '".$v_invoice_id."' 
                ";
                if(! $db->query($query))
                {
                    $mess .= 'FAILED DELETE Invoice Details<br>';
                }

                foreach($product_list as $index => $val)
                {
                    if($val['product_id'] > 0 && $val['qty'] > 0 && $val['price'] > 0)
                    {
                        $query = "select max(id_id) as last_id from invoice_details";
                        $result = $db->query($query);
                        $data = $result->fetchArray();
                        $id_id = ((int) $data['last_id'])+1;

                        $query = "
                            insert into
                                invoice_details
                                (
                                    id_id,
                                    invoice_id,
                                    rm_id,
                                    qty,
                                    price
                                )
                            values
                                (
                                    '".$id_id."',   
                                    '".$v_invoice_id."',   
                                    '".$val['product_id']."',   
                                    '".$val['qty']."',   
                                    '".$val['price']."'   
                                )
                        ";

                        if(! $db->query($query))
                        {
                            $mess .= 'FAILED Insert Invoice Details<br>';
                        }
                    }
                }    
            }

            if($mess != '')
            {
            ?>
                <script>
                    parent.document.getElementById('alert_mess').style.display = '';
                    parent.document.getElementById('alert_mess_content').innerHTML = '<h4>ERROR</h4><?=$mess?>';
                </script>
            <?php
            }
            else
            {
            ?>
                <script>
                    parent.window.open('<?=APP_URL?>?page=invoice_add_edit&book_id=<?=$v_book_id?>&invoice_id=<?=$v_invoice_id?>', '_self');
                </script>
            <?php
            }

            die();
        }

    }
    else
    {
        header('location: '.APP_URL.'?page=fatal_error');
    }   
}
elseif($_SERVER['REQUEST_METHOD'] === 'GET')
{
    if($page == 'logout')
    {
        session_destroy();
        
        $_SESSION['mess'] = 'Logout Successfully';
        header('location: '.APP_URL.'?page=login');
        
    }
    
    if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] > 0)
    {
        if($page == 'getSelectRestaurantMenuByRestaurantID')
        {   
            $restaurant_id = isset($_GET['restaurant_id']) ? $_GET['restaurant_id'] : 0;
            $res = array();
            if($restaurant_id == 0)
            {
                $res['status'] = 'error';        
                $res['status_mess'] = 'Restaurant ID Invalid / Empty';        
            }
            else
            {
                $query = "
                    select
                        restaurant_menu.rm_id,
                        restaurant_menu.rm_name
                    from
                        restaurant_menu
                    where
                        restaurant_menu.restaurant_id = '".$restaurant_id."'
                    order by
                        restaurant_menu.rm_name ASC
                ";
                $result = $db->query($query);
                while($row = $result->fetchArray())
                {
                    $res['data'][] = array(
                        'id' => $row['rm_id'],    
                        'name' => $row['rm_name'],    
                        'last_price' => 9999,    
                    );    
                }
                
                $res['status'] = 'ok';        
                $res['status_mess'] = '';
            }
            
            header('Content-type: application/json');
            echo json_encode($res);
            die();         
        }    
    }    
}