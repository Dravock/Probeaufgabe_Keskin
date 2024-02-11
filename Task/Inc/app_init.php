<?php
declare(strict_types=1);

class AppInit
{
    
    private $data;
    // Implementiere Methoden für den Datenzugriff und die Verarbeitung hier
    public function __construct()
    {
        // child class constructor
        $csv_path = "./Data/CSV/staff.csv";
        $read_csv = $this->read_csv($csv_path);
        $get_csv_headers = $this->get_csv_headers($read_csv);
        $get_employee_data = $this->get_employee_data($read_csv);

        // Normalize ALL Employe Data in Array
        foreach ($get_employee_data as $key => $value) {
            $normalized_array[$key] = $this->normalize_employee_array($get_csv_headers, $get_employee_data, $key);
        }
        $get_employee_data = $normalized_array;
        
        // Normalize Header Array
        $get_csv_headers = $this->normalize_header_arr($get_csv_headers);

        // Combine Header and Employee Data
        $process_data = $this->merge_array($get_csv_headers, $get_employee_data);
        $filter_header = $this->filter_header($process_data["tableheader"]);

        foreach($process_data["employee_data"] as $key => $value) {
            $filter_employee[$key] = $this->filter_employee($value);
        }

        // Sort the employee by name
        usort($filter_employee, array($this, "sort_by_name"));

        // Process the data
        $process_data = $this->merge_array($filter_header, $filter_employee);

        // Set the data
        $this->data = $process_data;
    }

    protected function read_csv($csv_path): array
    {
        $file = fopen($csv_path, "r");

        $employees_data = array();

        while (($data = fgetcsv($file)) !== FALSE) {
            $employees_data[] = $data;
        }
        fclose($file);

        return $employees_data;
    }

    protected function get_csv_headers($data, $filtered = false): array
    {
        $storage_array = array();

        if ($filtered) {
            $storage_array = $this->filter_header($data);
        } else {
            $storage_array = $data[0];
            foreach ($storage_array as $key => $value) {
                if ($value === "Name") {
                    $storage_array[$key] = "Name";
                }
            }
        }

        return $storage_array;
    }

    // Protected Methods
    protected function extract_csv_header($csv_path): array
    {
        $file = $this->read_csv($csv_path);
        $file = $file[0];
        return $file;
    }

    protected function extract_csv_data($csv_path): array
    {
        $file = $this->read_csv($csv_path);
        $file = array_slice($file, 1);
        return $file;
    }

    // Private Methods
    private function normalize_header_arr($get_csv_headers): array
    {
        $count_loops = 0;
        foreach ($get_csv_headers as $key => $value) {
            if ($count_loops === $key) {
                $return_arr[$value] = $value;
            }
            $count_loops++;
        }
        return $return_arr;
    }

    private function normalize_employee_array($data_header, $data_employee, $count = 0)
    {
        $arr = array();

        foreach ($data_header as $key_1 => $value_1) {
            foreach ($data_employee[$count] as $key_2 => $value_2) {
                if ($key_1 === $key_2) {
                    $arr[$value_1] = $value_2;
                };
            }
        }
        return $arr;
    }

    private function filter_header($data): array
    {
        $storage_array = [
            "name" => "Name",
        ];

        foreach ($data as $key => $value) {
            switch ($value) {
                case "startDate":
                    $storage_array[$key] = "Startdatum";
                    break;
                case "endDate":
                    $storage_array[$key] = "Enddatum";
                    break;
                case "weeklyHours":
                    $storage_array[$key] = "Aktuelle Wochenstunden";
                    break;
                case "updateDate":
                    $storage_array[$key] = "Letzte Aktualisierung/Änderung der Wochenstunden";
                    break;
                default:
                    break;
            }
        }

        return $storage_array;
    }

    private function filter_employee($data): array
    {
        $storage_array = array();

        $filterCategory = [
            "staffId",
            "firstName",
            "lastName",
            "startDate",
            "endDate",
            "weeklyHours" ,
            "updateDate" 
        ];

        $cache = array();

        foreach ($data as $key => $value) {
            if(in_array($key, $filterCategory)) {
                if($key === "firstName" || $key === "lastName") {
                    $cache[$key] = $value;
                } else {
                    $storage_array[$key] = $value;
                }
            }
        }

        $storage_array["name"] = $cache["lastName"]. " " .$cache["firstName"]  ;

        return $storage_array;
    }

    private function get_employee_data($data): array
    {
        $employees_array_raw = array_slice($data, 1);
        return $employees_array_raw;
    }

    private function merge_array($header,$employee): array
    {
        $data = [
            "tableheader" => $header,
            "employee_data" => $employee
        ];

        return $data;
    }

    private function sort_by_name($a , $b) {
        return strcmp($a['name'], $b['name']);
    }

    // Public Methods
    public function getAllEmployees(): array
    {
        return $this->data; 
    }
}
