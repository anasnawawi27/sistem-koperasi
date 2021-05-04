<?php

function already_login(){
    
    $ci =& get_instance();
    $user_session = $ci->session->userdata('id');
    if($user_session)
    {
        redirect('dashboard');
    }
}

function not_login(){
    
    $ci =& get_instance();
    $user_session = $ci->session->userdata('id');
    if(!$user_session)
    {
        redirect('auth');
    }
}