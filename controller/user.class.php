<?php

class UserController extends ControllerSecureLib
{
    
    public function __construct($public_views = array())
    {
        parent::__construct(array('login'));
    }


    public function index() {
        $this->user = $this->getUser();
        if(RoutingLib::isPost()) {
            $post = RoutingLib::cleanPost();
            if(isset($post['avatar']) && file_exists($post['avatar'])) {
                $url =  '/img/uploads/' . $this->user->id . '-avatar.jpg';
                $target = ConfigLib::g('directory/web') . $url;
                $url = ufix($url);
                rename($post['avatar'], $target);
                $post['avatar'] = $url;
            }            
            $this->user->update($post);
            $this->user->save();
        }
    }

    public function login() {
        $this->openid = new OpenidPluginLib($_SERVER["SERVER_NAME"]);
        if(!$this->openid->mode) {
            //no login yet
            if(RoutingLib::isPost()) {
                $this->openid->identity = 'https://www.google.com/accounts/o8/id';
                $this->openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');                
                return $this->redirect($this->openid->authUrl());
            }            
        } elseif($this->openid->mode == 'cancel') {
            //user canceled            
        } elseif(!$this->openid->validate()) {
            //user login invalid
        } else {
            //user login success
            $attr = $this->openid->getAttributes();
            $id = $this->openid->identity;
            $coll = new UsersModel();
            $user = $coll->getAll(sprintf('openid="%s"',$id), 1);
            if(is_array($user) && count($user) > 0) {
                $user = reset($user);
            }
            else
            {
                $user = new UserModel($coll, array(
                    'id' => null,
                    'name' => $attr['namePerson/first'] . ' ' . $attr['namePerson/last'],
                    'additional' => '',
                    'email' => $attr['contact/email'],
                    'openid' => $id,
                ));
                $user->save();
            }
            $this->setUser($user);
        }            
        $this->user = $this->getUser();
    }
    
    public function logout() {
        if(RoutingLib::isPost()) {
            $this->setUser(null);
        }
        $this->user = $this->getUser();
    }
    
    
}
