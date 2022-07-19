<?php
    require_once '../../dao/table.php';
    require_once '../../global.php';
    check_login();
    extract($_REQUEST);

    if(array_key_exists('btn_insert', $_REQUEST)){
        $titlePage = 'Add table';
        $table = [];
        $errorMessage = [];
        $table['name'] = $name ?? '';
        $table['guest_number'] = $guest_number ?? '';
        $table['status'] = $status ?? '';
        // var_dump($table);
        if(!$table['name']){
            $errorMessage['name'] = 'Vui lòng nhập tên bàn';
        }else if(table_exits($name)){
            $errorMessage['name'] = 'Tên đã tồn tại';
        }

        if(!$table['guest_number']){
            $errorMessage['guest_number'] = 'Vui lòng nhập dữ liệu';
        }else if($table['guest_number']<=0){
            $errorMessage['guest_number'] = 'Vui lòng nhập số lớn hơn 0';
        }

        if($table['status']==''){
            $errorMessage['status'] = 'Vui lòng chọn trạng thái bàn ';
        }

        if(empty($errorMessage)){
            table_insert($name, $guest_number, $status);
            unset($table);
            $MESSAGE = 'Thêm thành công';
        }

        $VIEW_PAGE = 'add.php';

    }else if(array_key_exists('btn_add', $_REQUEST)){
        $titlePage = 'Add table';
        $VIEW_PAGE = 'add.php';
    }else if(array_key_exists('btn_delete', $_REQUEST)){
        table_delete($id);
        header('Location: ' . $ADMIN_URL . '/table');

    }else if(array_key_exists('btn_update', $_REQUEST)){
        $titlePage = 'Update table';
        $tableInfo = table_select_by_id($id);
        // var_dump($tableInfo);
        $table = [];
        $errorMessage = [];
        $table['name'] = $name ?? '';
        $table['guest_number'] = $guest_number ?? '';
        $table['status'] = $status ?? '';

        if(!$table['name']){
            $errorMessage['name'] = 'Vui lòng nhập tên bàn';
        }else if($name != $tableInfo['name'] && table_exits($name)){
            $errorMessage['name'] = 'Tên đã tồn tại';
        }

        if(!$table['guest_number']){
            $errorMessage['guest_number'] = 'Vui lòng nhập dữ liệu';
        }else if($table['guest_number']<=0){
            $errorMessage['guest_number'] = 'Vui lòng nhập số lớn hơn 0';
        }

        if($table['status']==''){
            $errorMessage['status'] = 'Vui lòng chọn trạng thái bàn ';
        }

        if(empty($errorMessage)){
            table_edit($name, $guest_number, $status, $id);
            $MESSAGE = 'Cập nhật thành công, hệ thống tự động chuyển hướng sau 3s';
            header('Refresh: 3; URL = ' . $ADMIN_URL . '/table');
        }

        $VIEW_PAGE = 'edit.php';
    }else if(array_key_exists('btn_edit', $_REQUEST)){
        $titlePage = 'Update table';
        $tableInfo = table_select_by_id($id);

        $VIEW_PAGE = 'edit.php';
    }else if(array_key_exists('keywords', $_REQUEST)){
        $titlePage = 'Search table';
        $listTable = table_search($keywords);

        $VIEW_PAGE = 'search.php';
    } 
     else{
        $titlePage = 'list table';
        $errorMessage = [];
        $totalTable = count(table_select_all());
        $limit = 10;
        $totalPage = ceil($totalTable / $limit);

        $currentPage = $page ?? 1;

        if ($currentPage <= 0) {
            header('Location: ' . $ADMIN_URL . '/table/?page=1');
        } else if ($currentPage > $totalPage) {
            $currentPage = $totalPage;
        }

        $start = ($currentPage - 1) * $limit;
        $listTable = table_select_all($start, $limit);
        $VIEW_PAGE = 'list.php';
    }
    require_once '../layout.php';
    
?>