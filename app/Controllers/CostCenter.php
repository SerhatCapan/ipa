<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CostCenterModel;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class CostCenter extends BaseController
{
    private CostCenterModel $costcenter;

    public function __construct()
    {
        $this->costcenter = new CostCenterModel();
    }

    /**
     * TODO:
     * - Arbeitsstunden holen
     * - Kostenstellen-Gruppe holen
     *
     * @return string
     */
    public function index() {
        $table = get_table_template();
        $table->setHeading('Name', 'Kostenstellen-Gruppe', 'Arbeitsstunden', ' ');

        foreach ($this->costcenter->findAll() as $costcenter) {
            $table->addRow(
                '<a uk-tooltip="Kostenstelle bearbeiten" href="/costcenter/' . $costcenter['id'] . '">' . $costcenter['name'] . '</a>',
                'Gruppe',
                20,
                '<a id="icon_edit_costcenter" uk-tooltip="Kostenstelle bearbeiten" href="costcenter/edit/' .  $costcenter['id'] . '" class="uk-icon-link uk-margin-small-right" uk-icon="pencil"></a>
                <a id="icon_trash_costcenter" uk-tooltip="Kostenstelle löschen" href="costcenter/trash/' . $costcenter['id'] . '" class="uk-icon-link uk-margin-small-right" uk-icon="trash"></a>'
            );
        }

        $data = [
            "table" => $table->generate()
        ];

        return view('partials/header') .
            view('costcenter/index', $data) .
            view('partials/footer');
    }

    /**
     * @throws ReflectionException
     */
    public function create(): ResponseInterface {
        $data =  [
            'name' => $this->request->getPost('name')
        ];

        $this->costcenter->insert($data);

        $response = [
            'success' => true,
            'costcenter' => $this->costcenter->find($this->costcenter->getInsertID()),
            'message' => "Kostenstelle wurde erstellt"
        ];

        return $this->response->setJSON($response);
    }


    public function read()
    {
        $data = [
            'id' => $this->request->getGet('id'),
            'from_date' => $this->request->getGet('from_date'),
            'to_date' => $this->request->getGet('to_date'),
        ];

        $data = $this->costcenter->find($data);
    }


    public function update($id, $data)
    {

    }


    public function delete($id)
    {

    }
}
