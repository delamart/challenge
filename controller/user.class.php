<?php

class UserController extends ControllerSecureLib
{
    
    public function __construct($public_views = array())
    {
        $public_views[] = 'login';
        $public_views[] = 'create';
        parent::__construct($public_views);
    }


    public function index() {
        $extra = '';
        $this->errors = array();
        $this->user = $this->getUser();
        $this->title = $this->user->name;
        if(RoutingLib::isPost()) {
            $post = RoutingLib::cleanPost();
            if(!$post['password']) { unset($post['password']); }
            else { $post['password'] = password_hash($post['password']); }
            if(isset($post['avatar']) && file_exists($post['avatar'])) {
                $ext = substr($post['avatar'],-4);
                if(filesize($post['avatar']) > (200 * 1024)) 
                {
                    $this->errors[] = 'Photo trop grande, maximum 200 KBytes.';
                    unlink($post['avatar']);
                    unset($post['avatar']);
                }
                elseif( strcasecmp($ext,'.jpg') !== 0 && strcasecmp($ext,'.png') !== 0 )
                {
                    $this->errors[] = 'Seulement JPG et PNG authorisé.';
                    unlink($post['avatar']);
                    unset($post['avatar']);
                }
                else
                {
                    $md5 = md5_file($post['avatar']);
                    $url =  '/img/uploads/' . $this->user->id . '-' . $md5 . '-avatar'.$ext;
                    $url_thumb =  '/img/uploads/' . $this->user->id . '-' . $md5 . '-avatar-thumb'.$ext;
                    $target = ConfigLib::g('directory/web') . $url;
                    $target_thumb = ConfigLib::g('directory/web') . $url_thumb;
                    $url = ufix($url);
                    @unlink($target);
                    @unlink($target_thumb);
                    rename($post['avatar'], $target);
                    $img = new ImageLib($target);
                    $img->resize(110, 110, true);
                    $img->crop(110, 110);
                    if($img->save($target_thumb)) 
                        
                    $post['avatar'] = $url_thumb;
                    $extra .= 'Photo ajoutee' ."\n";
                }
            }            
            $this->user->update($post);
            $this->user->save();
            $extra .= 'Changements Sauvegarde' ."\n";
            $this->extra = $extra;
        }
    }

    public function login($type = null) {
        $this->errors = array();
        $this->title = 'login';
        $this->type = $type;
        switch ($type) {
            case 'google' : $this->googleLogin(); break;
            case 'challenge' : $this->challengeLogin(); break;
        }
        $this->user = $this->getUser();
    }

    public function create() {
        if(RoutingLib::isPost()) {
            $coll = new UsersModel();
            $values = $_POST;            
            if(count($this->errors = $coll->validate($values)) == 0)
            {            
                $post = RoutingLib::cleanPost();
                $db = DbLib::getInstance();                
                $q = sprintf('SELECT * FROM %s WHERE email LIKE ? AND password IS NOT NULL LIMIT 1', $coll->tbl()); 
                $stmt = $db->prepare($q);
                $stmt->execute(array($post['email']));
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if($user)
                {
                    $this->errors = array('Cet e-mail est déjà enregistré');
                }    
                else
                {
                    $post['password'] = password_hash($post['password']);
                    if(preg_match('/^(.+)@/', $post['email'], $matches)) { $post['name'] = $matches[1]; }
                    //$post['site'] = '';
                    $this->user = $coll->create($post);
                    $this->user->save();
                    $this->setUser($this->user);
                    return $this->redirect(url('user','index'));
                }
            }
        }        
        //return $this->redirect(url('user','login','challenge'));
    }
    
    private function googleLogin() {
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
                        
            $coll2 = new ChallengesModel();
            $mine = $coll2->getForUser($user->id);
            if($mine) { return $this->redirect(url('challenge','show',$mine->id)); }
            return $this->redirect(url('user','index'));
        }                    
    }
    
    private function challengeLogin() {
        if(RoutingLib::isPost()) {
            $coll = new UsersModel();
            $post = RoutingLib::cleanPost();
            $db = DbLib::getInstance();
            $q = sprintf('SELECT * FROM %s WHERE email LIKE ? AND password IS NOT NULL LIMIT 1', $coll->tbl()); 
            $stmt = $db->prepare($q);
            $stmt->execute(array($post['email']));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user) { 
                if(password_hash($post['password'],$user['password'],true))
                {
                    $this->user = $coll->create($user);
                    $this->setUser($this->user);
                    
                    $coll2 = new ChallengesModel();
                    $mine = $coll2->getForUser($this->user->id);
                    if($mine) { return $this->redirect(url('challenge','show',$mine->id)); }                    
                    return $this->redirect(url('user','index'));
                }
            }
            $this->errors = array('Could not find user/password');
        }        
    }

    public function logout() {
        $this->title = 'logout';
        if(RoutingLib::isPost()) {
            $this->setUser(null);
        }
        $this->user = $this->getUser();
    }
    
    
}
