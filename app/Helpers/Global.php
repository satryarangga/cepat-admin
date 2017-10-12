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
        return str_replace(',', '', $money);
    }

    /**
     * @param $money
     * @return string
     */
    function moneyFormat ($money) {
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

    function getPrevYears() {
        $now = date('Y');
        $limit = 3;
        for($i=0; $i < $limit; $i++) {
            $years[] = $now - $i;
        }

        return $years;
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

    function generateApiField($fieldName, $label, $type = 'string', $required = true, $options = null, $desc = null) {
        $field = [
            'fieldName' => $fieldName,
            'type'      => $type,
            'label'     => $label,
            'required'  => $required
        ];

        if($options != null) {
            $field['options'] = $options;
        }

        if($desc != null) {
            $field['desc'] = $desc;
        }

        return $field;
    }

    function getFieldOfTable($tableName, $primaryKey, $field) {
        $query = Illuminate\Support\Facades\DB::table($tableName)->where('id', $primaryKey)->value($field);

        return $query;
    }
