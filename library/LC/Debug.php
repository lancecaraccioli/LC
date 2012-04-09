<?
/**
 * 
 */
require_once('LC/Debug/Inspector.php');
require_once('LC/Debug/Inspector/Html.php');
class LC_Debug{
	
	/**
	 * @var LC_Debug_Logger the backend of the debugger
	 */
	protected $_inspector;
	
	public function setInspector(LC_Debug_Inspector $inspector){
			$this->_inspector = $inspector;
	}
	public function getInspector(){
		if (!$this->_inspector){
			return new LC_Debug_Inspector_Html();			
		}
		return $this->_inspector;
	}
	
	public function dump($data){
		$this->getInspector()->dump($data);
	}
	
	public function kill($data){
		$this->getInspector()->kill($data);
	}
}
