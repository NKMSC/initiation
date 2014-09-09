<?php
function ConnectMysql()
{
    // 连主库
    $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);    
    if($link)
    {
        mysql_select_db(SAE_MYSQL_DB,$link);
        return  $link;
    }else
    {
        return null;
    }
}
?>