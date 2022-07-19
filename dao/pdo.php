<?php

    function pdo_get_connection() {
        $conn = new PDO('mysql:host=localhost;dbname=duan_1;charset=utf8', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    function pdo_execute($sql) {
        $args = array_slice(func_get_args(), 1);
        try {
            $conn = pdo_get_connection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            echo 'Có lỗi xảy ra: ' . $e->getMessage();
        } finally {
            unset($conn);
        }
    }

    function pdo_query($sql) {
        $args = array_slice(func_get_args(), 1);
        try {
            $conn = pdo_get_connection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Có lỗi xảy ra:  ' . $e->getMessage();
        } finally {
            unset($conn);
        }
    }

    function pdo_query_one($sql) {
        $args = array_slice(func_get_args(), 1);
        try {
            $conn = pdo_get_connection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Có lỗi xảy ra:  ' . $e->getMessage();
        } finally {
            unset($conn);
        }
    }

    function pdo_query_value($sql) {
        $args = array_slice(func_get_args(), 1);
        try {
            $conn = pdo_get_connection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return array_values($result)[0];
        } catch (PDOException $e) {
            echo 'Có lỗi xảy ra:  ' . $e->getMessage();
        } finally {
            unset($conn);
        }
    }

?>