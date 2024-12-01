<?php
class CustomDataTables19ServerSideParameterParser
{
    /**
     * Convierte el valor a un valor nativo de php
     *
     * @param mixed $value
     * @return boolean|int|float|string
     */
    protected function castFilterValueToType ($value)
    {
        $parsedValue = $value;

        if (is_bool($value)) {
            $parsedValue = $value;
        } else if ($value === 'true') {
            $parsedValue = true;
        } else if ($value === 'false') {
            $parsedValue = false;
        } else if (is_numeric($value) && is_float($value + 0) && is_finite($value + 0)) {
            $parsedValue = (float) $value;
        } else if (is_numeric($value) && is_integer($value + 0) && is_finite($value + 0)) {
            $parsedValue = (int) $value;
        }

        return $parsedValue;
    }

    /**
     * Regresa un array que mapea los campos predeterminados del formulario enviados por DataTables
     *
     * @param array $formFields Este array debe contener llaves con el formato de datatables 1.9
     * por ejemplo mDataProp_0/sSearch_0
     * @return array
     */
    protected function parseFormFields ($formFields)
    {
        $parameters = array();
        $columns = array();
        foreach ($formFields as $key => $value) {
            $isExactParameter = false;

            switch ($key) {
                case 'iDisplayStart':
                case 'iDisplayLength':
                case 'iColumns':
                case 'iSortingCols':
                case 'sSearch':
                case 'bRegex':
                case 'sEcho':
                    $parameters[$key] = $this->castFilterValueToType($value);
                    $isExactParameter = true;
                    break;

                default:
                    break;
            }

            if (
                !$isExactParameter
                && preg_match(
                    '/([msbi](DataProp|Search|Searchable|Regex|Sortable|SortCol|SortDir))_(\d+)/',
                    $key,
                    $matches
                )
            ) {
                $filterKey = $matches[1];
                $columnIndex = $matches[3];
                if (empty($columns[$columnIndex])) {
                    $parsedValue = $value;

                    $columns[$columnIndex] = array(
                        $filterKey => $this->castFilterValueToType($parsedValue)
                    );
                } else {
                    $columns[$columnIndex][$filterKey] = $this->castFilterValueToType($value);
                }
            }
        }

        return array_merge($parameters, array(
            'columns' => $columns
        ));
    }

    /**
     * Regresa un array que mapea los campos predeterminados del formulario enviados por DataTables
     *
     * @param array $formFields Este array debe contener llaves con el formato de datatables 1.9
     * por ejemplo mDataProp_0/sSearch_0
     * @return array
     */
    public function parse ($formFields)
    {
        return $this->parseFormFields($formFields);
    }

    /**
     * Regresa un array que mapea el valor de "sSearch" al valor "mDataProp"
     *
     * @param array $columns
     * @return void
     */
    public function mapColumnDataPropToSearchTerm ($columns)
    {
        $dict = array();
        foreach ($columns as $config) {
            $dict[$config['mDataProp']] = $config['sSearch'];
        }

        return $dict;
    }
}


?>
