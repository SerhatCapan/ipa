<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterGroupModel;
use CodeIgniter\HTTP\ResponseInterface;

class CostCenterGroup extends BaseController
{
    private CostCenterGroupModel $costcenter_group;

    public function __construct()
    {
        $this->costcenter_group = new CostCenterGroupModel();
    }

    public function index() {

        $data = [
            "table" => $this->get_table($this->costcenter_group->findAll())
        ];

        return view('partials/header') .
            view('costcenter-group/index', $data) .
            view('partials/footer');
    }

    public function create()
    {
        $name = $this->request->getPost('name');
        $existing_row = $this->costcenter_group->where('name', $name)->first();

        if ($existing_row !== null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Es existiert bereits eine Kostenstellen-Gruppe mit dem Namen.",
                'table' => $this->get_table($this->costcenter_group->findAll())
            ]);
        }

        $this->costcenter_group->insert([
            'name' => $this->request->getPost('name')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => "Kostenstelle-Gruppe wurde erstellt",
            'table' => $this->get_table($this->costcenter_group->findAll()),
        ]);
    }

    public function read($id)
    {

    }

    public function update($id, $data)
    {

    }

    public function delete($id)
    {

    }

    public function get_table($costcenters) {
        $table = get_table_template();
        $table->setHeading('Name', 'Arbeitsstunden', ' ');

        foreach ($costcenters as $costcenter) {
            $table->addRow(
                '<a uk-tooltip="Kostenstelle-Gruppe bearbeiten" href="/costcenter/' . $costcenter['id'] . '">' . $costcenter['name'] . '</a>',
                20,
                '<a id="db-icon-edit-costcenter-group" uk-tooltip="Kostenstellen-Gruppe bearbeiten" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                <a id="db-icon-trash-costcenter-group" uk-tooltip="Kostenstellen-Gruppe löschen" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>'
            );
        }

        return $table->generate();
    }
}
