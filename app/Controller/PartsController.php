<?php
set_time_limit(300);
App::uses('AppController', 'Controller');
/**
 * Parts Controller
 *
 * @property Part $Part
 */
class PartsController extends AppController {
public $uses = array('Part','Pack','Link','Card','Psychic','Specie');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Part->recursive = 0;
		$this->paginate = array('order' => array('rank' => 'asc'));
		$this->set('parts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Part->exists($id)) {
			throw new NotFoundException(__('Invalid part'));
		}
		$options = array('conditions' => array('Part.' . $this->Part->primaryKey => $id));
		$this->Part->hasMany['Pack']['order'] = array('rank' => 'asc');
		$this->set('part', $this->Part->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Part->create();
			if ($this->Part->save($this->request->data)) {
				$this->Session->setFlash(__('The part has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The part could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Part->exists($id)) {
			throw new NotFoundException(__('Invalid part'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Part->save($this->request->data)) {
				$this->Session->setFlash(__('The part has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The part could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Part.' . $this->Part->primaryKey => $id));
			$this->request->data = $this->Part->find('first', $options);
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
		
		$this->Part->id = $id;
		if (!$this->Part->exists()) {
			throw new NotFoundException(__('Invalid part'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Part->delete()) {
			$this->Session->setFlash(__('Part deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Part was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * save method
 *
 * 
 * @param string $id
 * @return void
 */

  public function save($id = null) {
  	
    if($this->request->is('post')){
      $parts = $this->Part->find('all',array('order' => array('Part.rank' => 'asc')));
      $packs = '';
      foreach($parts as $part){
        $packs .= "        <optgroup label = \"".$part['Part']['part_name']."\">\n";
        $link_packs = $this->Pack->find('all',array('conditions' => array('part_id' => $part['Part']['id']), 'order' => array('Pack.rank' => 'asc')));
        foreach($link_packs as $link_pack){
          $packs .= "            <option value=\"".$link_pack['Pack']['id']."\" \$selstr[".$link_pack['Pack']['id']."]>".$link_pack['Pack']['pack_name']."</option>\n";
         }
       }
       $this->Session->setFlash(__('The part has been saved'));
     
       $this->set('packs',$packs);
       $this->autoRender = false;
       $output = $this->render('deck',$layout = '');
       $this->output = null;
       $this->autoRender = true;
     /* サーバー移転による変更
       $dir = ROOT;
       */
       $dir = '../../../cgi3';
       $files = 'deck.cgi';
       
       chmod($dir. DS. $files,0777);
       $file = new File($dir. DS. $files);
  
       if($file->write($output)){
         //chmod($dir. DS. $files,0644);
         chmod($dir. DS. $files,0755);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }
       
       $ser = '';
       $pack = $this->Pack->find('all');
       foreach($pack as $val){
         $link = $this->Link->find('all',array('conditions' => array(
                                'pack_id' => $val['Pack']['id'])));
         $str = '';
         $card = '';
         $str .= '@{$ser['.$val['Pack']['id'].']} = (';
         foreach($link as $val_l){
           $card .= $val_l['Link']['card_id'].',';
         }
         $ser .= $str.$card.");\n";
       }
            /* サーバー移転による変更
       $dir_s = ROOT;
       */
       $dir_s = '../../../cgi3';
       $files_s = 'series.lib';
       chmod($dir_s. DS. $files_s,0777);
       $file = new File($dir_s. DS. $files_s);
  
       if($file->write($ser)){
         chmod($dir_s. DS. $files_s,0644);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }

       $card = $this->Card->find('all',array(
                                'order' => 'id'));
       $str = "名前\t文明\t種族\tパワー\tコスト\t進化\t効果\tトリガー\n";
       foreach($card as $val){
         $str .= $val['Card']['name']."\t";
         $str .= $val['Card']['civilization']."\t";
         $str .= $val['Card']['kind']."\t";
         $str .= $val['Card']['power']."\t";
         $str .= $val['Card']['cost']."\t";
         $str .= $val['Card']['evolution']."\t";
         $str .= $val['Card']['effects']."\t";
         $str .= $val['Card']['trigger']."\t\n";
       }
            /* サーバー移転による変更
       $dir_c = ROOT;
       */
       $dir_c = '../../../cgi3';
       $files_c = 'card1.txt';
       chmod($dir_c. DS. $files_c,0777);
       $file = new File($dir_c. DS. $files_c);
  
       if($file->write($str)){
         chmod($dir_c. DS. $files_c,0644);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }

       $card = $this->Card->find('all',array(
                                'order' => 'id'));
       $str = "記述\n";
       foreach($card as $val){
         $str .= $val['Card']['str']."\t\n";
       }
            /* サーバー移転による変更
       $dir_c2 = ROOT;
       */
       $dir_c2 = '../../../cgi3';
       $files_c2 = 'card2.txt';
       chmod($dir_c2. DS. $files_c2,0777);
       $file = new File($dir_c2. DS. $files_c2);
  
       if($file->write($str)){
         chmod($dir_c2. DS. $files_c2,0644);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }
       
       // サイキックテキスト書き込み
       $psychic = $this->Psychic->find('all',array(
                                'order' => 'id'));
       $str = "";
       foreach($psychic as $val){
         $psychic_s = explode(',',$val['Psychic']['psychic_s']);
         if(count($psychic_s) > 1){
         	$str .= '$psy_super{'.$val['Psychic']['psychic_l'].'}	= [ '.$val['Psychic']['psychic_s'].' ];'."\n";
         	foreach($psychic_s as $val_s){
         		$str .= '$psy_cell{'.$val_s.'}	= '.$val['Psychic']['psychic_l'].';'."\n";
         	}
         }else{
         	$str .= '$psy_top{'.$val['Psychic']['psychic_s'].'}	= '.$val['Psychic']['psychic_l'].';'."\n";
         	$str .= '$psy_back{'.$val['Psychic']['psychic_l'].'}	= '.$val['Psychic']['psychic_s'].';'."\n";
         }
         $str .= "\n";
       }
            /* サーバー移転による変更
       $dir_c = ROOT;
       */
       $dir_sy = '../../../cgi3';
       $files_sy = 'psychic.txt';
       chmod($dir_sy. DS. $files_c,0777);
       $file = new File($dir_sy. DS. $files_sy);
  
       if($file->write($str)){
         chmod($dir_sy. DS. $files_sy,0644);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }
       

       
       // サイキック対応表書き込み
       $psychic_list = $this->Psychic->find('all',array(
                                'order' => 'id'));
       $str = "";
       foreach($psychic_list as $val){
			$card_name = $this->Card->find('first',array(
       							'conditions' => array(
       								'id' => $val['Psychic']['psychic_l']),
                                'order' => 'id'));
         	$str .= $card_name['Card']['name']."<br><br>";
       }
       $this->Session->setFlash(__('The part has been saved'));
     
       $this->set('psychic_list',$str);
       $this->autoRender = false;
       $output = $this->render('psychic_list',$layout = '');
       $this->output = null;
       $this->autoRender = true;
     /* サーバー移転による変更
       $dir = ROOT;
       */
       $dir = '../../../cgi3';
       $files = 'psychic_list.html';
       
       chmod($dir. DS. $files,0777);
       $file = new File($dir. DS. $files);
  
       if($file->write($output)){
         //chmod($dir. DS. $files,0644);
         chmod($dir. DS. $files,0755);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }





		// 勲章書き込み
		// csvファイル読み込み
		$fp = fopen("../../../cgi3/EditSymbol/kunsyo.csv","r");
	
		$str = '';
		$strNm = '';
		// 一行ごとに処理
		while($line = fgets($fp)){
			$data = explode(',',$line);
			$str .= '$order_symbol{\''.$data[0].'\'}	= \''.$data[2].'\';'."\n";
			$str .= '$order_color{\''.$data[0].'\'}	= \'#0000ff\';'."\n";
			$str .= '$order_text{\''.$data[0].'\'}	= \''.$data[1].'\';'."\n\n";
			
			$strNm .= ', \''.$data[0].'\'';
		}
		
       $this->set('kunsyo_name',$strNm);
       $this->set('kunsyo_list',$str);
       $this->autoRender = false;
       $output = $this->render('cust',$layout = '');
       $this->output = null;
       $this->autoRender = true;
            /* サーバー移転による変更
       $dir_kn = ROOT;
       */
       
       $dir_kn = '../../../cgi3';
       $files_kn = 'cust.cgi';
       chmod($dir_kn. DS. $files_kn,0777);
       $file = new File($dir_kn. DS. $files_kn);
  
       if($file->write($output)){
         chmod($dir_kn. DS. $files_kn,0644);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }

       // 種属書き込み
       $species = $this->Specie->find('all',array(
                                'order' => 'no'));
       $str = "";
       foreach($species as $val){
         $str .= $val['Specie']['species_name']."\n";
       }
            /* サーバー移転による変更
       $dir_c = ROOT;
       */
       $dir_c = '../../../cgi3';
       $files_c = 'syu.txt';
       chmod($dir_c. DS. $files_c,0777);
       $file = new File($dir_c. DS. $files_c);
  
       if($file->write($str)){
         chmod($dir_c. DS. $files_c,0644);
         $file->close();
         echo 'saccess';
       } else {
         echo 'failed';
         $file->close();
       }


//function FTPupload($ftp, $remote_file, $file)
//{
/* サーバー移動に伴い、FTP通信でのアップロードは行わない
$ftp = array(
	'ftp_server' => 'ftp.gmobb.jp',
	'ftp_user_name' => 'kataoka.hide@kyusyu.me',
	'ftp_user_pass' => 'dYU6FXNU'
	);
$remote_file = '~/cgi3/deck.cgi';
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
//}

//function FTPupload($ftp, $remote_file, $file)
//{
$ftp = array(
	'ftp_server' => 'ftp.gmobb.jp',
	'ftp_user_name' => 'kataoka.hide@kyusyu.me',
	'ftp_user_pass' => 'dYU6FXNU'
	);
$remote_file = '~/cgi3/series.lib';
$file = $dir_s. DS. $files_s;


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
//}

//function FTPupload($ftp, $remote_file, $file)
//{
$ftp = array(
	'ftp_server' => 'ftp.gmobb.jp',
	'ftp_user_name' => 'kataoka.hide@kyusyu.me',
	'ftp_user_pass' => 'dYU6FXNU'
	);
$remote_file = '~/cgi3/card1.txt';
$file = $dir_c. DS. $files_c;


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
//}

//function FTPupload($ftp, $remote_file, $file)
//{
$ftp = array(
	'ftp_server' => 'ftp.gmobb.jp',
	'ftp_user_name' => 'kataoka.hide@kyusyu.me',
	'ftp_user_pass' => 'dYU6FXNU'
	);
$remote_file = '~/cgi3/card2.txt';
$file = $dir_c2. DS. $files_c2;


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
//}
*/
     }
     
   }
   
}
