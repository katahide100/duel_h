<?php
App::uses('AppController', 'Controller');
/**
 * Psychics Controller
 *
 */
class PsychicsController extends AppController {
public $uses = array('Psychic','Card');
public $components = array('Paginator');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		// $this->Psychic->recursive = 0;
		// $this->set('psychics', $this->paginate());

		$conditions = array();
		$searchName = "";
		if (!empty($this->request->query['search_name'])) {
			$searchName = $this->request->query['search_name'];
			$conditions['OR'] = array(
				'CardS.name LIKE' => '%' . $searchName . '%',
				'CardL.name LIKE' => '%' . $searchName . '%',
			);
		}

		$this->Paginator->settings = array(
			// 'joins' => [
			// 	[
			// 	'table' => 'cards',
			// 	'alias' => 'Card',
			// 	'type'  => 'LEFT',
			// 	'conditions' => 'FIND_IN_SET(Card.id, Psychic.psychic_s)'
			// 	]
			// ],
			'contain' => array('CardS','CardL'),
			'conditions' => $conditions,
		);
		$psychics = $this->Paginator->paginate('Psychic');

		foreach ($psychics as &$p) {
			$ids = explode(',', $p['Psychic']['psychic_s']);
			$p['CardSList'] = $this->Card->find('all', [
				'conditions' => ['Card.id' => $ids]
			]);
		}

		$this->set(compact('psychics', 'searchName'));

		// // 検索フォームからの入力取得 (GET パラメータ想定)
		// $searchName = "";
		// if ($this->request->query['search_name']) {
		// 	$searchName = $this->request->query['search_name'];  // 入力欄 name="search_name"
		// }
		

		// // 基本のクエリ (関連モデル CardS, CardL を取得)
		// $query = $this->Psychic->find('all', array(
		// 	'contain' => []
		// ));

		// // if (!empty($searchName)) {
		// // 	// 覚醒前 (CardS.name) または 覚醒後 (CardL.name) にマッチするものを検索
		// // 	$query = $query->where([
		// // 		'OR' => [
		// // 			'CardS.name LIKE' => '%' . $searchName . '%',
		// // 			'CardL.name LIKE' => '%' . $searchName . '%'
		// // 		]
		// // 	]);
		// // }

		// $psychics = $this->paginate($query);
		// $this->set(compact('psychics', 'searchName'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Psychic->exists($id)) {
			throw new NotFoundException(__('Invalid Psychic'));
		}
		$options = array('conditions' => array('Psychic.' . $this->Psychic->primaryKey => $id));
		$psychic = $this->Psychic->find('first', $options);
		$ids = explode(',', $psychic['Psychic']['psychic_s']);
		$psychic['CardSList'] = $this->Card->find('all', [
			'conditions' => ['Card.id' => $ids]
		]);
		$this->set(compact('psychic'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		$arrPsychicSyu = array(
								'103',
								'145',
								'150',
								'151'
								);
		$strSql1 = '';
		foreach($arrPsychicSyu as $val){
			if($strSql1 != ''){
				$strSql1 .= " OR ";
			}
			$strSql1 .= "kind LIKE '%".$val."' OR kind LIKE '%".$val."%' OR kind LIKE '".$val."%'";
		}
		$strSql2 = "SELECT id,name FROM cards WHERE ".$strSql1." ORDER BY name";
		
		$psychics   =  $this->Card->query($strSql2);
		foreach($psychics as $key => $psychic){
			$psychicname[]= $psychic['cards']['name'];
		}
		$this->set('psychicname', $psychicname);

		$arrPsychicSpSyu = array(
								'119',
								'476',
								'477'
								);
		$strSpSql1 = '';
		foreach($arrPsychicSpSyu as $val){
			if($strSpSql1 != ''){
				$strSpSql1 .= " OR ";
			}
			$strSpSql1 .= "kind LIKE '%".$val."' OR kind LIKE '%".$val."%' OR kind LIKE '".$val."%'";
		}
		$strSpSql2 = "SELECT id,name FROM cards WHERE ".$strSpSql1." ORDER BY name";
		$psychics_sp =  $this->Card->query($strSpSql2);
		foreach($psychics_sp as $key => $psychic_sp){
			$psychic_spname[]= $psychic_sp['cards']['name'];
		}
		$this->set('psychic_spname', $psychic_spname);

		$arrPsychicSpSyu = array(
			'103',
			'145',
			'150',
			'151',
			'119',
			'476',
			'477'
		);
		$strFusionSql1 = '';
		foreach($arrPsychicSpSyu as $val){
			if($strFusionSql1 != ''){
				$strFusionSql1 .= " OR ";
			}
			$strFusionSql1 .= "kind LIKE '%".$val."' OR kind LIKE '%".$val."%' OR kind LIKE '".$val."%'";
		}
		$strFusionSql2 = "SELECT id,name FROM cards WHERE NOT( ".$strFusionSql1.") AND name <> '' ORDER BY name";
		$fusions =  $this->Card->query($strFusionSql2);
		foreach($fusions as $key => $fusion){
			$fusion_name[]= $fusion['cards']['name'];
		}
		$this->set('fusion_name', $fusion_name);

		$psychic_s_name = '';
		if ($this->request->is('post')) {
			if (isset($this->request->data['Psychic']['psychic_s']) && $this->request->data['Psychic']['psychic_s']) {
				foreach($psychics as $key => $psychic){
					// サイキック・クリーチャー(覚醒前)
					if(is_array($this->request->data['Psychic']['psychic_s'])){
						foreach($this->request->data['Psychic']['psychic_s'] as $key_s => $val_s){
									
							if($val_s == $key){
								$psychic_s_name .= ','.$psychic['cards']['id'];
							}
						}
					}else{
						if($this->request->data['Psychic']['psychic_s'] == $key){
							$psychic_s_name = $psychic['cards']['id'];
							
						}
					}
					// サイキック・クリーチャー(覚醒後)
					if(isset($this->request->data['Psychic']['psychic_l']) && $this->request->data['Psychic']['psychic_l'] == $key){
						$psychic_l_name = $psychic['cards']['id'];
						$this->request->data['Psychic']['psychic_l'] = $psychic_l_name;
					}
				}
				if(mb_substr($psychic_s_name,0,1) == ','){
					$psychic_s_name = mb_substr($psychic_s_name,1);
				}
				$this->request->data['Psychic']['psychic_s'] = $psychic_s_name;
				
				// サイキック・スーパー・クリーチャー
				foreach($psychics_sp as $key => $psychic_sp){
					if(isset($this->request->data['Psychic']['psychic_sp']) && $this->request->data['Psychic']['psychic_sp'] == $key){
						$psychic_sp_name = $psychic_sp['cards']['id'];
						$this->request->data['Psychic']['psychic_l'] = $psychic_sp_name;
						unset($this->request->data['Psychic']['psychic_sp']);
					}
				}
			}

			// 合体処理
			if (isset($this->request->data['Psychic']['fusion_s']) && $this->request->data['Psychic']['fusion_s']) {
				$fusion_s_name = "";
				foreach($fusions as $key => $fusion){
					// 合体前
					if(is_array($this->request->data['Psychic']['fusion_s'])){
						foreach($this->request->data['Psychic']['fusion_s'] as $key_s => $val_s){
							if($val_s == $key){
								$fusion_s_name .= ','.$fusion['cards']['id'];
							}
						}
					}else{
						if($this->request->data['Psychic']['fusion_s'] == $key){
							$fusion_s_name = $fusion['cards']['id'];
							
						}
					}
					// 合体後
					if(isset($this->request->data['Psychic']['fusion_l']) && $this->request->data['Psychic']['fusion_l'] == $key){
						$fusion_l_name = $fusion['cards']['id'];
						$this->request->data['Psychic']['psychic_l'] = $fusion_l_name;
					}
				}
				if(mb_substr($fusion_s_name,0,1) == ','){
					$fusion_s_name = mb_substr($fusion_s_name,1);
				}
				$this->request->data['Psychic']['psychic_s'] = $fusion_s_name;
			}
			
			$this->Psychic->create();
			if ($this->Psychic->save($this->request->data)) {
				$this->Session->setFlash(__('The Psychic has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Psychic could not be saved. Please, try again.'));
			}
		}

	/*
		if ($this->request->is('post')) {
$gods =  $this->Card->query("SELECT id,name FROM cards WHERE kind LIKE '103,%' OR kind LIKE '%,103,%' OR kind LIKE '103,%' OR kind LIKE '119,%' OR kind LIKE '%,119,%' OR kind LIKE '119,%'");
foreach($gods as $key => $god){
if($this->request->data['Psychic']['god_name'] == $key){
$god_name = $god['cards']['name'];
}
}
$this->request->data['Psychic']['god_name'] = $god_name;
			$this->Psychic->create();
			if ($this->Psychic->save($this->request->data)) {
				$this->Session->setFlash(__('The Psychic has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Psychic could not be saved. Please, try again.'));
			}
		}
    $this->set('god', $this->Card->query("SELECT id,name FROM cards WHERE kind LIKE '%84%' OR kind LIKE '%136%' AND str LIKE '%リンク%'"));
	*/
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Psychic->exists($id)) {
			throw new NotFoundException(__('Invalid Psychic'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Psychic->save($this->request->data)) {
				$this->Session->setFlash(__('The Psychic has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Psychic could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Psychic.' . $this->Psychic->primaryKey => $id));
			$this->request->data = $this->Psychic->find('first', $options);
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
		$this->Psychic->id = $id;
		if (!$this->Psychic->exists()) {
			throw new NotFoundException(__('Invalid Psychic'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Psychic->delete()) {
			$this->Session->setFlash(__('Psychic deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Psychic was not deleted'));
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
      $gods = $this->Psychic->find('all');
      $this->Session->setFlash(__('The part has been saved'));
      $Psychic = "";
      foreach($gods as $god){
        $Psychic .= '$c_name[$cno] eq "'.$god['Psychic']['god_name'].'" ? ('.$god['Psychic']['god_link'].")\n         :";
      }
      $this->set('Psychic',$Psychic);
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
