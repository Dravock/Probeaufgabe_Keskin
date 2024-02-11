<?php
declare(strict_types=1);

class Chronik extends AppInit
{

    private $chronik_data;
    private $history_uri;
    private $history_changes_uri;

    public function __construct()
    {
        // Call the parent constructor
        parent::__construct();

        // Set the history and history changes uri
        $this->history_uri = "./Data/CSV/history.csv";
        $history_file = $this->read_csv($this->history_uri);
        $history_file = $this->extract_data($history_file);
        $this->history_changes_uri = "./Data/CSV/history_changed_fields.csv";
        $history_changes_file = $this->read_csv($this->history_changes_uri);

        $history_changes_file = $this->extract_data($history_changes_file);

        $history_file = $this->filter_array_key($history_file, [1, 2, 6]);

        $history_changes_file = $this->filter_array_key($history_changes_file, [2, 3, 4]);

        // Build Chronik Data OBJ
        // Get all Employee ID's
        $employee_ids =  $this->get_employee_ids($history_file);
        foreach ($employee_ids as $key => $value) {
            $this->chronik_data['MA_Id_'.$value] = [
                "history" => $history_file,
                "history_changes" => $history_changes_file
            ];
        }

    }

    private function extract_data(array $data): array
    {
        $data = array_slice($data, 1);
        return $data;
    }

    private function filter_array_key($array, $filter_keys): array
    {
        $filtered_array = array();
        $loop = 0;
        foreach ($array as $index => $value) {
            foreach ($value as $key => $value_value) {
                if (in_array($key, $filter_keys)) {
                    $filtered_array[$index][$key] = $value_value;
                }
            }
            $loop++;
        }
        return $filtered_array;
    }

    private function get_employee_ids($the_data): array
    {
        $employee_ids = array();
        foreach ($the_data as $i => $value_1) {
            foreach ($value_1 as $key => $value_2) {
                if (!in_array($value_2, $employee_ids) && $key === 1) {
                    array_push($employee_ids, $value_2);
                }
            }
        }
        return $employee_ids;
    }

    public function get_chronik_data(): array
    {
        return $this->chronik_data;
    }
}
