<?php
App::uses('AppController', 'Controller');
/**
 * Godlinks Controller
 *
 * @property Godlink $Godlink
 */
class GodlinksController extends AppController {
public $uses = array('Godlink','Card');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Godlink->recursive = 0;
		$this->set('godlinks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Godlink->exists($id)) {
			throw new NotFoundException(__('Invalid godlink'));
		}
		$options = array('conditions' => array('Godlink.' . $this->Godlink->primaryKey => $id));
		$this->set('godlink', $this->Godlink->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
$gods =  $this->Card->query("SELECT id,name FROM cards WHERE kind LIKE '%84%' OR kind LIKE '%136%' AND str LIKE '%リンク%'");
foreach($gods as $key => $god){
if($this->request->data['Godlink']['god_name'] == $key){
$god_name = $god['cards']['name'];
}
}
$this->request->data['Godlink']['god_name'] = $god_name;
			$this->Godlink->create();
			if ($this->Godlink->save($this->request->data)) {
				$this->Session->setFlash(__('The godlink has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The godlink could not be saved. Please, try again.'));
			}
		}
    $this->set('god', $this->Card->query("SELECT id,name FROM cards WHERE kind LIKE '%84%' OR kind LIKE '%136%' AND str LIKE '%リンク%'"));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Godlink->exists($id)) {
			throw new NotFoundException(__('Invalid godlink'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Godlink->save($this->request->data)) {
				$this->Session->setFlash(__('The godlink has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The godlink could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Godlink.' . $this->Godlink->primaryKey => $id));
			$this->request->data = $this->Godlink->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Godlink->id = $id;
		if (!$this->Godlink->exists()) {
			throw new NotFoundException(__('Invalid godlink'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Godlink->delete()) {
			$this->Session->setFlash(__('Godlink deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Godlink was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * save method
 *
 *
 * @return void
 */
  public function save() {
    if($this->request->is('post')){
      $gods = $this->Godlink->find('all');
      $this->Session->setFlash(__('The part has been saved'));
      $godlink = "";
      foreach($gods as $god){
        $godlink .= '$c_name[$cno] eq "'.$god['Godlink']['god_name'].'" ? ('.$god['Godlink']['god_link'].")\n         :";
      }
      $this->set('godlink',$godlink);
      $this->autoRender = false;
      $output = $this->render('action',$layout = '');
      $this->output = null;
      $this->autoRender = true;

           /* サーバー移転による変更
       $dir = ROOT;
       */
       $dir = '../../../cgi3';
      $files = 'action.pl';
      chmod($dir. DS. $files,0777);
      $file = new File($dir. DS. $files);

      if($file->write($output)){
        chmod($dir. DS. $files,0644);
        $file->close();
        echo 'saccess';
      } else {
        echo 'failed';
        $file->close();
      }

/*
      $ftp = array(
        'ftp_server' => 'ftp.gmobb.jp',
        'ftp_user_name' => 'kataoka.hide@kyusyu.me',
        'ftp_user_pass' => 'dYU6FXNU'
        );
      //$remote_file = '~/cgi3_copy/action.pl';
      $remote_file = '~/cgi3/action.pl';
      $file = $dir. DS. $files;


      // 接続を確立する
      if(!$conn_id = ftp_connect($ftp['ftp_server'])){
        echo 'failed connect';
      }else{

      // ユーザ名とパスワードでログインする
      if(!$login_result = ftp_login($conn_id, $ftp['ftp_user_name'], $ftp['ftp_user_pass'])){
        ftp_pasv($conn_id, true);
        echo 'failed login';
      }else{
        ftp_pasv($conn_id, true);
        echo 'saccess login';
      // ファイルをアップロードする
      if (!ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
        echo "There was a problem while uploading $file\n";
        exit;
}
  // 接続を閉じる
  ftp_close($conn_id);
}
}
*/
    }
  }
}
