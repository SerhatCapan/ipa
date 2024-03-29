<?php

namespace App\Models;

use CodeIgniter\Model;

class VacationModel extends Model
{
    protected $table            = 'vacation';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'date', 'hours'];

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
     * Gets the Vacation credits and the Vacations for the current date.
     *
     * @param $current_date
     * @return array
     */
    public function get_vacation($current_date): array
    {
        $vacationcreditmodel = new VacationCreditModel();
        $vacation_credit = $vacationcreditmodel->get_vacation_credit_from_date($current_date);

        if (empty($vacation_credit)) {
            return [
                'vacation' => '',
                'vacation_credit' => '',
                'vacation_remaining_credits' => ''
            ];
        }

        $vacation = $this
            ->select()
            ->where("date BETWEEN '" . $vacation_credit['date_from'] . "' AND '" . $vacation_credit['date_to'] . "'")
            ->get()->getResultArray();

        // 'vacation': Alle Ferientage einzeln in einem Array
        // 'vacation_credit': Beinhaltet den Datensatz mit den Anzahl der gesetzten Ferienguthaben in dem Zwischenraum
        // 'vacation_remaining_credits': Die restlichen jetzigen noch verfügbaren Ferienguthaben
        return [
            'vacation' => $vacation,
            'vacation_credit' => $vacation_credit,
            'vacation_remaining_credits' => $vacation_credit['credit'] - count($vacation)
        ];
    }


    /**
     * Gets table HTML of vacation
     *
     * @return string
     */
    public function get_table_html(): string
    {
        $vacation = $this->findAll();
        $table = get_table_template();
        $table->setHeading([
            'Tag',
            'Stunden'
        ]);

        foreach ($vacation as $day) {
            $table->addRow(
                $day['date'],
                $day['hours'],
                '<a uk-tooltip="Ferientag löschen" data-id-vacation=' . $day['id'] . '" class="db-icon-delete-vacation uk-icon-link uk-margin-small-right" uk-icon="trash"></a>'
            );
        }

        return $table->generate();
    }
}
