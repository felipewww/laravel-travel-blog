<?php

//namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers\Painel\system\users;

use App\Authors;
use App\Library\DataTablesExtensions;
use App\Library\DataTablesInterface;
use App\Library\Jobs;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller implements DataTablesInterface
{
    use Jobs;
    use DataTablesExtensions;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/painel';

    protected $authorsModel;
    protected $authors;
    protected $authorsIds;

//    protected $model;
    protected $all;
//    protected $vars;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new User();
        $this->authorsModel = new Authors();
        $this->getAll();

        $this->vars['modulo'] = 'Sistema';
        $this->vars['pageDesc'] = 'Usuários';
    }

    public function getAll()
    {
        $this->all = $this->model->all();
        $this->getAuthors();
        $this->vars['all'] = $this->all;
    }

    private function getAuthors()
    {
        $this->authors = $this->authorsModel->all();

        $ids = [];
        foreach ($this->authors as $a)
        {
            array_push($ids, $a['users_id']);
        }

        $this->authorsIds = $ids;
//        dd($ids);

        foreach ($this->all as &$user)
        {
            if ( array_search($user['id'], $ids) !== false || $user['type'] == 'author' ){
                $user['is_author'] = true;
            }else{
                $user['is_author'] = false;
            }
        }
    }

    function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        foreach ($this->all as $user)
        {
            $cInfo = [
                $i,
                $user['id'],
                [
                    'image' => [
                        'src' => $user['photo'] ?? '/Site/media/images/autores/default.png',
                    ]
                ],
                $user['name'],
                $user['email'],
                $user['type'],
                [
                    'rowButtons' => [
                        [
                            'html' => 'editar',
                            'attributes' => ['data-jslistener-click' => 'users.edit']
                        ],
                        [
                            'html' => ($user['is_author']) ? 'config. autor' : 'definir autor',
                            'attributes' => [
                                'class' => ($user['is_author']) ? 'is_autor' : '',
                                'data-jslistener-click' => ($user['is_author']) ? '' : 'users.asAuthor',
                                'href' => ($user['is_author']) ? '/painel/blog/autores/'.$user['id'] : 'javascript:;',
                            ]
                        ]
                    ]
                ]
            ];

            array_push($data,$cInfo);
            $i++;
        }

        $this->data_info = $data;

        $this->data_cols = [
            ['title' => 'n'],
            ['title' => 'id'],
            ['title' => 'foto'],
            ['title' => 'nome'],
            ['title' => 'e-mail'],
            ['title' => 'tipo'],
            ['title' => 'ações', 'width' => '140px'],
        ];
    }

    public function view(Request $request){

        if ( $request->isMethod('post') ){
//            dd($request->input());
            $e =  $this->validator($request->input());

            if ($e->fails()) {
                dd($e->errors());
            }

            $this->create($request->input());

            //Reload All after updating
            //$this->all = $this->model->all();
            $this->getAll();
        }

        $this->getAuthors();
        $this->dataTablesInit();

        return view('Painel.system.users.register', $this->vars);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [];

        //Defaults
        $name       = 'required|max:255';
        $email      = 'required|email|max:255';
        $password   = 'min:6';

        //if create new...
        if ( empty($data['id']) ) {
            //Create
            $email .= '|unique:users';
            $password .= '|required';
            $rules['password'] = $password;
        }else{
            //update
            //Só validar password se for alteração dele.
            ( !empty($data['password']) ) ? $rules['password'] = $password : false;
        }

        $rules['name'] = $name;
        $rules['email'] = $email;

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => $email,
            'password' => $password,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if (!empty($data['id'])) {
            $user = $this->model->where('id', $data['id'])->get()[0];

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->type = $data['type'];

            if (isset($data['password']) && !empty($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

            $this->json_meta
            (
                [
                    'updated' => $user->save()
                ]
            );
            //$this->vars['updated'] = ;

        } else {
            $this->json_meta
            (
                [
                    'created' =>
                        User::create([
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'password' => bcrypt($data['password']),
                            'type' => bcrypt($data['type']),
                        ])
                ]
            );
        }
    }
}
