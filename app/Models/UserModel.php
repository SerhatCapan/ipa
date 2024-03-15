<?php

namespace App\Models;

use CodeIgniter\Model;
use ReflectionException;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'date_from_overtime'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    /**
     * TODO: needs to look on these things:
     * - Holidays
     * - Vacation
     * - Absences
     *
     * @param $user
     * @return int
     */
    public function get_overtime($user) {
        $optionmodel = new OptionModel();
        $workhourmodel = new WorkhourModel();
        $holidaymodel = new HolidayModel();
        $vacationmodel = new VacationModel();
        $absencemodel = new AbsenceModel();

        // get the sum of hours of all models
        $total_workhours = $workhourmodel
            ->select('SUM(hours) AS total_hours')
            ->where('id_user =', $user['id'])
            ->where('date >=', $user['date_from_overtime'])
            ->get()->getResultArray()[0]['total_hours'] ?? 0;

        $total_holidays_hours = $holidaymodel
            ->select('SUM(hours) AS total_hours')
            ->where('date >=', $user['date_from_overtime'])
            ->get()->getResultArray()[0]['total_hours'] ?? 0;

        $total_absence_hours = $absencemodel
            ->select('SUM(hours) AS total_hours')
            ->where('date >=', $user['date_from_overtime'])
            ->get()->getResultArray()[0]['total_hours'] ?? 0;

        $total_vacation_hours = $vacationmodel
            ->select('SUM(hours) AS total_hours')
            ->where('date >=', $user['date_from_overtime'])
            ->get()->getResultArray()[0]['total_hours'] ?? 0;


        $number_of_days_without_weekend = $this->get_number_of_days_without_weekend(strtotime($user['date_from_overtime']), strtotime('now'));
        $should_workhours = ($number_of_days_without_weekend * $optionmodel->get_workhours_per_day()) - $total_holidays_hours - $total_absence_hours - $total_vacation_hours;

        // total worked hours minus the "should-work" hours
        return $total_workhours - $should_workhours;
    }


    /**
     * Calculates the workdays of days between 2 dates.
     *
     * @param $date_from string timestamp
     * @param $date_to string timestamp
     * @return int
     */
    private function get_number_of_days_without_weekend(string $date_from, string $date_to): int {
        $workdays = 0;

        for ($i = $date_from; $i <= $date_to; $i = strtotime("+1 day", $i)) {
            // checks if current day is saturday or sunday
            if (date("N", $i) < 6) {
                $workdays++;
            }
        }

        return $workdays;
    }
}
