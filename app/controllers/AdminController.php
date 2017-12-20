<?php

class Acl
{
    protected $roles;
    protected $resources;
    protected $rules = [
        'allResources' => [
            'allRoles' => [
                'allPrivileges' => [
                    'type' => 'TYPE_DENY',
                ],
                'byPrivilegeId' => [],
            ],
            'byRoleId' => [],
        ],
        'byResourceId' => [],
    ];

    public function addRole($role, $parents = false)
    {
        if (is_string($role)) {
            $role = new Role($role);
        }

        $this->roles[$role->getName()] = [
            'instance' => $role,
            // 'parents' => [],
            // 'children' => [],
        ];

        // if (is_array($parents)) {
        //     foreach ($parents as $p) {
        //         if (is_string($p)) {
        //             $p = new Role($p);
        //         }

        //         if (isset($this->roles[$p->getName()])) {
        //             $this->roles[$p->getName()]['children'][$role->getName()] = $role;
        //             $this->roles[$role->getName()]['parents'][$p->getName()] = $p;
        //         }
        //     }
        // }
    }

    public function addResource($resource)
    {
        if (is_string($resource)) {
            $resource = new Resource($resource);
        }

        $this->resources[$resource->getName()] = [
            'instance' => $resource,
            // 'parents' => [],
            // 'children' => [],
        ];
    }

    public function deny($role_name, $resource_name = null, $permission_name = null)
    {
        // se nao passar o resource
        if (is_null($resource_name)) {
            // e nao passar a permissao
            if (is_null($permission_name)) {
                // vamos negar tudo para esse papel

        //         $this->rules['allResources']['byRoleId'][$role_name] = [
        //             'byPrivilegeId' => [],
        //             'allPrivileges' => [
        //                 'type' => 'TYPE_DENY',
        //             ],
        //         ];

        //         foreach ($this->resources as $r) {
        //             $this->rules['byResourceId'][$r['instance']->getName()] = [
        //                 'byRoleId' => [],
        //             ];
        //             $this->rules['byResourceId'][$r['instance']->getName()]['byRoleId'][$role_name] = [
        //                 'byPrivilegeId' => [],
        //                 'allPrivileges' => [
        //                     'type' => 'TYPE_DENY',
        //                 ],
        //             ];
        //         }
            }
        }
    }
}

class Role
{
    private $name;

    public function __construct($name = null)
    {
        $this->setName($name);
    }

    public function setName($name = null)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Resource
{
    private $name;

    public function __construct($name = null)
    {
        $this->setName($name);
    }

    public function setName($name = null)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}

// https://github.com/zendframework/zend-permissions-acl

class AdminController extends Controller
{
    private function checkLogin()
    {
        $LoginHelper = new LoginHelper();
        $has_login = $LoginHelper->checkLogin();
        if (!$has_login) return $this->goToAction('login');
        else return $LoginHelper->getData();
    }

	public function indexAction()
	{
        $login = $this->checkLogin();





        $acl = new Acl();

        $acl->addRole(new Role('guest'));
        $acl->addRole(new Role('member'));
        $acl->addRole('admin');

        $parents = array('guest', 'member', 'admin');
        $acl->addRole(new Role('someUser'), $parents);

        $acl->addResource(new Resource('someResource'));

        $acl->deny('guest');
        // $acl->deny('guest', 'someResource');
        // $acl->allow('member', 'someResource');
        // $acl->allow('someUser', 'someResource', 'edit');

        printa($acl);






        // printa('admin ok');
        // printa($login);

        // $Permission_1 = new Permission('list');
        // printa($Permission_1);
        // $Permission_2 = new Permission('edit');
        // printa($Permission_2);
        // $Permission_3 = new Permission('delete');
        // printa($Permission_3);

        // $Role_1 = new Role('role1');
        // $Role_1->addPermission($Permission_1);
        // $Role_1->addPermission($Permission_2);
        // printa($Role_1);

        // $Acl = new Acl();
        // $Acl->addRole($Role_1);
        // printa($Acl);

        // echo '<a href="' . _PATH_ . 'admin/logout' . '">logout</a>';
	}

	public function loginAction()
	{
        $this->view('admin/login', [
            'path' => _PATH_,
        ]);
	}

	public function loginPostAction()
	{
        $ret = [
            'error' => false,
            'messages' => [],
        ];

        $login = trim($this->request->post('login'));
        $password = trim($this->request->post('password'));

        if ($login == '') {
            $ret['error'] = true;
            $ret['messages'][] = [
                'type' => 'field_login',
                'message' => 'Campo "login" é obrigatório.',
            ];
        }

        if ($password == '') {
            $ret['error'] = true;
            $ret['messages'][] = [
                'type' => 'field_password',
                'message' => 'Campo "senha" é obrigatório.',
            ];
        }

        if (!$ret['error'] ) {
            $login_data = [
                'user_id' => 1,
                'name' => 'Leandro Macedo',
                'email' => 'fmlimao@gmail.com',
                'roles' => ['role1', 'role2'],
            ];

            $LoginHelper = new LoginHelper();
            $LoginHelper->login($login_data);

            $ret['messages'][] = [
                'type' => 'success',
                'message' => 'Login efetuado com sucesso.',
            ];
        }

        echo json_encode($ret);
	}

    public function logoutAction()
    {
        $LoginHelper = new LoginHelper();
        $LoginHelper->logout();
        $this->goToAction('');
    }
}
