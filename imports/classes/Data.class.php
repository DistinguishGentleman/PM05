<?php

class Data 
{
    public static function validateData(object $object): bool 
    {
        $isValid = true;

        foreach (get_object_vars($object) as $property => $value) {
            if (!str_starts_with($property, '_')) {
                continue;
            }

            if (empty(Request::clear_parameter($value))) {
                $fieldName = substr($property, 1);
                $object->{$fieldName . '_validate'} = "$fieldName is empty";
                $isValid = false;
            }
        }

        return $isValid;
    }

    public static function loadData(object $object, array $data): void 
    {
        foreach ($data as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }
    }

    public static function rn_to_br(string $string): string 
    {
        return str_replace('\r\n', '<br/>', $string);
    }

    public static function br_to_rn(string $string): string 
    {
        return str_replace('<br/>', '\r\n', $string);
    }

    public static function datetime_format(string $date): string 
    {
        return (new DateTime($date))->format('d.m.Y H:i:s');
    }
}


?>