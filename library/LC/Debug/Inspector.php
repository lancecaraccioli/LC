<?
abstract class LC_Debug_Inspector{
	/**
	 * Dump the contents of the source data into a sustable format and continue execution of script
	 * 
	 * A basic inspector might use the var_dump method to echo a string representation of the source data to the output stream.
	 * 
	 * @param mixed $data is the source data that should be inspected by the inspector
	 */
	abstract public function dump($data);
	
	
	/**
	 * Dump the contents of the source data into a sustable format and then kill the execution of the php script.
	 * 
	 * @see {link dump()}
	 * @param mixed $data is the source data that should be inspected by the inspector
	 */
	public function kill($data){
		$this->dump($data);
		die();
	}
	
}