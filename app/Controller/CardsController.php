<?php
App::uses('AppController', 'Controller');
/**
 * Cards Controller
 *
 * @property Card $Card
 */
class CardsController extends AppController {

/**
 * index method
 *
 * @return void
 */
/*	public function index() {
		$this->Card->recursive = 0;
		$this->set('cards', $this->paginate());
	}*/

    public $components = array('Search.Prg');

	public $presetVars = true;

	public $paginate = array();

	public function index() {

	/*	$this->paginate = array(
			'limit' => 2,
		);*/
		//種族ファイル読み込み
		$i = 0;
		while($i <= 0){
		
		//if($fp = fopen("http://kyusyu.me/kataoka.hide/cgi3/syu.txt","r")){
		if($fp = fopen("../../../cgi3/syu.txt","r")){
		// 終端に達するまでループ
		while (!feof($fp)) {
		  // ファイルから一行読み込む
		  $line = fgets($fp);
		  //$lineが空でなかったら
		  if($line != " \n\r" && $line != " \n" && $line != "\n" && $line != "\n\r"){
		    // 読み込んだ行を出力する
		    $syuList[] = $line;
		  }
		}
		// ファイルをクローズする
		fclose($fp);
		$i = 1;
		}
		}
		$this->set('syuList', $syuList);
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->Card->parseCriteria($this->passedArgs);
		$civilization = array( '0' => '光', '1' => '水', '2' => '闇', '3' => '火', '4' => '自然', '5' => 'ゼロ' );
		$this->set('civilization', $civilization);
		$this->set('effects', $this->kokaList);
		$cardList = $this->paginate();
		$this->set('cards', $cardList);

		//$this->set(compact('cardList'));

	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Card->exists($id)) {
			throw new NotFoundException(__('Invalid card'));
		}
		$options = array('conditions' => array('Card.' . $this->Card->primaryKey => $id));
		$this->set('card', $this->Card->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//種族ファイル読み込み
		$i = 0;
		while($i <= 0){
		
		//if($fp = fopen("http://kyusyu.me/kataoka.hide/cgi3/syu.txt","r")){
		if($fp = fopen("../../../cgi3/syu.txt","r")){
		$j = 0;
		// 終端に達するまでループ
		while (!feof($fp)) {
		
		  // ファイルから一行読み込む
		  $line = fgets($fp);
		  //$lineが空でなかったら
		  if($line != " \n\r" && $line != " \n" && $line != "\n" && $line != "\n\r"){
		    // 読み込んだ行を出力する
		    $syuList[$j] = $line;
		  }
		  $j++;
		}
		// ファイルをクローズする
		fclose($fp);
		$i = 1;
		}
		}
		
		// 昇順に並べ替え
		asort($syuList);
		
		$this->set('syuList', $syuList);
		$civilization = array( '0' => '光', '1' => '水', '2' => '闇', '3' => '火', '4' => '自然', '5' => 'ゼロ' );
		$this->set('civilization', $civilization);
		$this->set('kokas', $this->kokaList);
		if ($this->request->is('post')) {
			$this->Card->create();
			// もし要素が配列であったら、','区切りの文字列に変換
			if(is_array($this->request->data['Card']['kind'])){
				$this->request->data['Card']['kind'] = implode( ',', $this->request->data['Card']['kind']);
			}
			if(is_array($this->request->data['Card']['civilization'])){
				$this->request->data['Card']['civilization'] = implode( ',', $this->request->data['Card']['civilization']);
			}
			if(is_array($this->request->data['Card']['effects'])){
				$this->request->data['Card']['effects'] = implode( ',', $this->request->data['Card']['effects']);
			}
			if ($this->Card->save($this->request->data)) {
				$this->Session->setFlash(__('The card has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The card could not be saved. Please, try again.'));
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
		if (!$this->Card->exists($id)) {
			throw new NotFoundException(__('Invalid card'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Card->save($this->request->data)) {
				$this->Session->setFlash(__('The card has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The card could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Card.' . $this->Card->primaryKey => $id));
			$this->request->data = $this->Card->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
/*	public function delete($id = null) {
		$this->Card->id = $id;
		if (!$this->Card->exists()) {
			throw new NotFoundException(__('Invalid card'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Card->delete()) {
			$this->Session->setFlash(__('Card deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Card was not deleted'));
		$this->redirect(array('action' => 'index'));
	}*/
	
	/**
	 * 効果一覧
	 *
	 */
	public $kokaList = array(
		'1'=>'ブロッカー',
'2'=>'アタックトリガー',
'3'=>'Ｗ・ブレイカー',
'4'=>'サバイバー',
'5'=>'Ｔ・ブレイカー',
'6'=>'スピードアタッカー',
'7'=>'チャージャー',
'8'=>'クルー・ブレイカー',
'9'=>'スレイヤー',
'10'=>'ターボラッシュ',
'11'=>' サイレントスキル',
'12'=>'マナゾーンに置く時、タップして置く。',
'13'=>'ウェーブストライカー',
'14'=>'クローン',
'15'=>' シンパシー',
'16'=>'メタモーフ',
'17'=>'アクセル',
'18'=>'Ｇ・ゼロ',
'19'=>'メテオバーン',
'20'=>'ダイナモ',
'21'=>'サイクロン',
'22'=>'フォートＥ',
'23'=>'スリリング・スリー',
'24'=>'バイオ・T',
'25'=>'侍流ジェネレート',
'26'=>'シールド・プラス',
'27'=>'Ｏ・ドライブ',
'28'=>'シールド・フォース',
'29'=>'マッドネス',
'30'=>'ナイト・マジック',
'31'=>'ニンジャ・ストライク',
'32'=>'Q・ブレイカー',
'33'=>'シールド・セイバー',
'34'=>'シールド焼却'

		);
		

}
