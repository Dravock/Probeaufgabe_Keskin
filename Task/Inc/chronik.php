<?php
declare(strict_types=1);

class Chronik 
{
    public $id;

    private $chronik_data;
    private $history_uri;
    private $history_changes_uri;
    private $staff_csv;
    private $employe_name;

    public function __construct(string $id)
    {
        $this->id = $id;

        $this->staff_csv = "../Data/CSV/staff.csv";
        $file_staff = $this->read_csv($this->staff_csv);

        $this->employe_name = $this->get_employee_name($id,$file_staff);
    
        $this->history_uri = "../Data/CSV/history.csv";
        $file_history = $this->read_csv($this->history_uri);
        $file_history = $this->extract_data($file_history);

        $this->history_changes_uri = "../Data/CSV/history_changed_fields.csv";
        $file_history_changes = $this->read_csv($this->history_changes_uri);
        $file_history_changes = $this->extract_data($file_history_changes);

        $raw_data = $this->merge_arrays("history",$file_history,"history_changes",$file_history_changes);

        $filtered_history = $this->filter_data($raw_data,$this->id,"history");
        $filtered_history_changes = $this->filter_data($raw_data,$this->id,"history_changes");
        $merged_filtered_data = $this->merge_arrays("history",$filtered_history,"history_changes",$filtered_history_changes);


        $builded_chronik_data = $this->build_chronik_data($this->id);

        $this->chronik_data = $builded_chronik_data;
    }

    private function get_employee_name($id,$data): string
    {
        $storage_array = "" ;
        foreach($data as $key => $value){
            if($value[0] == $id){
                $storage_array = $value[6].' '.$value[5];
                return $storage_array;
            }
        }
        
    }

    private function build_chronik_data(string $id): array
    {
        $data =[];
        $return_array = [
            "employee_name" => $this->employe_name,
            "id" => $id,
            "history" => $data
        ];

        return $return_array;
    }

    private function filter_data(array $data , string $id ,string $filter_key): array
    {
        $filtered_data = [];
        foreach($data[$filter_key] as $key => $value){
            $test = $value[1];
            if($test == $id){
                $filtered_data[$key] = $value;
            }
        }

        return $filtered_data;
    }

    private function merge_arrays(string $key_1,array $array_1,string $key_2,array $array_2): array
    {
        $array = [
            $key_1=> $array_1,
            $key_2 => $array_2
        ];

        return $array;
    }

    private function read_csv(string $csv_path): array
    {
        $file = fopen($csv_path, "r");

        $employees_data = array();

        while (($data = fgetcsv($file)) !== FALSE) {
            $employees_data[] = $data;
        }
        fclose($file);

        return $employees_data;
    }

    private function extract_data(array $data): array
    {
        $data = array_slice($data, 1);
        return $data;
    }

    public function get_employee_chronik(): array
    {
        return $this->chronik_data;
    }
}
