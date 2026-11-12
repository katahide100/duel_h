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
         $str .= $val['Card']['trigger']."\n";
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
         $str .= $val['Card']['str']."\n";
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
                                'order' => 'Psychic.id'));
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
                                'order' => 'Psychic.id'));
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

       // duel-next（Next.js 版）用のパック一覧も同時に書き出す。
       // 出力先が無い・書けない場合でも cgi3 側の保存結果は壊さない。
       $this->writeDuelNextPacks();
       // カード情報（cards.json）と種族名（raceNames.json）も duel-next の形式で直接書き出す。
       // 以前は duel-next の convert.mjs が cgi3 の card1.txt / card2.txt / syu.txt から変換していた。
       $this->writeDuelNextCards();
       $this->writeDuelNextRaceNames();


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

/**
 * duel-next 用のパック一覧（data/packs.json）を書き出す。
 *
 * cgi3 では deck.cgi のプルダウン（パート＝optgroup / パック＝option）と
 * series.lib（パックID → カードID の配列）に分けてコードとして埋め込んでいるが、
 * duel-next にはデッキ構築画面のパック絞り込み用に 1 つの JSON にまとめて渡す。
 * 並び順は deck.cgi と同じ（パート rank → パック rank）。
 * 出力先は app/Config/bootstrap.php の DuelNext.dataDir（環境変数 DUEL_NEXT_DATA_DIR）。
 *
 * @return void
 */
  private function writeDuelNextPacks() {
    $dir = Configure::read('DuelNext.dataDir');
    if (!is_dir($dir)) {
      $this->Session->setFlash(__('duel-next の出力先が見つからないため packs.json はスキップしました: %s', $dir));
      return;
    }

    // パックID → カードID の配列（カードID昇順）
    $cardIdsByPack = array();
    $links = $this->Link->find('all', array(
      'recursive' => -1,
      'fields' => array('Link.pack_id', 'Link.card_id'),
      'order' => array('Link.card_id' => 'asc'),
    ));
    foreach ($links as $link) {
      $cardIdsByPack[$link['Link']['pack_id']][] = (int)$link['Link']['card_id'];
    }

    $result = array();
    $packCount = 0;
    $parts = $this->Part->find('all', array('recursive' => -1, 'order' => array('Part.rank' => 'asc')));
    foreach ($parts as $part) {
      $packs = array();
      $partPacks = $this->Pack->find('all', array(
        'recursive' => -1,
        'conditions' => array('Pack.part_id' => $part['Part']['id']),
        'order' => array('Pack.rank' => 'asc'),
      ));
      foreach ($partPacks as $pack) {
        $packId = $pack['Pack']['id'];
        $packs[] = array(
          'id' => (int)$packId,
          'name' => $pack['Pack']['pack_name'],
          'cardIds' => isset($cardIdsByPack[$packId]) ? array_values(array_unique($cardIdsByPack[$packId])) : array(),
        );
        $packCount++;
      }
      $result[] = array(
        'id' => (int)$part['Part']['id'],
        'name' => $part['Part']['part_name'],
        'packs' => $packs,
      );
    }

    $json = json_encode(array(
      'generatedAt' => date('c'),
      'generatedFrom' => 'duel_h parts',
      'parts' => $result,
    ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $path = $dir . DS . 'packs.json';
    if (@file_put_contents($path, $json . "\n") === false) {
      $this->Session->setFlash(__('packs.json を書き込めませんでした（権限を確認してください）: %s', $path));
      return;
    }
    @chmod($path, 0664);
  }


/**
 * duel-next 用のカード情報（data/cards.json）を書き出す。
 *
 * 以前は cgi3 の card1.txt / card2.txt を duel-next の convert.mjs で変換していたが、
 * 変換を挟まず最初から duel-next の形式で出す。中身は convert.mjs が作っていたものと同じ。
 * - 配列の添字 = id = カードID（card1.txt の行番号と同じく、id 順に並べた何番目か）
 * - cost / power は文字列のまま、evo は数値、abilities は効果番号の文字列の配列
 *   （シールド・トリガー（トリガーに 1）は "99" を足す）、discription は効果文
 * duel-next は更新日時を見て読み直すので、サーバーの再起動はいらない。
 *
 * @return void
 */
  private function writeDuelNextCards() {
    $cards = $this->Card->find('all', array(
      'recursive' => -1,
      'fields' => array('Card.id', 'Card.name', 'Card.civilization', 'Card.kind', 'Card.power', 'Card.cost', 'Card.evolution', 'Card.effects', 'Card.trigger', 'Card.str'),
      'order' => array('Card.id' => 'asc'),
    ));

    $result = array();
    foreach ($cards as $i => $card) {
      $c = $card['Card'];
      // convert.mjs は '0' も値ありとして扱っていたので、PHP の empty() ではなく空文字で判定する
      $effects = $this->trimForDuelNext($c['effects']);
      $abilities = $effects !== '' ? explode(',', $effects) : array();
      $trigger = $this->trimForDuelNext($c['trigger']);
      if ($trigger !== '' && in_array('1', explode(',', $trigger), true)) {
        $abilities[] = '99';
      }
      $result[] = array(
        'id' => $i,
        'name' => $this->trimForDuelNext($c['name']),
        'civilization' => explode(',', $this->trimForDuelNext($c['civilization'])),
        'race' => explode(',', $this->trimForDuelNext($c['kind'])),
        'cost' => $this->trimForDuelNext($c['cost']),
        'power' => $this->trimForDuelNext($c['power']),
        'evo' => (int)$this->trimForDuelNext($c['evolution']),
        'abilities' => $abilities,
        'discription' => $this->trimForDuelNext($c['str']),
      );
    }

    $this->writeDuelNextJson('cards.json', $result);
  }

/**
 * convert.mjs（csv-parse の trim）と同じく、全角スペースなども前後から取り除く。
 * PHP の trim() は全角スペースを残すため、「効果」が全角スペースだけのカードが
 * 効果番号「　」を持つなど、convert.mjs の出力と変わってしまう。
 *
 * @param mixed $value
 * @return string
 */
  private function trimForDuelNext($value) {
    $value = (string)$value;
    $trimmed = preg_replace('/^[\s\p{Z}\x{FEFF}]+|[\s\p{Z}\x{FEFF}]+$/u', '', $value);
    // 文字コードが壊れていて正規表現が使えない時は通常の trim にする
    return $trimmed === null ? trim($value) : $trimmed;
  }

/**
 * duel-next 用の種族名一覧（data/raceNames.json。配列の添字 = 種族コード）を書き出す。
 * cgi3 の syu.txt と同じ並び（species.no 順）。以前は convert.mjs が syu.txt から変換していた。
 *
 * @return void
 */
  private function writeDuelNextRaceNames() {
    $species = $this->Specie->find('all', array('recursive' => -1, 'order' => 'no'));
    $names = array();
    foreach ($species as $val) {
      $names[] = str_replace("\r", '', (string)$val['Specie']['species_name']);
    }
    // syu.txt からの変換と同じく、末尾の空行は持たない
    while (!empty($names) && trim(end($names)) === '') {
      array_pop($names);
    }

    $this->writeDuelNextJson('raceNames.json', $names);
  }

/**
 * duel-next の出力先（DuelNext.dataDir）に JSON を書き出す。
 *
 * duel-next はサーバー稼働中に読み直すため、書きかけのファイルを読まないよう
 * 一時ファイルに書いてから rename で置き換える。
 * 出力先が無い・書けない場合でも cgi3 側の保存結果は壊さない（メッセージを出すだけ）。
 *
 * @param string $fileName 出力するファイル名
 * @param array $data JSON にするデータ
 * @return bool 書き出せたか
 */
  private function writeDuelNextJson($fileName, $data) {
    $dir = Configure::read('DuelNext.dataDir');
    if (!is_dir($dir)) {
      $this->Session->setFlash(__('duel-next の出力先が見つからないため %s はスキップしました: %s', $fileName, $dir));
      return false;
    }

    $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    // 文字コードの壊れた文字が 1 つあっても全体を出せなくならないようにする（PHP 7.2 以降）
    if (defined('JSON_INVALID_UTF8_SUBSTITUTE')) {
      $options |= JSON_INVALID_UTF8_SUBSTITUTE;
    }
    $json = json_encode($data, $options);
    if ($json === false) {
      $this->Session->setFlash(__('%s を作れませんでした: %s', $fileName, json_last_error_msg()));
      return false;
    }

    $path = $dir . DS . $fileName;
    $tmp = $path . '.tmp';
    if (@file_put_contents($tmp, $json . "\n") !== false) {
      @chmod($tmp, 0664);
      if (@rename($tmp, $path)) {
        return true;
      }
      @unlink($tmp);
    }
    // フォルダに書けない（既存のファイルだけ書ける）環境では直接上書きする。
    // duel-next は読めなかった時は前の内容を使い続けるので、書いている途中に読まれても壊れない
    if (@file_put_contents($path, $json . "\n") === false) {
      $this->Session->setFlash(__('%s を書き込めませんでした（権限を確認してください）: %s', $fileName, $path));
      return false;
    }
    @chmod($path, 0664);
    return true;
  }

}
