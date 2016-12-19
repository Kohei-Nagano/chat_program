<?php
/**
 * BBSクラス
 *
 * @author     M.Katsube <katsubemakito@gmail.com>
 * @copyright  Copyright ©2016 M.Katsube All Rights Reserved.
 * @license    MIT license
 */
 class Chat{
  //-------------------------------------------
  // 定数
  //-------------------------------------------
  const MODE_VIEW  = 'view';               //現在は未使用
  const MODE_WRITE = 'write';

  const ERRORCD_VALIDATION = 'E400V';      //validation
  const ERRORCD_NOTFOUND   = 'E404';       //ファイルが存在しない  checkLogFile()
  const ERRORCD_NOTREAD    = 'E403R';      //ファイルが読み込めない  checkLogFile()
  const ERRORCD_NOTWRITE   = 'E403W';      //ファイルに書き込めない  checkLogFile()
  const ERRORCD_WRITING    = 'E500W';      //ファイルに書き込めない
  const ERRORCD_COMMON     = 'ECOMMON';    //汎用エラー
  
  const ERRORCD_NOTFOUND_ID		 	= 'ENID';    	 //IDは入力されているが存在しない
  const ERRORCD_NOTINPUT_ID_PW		= 'ENPW';    //IDまたはパスワードのいずれかが未入力
  const ERRORCD_NOTCORRECT_ID_PW	= 'ENID_PW'; //ID,PWは入力されているが一致しない
  
  
  //-------------------------------------------
  // プロパティ
  //-------------------------------------------
  private $logfile   = 'bbslog.txt';
  private $error_cd  = null;


  
  static private $errors = [
      'E400V'   => '必要な項目が入力されていません'
    , 'E404'    => 'ログファイルが存在しません'            //checkLogFile()
    , 'E403R'   => 'ログファイルを読み込むことができません'  //checkLogFile()
    , 'E403W'   => 'ログファイルに書き込むことができません'  //checkLogFile()
    , 'E500W'   => 'ログファイルに書き込めませんでした'
    , 'ECOMMON' => 'システムエラーが発生しました'
    , 'ENID'	  => 'Not found id.'
    , 'ENPW'	  => 'Please input your id and passowrd.'
    , 'ENID_PW' => 'ID or Password is incorrect.'
  ];

 /**
  * コンストラクタ
  *
  * @param  $file  string
  * @return void
  * @access public
  */
  function __construct($file=null){
  }
  
  /**
   * user_info
   * @return boolean
   * @access public
   */
  function user_info($login_id = null, $password = null){
	$dsn  = 'mysql:dbname=chat_db;host=127.0.0.1';
	$user = 'root';
	$pw   = 'H@chiouji1';
  
   $sql ="SELECT * FROM user_info WHERE loginid = '$login_id'";
	//SQL
	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();

    $buff = $sth->fetch();
    //var_dump($buff);
    if(empty($login_id) && empty($password)){
      $this->error_cd = self::ERRORCD_NOTINPUT_ID_PW;
      return(false);
    }
	else if(!empty($login_id) && $buff === false){
      $this->error_cd = self::ERRORCD_NOTFOUND_ID;
      return(false);
    }
    else if($buff['password'] !== $password ){
      $this->error_cd = self::ERRORCD_NOTCORRECT_ID_PW;
      return(false);
    }  
    return(true);
  }
  
    /**
   * user_info
   * @return boolean
   * @access public
   */
  function get_user_name($login_id = null){
	$dsn  = 'mysql:dbname=chat_db;host=127.0.0.1';
	$user = 'root';
	$pw   = 'H@chiouji1';
  
   $sql ="SELECT * FROM user_info WHERE loginid = '$login_id'";
	//SQL
	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();
	
	$buff = $sth->fetch();

    if($buff === false){
    	return null;
    }

    return($buff['dispname']);
  }
  
     /**
   * insert_chat_log
   * @return boolean
   * @access public
   */
  function insert_chat_log($user_id = null, $text = null){
	$dsn  = 'mysql:dbname=chat_db;host=127.0.0.1';
	$user = 'root';
	$pw   = 'H@chiouji1';

   $sql = "INSERT INTO chat_log values(NULL, '$user_id', '$text', Now())";
   
   	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();
  }
  
   /**
   * delete_chat_log
   * @return boolean
   * @access public
   */
  function delete_chat_log($login_id = null){
	$dsn  = 'mysql:dbname=chat_db;host=127.0.0.1';
	$user = 'root';
	$pw   = 'H@chiouji1';
  
   $sql = "DELETE FROM chat_log WHERE id = 'login_id";
	
	//try{
	//	$dbh = new PDO($dsn,$user,$pw);
	//	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//	$dbh->beginTransaction();
	//	$sth = $dbh->prepare($sql);
	//	$sth->execute();
	//	$dbh->commit();
	//	$buff = $sth->fetch();
	//}
	//catch{
	//	$dbh->rollback();
	//}
  }
  
  /**
   * エラーコードを取得
   *
   * @return string | null
   * @access public
   */
  function getErrorCD(){
    return( $this->error_cd );
  }

  /**
   * エラーメッセージを取得
   *
   * @return string | boolean
   * @access public
   */
  static function getErrorMessage($cd=null){
    if( $cd === null ){
      return( self::$errors );
    }
    
    //エラーCDが存在しない場合は汎用エラーCDをセット
    if( ! array_key_exists($cd, self::$errors) ){
      $cd = self::ERRORCD_COMMON;
    }
    
    return( self::$errors[$cd] );
  }
  
  /**
   * ログを取得する
   *
   * @return array
   * @access public
   */
  function getLog($id = null){
	$dsn  = 'mysql:dbname=chat_db;host=127.0.0.1';
	$user = 'root';
	$pw   = 'H@chiouji1';

	$dbh = new PDO($dsn,$user,$pw);

	$sql = "SELECT COUNT(*) as count FROM chat_log";
      	
	$sth = $dbh->prepare($sql);
	$sth->execute();
	
	$count = $sth->fetch()['count'] - $id + 1;
	
	$sql = "SELECT * FROM chat_log where id = '$count'";
   
	$sth = $dbh->prepare($sql);
	$sth->execute();
    return($sth->fetch());
  }
  
  /**
   * エラー画面へ遷移する
   *
   * @param  $cd    string
   * @return void
   * @access public
   */
  static function error($cd){
    header('Location: chat_error.php?cd='.urlencode($cd));
  }

  /**
   * エスケープ処理
   *
   * 文字列中にカンマや改行があると誤作動を起こしてしまうため
   * 別の文字に置換、または削除をする。
   *
   * @param  $str     string
   * @return string
   * @access private
   */
  private function _escape($str){
    $str = str_replace(',',  '&#44', $str);    // 区切り文字 -> 文字参照
    $str = str_replace("\n", '<br>', $str);    // ¥n -> <br>
    $str = str_replace("\r", '',     $str);    // ¥r -> ""

    return($str);
  }
}
