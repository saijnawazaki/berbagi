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
}