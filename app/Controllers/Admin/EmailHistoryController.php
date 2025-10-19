<?php

namespace App\Controllers\Admin;

use App\Models\EmailHistoryModel;
use App\Requests\EmailHistories\CreateEmailHistoriesRequest;
use App\Resources\EmailHistoriesResource;
use App\Services\JwtAuthService;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */
class EmailHistoryController extends ResourceController
{
    protected $model;
    protected $jwtService;
    protected $controllerName = 'Email History';

    public function __construct()
    {
        $this->model = new EmailHistoryModel();
        $this->jwtService = new JwtAuthService();
    }

    public function index()
    {
        try {
            // Authorization
            $auth = $this->jwtService->authenticateUser();
            if (!$auth['status']) {
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                    ], 403);
            }

            $userInfo = (array)$auth['user_info'];
            if (!isAdmin($userInfo['role_id'])) {
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);
            }

            $rules = [
                'page'   => 'permit_empty|integer|is_natural_no_zero',
                'limit'  => 'permit_empty|integer|is_natural_no_zero',
                'search' => 'permit_empty|max_length[100]',
            ];
            $validation = \Config\Services::validation();
            $validation->setRules($rules);
            $query = $this->request->getGet();

            if (!$validation->run($query)) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'Validation failed',
                    'errors'  => $validation->getErrors(),
                ], 422);
            }

            $page   = (int)($query['page'] ?? 1);
            $limit  = (int)($query['limit'] ?? 10);
            $search = $query['search'] ?? '';
            $offset = ($page - 1) * $limit;

            $builder = $this->model;
            if ($search) {
                $builder->like('recipient', $search)
                        ->orLike('subject', $search);
            }

            $total = $builder->countAllResults(false);
            $data  = $builder->orderBy('created_at', 'DESC')->findAll($limit, $offset);

            return $this->respond([
                'status' => true,
                'data'   => EmailHistoriesResource::collection($data),
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'page'  => $page,
                    'pages' => ceil($total / $limit),
                ],
            ]);
        } catch (\Throwable $th) {
            $message = "SystemSettingController.create: ";
            $message .= $th->getFile() . " ";
            $message .= $th->getLine() . " ";
            $message .= $th->getMessage() . " ";
            log_message('error', $message);
            return $this->respond([
                'status' => false,
                'message' => 'An error occurred during processing. Please try again later.'
            ]);
        }
    }

    public function create()
    {
        try {
            $auth = $this->jwtService->authenticateUser();
            if (!$auth['status']) {
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);
            }

            $userInfo = (array)$auth['user_info'];
            if (!isAdmin($userInfo['role_id'])) {
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);
            }

            $req = $this->request->getJSON(true);
            $rules    = CreateEmailHistoriesRequest::rules();
            $messages = CreateEmailHistoriesRequest::messages();
            if (!$this->validateData($req, $rules, $messages)) {
                return $this->respond([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            if ((int)($req['status'] ?? 0) === 1) {
                $req['sent_at'] = date('Y-m-d H:i:s');
            }

            if (isset($req['resent_times']) && $req['resent_times'] > 99) {
                $req['resent_times'] = 99;
            }

            $this->model->insert($req);
            return $this->respond([
                'status' => true,
                'message' => lang('Common.success.model_create', ['name' => $this->controllerName])], 201);
        } catch (\Throwable $th) {
            $message = "SystemSettingController.create: ";
            $message .= $th->getFile() . " ";
            $message .= $th->getLine() . " ";
            $message .= $th->getMessage() . " ";
            log_message('error', $message);
            return $this->respond([
                'status' => false,
                'message' => 'An error occurred during processing. Please try again later.'
            ]);
        }
    }

    public function show($id = null)
    {
        try {
            $auth = $this->jwtService->authenticateUser();
            if (!$auth['status'])
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);

            $userInfo = (array)$auth['user_info'];
            if (!isAdmin($userInfo['role_id']))
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);

            $data = $this->model->find($id);
            if (!$data) {
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.not_found', ['name' => $this->controllerName])
                ], 404);
            }

            return $this->respond([
                'status' => true,
                'data' => new EmailHistoriesResource($data)
            ]);
        } catch (\Throwable $th) {
            $message = "SystemSettingController.create: ";
            $message .= $th->getFile() . " ";
            $message .= $th->getLine() . " ";
            $message .= $th->getMessage() . " ";
            log_message('error', $message);
            return $this->respond([
                'status' => false,
                'message' => 'An error occurred during processing. Please try again later.'
            ]);
        }
    }

    public function update($id = null)
    {
        try {
            $auth = $this->jwtService->authenticateUser();
            if (!$auth['status'])
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);

            $userInfo = (array)$auth['user_info'];
            if (!isAdmin($userInfo['role_id']))
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);

            $record = $this->model->find($id);
            if (!$record) return $this->respond([
                'status' => false,
                'message' => lang('Common.error.not_found', ['name' => $this->controllerName])
            ], 404);

            $req = $this->request->getJSON(true);
            $rules    = CreateEmailHistoriesRequest::rules();
            $messages = CreateEmailHistoriesRequest::messages();
            if (!$this->validateData($req, $rules, $messages)) {
                return $this->respond([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            if ((int)($req['status'] ?? 0) === 1) {
                $req['sent_at'] = date('Y-m-d H:i:s');
            }
            if (isset($req['resent_times']) && $req['resent_times'] > 99) {
                $req['resent_times'] = 99;
            }

            $this->model->update($id, $req);
            return $this->respond([
                'status' => true,
                'message' => lang('Common.success.model_update', ['name' => $this->controllerName])
            ]);
        } catch (\Throwable $th) {
            $message = "SystemSettingController.create: ";
            $message .= $th->getFile() . " ";
            $message .= $th->getLine() . " ";
            $message .= $th->getMessage() . " ";
            log_message('error', $message);
            return $this->respond([
                'status' => false,
                'message' => 'An error occurred during processing. Please try again later.'
            ]);
        }
    }

    public function delete($id = null)
    {
        try {
            $auth = $this->jwtService->authenticateUser();
            if (!$auth['status']) 
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);
            $userInfo = (array)$auth['user_info'];
            if (!isAdmin($userInfo['role_id']))
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.no_authorize')
                ], 403);

            $record = $this->model->find($id);
            if (!$record) 
                return $this->respond([
                    'status' => false,
                    'message' => lang('Common.error.not_found', ['name' => $this->controllerName])
                ], 404);

            $this->model->delete($id);
            return $this->respond([
                'status' => true,
                'message' => lang('Common.success.model_delete', ['name' => $this->controllerName])
            ]);
        } catch (\Throwable $th) {
            $message = "SystemSettingController.create: ";
            $message .= $th->getFile() . " ";
            $message .= $th->getLine() . " ";
            $message .= $th->getMessage() . " ";
            log_message('error', $message);
            return $this->respond([
                'status' => false,
                'message' => 'An error occurred during processing. Please try again later.'
            ]);
        }
    }
}
