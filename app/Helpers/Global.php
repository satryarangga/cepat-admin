<?php

    /**
     * @param string $messageType
     * @param string $message
     * @return string
     */
    function setDisplayMessage($messageType = 'error', $message = 'Error Message')
    {
        $message = '<div style="margin:20px 0" class="alert alert-' . $messageType . '">' . $message . '</div>';
        return $message;
    }

    /**
     * @param $status
     * @param string $type
     * @return string
     */
    function setActivationStatus($status, $type = 'Active'){
        if($status == 0){
            return '<span class="btn btn-danger">Not '.$type.'</span>';
        }

        return '<span class="btn btn-success">'.$type.'</span>';
    }

    function parseMoneyToInteger($money) {
        if($money == null){
            return 0;
        }
        $money = str_replace('.', '', $money);
        $money = str_replace('Rp', '', $money);
        return str_replace(',', '', $money);
    }

    /**
     * @param $money
     * @return string
     */
    function moneyFormat ($money, $useCurrency = true) {
        $currency = ($useCurrency) ? 'Rp. ' : '';
        $money = number_format($money,0,',',',');

        return $currency.$money;
    }

    /**
     * @param $money
     * @return string
     */
    function numberFormat ($money) {
        $currency = 'Rp. ';
        $money = number_format($money,0,',',',');

        return $money;
    }

    function getMonths() {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }

    function dateHumanFormat($date) {
        if($date == null) {
            return null;
        }

        return date('j F Y', strtotime($date));
    }

    function logUser($desc) {
        return App\Models\UserLogs::createLog($desc);
    }

    function getFieldOfTable($tableName, $primaryKey, $field) {
        $query = Illuminate\Support\Facades\DB::table($tableName)->where('id', $primaryKey)->value($field);

        return $query;
    }

    function urlFormat($name) {
        $constraint = [' ', '_'];
        return strtolower(str_replace($constraint, '-', $name));
    }

    function convertSeconds($seconds) {
      if(!$seconds) {
        return null;
      }
      $dt1 = new DateTime("@0");
      $dt2 = new DateTime("@$seconds");

      if($seconds >= 86400) {
        return $dt1->diff($dt2)->format('%a d, %h h, %i m, %s s');
      }

      if($seconds >= 3600) {
        return $dt1->diff($dt2)->format('%h h, %i m, %s s'); 
      }

      if($seconds >= 60) {
        return $dt1->diff($dt2)->format('%i m , %s s'); 
      }

      return $dt1->diff($dt2)->format('%s s'); 

    }

    function setShippingStatus($status) {
        switch ($status) {
          case 0:
            return 'Not Shipped';
            break;
          case 1:
            return 'Shipped';
            break;
          case 2:
            return 'Delivered';
            break;
          case 3:
            return 'Fail to delivered';
            break;
          case 4:
            return 'Returned';
            break;
        }
    }

    function getPaymentStatus($status) {
        switch ($status) {
          case 0:
            return 'Unpaid';
            break;
          case 1:
            return 'Confirmed by Customer';
            break;
          case 2:
            return 'Paid';
            break;
        }
    }

    function buildCategoryTreeArray($parent, $category) {
        $arr = [];
        if (isset($category['parent_cats'][$parent])) {
            foreach ($category['parent_cats'][$parent] as $cat_id) {
                if (!isset($category['parent_cats'][$cat_id])) {
                    $arr[] = [
                        'id'  =>  $category['categories'][$cat_id]['id'],
                        'name'  =>  $category['categories'][$cat_id]['name'],
                        'status'  =>  $category['categories'][$cat_id]['status'],
                    ];
                }
                if (isset($category['parent_cats'][$cat_id])) {
                    $arr[] = [
                        'id'        =>  $category['categories'][$cat_id]['id'],
                        'name'      =>  $category['categories'][$cat_id]['name'],
                        'status'  =>  $category['categories'][$cat_id]['status'],
                        'children'  => buildCategoryTreeArray($cat_id, $category)
                    ];
                }
            }
        }
        return $arr;
    }