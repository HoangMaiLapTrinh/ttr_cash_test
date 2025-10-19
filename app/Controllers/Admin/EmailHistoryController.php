<?php

namespace App\Controllers\Admin;

use App\Models\EmailHistoryModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */

class EmailHistoryController extends ResourceController
{
    protected $modelName = EmailHistoryModel::class;
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->respond($data) : $this->failNotFound('Not found');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if (!$this->model->insert($data))
            return $this->failValidationErrors($this->model->errors());
        return $this->respondCreated(['status' => true, 'message' => 'Created']);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if (!$this->model->update($id, $data))
            return $this->failValidationErrors($this->model->errors());
        return $this->respond(['status' => true, 'message' => 'Updated']);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respondDeleted(['status' => true, 'message' => 'Deleted']);
    }
}
