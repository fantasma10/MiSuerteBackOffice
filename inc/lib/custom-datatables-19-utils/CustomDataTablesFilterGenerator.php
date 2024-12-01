<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions.ajax.inc.php');

class CustomDataTablesFilterGenerator
{
    private $optionsDict = array();

    public function addOptionFromSource (
        $source,
        $filterKey,
        $labelKey,
        $valueKey,
        $comparatorFunction
    ) {
        $label = $source[$labelKey];
        $value = $source[$valueKey];

        if (
            (
                is_callable($comparatorFunction)
                && $comparatorFunction($value)
            )
            || (
                is_callable($comparatorFunction, true)
                && call_user_func(array($this, $comparatorFunction), $value)
            )
        ) {
            if (empty($this->optionsDict[$filterKey][$value])) {
                $this->optionsDict[$filterKey][$value] = array(
                    'id' => $value,
                    'name' => $label
                );
            }
        }
    }

    public function addOption ($filterKey, $value, $label)
    {
        $this->optionsDict[$filterKey][$value] = array(
            'id' => $value,
            'name' => $label
        );
    }

    public function generate ()
    {
        $filters = array();
        foreach ($this->optionsDict as $key => $items) {
            $columnsValues = array_values($items);
            array_multisort(array_column($columnsValues, 'name'), SORT_ASC, $columnsValues);
            $filters[$key] = $columnsValues;
        }

        return $filters;
    }

    public function isNotEmptyStringValue ($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $sanitized = trim($value);
        return !empty($sanitized);
    }

    /**
     * Este método es útil para valores que vienen directamente desde el stored procedure
     * porque todos vienen como strings aunque sean números o nulos
     *
     * @param string $value
     * @return boolean
     */
    public function isNotNullStringValue ($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $sanitized = strtolower(trim($value));
        return (
            $sanitized !== 'null'
            && !empty($sanitized)
        );
    }

    public function isBooleanValue ($value)
    {
        if (is_bool($value)) {
            return true;
        } else if (is_string($value)) {
            $sanitized = strtolower(trim($value));
            return (
                $sanitized === 'true'
                || $sanitized === 'false'
            );
        }

        return false;
    }
}




?>
